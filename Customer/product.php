<?php require_once "auth.php"; ?>
<?php 
require_once "../config/db.php";

$game_id = $_GET['game_id'] ?? 0;
if (!$game_id || !is_numeric($game_id)) {
  die("Invalid game");
}
$sql = "SELECT * FROM games WHERE id = $game_id";
$game = $conn->query($sql)->fetch_assoc();

if (!$game) {
  die("Game not found");
}
$sql = "
SELECT * FROM packages 
WHERE game_id = $game_id AND status='ON'
";
$packages = $conn->query($sql);

?>
<?php include "partials/header.php"; ?>

<!-- PAGE HERO -->
<section class="se-page-hero">
  <div class="se-page-hero-inner">
    <h2 class="se-page-title"><?= htmlspecialchars($game['name']) ?></h2>
    <p class="se-page-breadcrumb">
      Home > Top-Up > <?= htmlspecialchars($game['name']) ?>
    </p>
</section>

<section class="se-section">
  <div class="se-container">

    <div class="row g-5">

      <!-- ================= LEFT ================= -->
      <div class="col-lg-4">

        <div class="se-card p-4">
          <img src="../admin/<?= htmlspecialchars($game['image']) ?>" class="se-ph se-ph-wide mb-3" alt="<?= htmlspecialchars($game['name']) ?>">

          <h4 style="font-weight:900;">
            <?= htmlspecialchars($game['name']) ?>
          </h4>

          <p style="font-size:14px; line-height:1.7;">
            เติม Credit เกม <br>
            ขั้นตอนการเติมเกม:
            <br>1. เลือกแพ็คเกจ
            <br>2. กรอก UID
            <br>3. เลือกช่องทางชำระเงิน
          </p>
        </div>

      </div>

      <!-- ================= RIGHT ================= -->
      <div class="col-lg-8">

        <!-- GAME ID -->
        <div class="se-card p-4 mb-4">
          <h5 class="mb-3" style="font-weight:800;">Game ID</h5>

          <form action="add_uid.php" method="POST">
  
            <input type="hidden" name="game_id" value="<?= $game_id ?>">

            <input type="text"
              name="uid"
              id="uidInput"
              class="form-control mb-3"
              placeholder="กรอก User ID / UID"
              required>

            <button type="button" id="saveUidBtn" class="se-btn-green w-100 mb-2">
              บันทึก ID นี้เป็น ID หลัก
            </button>

          </form>

          <button type="button" id="manageUidBtn" class="se-btn-gray w-100">
            จัดการ ID หลัก
          </button>
        </div>

        <!-- PRODUCT BOX -->
        <div class="se-card p-4 mb-4">
    
        <div class="se-product-box">

          <!-- PAYMENT -->
    

            <h5 style="font-weight:800;">เลือกช่องทางการชำระเงิน</h5>
            <section class="se-payment mt-4">
            <div class="se-container">
                <div class="row g-3">

                <div class="col-6 col-lg-4">
                    <div class="se-payment-card" data-payment="promptpay">
                    <div class="se-payment-logo"><img src="../admin/uploads/promptpay.jpg" alt="PromptPay"></div>
                    <div class="se-payment-name">PromptPay</div>
                    </div>
                </div>

                <div class="col-6 col-lg-4">
                    <div class="se-payment-card" data-payment="truemoney">
                    <div class="se-payment-logo"><img src="../admin/uploads/truemoney.jpg" alt="TrueMoney"></div>
                    <div class="se-payment-name">TrueMoney</div>
                    </div>
                </div>

                <div class="col-6 col-lg-4">
                    <div class="se-payment-card" data-payment="wallet">
                    <div class="se-payment-logo"><img src="../admin/uploads/wallet.jpg" alt="Wallet"></div>
                    <div class="se-payment-name">Wallet</div>
                    </div>
                </div>

                </div>
            </div>
            </section>


          <!-- PACKAGE -->
            <h5 class="mt-5 mb-3 fw-bold">เลือกแพ็กเกจ</h5>

            <div class="row g-3">
              <input type="hidden" id="selectedPackageId">
              <?php while($p = $packages->fetch_assoc()): ?>

                <div class="col-6 col-lg-4">
                  <div class="se-package-card"
                      data-price="<?= $p['price'] ?>"
                      data-id="<?= $p['id'] ?>">

                    <div class="se-package-name">
                      <?= htmlspecialchars($p['name']) ?>
                    </div>

                    <div class="se-package-price">
                      ฿<?= number_format($p['price'],2) ?>
                    </div>

                  </div>
                </div>

              <?php endwhile; ?>
            </div>


          <!-- DISCOUNT -->
            <div class="se-product-section">
            <h5 class="se-section-title">ส่วนลด</h5>

            <div class="se-discount-row">
                <input type="text"
                    id="discountInput"
                    class="se-discount-input"
                    placeholder="กรอกโค้ดส่วนลด">

                <button type="button"
                        id="applyDiscount"
                        class="se-btn-green se-discount-btn">
                ใช้งาน
                </button>
            </div>
            </div>

          <!-- SUMMARY -->
          <div class="se-summary-box">

            <div class="se-summary-row">
              <span>ราคาสินค้า</span>
              <span>฿<span id="productPrice">0</span></span>
            </div>

            <div class="se-summary-row">
              <span>ส่วนลด</span>
              <span>-฿<span id="discountPrice">0</span></span>
            </div>

            <div class="se-total">
              สรุปยอดชำระเงิน ฿<span id="totalPrice">0</span>
            </div>

            <button id="continueBtn" class="se-btn-green" disabled>
            ดำเนินการต่อ
            </button>

          </div>

        </div>

      </div>
      

    </div>

  </div>
</section>

<script src="assets/js/product.js"></script>
<?php include "partials/footer.php"; ?>