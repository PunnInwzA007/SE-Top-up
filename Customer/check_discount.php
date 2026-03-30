<?php
session_start();
require_once "../config/db.php";

$code = $_GET['code'] ?? '';
$price = $_GET['price'] ?? 0;

$stmt = $conn->prepare("
SELECT * FROM discount_codes 
WHERE code=? 
AND status='ACTIVE'
AND used_count < usage_limit
");

$stmt->bind_param("s",$code);
$stmt->execute();
$result = $stmt->get_result();

if($row = $result->fetch_assoc()){

  if($price >= $row['min_price']){
    $_SESSION['checkout']['discount_code'] = $code;

    echo json_encode([
      "success" => true,
      "amount" => $row['discount_amount']
    ]);

  }else{
    echo json_encode([
      "success" => false,
      "message" => "ยอดขั้นต่ำไม่ถึง (ขั้นต่ำ {$row['min_price']} บาท)"
    ]);
  }

}else{
  echo json_encode([
    "success" => false,
    "message" => "โค้ดไม่ถูกต้อง หรือถูกใช้ไปแล้ว"
  ]);
}