<?php
require '../conn.php';

// Query to fetch total production grouped by item_name
$query = "SELECT item, SUM(quantity) as total FROM production GROUP BY item ORDER BY total DESC";
$result = $conn->query($query);

$labels = [];
$totals = [];

// Prepare data for the graph
while ($row = $result->fetch_assoc()) {
    $labels[] = $row['item'];  // x-axis labels
    $totals[] = $row['total'];     // y-axis values
}

// Return data in JSON format
echo json_encode(['labels' => $labels, 'totals' => $totals]);
?>
