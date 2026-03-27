<?php 
session_start();
require_once "../config/db.php";

$user_id = $_SESSION['user_id'];
$order_id = $_GET['order_id'];
$code = $_GET['code'] ?? '';
$discount = 0;

/* ======================
   GET ORDER INFO
====================== */
$stmt = $conn->prepare("
SELECT 
orders.id,
orders.price,
orders.status,
games.name AS game_name,
packages.name AS package_name,
orders.game_uid
FROM orders
JOIN packages ON orders.package_id = packages.id
JOIN games ON packages.game_id = games.id
WHERE orders.id=? AND orders.user_id=?
");
$stmt->bind_param("ii",$order_id,$user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if(!$order){
  die("Order not found");
}

/* ======================
   GET USER BALANCE
====================== */
$stmt = $conn->prepare("
SELECT balance FROM users WHERE id=?
");
$stmt->bind_param("i",$user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$balance = $user['balance'];

/* ======================
   CHECK DISCOUNT
====================== */
if($code){

  $stmt = $conn->prepare("
  SELECT * FROM discount_codes 
  WHERE code=? AND status='ACTIVE'
  ");
  $stmt->bind_param("s",$code);
  $stmt->execute();
  $result = $stmt->get_result();

  if($row = $result->fetch_assoc()){
    if($order['price'] >= $row['min_price']){
      $discount = $row['discount_amount'];
    }
  }

}

$final_price = max(0, $order['price'] - $discount);

/* ======================
   CONFIRM PURCHASE
====================== */
if(isset($_POST['confirm'])){
   
   if($order['status'] == 'success'){
      header("Location: history.php");
      exit;
   }
  if($balance < $final_price){
    $error = "Insufficient balance";
  }
  else{

    $conn->begin_transaction();

    try{

      /* deduct balance */
      $new_balance = $balance - $final_price;

      $stmt = $conn->prepare("
      UPDATE users SET balance=? WHERE id=?
      ");
      $stmt->bind_param("di",$new_balance,$user_id);
      $stmt->execute();

      /* update order */
      $stmt = $conn->prepare("
      UPDATE orders SET status='pending' WHERE id=?
      ");
      $stmt->bind_param("i",$order_id);
      $stmt->execute();

      /* insert transaction */
      $stmt = $conn->prepare("
      INSERT INTO transactions (user_id,type,amount,order_id)
      VALUES (?,?,?,?)
      ");
      $type = "purchase";
      $amount = -$final_price;
      $stmt->bind_param("isdi",$user_id,$type,$amount,$order_id);
      $stmt->execute();

      /* ===== GIVE POINT ===== */
      $points = floor($order['price'] / 10);

      $stmt = $conn->prepare("
      UPDATE users SET points = points + ? WHERE id=?
      ");
      $stmt->bind_param("ii",$points,$user_id);
      $stmt->execute();

      /* ===== USE DISCOUNT ===== */
      if($code){

        $stmt = $conn->prepare("
        UPDATE discount_codes 
        SET used_count = used_count + 1 
        WHERE code=?
        ");
        $stmt->bind_param("s",$code);
        $stmt->execute();

        $stmt = $conn->prepare("
        UPDATE discount_codes 
        SET status='USED'
        WHERE code=? AND used_count >= usage_limit
        ");
        $stmt->bind_param("s",$code);
        $stmt->execute();
      }

      $conn->commit();

      header("Location: history.php");
      exit();

    }catch(Exception $e){

      $conn->rollback();
      $error = "Transaction failed";

    }

  }

}
?>
<form method="POST">
  <button type="submit" name="confirm" class="se-btn-green w-100 mt-3">
    ยืนยันการชำระเงิน
  </button>
</form>