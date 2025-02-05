<?php
    error_reporting(0);
    include "../backend/resession.php";
    include "../conn.php";

    // Get current user's ID from session
    $userid = $_SESSION['id'];

    // Fetch items and available data from inventory where type = 'finish'
    $inventorySql = "SELECT item, quantity AS available FROM inventory WHERE type = 'finish'";
    $inventoryResult = $conn->query($inventorySql);

    // Fetch committed and delivered data from orders table
    $ordersSql = "SELECT 
        item, 
        SUM(CASE WHEN status = 'pending' THEN quantity ELSE 0 END) AS committed,
        SUM(CASE WHEN status = 'delivered' THEN quantity ELSE 0 END) AS delivered
    FROM orders
    GROUP BY item";
    $ordersResult = $conn->query($ordersSql);

    // Prepare data for merging inventory and orders
    $ordersData = [];
    while ($row = $ordersResult->fetch_assoc()) {
        $ordersData[$row['item']] = ['committed' => $row['committed'], 'delivered' => $row['delivered']];
    }
?>

<!-- Table for Inventory and Orders Summary -->
 <div class="box">
<h2>Orders Summary</h2>
<div class="search-box">
        <button class="btn-search"><i class="fas fa-search" aria-hidden="true"></i></button>
        <input type="text" class="input-search" placeholder="Type to Search...">
    </div>
    <br>
    <div class="actions">
        <button class="add-item-btn" onclick="usersForm('order')">New Batch</button>
    </div>
<table class="table">
    <thead>
        <tr>
            <th>Item</th>
            <th>Available</th>
            <th>Committed</th>
            <th>Delivered</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $inventoryResult->fetch_assoc()): ?>
            <?php
                $item = htmlspecialchars($row['item'], ENT_QUOTES, 'UTF-8');
                $available = $row['available'];
                $committed = isset($ordersData[$item]['committed']) ? $ordersData[$item]['committed'] : 0;
                $delivered = isset($ordersData[$item]['delivered']) ? $ordersData[$item]['delivered'] : 0;
            ?>
            <tr>
                <td><?php echo $item; ?></td>
                <td><?php echo $available; ?></td>
                <td><?php echo $committed; ?></td>
                <td><?php echo $delivered; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>
<div class="popup-container" id="editPopupForm" style="display: none;">
    <div class="popup-content">
        <span class="close-btn" onclick="closeEditForm()">&times;</span>
        <h2>Edit Order</h2>
        <form action="scripts/EditOrder.php" method="post">
            <input type="hidden" id="editOrderId" name="orderId" required>
            
            <div class="form-row">
                <div class="input-data">
                    <input type="text" id="editItem" name="item" required>
                    <div class="underline"></div>
                    <label for="editItem">Item</label>
                </div>
            </div>
            
            <div class="form-row">
                <div class="input-data">
                    <input type="number" id="editQuantity" name="quantity" required>
                    <div class="underline"></div>
                    <label for="editQuantity">Quantity</label>
                </div>
            </div>

            <div class="form-row">
                <div class="input-data">
                    <input type="number" id="editPrice" name="price" step="0.01" required>
                    <div class="underline"></div>
                    <label for="editPrice">Price</label>
                </div>
            </div>

            <button class="button" type="submit">Update Order</button>
        </form>
    </div>
</div>

<!-- Form for Adding New Orders -->
<div class="popup-container Poporder" id="popupForm">
    <div class="popup-content">
        <span class="close-btn" onclick="hideForm('orders')">&times;</span>
        <h2>Add Order</h2>
        <form action="" id="orderForm" method="post">
            <input type="hidden" id="userid" name="userid" value="<?php echo $userid; ?>" required>
            <input type="hidden" id="feed" name="feed" required>
            <div class="form-row dropdrop">
            <nav>
                <menu>
                    <menuitem>
                        <a id ="dropTitle">Select Item to Order</a>
                        <menu>
<?php
$sql3 = "SELECT DISTINCT `feed` FROM `inventory`;";
$result3 = mysqli_query($conn, $sql3);

while ($row3 = mysqli_fetch_assoc($result3)) {
    echo "<menuitem>";
    echo "<a>" . htmlspecialchars(ucfirst($row3["feed"])) . "</a>";
    echo "<menu>";
    
    // Corrected SQL query for $sql4
    $sql4 = "SELECT `item`, `feed`, `itemID` FROM `inventory` WHERE `feed` = '" . mysqli_real_escape_string($conn, $row3["feed"]) . "' AND `type` = 'finish';";
    $result4 = mysqli_query($conn, $sql4);

    while ($row4 = mysqli_fetch_assoc($result4)) {
        echo "<menuitem><a onclick='setDrop(\"".$row4['item']."\")'>" . htmlspecialchars(ucfirst($row4['item'])) . "</a></menuitem>";
    }

    echo "</menu>";
    echo "</menuitem>";
}
?>
</menu>
</nav>
            </div>
            <div class="form-row">
                <div class="input-data">
                    <input type="number" id="quantity" name="quantity" required>
                    <div class="underline"></div>
                    <label for="quantity">Quantity</label>
                </div></div>

            <button class="button" onclick="callScript('orderForm','scripts/AddOrder.php','orders')" type="submit">Submit</button>
        </form>
    </div>
</div>

<!-- Table for Detailed Orders List -->
 <div class="box">
<h2>Orders List</h2>
<div class="search-box">
            <button class="btn-search" id="inventorySearch"><i class="fas fa-search"></i></button>
            <input type="text" id="searchInput" onfocus="addSearch('inventorySearch','inventoryContent','searchInput','searchInventory')" onblur="removeSearch('inventorySearch')" class="input-search" id="searchInput" placeholder="Type to Search...">
                </div></br>
<table class="table">
    <thead>
        <tr>
            <th>Responsible</th>
            <th>Order Date</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Delivered Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $ordersListSql = "
                SELECT orders.*, user.name AS responsible
                FROM orders
                JOIN user ON orders.user = user.userid ORDER BY orders.order_date DESC;
            ";
            $stmt = $conn->prepare($ordersListSql);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()):
                $totalPrice = $row['quantity'] * $row['price'];
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row['responsible']); ?></td>
                <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                <td><?php echo htmlspecialchars($row['item']); ?></td>
                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                <td><?php echo htmlspecialchars(number_format($row['price'], 2)); ?></td>
                <td><?php echo htmlspecialchars(number_format($totalPrice, 2)); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td><?php echo htmlspecialchars($row['delivered_date']); ?></td>
                <td class='account-actions'>
                <button class="btn btn-edit" onclick="openEditForm(
                        <?php echo $row['orderid']; ?>,
                        '<?php echo htmlspecialchars($row['item']); ?>',
                        <?php echo $row['quantity']; ?>,
                        <?php echo $row['price']; ?>
                    )">Edit</button>
                    <button class="btn btn-delete" onclick="deleteOrder(<?php echo $row['orderid']; ?>)">Delete</button>
                    <button class="btn btn-update" style="color:black;" onclick="promptUpdateAndUpdate(<?php echo $row['orderid']; ?>)">Update</button>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>