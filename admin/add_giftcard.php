<?php
require_once "../config/db.php";

$reward_id = intval($_POST['reward_id']);
$codes = explode("\n", $_POST['codes']);

foreach($codes as $code){
    $code = trim($code);

    if($code == '') continue;

    $conn->query("
      INSERT INTO giftcard_stock (reward_id, code)
      VALUES ($reward_id, '$code')
    ");
}

header("Location: giftcards.php");
exit;