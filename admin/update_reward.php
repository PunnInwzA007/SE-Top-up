<?php
require_once "../config/db.php";

$id    = $_POST['id'];
$name  = $_POST['name'];
$type  = $_POST['type'];

$package_id = $_POST['package_id'] !== '' ? $_POST['package_id'] : "NULL";
$point_cost = $_POST['point_cost'];
$amount = $_POST['amount'] !== '' ? $_POST['amount'] : "NULL";

$point_cost = intval($_POST['point_cost']);
$amount = $_POST['amount'] !== '' ? intval($_POST['amount']) : null;

if ($point_cost < 0) {
    die("point_cost ห้ามติดลบ");
}

if ($amount !== null && $amount < 0) {
    die("amount ห้ามติดลบ");
}
$sql = "UPDATE rewards
        SET name='$name',
            type='$type',
            package_id=$package_id,
            point_cost='$point_cost',
            amount=$amount
        WHERE id=$id";

$conn->query($sql);

header("Location: rewards.php");