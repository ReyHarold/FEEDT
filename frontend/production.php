<?php
error_reporting(0);
include "../backend/resession.php";
include "../conn.php";

// Get current date
$currentDate = date('Y-m-d');

// Update status based on the current date
try {
    // Update status to "pending" if start_date <= currentDate <= end_date
    $stmtPending = $conn->prepare("UPDATE production SET status = 'pending' WHERE start_date <= ? AND end_date >= ? AND status != 'complete'");
    $stmtPending->bind_param("ss", $currentDate, $currentDate);
    $stmtPending->execute();

    // Update status to "advance" if currentDate > start_date and currentDate < end_date
    $stmtAdvance = $conn->prepare("UPDATE production SET status = 'advance' WHERE start_date > ? AND end_date >= ? AND status != 'complete'");
    $stmtAdvance->bind_param("ss", $currentDate, $currentDate);
    $stmtAdvance->execute();

    // Update status to "late" if end_date < currentDate
    $stmtLate = $conn->prepare("UPDATE production SET status = 'late' WHERE end_date < ? AND status != 'complete'");
    $stmtLate->bind_param("s", $currentDate);
    $stmtLate->execute();

    // Close statements
    $stmtPending->close();
    $stmtAdvance->close();
    $stmtLate->close();
} catch (Exception $e) {
    echo "Error updating production statuses: " . $e->getMessage();
}
?>
<div class="popup-container Popproduction" id="popupForm">
        <div class="popup-content">
            <span class="close-btn" onclick= "hideForm('production')">&times;</span>
            <h2>Add Batch</h2>
            <form action="" id="productionForm" method="post">
            <input type="hidden" id="type" name="type" required>
            <input type="hidden" id="name" name="name" required>
            <input type="hidden" id="id" name="id" value= "<?php echo $_SESSION['id'];?>" required>
            <div class="form-row">
                <div class="input-data">
                <?php
                include "production_datalist.php";
                ?>
                </div></div>
                <div class="ingredientContainer finish">
                <div id="ingredientContainers"></div>
                </div>

                <div class="form-row">
                <div class="input-data">
                    <input type="date" id="start" name="start" placeholder="">
                    <div class="underline"></div>
                    <label for="name">Start Date:</label>
                </div>
                <div class="input-data">
                <input type="date" id="end" name="end" placeholder="">
                    <div class="underline"></div>
                    <label for="name">End Date:</label>
                </div>
                </div>
                <button class="button" onclick="callScript('productionForm','scripts/AddProduction.php','production')" type="submit">Submit</button>
            </form>
        </div>
    </div>
<div class="box">
    <h2>Pending Batches</h2>
    <br>
    <div class="actions">
        <button class="add-item-btn" onclick="usersForm('production')">New Batch</button>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Type of Feed</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Ingredient</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM `production` WHERE `status` = 'pending'";
            $result2 = mysqli_query($conn, $sql2);

            while ($row2 = mysqli_fetch_assoc($result2)) {
                $id = htmlspecialchars($row2["production_id"], ENT_QUOTES, 'UTF-8');
                $item = htmlspecialchars($row2["item"], ENT_QUOTES, 'UTF-8');
                $quantity = htmlspecialchars($row2["quantity"], ENT_QUOTES, 'UTF-8');
                $type = htmlspecialchars($row2["type"], ENT_QUOTES, 'UTF-8');
                $ingredients = htmlspecialchars($row2["ingredients"], ENT_QUOTES, 'UTF-8');
                $start_date = htmlspecialchars($row2["start_date"], ENT_QUOTES, 'UTF-8');
                $end_date = htmlspecialchars($row2["end_date"], ENT_QUOTES, 'UTF-8');
                $status = htmlspecialchars($row2["status"], ENT_QUOTES, 'UTF-8');

                echo '<tr>';
                echo '<td>' . ucfirst($type) . '</td>';
                echo '<td>' . ucfirst($item) . '</td>';
                echo '<td>' . $quantity . '</td>';
                echo '<td>' . $ingredients . '</td>';
                echo '<td>' . $start_date . '</td>';
                echo '<td>' . $end_date . '</td>';
                echo '<td>' . ucfirst($status) . '</td>';
                echo "<td class='account-actions'>
                        <button class='btn btn-edit'>Edit</button>
                        <button class='btn btn-delete'>Delete</button>
                        <button style='color:black;' class='btn btn-update' onclick=\"updateStatus('$id')\">Update</button>
                    </td>";
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>
<div class="box">
    <h2>ALL Production</h2>
    <div class="search-box">
    <button class="btn-search" id="productionSearch"><i class="fas fa-search"></i></button>
    <input type="text" onfocus="addSearch('productionSearch', 'productionContent', 'searchInput', 'searchProduction')" class="input-search" id="searchInput" placeholder="Search production...">
</div>

<table class="table">
    <thead>
        <tr>
            <th>Type of Feed</th>
            <th>Item</th>
            <th>Quantity</th>
            <th>Ingredient</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="productionContent">
        <?php
        // Displaying all production batches by default
        $sql2 = "SELECT * FROM production ORDER BY FIELD(status, 'Late', 'Pending', 'Advance', 'Complete') LIMIT 10";
        $result2 = mysqli_query($conn, $sql2);

        while ($row2 = mysqli_fetch_assoc($result2)) {
            $id = htmlspecialchars($row2["production_id"], ENT_QUOTES, 'UTF-8');
            $item = htmlspecialchars($row2["item"], ENT_QUOTES, 'UTF-8');
            $quantity = htmlspecialchars($row2["quantity"], ENT_QUOTES, 'UTF-8');
            $type = htmlspecialchars($row2["type"], ENT_QUOTES, 'UTF-8');
            $ingredients = htmlspecialchars($row2["ingredients"], ENT_QUOTES, 'UTF-8');
            $start_date = htmlspecialchars($row2["start_date"], ENT_QUOTES, 'UTF-8');
            $end_date = htmlspecialchars($row2["end_date"], ENT_QUOTES, 'UTF-8');
            $status = htmlspecialchars($row2["status"], ENT_QUOTES, 'UTF-8');

            echo '<tr>';
            echo '<td>' . ucfirst($type) . '</td>';
            echo '<td>' . ucfirst($item) . '</td>';
            echo '<td>' . $quantity . '</td>';
            echo '<td>' . $ingredients . '</td>';
            echo '<td>' . $start_date . '</td>';
            echo '<td>' . $end_date . '</td>';
            echo '<td>' . ucfirst($status) . '</td>';
            echo "<td class='account-actions'>
                    <button class='btn btn-edit'>Edit</button>
                    <button class='btn btn-delete'>Delete</button>
                </td>";
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
</div>
