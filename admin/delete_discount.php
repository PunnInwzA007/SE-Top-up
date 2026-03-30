<?php
require_once "../config/db.php";

$id = intval($_GET['id']);

$conn->query("
UPDATE discount_codes 
SET status='DISABLED' 
WHERE id=$id
");

header("Location: discounts.php?success=deleted");
exit;