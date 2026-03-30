<?php
require_once "auth.php";
require_once "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = intval($_POST['id']);

    if ($id <= 0) {
        header("Location: games.php?error=invalid_id");
        exit;
    }

    // เริ่ม transaction กันพัง
    $conn->begin_transaction();

    try {

        // 🔥 ลบเกม (CASCADE จะจัดการ packages + game_uids ให้เอง)
        $stmt = $conn->prepare("DELETE FROM games WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // เช็คว่าลบจริงไหม
        if ($stmt->affected_rows <= 0) {
            throw new Exception("Delete failed");
        }

        // commit
        $conn->commit();

        header("Location: games.php?success=delete");
        exit;

    } catch (Exception $e) {

        // rollback ถ้ามีปัญหา
        $conn->rollback();

        header("Location: games.php?error=delete_fail");
        exit;
    }
}