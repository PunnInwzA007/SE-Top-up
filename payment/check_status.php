<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../config/omise.php";
require_once __DIR__ . "/../omise/lib/Omise.php";

$charge_id = $_GET['id'] ?? null;

if(!$charge_id){
    die("no charge id");
}

/* =========================
   GET CHARGE FROM OMISE
========================= */
$charge = OmiseCharge::retrieve($charge_id);

/* =========================
   GET PAYMENT FROM DB
========================= */
$stmt = $conn->prepare("SELECT * FROM payments WHERE charge_id=?");
$stmt->bind_param("s", $charge_id);
$stmt->execute();
$payment = $stmt->get_result()->fetch_assoc();

if(!$payment){
    die("payment not found");
}

/* =========================
   HANDLE SUCCESS
========================= */
if($charge['status'] === 'successful'){

    // ❗ กันซ้ำ
    if($payment['status'] === 'successful'){
        // ไม่ต้องทำอะไร
    } else {

        $conn->begin_transaction();

        try {

            // ✅ update payment
            $stmt = $conn->prepare("
            UPDATE payments SET status='successful' WHERE charge_id=?
            ");
            $stmt->bind_param("s", $charge_id);
            $stmt->execute();

            /* =========================
               WALLET FLOW
            ========================= */
            if($payment['type'] === 'wallet'){

                $stmt = $conn->prepare("
                UPDATE users SET balance = balance + ? WHERE id=?
                ");
                $stmt->bind_param("di", $payment['amount'], $payment['user_id']);
                $stmt->execute();

                $stmt = $conn->prepare("
                INSERT INTO transactions (user_id, type, amount)
                VALUES (?, 'topup', ?)
                ");
                $stmt->bind_param("id", $payment['user_id'], $payment['amount']);
                $stmt->execute();
            }

            /* =========================
               PACKAGE FLOW
            ========================= */
            if($payment['type'] === 'package'){

                $package_id = $payment['package_id'];
                $user_id = $payment['user_id'];
                $price = $payment['amount'];

                $stmt = $conn->prepare("
                    SELECT p.*, g.name AS game_name
                    FROM packages p
                    JOIN games g ON p.game_id = g.id
                    WHERE p.id=?
                ");
                $stmt->bind_param("i", $package_id);
                $stmt->execute();
                $pkg = $stmt->get_result()->fetch_assoc();

                $uid = $_SESSION['checkout']['uid'] ?? 'UNKNOWN';

                $stmt = $conn->prepare("
                    INSERT INTO orders (user_id, package_id, game_uid, price, status, game_name, package_name)
                    VALUES (?, ?, ?, ?, 'pending', ?, ?)
                ");
                $stmt->bind_param(
                    "iisdss",
                    $user_id,
                    $package_id,
                    $uid,
                    $price,
                    $pkg['game_name'],
                    $pkg['name']
                );
                $stmt->execute();

                $order_id = $conn->insert_id;

                $stmt = $conn->prepare("
                INSERT INTO transactions (user_id, type, amount, order_id)
                VALUES (?, 'purchase', ?, ?)
                ");
                $amount = -$price;
                $stmt->bind_param("idi", $user_id, $amount, $order_id);
                $stmt->execute();
            }

            $conn->commit();

        } catch (Exception $e){
            $conn->rollback();
            die($e->getMessage());
        }
    }
}

/* =========================
   SHOW QR
========================= */
$qr = $charge['source']['scannable_code']['image']['download_uri'];
?>

<h2>PromptPay QR</h2>
<img src="<?= $qr ?>" width="300">

<p>Status: <?= $charge['status'] ?></p>

<a href="check_status.php?id=<?= $charge_id ?>">
    <button>เช็คสถานะ</button>
</a>