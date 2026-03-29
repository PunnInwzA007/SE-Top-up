<?php
session_start();
require_once "../config/db.php";

$user_id = $_SESSION['user_id'];
$reward_id = $_GET['id'] ?? 0;

/* ======================
   GET REWARD + USER
====================== */
$reward = $conn->query("SELECT * FROM rewards WHERE id = $reward_id")->fetch_assoc();
$user = $conn->query("SELECT points FROM users WHERE id = $user_id")->fetch_assoc();

if(!$reward){
  die("Reward not found");
}

if($user['points'] < $reward['point_cost']){
  die("Point ไม่พอ");
}

/* ======================
   START TRANSACTION (สำคัญ)
====================== */
$conn->begin_transaction();

try {

  $detail = null;

  /* ======================
     TYPE: balance
  ====================== */
  if($reward['type'] == 'balance'){

    $conn->query("
      UPDATE users 
      SET balance = balance + {$reward['value']}
      WHERE id = $user_id
    ");

    $detail = "+{$reward['value']} balance";
  }

  /* ======================
     TYPE: code
  ====================== */
  if($reward['type'] == 'code'){

    $code = "SE" . rand(1000,9999);

    $conn->query("
      INSERT INTO discount_codes (code, discount_amount, usage_limit)
      VALUES ('$code', {$reward['value']}, 1)
    ");

    $detail = $code; // ⭐ เก็บ code ลง history
  }

  /* ======================
     TYPE: giftcard
  ====================== */
  if($reward['type'] == 'giftcard'){

    // ดึง code ที่ยัง available
    $gift = $conn->query("
      SELECT * FROM giftcard_stock 
      WHERE reward_id = {$reward['id']} AND status = 'available'
      LIMIT 1
    ")->fetch_assoc();

    if(!$gift){
      throw new Exception("Giftcard หมด");
    }

    // mark used
    $conn->query("
      UPDATE giftcard_stock 
      SET status='used', used_by=$user_id, used_at=NOW()
      WHERE id = {$gift['id']}
    ");

    $detail = $gift['code']; // ⭐ เก็บ code ลง history
  }

  /* ======================
     DEDUCT POINT
  ====================== */
  $conn->query("
    UPDATE users 
    SET points = points - {$reward['point_cost']}
    WHERE id = $user_id
  ");

  /* ======================
     INSERT HISTORY ⭐ สำคัญ
  ====================== */
  $conn->query("
    INSERT INTO user_rewards (user_id, reward_id, detail, status)
    VALUES ($user_id, {$reward['id']}, '$detail', 'success')
  ");

  $conn->commit();

  echo "🎉 แลกสำเร็จ! ได้: <b>$detail</b>";

} catch (Exception $e) {
  $conn->rollback();
  echo "❌ Error: " . $e->getMessage();
}