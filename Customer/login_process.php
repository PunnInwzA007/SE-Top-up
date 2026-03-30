<?php

session_start();
require_once "../config/db.php";

if(isset($_POST['login'])){

$username = trim($_POST['username']);
$password = trim($_POST['password']);

/* ===== ดึง user ===== */

$stmt = $conn->prepare("
SELECT id, username, password, status
FROM users
WHERE username = ?
");

$stmt->bind_param("s",$username);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 1){

$user = $result->fetch_assoc();

/* 🔥 เช็ค banned */
if($user['status'] == 'banned'){
    $_SESSION['error'] = "บัญชีถูกระงับ";
    header("Location: login.php");
    exit();
}
/* ===== เช็ค password ===== */

if(password_verify($password, $user['password'])){

$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];

header("Location: index.php");
exit();

}else{

$_SESSION['error'] = "Incorrect password";
header("Location: login.php");
exit();

}

}else{

$_SESSION['error'] = "User not found";
header("Location: login.php");
exit();

}

}