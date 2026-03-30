<?php
require_once "../config/db.php";

$id = intval($_GET['id']);

$conn->query("DELETE FROM giftcard_stock WHERE id=$id");

header("Location: giftcards.php");
exit;