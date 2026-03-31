<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../config/omise.php";
require_once __DIR__ . "/../omise/lib/Omise.php";

if(!isset($_SESSION['user_id'])){
    die("not login");
}

$user_id = $_SESSION['user_id'];

/* =========================
   แยก flow
========================= */
$type = '';
$amount = 0;
$package_id = null;

/* ===== WALLET ===== */
if(isset($_GET['amount']) && !isset($_GET['package_id'])){
    $amount = floatval($_GET['amount']);

    if($amount < 10){
        die("invalid amount");
    }

    $type = 'wallet';
}

/* ===== PACKAGE ===== */
if(isset($_GET['package_id'])){
    $package_id = intval($_GET['package_id']);

    // 🔥 ดึงราคา package
    $stmt = $conn->prepare("SELECT price FROM packages WHERE id=?");
    $stmt->bind_param("i", $package_id);
    $stmt->execute();
    $pkg = $stmt->get_result()->fetch_assoc();

    if(!$pkg){
        die("package not found");
    }

    // 🔥 ใช้ราคาจาก checkout (รวม discount แล้ว)
    if(isset($_GET['amount'])){
        $amount = floatval($_GET['amount']);
    } else {
        $amount = $pkg['price'];
    }

    $type = 'package';
}

/* ===== ถ้าไม่มีอะไรเลย ===== */
if(!$type){
    die("invalid request");
}

/* =========================
   GET DISCOUNT FROM SESSION
========================= */
$discount_code = $_SESSION['checkout']['discount_code'] ?? null;

/* =========================
   CREATE CHARGE
========================= */
$charge = OmiseCharge::create([
    'amount' => $amount * 100,
    'currency' => 'thb',
    'source' => ['type' => 'promptpay'],
    'metadata' => [
        'type' => $type,
        'user_id' => $user_id,
        'package_id' => $package_id,
        'discount_code' => $discount_code
    ]
]);

$charge_id = $charge['id'];

/* =========================
   SAVE PAYMENT
========================= */
$stmt = $conn->prepare("
INSERT INTO payments (user_id, charge_id, amount, type, package_id, status, discount_code)
VALUES (?, ?, ?, ?, ?, 'pending', ?)
");

$stmt->bind_param(
    "isdsss",
    $user_id,
    $charge_id,
    $amount,
    $type,
    $package_id,
    $discount_code
);

$stmt->execute();

/* =========================
   REDIRECT
========================= */
header("Location: check_status.php?id=".$charge_id);
exit;