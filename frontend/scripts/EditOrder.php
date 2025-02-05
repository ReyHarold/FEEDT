<?php
session_start();
include "../../conn.php";

$orderId = $_POST['orderId'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];

try {
    // Update the order with the new quantity and price
    $stmt = $conn->prepare("UPDATE orders SET quantity = ?, price = ? WHERE orderid = ?");
    $stmt->bind_param("idi", $quantity, $price, $orderId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Order updated successfully.";
    } else {
        throw new Exception("No changes were made or order not found.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
