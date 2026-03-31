<?php
include("auth.php");
include("../config/db.php");

$id     = $_POST["id"];
$name   = $_POST["name"];
$status = $_POST["status"];
$category = $_POST["category"];
$allowed = ['image/jpeg','image/png','image/jpg'];

if (!in_array($_FILES["image"]["type"], $allowed)) {
    die("อนุญาตเฉพาะ JPG, PNG, JPEG");
}
// ถ้ามีอัปโหลดรูปใหม่
if(!empty($_FILES["image"]["name"])){

  $fileName = time()."_".$_FILES["image"]["name"];
  $target   = "uploads/".$fileName;

  move_uploaded_file($_FILES["image"]["tmp_name"], $target);

  $conn->query("UPDATE games 
                SET name='$name', status='$status', category='$category', image='$target'
                WHERE id=$id");

} else {

  $conn->query("UPDATE games 
                SET name='$name', status='$status', category='$category'
                WHERE id=$id");
}

header("Location: games.php");
exit();
?>
