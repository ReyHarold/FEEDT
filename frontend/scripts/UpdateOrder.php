<?php
session_start();
include "../../conn.php";
include "../../backend/verify_password.php";

// Get user input
$orderId = $_POST['orderId'];
$password = $_POST['password'];

try {
    // Verify the entered password against the logged-in user's stored
    // credentials (supports bcrypt hashes and legacy plaintext rows).
    if (!verify_current_user_password($conn, $password)) {
        throw new Exception("Incorrect password.");
    }

    // Update the order status to 'delivered'
    $updateStmt = $conn->prepare("
        UPDATE orders 
        SET status = 'delivered', delivered_date = NOW() 
        WHERE orderid = ?
    ");
    $updateStmt->bind_param("i", $orderId);
    $updateStmt->execute();

    if ($updateStmt->affected_rows > 0) {
        echo "Order status updated to 'delivered' successfully.";
    } else {
        throw new Exception("Failed to update the order status.");
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn->close();
?>
