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
            <div class="form-row">
                <div class="input-data">
                    <input type="text" id="addItem" name="addItem" required>
                    <div class="underline"></div>
                    <label for="name">Item Name:</label>
                </div></div>
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
            <div class="form-row">
                <div class="input-data">
                    <input type="text" id="item" name="item" required>
                    <div class="underline"></div>
                    <label for="name">Item Name:</label>
                </div></div>
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
    <h2>Warning</h2>
    <?php
    $sql2 = "SELECT * FROM `inventory` WHERE `minimumlvl`> `quantity` OR `maximumlvl`< `quantity`";
    $result = mysqli_query($conn, $sql2);
    if(mysqli_num_rows($result)==0){
        echo "Inventory is Stable!";
    }else{
        while($row= mysqli_fetch_assoc($result)){
            if($row["quantity"]>$row["maximumlvl"]){
             echo "<p>Low Level of ".ucfirst($row['item']).", ".$row["quantity"]."KG on stock</p>";
            }elseif($row["quantity"]<$row["minimumlvl"]){
             echo "<p>High Level of ".ucfirst($row['item']).", ".$row["quantity"]."KG on stock</p>";
            }
             echo "</br>";
        }
    }
    ?>
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
                    if(mysqli_num_rows($result)==0){
                        echo "<tr><td></td>You have no activities</tr><td></td>";
                     }else{
                        while($row= mysqli_fetch_assoc($result)){
                        echo"<tr class='activity'>";
                        echo '<td>'.ucfirst($row['item']).'</td>';
                        echo  '<td>'.$row["quantity"].'KG</td>';
                        echo  '<td>₱'.$row["price"].'</td>';
                        echo '<td>'.$row["maximumlvl"].'</td>';
                        echo '<td>'.$row["minimumlvl"].'</td>';
                        echo  "<td class='account-actions'>
                                    <button class='btn btn-edit' onclick='usersForm(\"inventory\", \"" . $row['itemID'] . "\", \"" . ucfirst($row['item']) . "\" , \"" . $row['price'] . "\", [ \"" . $row['quantity'] . "\" , \"" . $row['minimumlvl'] . "\" , \"" . $row['maximumlvl'] . "\"] )'>Edit</button>
                                    <button class='btn btn-delete'>Delete</button>
                                </td></tr>";
                        }
                    };
                    ?>
                </tbody>
            </table>
        </div>