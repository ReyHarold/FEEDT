<?php
include "../../conn.php";
session_start();

// Get POST data from the form
$userid = $_POST['userid'];
$item = $_POST['feed'];
$quantity = intval($_POST['quantity']);
$status = 'pending';

try {
    // Start transaction
    $conn->begin_transaction();

    // Fetch price from the inventory for the selected item
    $priceStmt = $conn->prepare("SELECT price, quantity AS available FROM inventory WHERE item = ?");
    $priceStmt->bind_param("s", $item);
    $priceStmt->execute();
    $priceResult = $priceStmt->get_result();

    if ($priceResult->num_rows > 0) {
        $inventoryData = $priceResult->fetch_assoc();
        $price = $inventoryData['price'];
        $available = $inventoryData['available'];

        if ($available < $quantity) {
            throw new Exception("Insufficient stock available for the selected item.");
        }

        // Insert the new order into the orders table
        $insertOrderStmt = $conn->prepare("
            INSERT INTO orders (user, item, quantity, price, status, order_date)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        $insertOrderStmt->bind_param("isdis", $userid, $item, $quantity, $price, $status);
        $insertOrderStmt->execute();

        // Reduce the quantity in the inventory table
        $updateInventoryStmt = $conn->prepare("
            UPDATE inventory SET quantity = quantity - ? WHERE item = ?
        ");
        $updateInventoryStmt->bind_param("is", $quantity, $item);
        $updateInventoryStmt->execute();

        // Fetch user's name for logging
        $userStmt = $conn->prepare("SELECT name FROM user WHERE userid = ?");
        $userStmt->bind_param("i", $userid);
        $userStmt->execute();
        $userResult = $userStmt->get_result();
        $user = $userResult->fetch_assoc();
        $username = $user['name'];

        // Log the order in the log table
        $logDescription = $username . " placed an order: " . $item;
        $logStmt = $conn->prepare("
            INSERT INTO log (userid, type, description) VALUES (?, 'order', ?)
        ");
        $logStmt->bind_param("is", $userid, $logDescription);
        $logStmt->execute();

        // Commit the transaction
        $conn->commit();
        echo "Order successfully placed!";
    } else {
        throw new Exception("Item not found in inventory.");
    }
} catch (Exception $e) {
    // Roll back the transaction on error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn->close();
?>