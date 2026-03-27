<?php
session_start();
require_once "../config/db.php";

$user_id = $_SESSION['user_id'];

/* ======================
   GET USER POINT
====================== */
$user = $conn->query("
SELECT points FROM users WHERE id = $user_id
")->fetch_assoc();

if($user['points'] < 100){
  die("Point ไม่พอ (ต้องมี 100)");
}

/* ======================
   GENERATE CODE
====================== */
$code = "SE" . rand(1000,9999);

/* ======================
   CREATE DISCOUNT
====================== */
$conn->query("
INSERT INTO discount_codes (code, discount_amount, usage_limit)
VALUES ('$code', 20, 1)
");

/* ======================
   DEDUCT POINT
====================== */
$conn->query("
UPDATE users 
SET points = points - 100
WHERE id = $user_id
");

echo "🎉 แลกสำเร็จ! Code ของคุณ: <b>$code</b>";