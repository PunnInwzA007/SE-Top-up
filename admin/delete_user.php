<?php
require_once "../config/db.php";

$id = intval($_GET['id']);

$conn->query("
UPDATE users SET status='banned' WHERE id=$id
");

header("Location: users.php");
exit;