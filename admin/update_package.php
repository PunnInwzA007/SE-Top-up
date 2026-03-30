<?php
require_once "../config/db.php";

$id      = $_POST['id'];
$game_id = $_POST['game_id'];
$name    = $_POST['name'];
$price   = $_POST['price'];
$status  = $_POST['status'];

if ($price < 0) { $price = 0; }
$sql = "UPDATE packages
        SET game_id='$game_id',
            name='$name',
            price='$price',
            status='$status'
        WHERE id='$id'";

$conn->query($sql);

header("Location: packages.php");