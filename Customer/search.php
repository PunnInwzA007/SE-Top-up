<?php
// search.php
$host = "db";           // ❗ ห้ามใช้ localhost ให้ใช้ชื่อ service ใน docker-compose
$user = "root";
$pass = "root";         // ❗ ใน docker-compose ของคุณตั้ง password ไว้ว่า root
$db   = "se_topup";     // ชื่อ DB จาก docker-compose

$conn = new mysqli($host, $user, $pass, $db);

// เช็คการเชื่อมต่อ (ถ้าพังจะแจ้ง error ออกมา)
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$conn->set_charset("utf8mb4");
header('Content-Type: application/json');

$q = $_GET['q'] ?? '';

if ($q !== '') {
    $stmt = $conn->prepare("SELECT id, name, image FROM games WHERE name LIKE ? LIMIT 5");
    $searchTerm = "%$q%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $games = [];
    while ($row = $result->fetch_assoc()) {
        $games[] = $row;
    }
    echo json_encode($games);
} else {
    echo json_encode([]);
}