<?php
        error_reporting(0);
        include "../backend/resession.php";
        include "../conn.php";
?>
        <div class="popup-container PopinventoryAdd" id="popupForm">
        <div class="popup-content">
            <span class="close-btn" onclick= "hideForm('inventoryAddform')">&times;</span>
            <h2>Add Item</h2>
            <form action="" id="inventoryAddform" method="post">
            <input type="hidden" id="Addfeed" name="feed" required>
            <div class="form-row">
                <div class="input-data">
                    <input type="text" id="addItem" name="addItem" autocomplete="off" required>
                    <div class="underline"></div>
                    <label for="name">Item Name:</label>
                </div>
                <div class="checkbox-wrapper-2">
                    <input class= "sc-gJwTLC ikxBAC" type="checkbox" onclick="IngredientShow('Addfinish')" value="finish" id="Addfinish" name="finish">
                    <label for="users">Finished Product?</label>
                </div>
            </div>
                <div class="form-row">
                <div style="display:none;" class="input-data" id ="otherDiv">
                    <input id="newFeed" name="newFeed" autocomplete="off">
                    <div class="underline"></div>
                    <label for="name">New Feed:</label>
                </div>
                <nav>
<menu>
	<menuitem>
        <a id ="AddDropTitle">Select Type of Feed</a>
        <menu>
            <?php
            $sql3 = "SELECT DISTINCT `feed` FROM `inventory`;";
            $result3 = mysqli_query($conn, $sql3);

            while ($row3 = mysqli_fetch_assoc($result3)) {
                echo "<menuitem>";
                echo "<a onclick ='setDrop(\"".$row3["feed"]."\", \"add\")'>" . htmlspecialchars(ucfirst($row3["feed"])) . "</a>";
                echo "</menuitem>";
            }
            ?>
    <menuitem>
    <a onclick="otherFeed()">Other</a>
    </menuitem>
            </menu>
            </nav>
            </div>
            <div class="ingredientContainer Addfinish" style="display:none">
                <div class="form-row Addfinish" id="ingredientrow" style="display:none">
                    <div style = "z-index:999;"class="input-data">
                    <?php
                        $sqlsearch = "SELECT `item` FROM `inventory` WHERE `type` = 'ingredient';";
                        $resultsearch = mysqli_query($conn, $sqlsearch);

                        $items = [];
                        while ($row = mysqli_fetch_assoc($resultsearch)) {
                            $items[] = "" . ucfirst($row['item']) . "";
                        }
                    ?>
                        <input type="text" id="searchBox" autocomplete="off" onkeyup='suggest(<?php echo json_encode($items); ?>)'>
                        <div class="underline"></div>
                        <label for="searchBox">Search for Ingredient:</label>
                        <ul id="suggestions" class="suggestions"></ul>
                    </div>
                </div>
                    <div class="form-row Addfinish" id="ingredientrow" style="display:none">
                        <div class="input-data">
                            <input type="number" id="yield" name="yield">
                            <div class="underline"></div>
                            <label for="searchBox">Yield(KG):</label>
                        </div>
                    </div>
                </div>
            <div class="form-row">
                <div class="input-data">
                    <input type="number" id="addQuantity" name="addQuantity" required>
                    <div class="underline"></div>
                    <label for="email">Quantity(KG):</label>
            </div>
                <div class="input-data">
                        <input type="number" id="addPrice" name="addPrice" required>
                        <div class="underline"></div>
                        <label for="email">Price:</label>
                </div>
        </div>
            <div class="form-row">
                <div class="input-data">
                    <input type="number" id="minLvlAdd" name="minLvlAdd" required>
                    <div class="underline"></div>
                    <label for="email">Minimum Level:</label>
            </div>
            <div class="input-data">
                    <input type="number" id="maxLvlAdd" name="maxLvlAdd" required>
                    <div class="underline"></div>
                    <label for="email">Maximum Level:</label>
            </div>
        </div>

                <button class="button" onclick="callScript('inventoryAddform','scripts/inventoryAddform.php','inventory')" type="submit">Submit</button>
            </form>
        </div>
    </div>

    <div class="popup-container Popinventory" id="popupForm">
        <div class="popup-content">
            <span class="close-btn" onclick= "hideForm('inventory')">&times;</span>
            <h2>Edit Item</h2>
            <form action="" id="inventory" method="post">
            <input type="hidden" id="inventoryid" name="inventoryid" value= "" required>
            <input type="hidden" id="feed" name="feed" required>
            <div class="form-row">
                <div class="input-data">
                    <input type="text" id="item" name="item" required>
                    <div class="underline"></div>
                    <label for="name">Item Name:</label>
                </div>
                <div class="checkbox-wrapper-2">
                    <input onclick="IngredientShow('finish')" class= "sc-gJwTLC ikxBAC" type="checkbox" value="finish" id="finish" name="finish">
                    <label for="users">Finished Product?</label>
                </div>
            </div>
                <div class="form-row dropdrop">
                <nav>
<menu>
	<menuitem>
        <a id ="dropTitle">Feed</a>
        <menu>
            <?php
            $sql3 = "SELECT DISTINCT `feed` FROM `inventory`;";
            $result3 = mysqli_query($conn, $sql3);

            while ($row3 = mysqli_fetch_assoc($result3)) {
                echo "<menuitem>";
                echo "<a onclick ='setDrop(\"".ucfirst($row3["feed"])."\")'>" . htmlspecialchars(ucfirst($row3["feed"])) . "</a>";
                echo "</menuitem>";
            }
            ?>
            </menu>
            </nav>
            </div>
            <div class="ingredientContainer finish" style="display:none">
                <div class="form-row finish" id="ingredientrow" style="display:none">
                    <div style = "z-index:999;"class="input-data">
                    <?php
                        $sqlsearch = "SELECT `item` FROM `inventory` WHERE `type` = 'ingredient';";
                        $resultsearch = mysqli_query($conn, $sqlsearch);

                        $items = [];
                        while ($row = mysqli_fetch_assoc($resultsearch)) {
                            $items[] = "" . ucfirst($row['item']) . "";
                        }
                    ?>
                        <input type="text" id="searchBox" autocomplete="off" onkeyup='suggest(<?php echo json_encode($items); ?>)'>
                        <div class="underline"></div>
                        <label for="searchBox">Search for Ingredient:</label>
                        <ul id="suggestions" class="suggestions"></ul>
                    </div>
                </div>
                    <div class="form-row finish" id="ingredientrow" style="display:none">
                        <div class="input-data">
                            <input type="number" id="yield" name="yield">
                            <div class="underline"></div>
                            <label for="searchBox">Yield(KG):</label>
                        </div>
                    </div>
                </div>
            <div class="form-row">
                <div class="input-data">
                    <input type="number" id="quantity" name="quantity" required>
                    <div class="underline"></div>
                    <label for="email">Quantity(KG):</label>
            </div>
                <div class="input-data">
                        <input type="number" id="price" name="price" required>
                        <div class="underline"></div>
                        <label for="email">Price:</label>
                </div>
        </div>
            <div class="form-row">
                <div class="input-data">
                    <input type="number" id="minLvl" name="minLvl" required>
                    <div class="underline"></div>
                    <label for="email">Minimum Level:</label>
            </div>
            <div class="input-data">
                    <input type="number" id="maxLvl" name="maxLvl" required>
                    <div class="underline"></div>
                    <label for="email">Maximum Level:</label>
            </div>
        </div>

                <button class="button" onclick="callScript('inventory','scripts/inventoryform.php','inventory')" type="submit">Submit</button>
            </form>
        </div>
    </div>

       <div class="box">
                <h2>Inventory</h2>
                <div class="search-box">
            <button class="btn-search" id="inventorySearch"><i class="fas fa-search"></i></button>
            <input type="text" id="searchInput" onfocus="addSearch('inventorySearch','inventoryContent','searchInput','searchInventory')" onblur="removeSearch('inventorySearch')" class="input-search" id="searchInput" placeholder="Type to Search...">
                </div></br>
                <div class="actions">
                    <button class="add-item-btn" onclick="usersForm('inventoryAdd')">Add Item</button>
                </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity(KG)</th>
                        <th>Price per KG</th>
                        <th>Maximum Level(KG)</th>
                        <th>Minimum Level(KG)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="inventoryContent">
    <?php
    $sql = "SELECT * FROM inventory;";
    $result = mysqli_query($conn, $sql);

    $items = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $quantity = $row["quantity"];
        $minLvl = $row["minimumlvl"];
        $maxLvl = $row["maximumlvl"];

        // Determine the status of each item
        if ($quantity < $minLvl) {
            $row["status"] = "low";
        } elseif ($quantity > $maxLvl) {
            $row["status"] = "high";
        } else {
            $row["status"] = "normal";
        }

        $items[] = $row;
    }

    // Sort the items: Low stock first, High stock second, Normal stock last
    usort($items, function ($a, $b) {
        $order = ["low" => 0, "high" => 1, "normal" => 2];
        return $order[$a["status"]] <=> $order[$b["status"]];
    });

    // Display the sorted items
    foreach ($items as $row) {
        $quantity = $row["quantity"];
        $minLvl = $row["minimumlvl"];
        $maxLvl = $row["maximumlvl"];
        $rowClass = "";

        if ($row["status"] === "low") {
            $rowClass = "low-stock";
        } elseif ($row["status"] === "high") {
            $rowClass = "high-stock";
        }

        echo "<tr class='activity $rowClass'>";
        echo '<td>' . ucfirst($row['item']) . '</td>';
        echo '<td>' . number_format($quantity) . 'KG</td>';
        echo '<td>₱' . number_format($row["price"]) . '</td>';
        echo '<td>' . number_format($maxLvl) . '</td>';
        echo '<td>' . number_format($minLvl) . '</td>';
        echo "<td class='account-actions'>
                <button class='btn btn-edit' onclick='usersForm(\"inventory\", \"" . $row['itemID'] . "\", \"" . ucfirst($row['item']) . "\", \"" . $row['price'] . "\", [\"" . $quantity . "\", \"" . $minLvl . "\", \"" . $maxLvl . "\", \"" . $row['type'] . "\", \"" . ucfirst($row['feed']) . "\"])'>Edit</button>
                <button class='btn btn-delete' onclick='Delete(\"" . $row['itemID'] . "\", \"" . $row['item'] . "\", \"deleteInventory\", \"inventory\")'>Delete</button>
              </td>";
        echo "</tr>";
    }
    ?>
</tbody>


            </table>
        </div>
        <style>
table tbody tr.low-stock td {
    background-color: #ffcccc !important;
    color: #b30000 !important;
}

table tbody tr.high-stock td {
    background-color: #cce5ff !important;
    color: #004085 !important;
}
        </style>