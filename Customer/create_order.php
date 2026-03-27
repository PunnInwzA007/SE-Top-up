<?php
session_start();
require_once "../config/db.php";

$user_id = $_SESSION['user_id'];
$package_id = $_POST['package_id'];
$uid = $_POST['uid'];

// ดึงราคา package
$stmt = $conn->prepare("SELECT price FROM packages WHERE id=?");
$stmt->bind_param("i",$package_id);
$stmt->execute();
$package = $stmt->get_result()->fetch_assoc();

$price = $package['price'];

// สร้าง order
$stmt = $conn->prepare("
INSERT INTO orders (user_id, package_id, game_uid, price, status)
VALUES (?,?,?,?, 'pending')
");

$stmt->bind_param("iisd",$user_id,$package_id,$uid,$price);
$stmt->execute();

$order_id = $stmt->insert_id;

// redirect ไป checkout
header("Location: checkout.php?order_id=".$order_id);