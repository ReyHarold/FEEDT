<?php
session_start();
include "../../conn.php";

$orderId = $_POST['orderId'];

try {
    // Update the status of the order to 'delivered'
    $stmt = $conn->prepare("UPDATE orders SET status = 'delivered', `delivered_date` = NOW()  WHERE orderid = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Order marked as delivered successfully.";
    } else {
        throw new Exception("Failed to update the order status.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>
