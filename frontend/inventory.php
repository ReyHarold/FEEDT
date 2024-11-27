<?php
        error_reporting(0);
        include "../backend/resession.php";
        include "../conn.php";
?>
        <div class="popup-container Popinventory" id="popupForm">
        <div class="popup-content">
            <span class="close-btn" onclick= "hideForm('inventoryAddform')">&times;</span>
            <h2>Edit user</h2>
            <form action="" id="inventoryAddform" method="post">
            <input type="hidden" id="id" name="id" value= "" required>
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
                    <label for="email">Quantity:</label>
            </div></div>
            <div class="form-row">
                <div class="input-data">
                    <input type="number" id="addPrice" name="addPrice" required>
                    <div class="underline"></div>
                    <label for="email">Price:</label>
            </div></div>

                <button class="button" onclick="callScript('inventoryAddform','scripts/inventoryAddform.php','inventory')" type="submit">Submit</button>
            </form>
        </div>
    </div>
    <div class="box">
    <h2>Inventory Report</h2>
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
                        <th>Quantity</th>
                        <th>Price</th>
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
                        echo '<td>'.$row["item"].'</td>';
                        echo  '<td>'.$row["quantity"].'</td>';
                        echo  '<td>₱'.$row["price"].'</td>';
                        echo  "<td class='account-actions'>
                        <button class='btn btn-edit'>Edit</button>
                            <button class='btn btn-delete'>Delete</button>
                        </td></tr>";
                        }
                    };
                    ?>
                </tbody>
            </table>
        </div>