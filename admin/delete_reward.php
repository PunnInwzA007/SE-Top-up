<?php
require_once "../config/db.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: rewards.php?error=invalid_id");
    exit;
}

$id = intval($_GET['id']);

// เช็คว่ามี reward จริงไหม
$check = $conn->query("SELECT id FROM rewards WHERE id=$id");

if ($check->num_rows === 0) {
    header("Location: rewards.php?error=not_found");
    exit;
}

// 🔥 soft delete (เปลี่ยนเป็น OFF)
$conn->query("UPDATE rewards SET status='OFF' WHERE id=$id");

header("Location: rewards.php?success=deleted");
exit;
?>