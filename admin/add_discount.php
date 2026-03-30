<?php
require_once "../config/db.php";

$code = $_POST['code'];
$amount = $_POST['discount_amount'];
$min = $_POST['min_price'];
$limit = $_POST['usage_limit'];

$conn->query("
INSERT INTO discount_codes (code, discount_amount, min_price, usage_limit, status, used_count)
VALUES ('$code','$amount','$min','$limit','ACTIVE',0)
");

header("Location: discounts.php");