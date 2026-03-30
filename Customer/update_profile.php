<?php
require_once "../config/db.php";
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$type = $_POST['type'] ?? '';

/* =========================
   PERSONAL INFO
========================= */
if($type === 'personal'){

    $firstname = trim($_POST['firstname'] ?? '');
    $lastname  = trim($_POST['lastname'] ?? '');

    if($firstname !== '' && $lastname !== ''){
        $stmt = $conn->prepare("
            UPDATE users 
            SET firstname=?, lastname=? 
            WHERE id=?
        ");
        $stmt->bind_param("ssi", $firstname, $lastname, $user_id);
        $stmt->execute();
    }
}

/* =========================
   CONTACT INFO
========================= */
if($type === 'contact'){

    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    // validate email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: profile.php");
        exit;
    }

    // validate phone (10 digit)
    if(!preg_match('/^[0-9]{10}$/', $phone)){
        header("Location: profile.php");
        exit;
    }

    $stmt = $conn->prepare("
        UPDATE users 
        SET email=?, phone=? 
        WHERE id=?
    ");
    $stmt->bind_param("ssi", $email, $phone, $user_id);
    $stmt->execute();
}

/* =========================
   CHANGE PASSWORD
========================= */
if($type === 'password'){

    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm      = $_POST['confirm_password'] ?? '';

    // ดึง password เดิม
    $stmt = $conn->prepare("SELECT password FROM users WHERE id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if(!$result){
        header("Location: profile.php");
        exit;
    }

    // เช็ค password เดิม
    if(!password_verify($old_password, $result['password'])){
        header("Location: profile.php");
        exit;
    }

    // เช็ค confirm
    if($new_password !== $confirm || strlen($new_password) < 4){
        header("Location: profile.php");
        exit;
    }

    $hash = password_hash($new_password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("
        UPDATE users 
        SET password=? 
        WHERE id=?
    ");
    $stmt->bind_param("si", $hash, $user_id);
    $stmt->execute();
}

/* ========================= */
header("Location: profile.php");
exit;