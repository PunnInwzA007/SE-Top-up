<?php
include("auth.php");
include("../config/db.php");

$name   = $_POST["name"];
$status = $_POST["status"];
$category = $_POST["category"];

// Upload Image
$fileName = time() . "_" . $_FILES["image"]["name"];
$target = "uploads/" . $fileName;

move_uploaded_file($_FILES["image"]["tmp_name"], $target);

// Insert DB
$conn->query("INSERT INTO games(name,image,status,category)
            VALUES('$name','$target','$status','$category')");

header("Location: games.php");
exit();
?>
