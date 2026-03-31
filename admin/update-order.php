<?php
require_once "auth.php";
require_once "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = intval($_POST['id']);
    $status = $_POST['status'];

    $allowed = ['pending','success','cancel'];

    if ($id > 0 && in_array($status, $allowed)) {

        $conn->begin_transaction();

        try {

            // 🔥 ดึง order เดิม
            $stmt = $conn->prepare("SELECT user_id, price, status FROM orders WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $order = $stmt->get_result()->fetch_assoc();

            if (!$order) {
                throw new Exception("Order not found");
            }

            $userId = $order['user_id'];
            $price  = $order['price'];
            $oldStatus = $order['status'];

            // 🔥 อัปเดตสถานะ
            $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
            $stmt->bind_param("si", $status, $id);
            $stmt->execute();

            // =========================
            // 💣 CASE: CANCEL
            // =========================
            if ($status === 'cancel' && $oldStatus !== 'cancel') {

                // ✅ คืนเงิน
                $stmt = $conn->prepare("UPDATE users SET balance = balance + ? WHERE id=?");
                $stmt->bind_param("di", $price, $userId);
                $stmt->execute();
                // ✅ หัก point (ตามราคาที่ซื้อ)
                $stmt = $conn->prepare("
                    UPDATE users 
                    SET points = GREATEST(points - ?, 0)
                    WHERE id=?
                ");

                $pointToRemove = intval($price / 10);
                $stmt->bind_param("ii", $pointToRemove, $userId);
                $stmt->execute();
                // ✅ บันทึก transaction (refund)
                $stmt = $conn->prepare("
                    INSERT INTO transactions (user_id, type, amount, order_id)
                    VALUES (?, 'refund', ?, ?)
                ");

                $stmt->bind_param("idi", $userId, $price, $id);
                $stmt->execute();

                // ❗ (optional) ตัด point ถ้ามึงเคยให้
                // $conn->query("UPDATE users SET points = points - 10 WHERE id=$userId");
            }

            $conn->commit();

        } catch (Exception $e) {

            $conn->rollback();
        }
    }
}

header("Location: orders.php");
exit;