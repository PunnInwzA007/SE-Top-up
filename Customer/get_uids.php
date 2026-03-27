<?php
session_start();
require_once "../config/db.php";

$user_id = $_SESSION['user_id'];
$game_id = $_GET['game_id'];

$stmt = $conn->prepare("
SELECT id, uid FROM game_uids 
WHERE user_id=? AND game_id=?
ORDER BY id DESC
");

$stmt->bind_param("ii",$user_id,$game_id);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()){
  $data[] = $row;
}

echo json_encode($data);