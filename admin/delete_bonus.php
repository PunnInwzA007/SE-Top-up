<?php
require_once "../config/db.php";

$id = intval($_GET['id']);

$conn->query("DELETE FROM bonus_codes WHERE id=$id");

header("Location: bonus_codes.php");
exit;