<?php
require_once "../config/db.php";

$id = $_POST['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$status = $_POST['status'] ?? 'active';

$conn->query("
UPDATE users
SET username='$username',
    email='$email',
    status='$status'
WHERE id=$id
");

header("Location: users.php");
exit;