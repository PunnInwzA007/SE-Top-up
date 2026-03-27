<?php
require_once "../config/db.php";

$code = $_GET['code'] ?? '';
$price = $_GET['price'] ?? 0;

$stmt = $conn->prepare("
SELECT * FROM discount_codes 
WHERE code=? AND status='ACTIVE'
");

$stmt->bind_param("s",$code);
$stmt->execute();
$result = $stmt->get_result();

if($row = $result->fetch_assoc()){

  if($price >= $row['min_price']){
    echo json_encode([
      "success" => true,
      "amount" => $row['discount_amount']
    ]);
  }else{
    echo json_encode([
      "success" => false
    ]);
  }

}else{
  echo json_encode([
    "success" => false
  ]);
}