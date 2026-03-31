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
    if($payment['status'] !== 'successful'){

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

                // 💰 เพิ่มเงิน
                $stmt = $conn->prepare("
                UPDATE users SET balance = balance + ? WHERE id=?
                ");
                $stmt->bind_param("di", $payment['amount'], $payment['user_id']);
                $stmt->execute();

                // 📜 transaction
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

                // 🔥 ดึง package + game
                $stmt = $conn->prepare("
                    SELECT p.*, g.name AS game_name
                    FROM packages p
                    JOIN games g ON p.game_id = g.id
                    WHERE p.id=?
                ");
                $stmt->bind_param("i", $package_id);
                $stmt->execute();
                $pkg = $stmt->get_result()->fetch_assoc();

                if(!$pkg){
                    throw new Exception("package not found");
                }

                // 🎮 UID
                $uid = $_SESSION['checkout']['uid'] ?? 'UNKNOWN';

                // ✅ CREATE ORDER (สำคัญมาก ห้ามหาย)
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

                $order_id = $conn->insert_id; // 🔥 ได้จริงแล้ว

                // 📜 transaction (ต้องมาหลัง order)
                $stmt = $conn->prepare("
                INSERT INTO transactions (user_id, type, amount, order_id)
                VALUES (?, 'purchase', ?, ?)
                ");
                $amount = -$price;
                $stmt->bind_param("idi", $user_id, $amount, $order_id);
                $stmt->execute();

                // 🎟️ update discount
                if($payment['discount_code']){
                    $code = $payment['discount_code'];

                    $stmt = $conn->prepare("
                    UPDATE discount_codes 
                    SET used_count = used_count + 1 
                    WHERE code=? 
                    ");
                    $stmt->bind_param("s", $code);
                    $stmt->execute();
                }
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
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Payment Status</title>

<style>
:root{
  --se-blue:#0071f8;
  --se-pink:#ee626b;
  --se-gray:#f2f2f2;
  --se-border:rgba(0,0,0,.10);
  --se-shadow:0 10px 24px rgba(0,0,0,.08);
}

body{
  margin:0;
  font-family: Arial, sans-serif;
  background: var(--se-gray);
}

/* layout */
.container{
  display:flex;
  justify-content:center;
  align-items:center;
  height:100vh;
}

/* card */
.card{
  background:#fff;
  padding:30px;
  border-radius:20px;
  width:360px;
  text-align:center;
  box-shadow: var(--se-shadow);
  border:1px solid var(--se-border);
}

/* title */
.title{
  font-size:22px;
  font-weight:900;
  margin-bottom:20px;
}

/* badge */
.badge{
  display:inline-block;
  padding:10px 22px;
  border-radius:30px;
  font-weight:bold;
  margin-bottom:20px;
  color:#fff;
}

.success{ background:#22c55e; }
.pending{ background:var(--se-blue); }
.failed{ background:var(--se-pink); }

/* text */
.text{
  margin-bottom:15px;
}

/* qr */
.qr img{
  width:200px;
  border-radius:12px;
  background:#fff;
  padding:10px;
  border:1px solid var(--se-border);
  margin-bottom:20px;
}

/* button */
.btn{
  display:block;
  padding:12px;
  border-radius:12px;
  text-decoration:none;
  font-weight:bold;
  margin-top:10px;
  transition:0.2s;
}

.btn-blue{
  background:var(--se-blue);
  color:#fff;
}

.btn-pink{
  background:var(--se-pink);
  color:#fff;
}

.btn:hover{
  transform:translateY(-2px);
  box-shadow: var(--se-shadow);
}
</style>
</head>

<body>

<div class="container">
  <div class="card">

    <div class="title">สถานะการชำระเงิน</div>

    <!-- STATUS -->
    <?php if($charge['status'] === 'successful'): ?>
      <div class="badge success">SUCCESS</div>
    <?php elseif($charge['status'] === 'pending'): ?>
      <div class="badge pending">PENDING</div>
    <?php else: ?>
      <div class="badge failed">FAILED</div>
    <?php endif; ?>

    <!-- TEXT -->
    <?php if($charge['status'] === 'pending'): ?>
      <div class="text">กรุณาสแกน QR เพื่อชำระเงิน</div>
    <?php endif; ?>

    <?php if($charge['status'] === 'successful'): ?>
      <div class="text" style="color:#22c55e;font-weight:bold;">
        ชำระเงินสำเร็จ 🎉
      </div>
    <?php endif; ?>

    <?php if($charge['status'] === 'failed'): ?>
      <div class="text" style="color:var(--se-pink);">
        การชำระเงินล้มเหลว
      </div>
    <?php endif; ?>

    <!-- QR -->
    <?php if($charge['status'] === 'pending'): ?>
      <div class="qr">
        <img src="<?= $qr ?>">
      </div>
    <?php endif; ?>

    <!-- BUTTON -->
    <a href="check_status.php?id=<?= $charge_id ?>" class="btn btn-blue">
      รีเฟรชสถานะ
    </a>

    <a href="../Customer/history.php" class="btn btn-pink">
      กลับไปหน้า History
    </a>

  </div>
</div>

</body>
</html>