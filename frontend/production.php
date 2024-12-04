<?php
        error_reporting(0);
        include "../backend/resession.php";
        include "../conn.php";
    ?>
<div class="popup-container Popproduction" id="popupForm">
        <div class="popup-content">
            <span class="close-btn" onclick= "hideForm('production')">&times;</span>
            <h2>Add Batch</h2>
            <form action="" id="userForm" method="post">
            <input type="hidden" id="id" name="id" value= "" required>
            <div class="form-row">
                <div class="input-data">
                    <input type="text" id="name" name="name" required>
                    <div class="underline"></div>
                    <label for="name">Type of feed:</label>
                </div></div>
                <div class="form-row">
                <div class="input-data">
                    <input type="text" id="name" name="name" required>
                    <div class="underline"></div>
                    <label for="name">Add Ingredient:</label>
                </div>
                <button class="button" onclick="">Add</button>
            </div>

            <div class="list-container">
                    <div class="checkbox-wrapper-2">
                    <input class= "sc-gJwTLC ikxBAC" type="checkbox" value="users" id="users" name="privilage[]">
                    <label for="users">Yellow corn</label>
                </div>

                <div class="checkbox-wrapper-2">
                    <input class= "sc-gJwTLC ikxBAC" type="checkbox" value="inventory" id="inventory" name="privilage[]">
                    <label for="inventory">Soya</label>
                </div>

                <div class="checkbox-wrapper-2">
                    <input class= "sc-gJwTLC ikxBAC" type="checkbox" value="orders" id="orders" name="privilage[]">
                    <label for="orders">Rice bran</label>
                </div>

                <div class="checkbox-wrapper-2">
                    <input class= "sc-gJwTLC ikxBAC" type="checkbox" value="production" id="production" name="privilage[]">
                    <label for="production">Coconut Oil</label>
                </div>
                </div>

            <div class="form-row">
                <div class="input-data">
                    <input type="text" id="name" name="name" required>
                    <div class="underline"></div>
                    <label for="name">Yield:</label>
                </div>
                </div>

                <div class="form-row">
                <div class="input-data">
                    <input type="date" id="name" name="name" placeholder="" required>
                    <div class="underline"></div>
                    <label for="name">Start Date:</label>
                </div>
                <div class="input-data">
                <input type="date" id="name" name="name" placeholder="" required>
                    <div class="underline"></div>
                    <label for="name">End Date:</label>
                </div>
                </div>
                <button class="button" onclick="callScript('userForm','scripts/updateUser.php','users')" type="submit">Submit</button>
            </form>
        </div>
    </div>
 <div class="box">
            <h2>Pending Batches</h2>
            
         <div class="search-box">
            <button class="btn-search"><i class="fas fa-search"></i></button>
            <input type="text" class="input-search" placeholder="Type to Search...">
        </div>
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
                    <th>Owner</th>
                    <th>Actions</th>
                    </tr>
                </thead>
            <tbody id ="productionContent">
                <?php
                 $sql2 = "SELECT * FROM `production` WHERE `status` = 'pending'";
                 $count = 0;
                 $result2 = mysqli_query($conn, $sql2);
         
                     while($row2= mysqli_fetch_assoc($result2)){
                         if($count<10){
                             echo"<tr class='account'>";
                             }else{
                             echo"<tr class='account rowb hide'>";
                             }
                             $id = htmlspecialchars($row2["production_id"], ENT_QUOTES, 'UTF-8');
                             $item = htmlspecialchars($row2["item"], ENT_QUOTES, 'UTF-8'); // Sanitize strings
                             $quantity = htmlspecialchars($row2["quantity"], ENT_QUOTES, 'UTF-8');
                             $type = htmlspecialchars($row2["type"], ENT_QUOTES, 'UTF-8');
                             $type = htmlspecialchars($row2["status"], ENT_QUOTES, 'UTF-8');
                             $type = htmlspecialchars($row2["done"], ENT_QUOTES, 'UTF-8');
                             $type = htmlspecialchars($row2["start_date"], ENT_QUOTES, 'UTF-8');
                             $type = htmlspecialchars($row2["end_date"], ENT_QUOTES, 'UTF-8');
                             echo '<td>'.ucfirst($row2['type']).'</td>';
                             echo '<td>'.ucfirst($row2['item']).'</td>';
                             echo '<td>'.$row2['quantity'].'</td>';
                             echo '<td>'.$row2["ingredients"].'</td>';
                             echo '<td>'.$row2['start_date'].'</td>';
                             echo '<td>'.$row2['end_date'].'</td>';
                             echo '<td>'.ucfirst($row2['done']).'</td>';
                             echo "<td class='account-actions'>
                        <button class='btn btn-edit'>Edit</button>
                            <button class='btn btn-delete'>Delete</button>
                        </td></tr>";

                         $count++;
                     };
                ?>
            </tbody>
</div> 