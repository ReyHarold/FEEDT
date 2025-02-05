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

<?php
    error_reporting(0);
    include "../backend/resession.php";
    include "../conn.php";

    // Fetch inventory data with available and committed quantities
    $inventorySql = "
        SELECT 
            inventory.item, 
            inventory.quantity AS available, 
            inventory.price,
            inventory.type,
            IFNULL(SUM(orders.quantity), 0) AS committed
        FROM inventory
        LEFT JOIN orders ON inventory.item = orders.item AND orders.status != 'delivered'
        GROUP BY inventory.item
    ";
    
    $inventoryResult = $conn->query($inventorySql);
?>
<div id="printableArea">
<table>
    <h2 style="color:black;">FIMS: Inventory Report</h2>
    <thead>
        <tr>
            <th>Item</th>
            <th>Type</th>
            <th>Available Quantity</th>
            <th>Total Quantity</th>
            <th>Price</th>
            <th>Total Value</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $inventoryResult->fetch_assoc()): ?>
            <?php
                $item = htmlspecialchars($row['item'], ENT_QUOTES, 'UTF-8');
                $type = htmlspecialchars($row['type'], ENT_QUOTES, 'UTF-8');
                $available = $row['available'];
                $committed = $row['committed'];
                $totalQuantity = $available + $committed;
                $price = number_format($row['price'], 2);
                $totalValue = number_format($totalQuantity * $row['price'], 2);
            ?>
            <tr>
                <td><?php echo $item; ?></td>
                <td><?php echo ucfirst($type); ?></td>
                <td><?php echo $available; ?></td>
                <td><?php echo $totalQuantity; ?></td>
                <td><?php echo $price; ?></td>
                <td><?php echo $totalValue; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>
<!-- Print Button -->
<button type="button" onclick="printReport()">Print</button>


<?php
    $conn->close();
?>
