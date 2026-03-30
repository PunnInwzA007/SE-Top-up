<?php require_once "auth.php"; ?>
<?php
require_once "../config/db.php";

$user_id = $_SESSION['user_id'];

// 1. จัดการเรื่องส่วนลด (ต้องทำก่อนคำนวณราคา)
$discount_amount = 0;
if(isset($_POST['discount'])){
    $discount_amount = floatval($_POST['discount']);
    $_SESSION['checkout']['discount'] = $discount_amount;
} else {
    $discount_amount = $_SESSION['checkout']['discount'] ?? 0;
}

// 2. รับค่าจากหน้า Product หรือ Session
if($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['confirm'])){
    $_SESSION['checkout']['package_id'] = $_POST['package_id'];
    $_SESSION['checkout']['uid'] = $_POST['uid'];
}

$package_id = $_POST['package_id'] ?? ($_SESSION['checkout']['package_id'] ?? null);
$uid = $_POST['uid'] ?? ($_SESSION['checkout']['uid'] ?? null);

if(!$package_id || !$uid){
    echo "DEBUG: NO DATA";
    exit;
}

/* ======================
    GET PACKAGE
====================== */
$stmt = $conn->prepare("
    SELECT packages.*, games.name AS game_name 
    FROM packages
    JOIN games ON packages.game_id = games.id
    WHERE packages.id=?
");
$stmt->bind_param("i", $package_id);
$stmt->execute();
$package = $stmt->get_result()->fetch_assoc();

if(!$package){ die("Package not found"); }

$base_price = $package['price']; 
$total_price = max(0, $base_price - $discount_amount); // คำนวณราคาสุทธิ

/* ======================
    GET USER BALANCE
====================== */
$stmt = $conn->prepare("SELECT balance FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$balance = $user['balance'];

/* ======================
    CONFIRM PURCHASE
====================== */
if(isset($_POST['confirm'])){
    if($balance < $total_price){
        $error = "เงินไม่พอ";
    } else {
        $conn->begin_transaction();
        try {
            // 💳 หักเงิน
            $new_balance = $balance - $total_price;
            $stmt = $conn->prepare("UPDATE users SET balance=? WHERE id=?");
            $stmt->bind_param("di", $new_balance, $user_id);
            $stmt->execute();

            // 🧾 สร้าง order
            $stmt = $conn->prepare("INSERT INTO orders (user_id, package_id, game_uid, price, status) VALUES (?,?,?,?, 'pending')");
            $stmt->bind_param("iisd", $user_id, $package_id, $uid, $total_price);
            $stmt->execute();
            
            $order_id = $conn->insert_id;

            // 📜 บันทึก transaction
            $stmt = $conn->prepare("INSERT INTO transactions (user_id, type, amount, order_id) VALUES (?,?,?,?)");
            $type = "purchase"; // 🔥 ประกาศตัวแปร type
            $amount = -$total_price;
            $stmt->bind_param("isdi", $user_id, $type, $amount, $order_id);
            $stmt->execute();

            // 4. เพิ่ม Point (10 บาท = 1 Point)
            $points = floor($total_price / 10);
            $stmt_points = $conn->prepare("UPDATE users SET points = points + ? WHERE id=?");
            $stmt_points->bind_param("ii", $points, $user_id);
            $stmt_points->execute();

            $conn->commit();
            
            // ล้างส่วนลดเมื่อจ่ายเงินเสร็จ
            unset($_SESSION['checkout']['discount']);
            
            header("Location: history.php");
            exit;

        } catch (Exception $e) {
            $conn->rollback();
            $error = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }
    }
}
// 🔥 mark code used
if(isset($_SESSION['checkout']['redeem_code'])){
    $code = $_SESSION['checkout']['redeem_code'];

    $stmt = $conn->prepare("
      UPDATE bonus_codes 
      SET status='used', used_at=NOW() 
      WHERE code=? 
    ");
    $stmt->bind_param("s", $code);
    $stmt->execute();

    unset($_SESSION['checkout']['redeem_code']);
}
?>

<?php include "partials/header.php"; ?>

<section class="se-section">
  <div class="se-container">
    <div class="row g-4">
      <div class="col-lg-7">
        <div class="se-card p-4">
          <h5 class="mb-4" style="font-weight:900;">รายละเอียดคำสั่งซื้อ</h5>
          <div class="mb-3"><strong>เกม:</strong> <?= htmlspecialchars($package['game_name']) ?></div>
          <div class="mb-3"><strong>แพ็กเกจ:</strong> <?= htmlspecialchars($package['name']) ?></div>
          <div class="mb-3"><strong>UID:</strong> <?= htmlspecialchars($uid) ?></div>
          <hr>
          <span class="badge bg-warning">รอเติม (Pending)</span>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="se-card p-4">
          <h5 class="mb-4" style="font-weight:900;">สรุปการชำระเงิน</h5>
          <div class="d-flex justify-content-between mb-2">
              <span>ราคาปกติ</span>
              <span>฿<?= number_format($base_price, 2) ?></span>
          </div>
          <div class="d-flex justify-content-between mb-2 text-danger">
              <span>ส่วนลด</span>
              <span>-฿<?= number_format($discount_amount, 2) ?></span>
          </div>
          <hr>
          <div class="d-flex justify-content-between mb-3">
              <strong>ยอดชำระสุทธิ</strong>
              <strong class="text-success">฿<?= number_format($total_price, 2) ?></strong>
          </div>
          <hr>
          <div class="mb-3">
            <span>เงินในบัญชี:</span>
            <strong>฿<?= number_format($balance,2) ?></strong>
          </div>

          <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
          <?php endif; ?>

          <form method="POST">
            <input type="hidden" name="package_id" value="<?= $package_id ?>">
            <input type="hidden" name="uid" value="<?= htmlspecialchars($uid) ?>">
            <button 
              type="submit" 
              name="confirm"
              class="se-btn-green w-100"
              <?= $balance < $total_price ? 'disabled' : '' ?>
            >
              ยืนยันการชำระเงิน
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include "partials/footer.php"; ?>