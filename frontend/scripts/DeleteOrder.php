<?php
session_start();
include "../../conn.php";

$orderId = $_POST['orderId'];

try {
    // Delete the order with the given order ID
    $stmt = $conn->prepare("DELETE FROM orders WHERE orderid = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Order deleted successfully.";
    } else {
        throw new Exception("Failed to delete the order.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
