<?php
require '../conn.php'; // Ensure database connection

$query = "SELECT feed, SUM(quantity) as total FROM inventory GROUP BY feed";
$result = $conn->query($query);

$labels = [];
$values = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['feed'];
    $values[] = $row['total'];
}

echo json_encode(['labels' => $labels, 'values' => $values]);
?>
