<?php
require_once "auth.php";
require_once "../config/db.php";

$user_id = $_SESSION['user_id'];

$error = null;
$codeData = null;
$uids = null;

/* ======================
   STEP 1: CHECK CODE
====================== */
if(isset($_POST['check_code'])){

  $input_code = strtoupper(trim($_POST['code']));

  if(empty($input_code)){
    $error = "กรุณากรอกโค้ด";
  } else {

    $stmt = $conn->prepare("
      SELECT bc.*, p.game_id, p.price, g.name AS game_name
      FROM bonus_codes bc
      LEFT JOIN packages p ON bc.package_id = p.id
      LEFT JOIN games g ON p.game_id = g.id
      WHERE bc.code = ? AND bc.status = 'unused'
      LIMIT 1
    ");
    $stmt->bind_param("s", $input_code);
    $stmt->execute();

    $codeData = $stmt->get_result()->fetch_assoc();

    if(!$codeData){
      $error = "โค้ดไม่ถูกต้อง หรือถูกใช้ไปแล้ว";
    } else {

      // 🔥 ดึง UID ของ user สำหรับเกมนี้
      $game_id = $codeData['game_id'];

      $uids = $conn->query("
        SELECT * FROM game_uids 
        WHERE user_id = $user_id AND game_id = $game_id
      ");
    }
  }
}

/* ======================
   STEP 2: GO CHECKOUT
====================== */
if(isset($_POST['go_checkout'])){

  $code = $_POST['code'];
  $uid = trim($_POST['uid']);

  if(empty($uid)){
    $error = "กรุณากรอก UID";
  } else {

    // 🔒 เช็ค code ซ้ำอีกรอบกันโกง
    $stmt = $conn->prepare("
      SELECT bc.*, p.price
      FROM bonus_codes bc
      LEFT JOIN packages p ON bc.package_id = p.id
      WHERE bc.code = ? AND bc.status = 'unused'
      LIMIT 1
    ");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $codeData = $stmt->get_result()->fetch_assoc();

    if(!$codeData){
      $error = "โค้ดไม่ถูกต้อง หรือถูกใช้ไปแล้ว";
    } else {

      $package_id = $codeData['package_id'];
      $price = $codeData['price'];

      // 🔥 SESSION ไป checkout
      $_SESSION['checkout']['package_id'] = $package_id;
      $_SESSION['checkout']['uid'] = $uid;
      $_SESSION['checkout']['discount'] = $price; // ฟรี 100%
      $_SESSION['checkout']['redeem_code'] = $code;

      header("Location: checkout.php");
      exit;
    }
  }
}
?>

<?php include "partials/header.php"; ?>

<section class="se-section">
  <div class="se-container">
    <div class="row justify-content-center">

      <div class="col-lg-6">
        <div class="se-card p-4">

          <h4 style="font-weight:900;">Redeem Code</h4>
          <hr>
          <!-- ================= STEP 1 ================= -->
          <?php if(!$codeData): ?>

          <form method="POST">

            <input 
              type="text"
              name="code"
              class="form-control mb-3"
              placeholder="กรอกโค้ด"
              required
            >

            <button class="se-btn-green w-100" name="check_code">
              ตรวจสอบโค้ด
            </button>

          </form>

          <?php endif; ?>

          <!-- ================= STEP 2 ================= -->
          <?php if($codeData): ?>

          <div class="mt-3 mb-3 p-3" style="background:#f5f5f5;border-radius:10px;">
            <div><strong>เกม:</strong> <?= htmlspecialchars($codeData['game_name']) ?></div>
            <div><strong>แพ็กเกจ:</strong> <?= htmlspecialchars($codeData['package_id']) ?></div>
            <div><strong>ราคา:</strong> <?= number_format($codeData['price']) ?> บาท</div>
            <div style="color:green;"><strong>ส่วนลด:</strong> ฟรี 100%</div>
          </div>

          <form method="POST">

            <input type="hidden" name="code" value="<?= $codeData['code'] ?>">

            <!-- UID INPUT -->
            <input 
              type="text"
              name="uid"
              id="uidInput"
              class="form-control mb-3"
              placeholder="กรอก UID"
              required
            >

            <!-- UID LIST -->
            <?php if($uids && $uids->num_rows > 0): ?>
              <select class="form-select mb-3" onchange="document.getElementById('uidInput').value=this.value">
                <option value="">-- เลือก UID ที่เคยใช้ --</option>
                <?php while($u = $uids->fetch_assoc()): ?>
                  <option value="<?= $u['uid'] ?>">
                    <?= htmlspecialchars($u['uid']) ?>
                  </option>
                <?php endwhile; ?>
              </select>
            <?php endif; ?>

            <button class="se-btn-green w-100" name="go_checkout">
              ดำเนินการต่อไป Checkout
            </button>

          </form>

          <?php endif; ?>

          <!-- ERROR -->
          <?php if($error): ?>
            <div class="alert alert-danger mt-3"><?= $error ?></div>
          <?php endif; ?>

        </div>
      </div>

    </div>
  </div>
</section>

<?php include "partials/footer.php"; ?>