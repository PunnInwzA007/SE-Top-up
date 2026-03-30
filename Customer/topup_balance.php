<?php require_once "auth.php"; ?>
<?php require_once "../config/db.php"; ?>
<?php include "partials/header.php"; ?>

<?php
$user_id = $_SESSION['user_id'];
$message = "";

/* ======================
   HANDLE TOPUP
====================== */
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $amount = floatval($_POST['amount']);

    if($amount < 10){
        $message = "ขั้นต่ำ 10 บาท";
    } else {

        // 💳 เพิ่มเงิน (mock ก่อน)
        $stmt = $conn->prepare("UPDATE users SET balance = balance + ? WHERE id=?");
        $stmt->bind_param("di", $amount, $user_id);
        $stmt->execute();

        // 🧾 บันทึก transaction
        $stmt = $conn->prepare("INSERT INTO transactions (user_id, type, amount) VALUES (?, 'topup', ?)");
        $stmt->bind_param("id", $user_id, $amount);
        $stmt->execute();

        $message = "เติมเงินสำเร็จ +{$amount} บาท";
    }
}
?>

<section class="se-section">
  <div class="se-container">
    <div class="row justify-content-center">
      <div class="col-lg-6">

        <div class="se-card p-4">

          <h4 style="font-weight:900;">เติมเงินเข้าสู่ระบบ</h4>

          <?php if($message): ?>
            <div class="alert alert-info mt-3">
              <?= $message ?>
            </div>
          <?php endif; ?>

          <form method="POST" class="mt-3">

            <!-- จำนวนเงิน -->
            <label class="form-label">จำนวนเงิน (บาท)</label>
            <input type="number" name="amount" class="form-control mb-3" required>

            <!-- ช่องทาง -->
            <label class="form-label">ช่องทางการชำระเงิน</label>
            <select class="form-select mb-4">
              <option>PromptPay</option>
              <option>TrueMoney</option>
              <option>Wallet</option>
            </select>

            <button class="se-btn-green w-100">
              เติมเงิน
            </button>

          </form>

        </div>

      </div>
    </div>
  </div>
</section>

<?php include "partials/footer.php"; ?>