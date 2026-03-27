<?php
require_once "../config/db.php";

$code = $_GET['code'] ?? '';

$sql = "
SELECT * FROM discount_codes 
WHERE code='$code' AND status='ACTIVE'
";

$result = $conn->query($sql);

if($result->num_rows > 0){
  $row = $result->fetch_assoc();

  echo json_encode([
    "success" => true,
    "amount" => $row['discount_amount']
  ]);
}else{
  echo json_encode(["success"=>false]);
}