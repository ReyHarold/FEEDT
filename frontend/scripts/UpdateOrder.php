<?php
session_start();
include "../../conn.php";

// Get user input
$orderId = $_POST['orderId'];
$password = $_POST['password'];
$userid = $_SESSION['id'];

try {
    // Fetch the user's password from the database
    $stmt = $conn->prepare("SELECT password FROM user WHERE userid = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("User not found.");
    }

    $user = $result->fetch_assoc();
    $storedPassword = $user['password'];

    // Verify the entered password
    if (!password_verify($password, $storedPassword)) {
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
