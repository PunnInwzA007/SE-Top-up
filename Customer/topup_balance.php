<?php
// 🔥 ห้ามมี space / บรรทัดว่างก่อนนี้เด็ดขาด

require_once "auth.php";
require_once "../config/db.php";

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

        header("Location: ../payment/create_charge.php?amount=".$amount);
        exit;
    }
}

include "partials/header.php";
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