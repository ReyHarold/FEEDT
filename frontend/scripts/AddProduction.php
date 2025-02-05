<?php
include "../../conn.php";
session_start();

// Get POST data
$userid = $_POST['id'];
$productType = $_POST['type'];
$productName = $_POST['name'];
$yield = $_POST['yield'];
$startDate = $_POST['start']; // Assuming first date input is start date
$endDate = $_POST['end'];   // Assuming second date input is end date

$ingredients = $_POST['ingredientAndYieldName'];
$quantities = $_POST['ingredientAndYield'];

// Get current date
$currentDate = date('Y-m-d');

// Determine status
if ($currentDate <= $endDate) {
    $status = 'pending';
} elseif($currentDate >= $endDate) {
    $status = 'late';
}

// Format ingredients as a string (e.g., "Molasses 100, Monocalcium Phosphate 50")
$formattedIngredients = [];
for ($i = 0; $i < count($ingredients); $i++) {
    $formattedIngredients[] = $ingredients[$i] . ' ' . $quantities[$i];
}
$ingredientString = implode(', ', $formattedIngredients);

// Start transaction
$conn->begin_transaction();

try {
    // Insert into production table with status
    $stmt = $conn->prepare("INSERT INTO production (item, `type`, quantity, `start_date`, end_date, ingredients, `status`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissss", $productName, $productType, $yield, $startDate, $endDate, $ingredientString, $status);
    $stmt->execute();
    
    // Update inventory and log changes for each ingredient
    for ($i = 0; $i < count($ingredients); $i++) {
        $ingredientName = $ingredients[$i];
        $quantityUsed = $quantities[$i];
        
        // Update inventory
        $updateStmt = $conn->prepare("UPDATE inventory SET quantity = quantity - ? WHERE item = ?");
        $updateStmt->bind_param("is", $quantityUsed, $ingredientName);
        $updateStmt->execute();
        
    }
    // Insert log entry
    $logStmt = $conn->prepare("INSERT INTO log (`description`, `type`, `userid`) VALUES (?, 'production', ?)");
    $action = "Added new Batch for production: " . $productName;
    $logStmt->bind_param("ss", $action, $userid);
    $logStmt->execute();
    
    // Increase finished product quantity in inventory
    $updateFinishedProductStmt = $conn->prepare("UPDATE inventory SET quantity = quantity + ? WHERE item = ?");
    $updateFinishedProductStmt->bind_param("is", $yield, $productName);
    $updateFinishedProductStmt->execute();
    
    // Commit transaction
    $conn->commit();
    echo "Production and inventory update successful!";
} catch (Exception $e) {
    // Rollback on error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}
