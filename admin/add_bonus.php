<?php
require_once "../config/db.php";

$package_id = $_POST['package_id'];
$codes = explode("\n", $_POST['codes']);

foreach($codes as $code){
    $code = trim($code);
    if($code == '') continue;

    $conn->query("
    INSERT INTO bonus_codes (code, package_id, status)
    VALUES ('$code', $package_id, 'unused')
    ");
}

header("Location: bonus_codes.php");
exit;