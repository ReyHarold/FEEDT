<?php
// Include the necessary files for session and database connection
error_reporting(E_ALL); // Enable full error reporting to debug issues
include "../../conn.php";

// Get the search query from the request
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Escape special characters in the query to prevent SQL injection
$query = mysqli_real_escape_string($conn, $query);

// Prepare the SQL query
$sql = "SELECT * FROM inventory WHERE item LIKE '%$query%' OR feed LIKE '%$query%'";

// Execute the query
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn)); // Debugging query error
}

// Create an array to hold the results
$items = [];

// Fetch results
while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row; // Add each item to the results array
}

// Return the results as JSON
echo json_encode($items);
?>
