<?php
error_reporting(0);
include "../backend/resession.php";
include "../conn.php";

// Get all production data
$productionSql = "
    SELECT 
        production.production_id, 
        production.item, 
        production.quantity, 
        production.start_date, 
        production.end_date, 
        production.status 
    FROM production
    ORDER BY production.start_date DESC
";

$productionResult = $conn->query($productionSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Production Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div id="printableArea">
    <h2 style="color:black;">Production Report</h2>
    <table>
        <thead>
            <tr>
                <th>Batch ID</th>
                <th>Product</th>
                <th>Quantity Produced</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $productionResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['production_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['item']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
    <button type="button" onclick="printReport()">Print</button>    
</body>
</html>

<?php
$conn->close();
?>
