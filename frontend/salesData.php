<?php
require '../conn.php';

$query = "SELECT item, SUM(quantity) as total FROM orders GROUP BY item ORDER BY total DESC LIMIT 10";
$result = $conn->query($query);

$labels = [];
$values = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['item'];
    $values[] = $row['total'];
}

echo json_encode(['labels' => $labels, 'values' => $values]);
?>
