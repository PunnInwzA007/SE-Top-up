<?php require_once "auth.php"; ?>
<?php require_once "../config/db.php"; ?>

<?php
$user_id = $_SESSION['user_id'];
$reward_id = $_GET['id'] ?? 0;

/* ======================
   GET REWARD + USER
====================== */
$reward = $conn->query("
  SELECT r.*, g.image AS game_image
  FROM rewards r
  LEFT JOIN packages p ON r.package_id = p.id
  LEFT JOIN games g ON p.game_id = g.id
  WHERE r.id = $reward_id AND r.status='ON'
")->fetch_assoc();

$user = $conn->query("
  SELECT points, balance 
  FROM users 
  WHERE id = $user_id
")->fetch_assoc();

if(!$reward){
  die("Reward not found");
}

if($user['points'] < $reward['point_cost']){
  $error = "Point ไม่พอ";
}

/* ======================
   HANDLE REDEEM
====================== */
if(isset($_POST['confirm']) && empty($error)){

  $conn->begin_transaction();

  try {
    $detail = null;

    /* ===== BALANCE ===== */
    if($reward['type'] == 'balance'){
      // ดึงจำนวนเงินจากชื่อ เช่น "เงิน 50 บาท"
      $amount = $reward['amount'];

      $conn->query("
        UPDATE users 
        SET balance = balance + $amount 
        WHERE id = $user_id
      ");

      $detail = "+$amount บาท";
    }

    /* ===== CODE ===== */
    if($reward['type'] == 'code'){
      $code = "BONUS" . strtoupper(bin2hex(random_bytes(3)));

      $conn->query("
        INSERT INTO bonus_codes (user_id, code, status, package_id)
        VALUES ($user_id, '$code', 'unused', ".($reward['package_id'] ?? "NULL").")
      ");

      $detail = $code;
    }

    /* ===== GIFTCARD ===== */
    if($reward['type'] == 'giftcard'){
      $gift = $conn->query("
        SELECT * FROM giftcard_stock 
        WHERE reward_id = {$reward['id']} AND status='available'
        LIMIT 1
      ")->fetch_assoc();

      if(!$gift){
        throw new Exception("Giftcard หมด");
      }

      $conn->query("
        UPDATE giftcard_stock 
        SET status='used', used_by=$user_id, used_at=NOW()
        WHERE id = {$gift['id']}
      ");

      $detail = $gift['code'];
    }

    /* ===== หัก POINT ===== */
    $conn->query("
      UPDATE users 
      SET points = points - {$reward['point_cost']}
      WHERE id = $user_id
    ");

    /* ===== HISTORY ===== */
    $conn->query("
      INSERT INTO user_rewards (user_id, reward_id, detail, status)
      VALUES ($user_id, {$reward['id']}, '$detail', 'success')
    ");

    $conn->commit();

    $success = "แลกสำเร็จ! ได้: $detail";

  } catch (Exception $e) {
    $conn->rollback();
    $error = $e->getMessage();
  }
}

/* ======================
   IMAGE
====================== */
function getRewardImage($r){
  if($r['type'] === 'balance'){
    return '../admin/uploads/point+.png';
  }
  return !empty($r['game_image'])
    ? '../admin/' . $r['game_image']
    : '../admin/uploads/default.png';
}
?>
<?php include "partials/header.php"; ?>

<section class="se-section">
  <div class="se-container">

    <!-- 🔙 BACK -->
    <a href="points.php" class="se-btn-red mb-3">← กลับ</a>

    <div class="row g-4">

      <!-- LEFT -->
      <div class="col-lg-7">
        <div class="se-card p-4">

          <h5 class="mb-4" style="font-weight:900;">รายละเอียด Reward</h5>

          <img src="<?= getRewardImage($reward) ?>" class="se-ph se-ph-wide mb-3">

          <div class="mb-2"><strong>ชื่อ:</strong> <?= htmlspecialchars($reward['name']) ?></div>
          <div class="mb-2"><strong>ประเภท:</strong> <?= $reward['type'] ?></div>
          <div class="mb-2"><strong>มูลค่า:</strong> <?= $reward['value'] ?></div>

        </div>
      </div>

      <!-- RIGHT -->
      <div class="col-lg-5">
        <div class="se-card p-4">

          <h5 class="mb-4" style="font-weight:900;">สรุปการแลก</h5>

          <div class="d-flex justify-content-between mb-2">
            <span>แต้มที่ใช้</span>
            <span><?= number_format($reward['point_cost']) ?></span>
          </div>

          <hr>

          <div class="mb-3">
            <span>แต้มของคุณ:</span>
            <strong><?= number_format($user['points']) ?></strong>
          </div>

          <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
          <?php endif; ?>

          <?php if(isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
          <?php endif; ?>

          <form method="POST">
            <button 
              type="submit" 
              name="confirm"
              class="se-btn-green w-100"
              <?= isset($error) ? 'disabled' : '' ?>
            >
              ยืนยันการแลก
            </button>
          </form>

        </div>
      </div>

    </div>

  </div>
</section>

<?php include "partials/footer.php"; ?>