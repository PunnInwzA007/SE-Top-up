<?php
require_once "../config/db.php";

$game_id = $_POST['game_id'];
$name    = $_POST['name'];
$price   = $_POST['price'];
$status  = $_POST['status'];

if ($price < 0) { $price = 0; }
$sql = "INSERT INTO packages (game_id,name,price,status)
        VALUES ('$game_id','$name','$price','$status')";

$conn->query($sql);

header("Location: packages.php");