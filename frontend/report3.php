<?php
error_reporting(0);
include "../backend/resession.php";
include "../conn.php";

// Get all orders
$orderSql = "
    SELECT 
        orders.orderid, 
        user.name AS responsible, 
        orders.order_date, 
        orders.item, 
        orders.quantity, 
        orders.price, 
        orders.status, 
        orders.delivered_date 
    FROM orders
    JOIN user ON orders.user = user.userid
    ORDER BY orders.order_date DESC
";

$orderResult = $conn->query($orderSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Report</title>
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
    <h2 style="color:black;">Order Report</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Responsible</th>
                <th>Order Date</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Status</th>
                <th>Delivered Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $orderResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['orderid']); ?></td>
                    <td><?php echo htmlspecialchars($row['responsible']); ?></td>
                    <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['item']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td><?php echo htmlspecialchars(number_format($row['price'], 2)); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo htmlspecialchars($row['delivered_date']); ?></td>
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
