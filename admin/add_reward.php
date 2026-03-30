<?php
require_once "../config/db.php";

$name  = $_POST['name'];
$type  = $_POST['type'];

$package_id = $_POST['package_id'] !== '' ? intval($_POST['package_id']) : "NULL";
$point_cost = $_POST['point_cost'];
$amount = $_POST['amount'] !== '' ? intval($_POST['amount']) : "NULL";

$sql = "INSERT INTO rewards (name,type,package_id,point_cost,amount)
        VALUES ('$name','$type',$package_id,'$point_cost',$amount)";

$conn->query($sql);

header("Location: rewards.php");