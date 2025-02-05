<?php
include "../../conn.php";

// Get the search query from the URL
$query = isset($_GET['query']) ? $_GET['query'] : '';
$query = mysqli_real_escape_string($conn, $query);
// SQL query to search production batches
$sql = "SELECT * FROM production WHERE (item LIKE '%$query%' OR type LIKE '%$query%' OR status LIKE '%$query%') LIMIT 10";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($conn)); // Debugging query error
}

// Fetch results and convert them to an array
$productions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $productions[] = $row;
}

// Return the results as JSON
echo json_encode($productions);
?>
