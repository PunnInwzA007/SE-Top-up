<?php
require_once "auth.php";
require_once "../config/db.php";

if(isset($_POST['go_checkout'])){

  $code = $_POST['code'];
  $uid = $_POST['uid'];

  if(empty($uid)){
    $error = "กรุณากรอก UID";
  } else {

    // 🔍 หา bonus code
    $stmt = $conn->prepare("
      SELECT * FROM bonus_codes 
      WHERE code = ? AND status = 'unused'
      LIMIT 1
    ");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $codeData = $stmt->get_result()->fetch_assoc();

    if(!$codeData){
      $error = "โค้ดไม่ถูกต้อง";
    } else {

      // 🔥 ดึง package ของ reward นี้
      // (สมมติ bonus_codes มี package_id แล้ว)
      $package_id = $codeData['package_id'];

      $stmt = $conn->prepare("
        SELECT price FROM packages WHERE id = ?
      ");
      $stmt->bind_param("i", $package_id);
      $stmt->execute();
      $pkg = $stmt->get_result()->fetch_assoc();

      if(!$pkg){
        $error = "Package ไม่ถูกต้อง";
      } else {

        // 🔥 SET SESSION (สำคัญสุด)
        $_SESSION['checkout']['package_id'] = $package_id;
        $_SESSION['checkout']['uid'] = $uid;

        // 👇 ทำให้ฟรี 100%
        $_SESSION['checkout']['discount'] = $pkg['price'];

        // เก็บไว้ mark used ตอน checkout
        $_SESSION['checkout']['redeem_code'] = $code;

        // 🔥 ไป checkout เลย
        header("Location: checkout.php");
        exit;
      }
    }
  }
}
?>
<?php
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
      SELECT bc.*, g.name AS game_name 
      FROM bonus_codes bc
      LEFT JOIN games g ON bc.game_id = g.id
      WHERE bc.code = ? AND bc.status = 'unused'
      LIMIT 1
    ");
    $stmt->bind_param("s", $input_code);
    $stmt->execute();

    $codeData = $stmt->get_result()->fetch_assoc();

    if(!$codeData){
      $error = "โค้ดไม่ถูกต้อง หรือถูกใช้ไปแล้ว";
    } else {

      $game_id = $codeData['game_id'];

      // 🔥 ดึง UID ของเกมนั้น
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
  $uid = $_POST['uid'];
  $game_id = $_POST['game_id'];

  if(empty($uid)){
    $error = "กรุณากรอก UID";
  } else {

    // 🔥 redirect ไป checkout
    $_SESSION['checkout']['uid'] = $uid;
    $_SESSION['checkout']['redeem_code'] = $code;
    $_SESSION['checkout']['game_id'] = $game_id;

    header("Location: checkout.php");
    exit;
  }
}
?>

<?php include "partials/header.php"; ?>

<section class="se-section">
  <div class="se-container">
    <div class="row justify-content-center">

      <div class="col-lg-6">
        <div class="se-card p-4">

          <h4 style="font-weight:900;">🎁 Redeem Code</h4>

          <!-- STEP 1 -->
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

          <!-- STEP 2 -->
          <?php if($codeData): ?>

          <div class="mt-3">
            <strong>เกม:</strong> <?= htmlspecialchars($codeData['game_name']) ?><br>
            <strong>โบนัส:</strong> -<?= $codeData['value'] ?>
          </div>

          <form method="POST" class="mt-3">

            <input type="hidden" name="code" value="<?= $codeData['code'] ?>">
            <input type="hidden" name="game_id" value="<?= $codeData['game_id'] ?>">

            <!-- UID INPUT -->
            <input 
              type="text"
              name="uid"
              class="form-control mb-3"
              placeholder="กรอก UID"
              required
            >

            <!-- UID LIST -->
            <?php if($uids && $uids->num_rows > 0): ?>
              <select class="form-select mb-3" onchange="this.previousElementSibling.value=this.value">
                <option value="">-- เลือก UID ที่เคยใช้ --</option>
                <?php while($u = $uids->fetch_assoc()): ?>
                  <option value="<?= $u['uid'] ?>">
                    <?= htmlspecialchars($u['uid']) ?>
                  </option>
                <?php endwhile; ?>
              </select>
            <?php endif; ?>

            <button class="se-btn-green w-100" name="go_checkout">
              ดำเนินการต่อ
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