    <?php
        error_reporting(0);
        include "../backend/resession.php";
        include "../conn.php";
// Check if user ID is passed in the URL
if (isset($_GET['id'])) {
    // Get the user ID from the URL (e.g., edit_user.php?id=1)
    $userId = $_GET['id'];

    // Query to get the user details by userID
    $sql = "SELECT * FROM user WHERE userid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);  // Bind the userId parameter
    $stmt->execute();  // Execute the query
    $result = $stmt->get_result();  // Get the result

    // Check if user exists
    if ($result->num_rows > 0) {
        // Fetch the user data from the result
        $user = $result->fetch_assoc();
    } else {
        // User not found, redirect or show error message
        echo "User not found!";
        exit;
    }

    $stmt->close();
} else {
    // If no ID is passed, it's a new user, not an edit
    $user = null;
}

?>

<div class="popup-container Popuser" id="popupForm">
    <div class="popup-content">
        <span class="close-btn" onclick="hideForm('user')">&times;</span>
        <h2 id="formTitle">Edit User</h2> <!-- Change title dynamically -->
        <form action="scripts/addUser.php" id="userForm" method="post" enctype="multipart/form-data">
    <!-- Hidden Field to Determine Add or Update Action -->
    <input type="hidden" name="action" id="action" value="<?php echo isset($user) ? 'update' : 'add'; ?>"> <!-- Default is 'add', 'update' for existing users -->

    <!-- Hidden Field to Store User ID for Update -->
    <input type="hidden" name="id" id="userId" value="<?php echo isset($user) ? $user['userid'] : ''; ?>">

    <div class="form-row">
        <div class="input-data">
            <input type="text" id="name" name="name" required value="<?php echo isset($user) ? $user['name'] : ''; ?>">
            <div class="underline"></div>
            <label for="name">Name:</label>
        </div>
        <div class="input-data">
            <input type="email" id="email" name="email" required value="<?php echo isset($user) ? $user['email'] : ''; ?>">
            <div class="underline"></div>
            <label for="email">Email:</label>
        </div>
    </div>

    <!-- Password and Confirm Password -->
    <div class="form-row">
        <div class="input-data">
            <input type="password" id="password" name="password" placeholder="New Password" value="">
            <div class="underline"></div>
            <label for="password">Password:</label>
        </div>
        <div class="input-data">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" value="">
            <div class="underline"></div>
            <label for="confirm_password">Confirm Password:</label>
        </div>
    </div>

    <!-- Profile Picture -->
    <div class="form-row">
        <div>
            <label for="user_pic">Profile Picture:</label>
            <input type="file" id="user_pic" name="user_pic" accept="image/*">
        </div>
        <?php if (isset($user['user_pic'])): ?>
            <div>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($user['user_pic']); ?>" alt="Profile Picture" width="100">
            </div>
        <?php endif; ?>
    </div>

    <!-- Privileges (Checkboxes) -->
    <div class="form-row">
        <?php 
        // Convert stored privileges into an array
        $privileges = explode(",", $user['privilage']); // Convert comma-separated string to array
        ?>
        <div class="checkbox-wrapper-2">
            <input class="sc-gJwTLC ikxBAC" type="checkbox" value="users" id="users" name="privilage[]" <?php echo in_array('users', $privileges) ? 'checked' : ''; ?>>
            <label for="users">Users</label>
        </div>

        <div class="checkbox-wrapper-2">
            <input class="sc-gJwTLC ikxBAC" type="checkbox" value="inventory" id="inventory" name="privilage[]" <?php echo in_array('inventory', $privileges) ? 'checked' : ''; ?>>
            <label for="inventory">Inventory</label>
        </div>

        <div class="checkbox-wrapper-2">
            <input class="sc-gJwTLC ikxBAC" type="checkbox" value="orders" id="orders" name="privilage[]" <?php echo in_array('orders', $privileges) ? 'checked' : ''; ?>>
            <label for="orders">Orders</label>
        </div>
    </div>
    <div class="form-row">
    <div class="checkbox-wrapper-2">
            <input class="sc-gJwTLC ikxBAC" type="checkbox" value="production" id="production" name="privilage[]" <?php echo in_array('production', $privileges) ? 'checked' : ''; ?>>
            <label for="production">Production</label>
        </div>
        <div class="checkbox-wrapper-2">
            <input class="sc-gJwTLC ikxBAC" type="checkbox" value="reports" id="reports" name="privilage[]" <?php echo in_array('reports', $privileges) ? 'checked' : ''; ?>>
            <label for="reports">Reports</label>
        </div>
        </div>

    <button class="button" type="submit">Submit</button>
</form>

    </div>
</div>


        <div class="box">
        <h2>All Accounts</h2>
        <div class="search-box">
            <button class="btn-search" id="accountSearch"><i class="fas fa-search"></i></button>
            <input type="text" id="searchAccounts" onfocus="addSearch('accountSearch','accountContent','searchAccounts','searchAccount','searchAccountshow')" class="input-search" placeholder="Type to Search...">
        </div><br>
        <button class="add-item-btn" onclick="showForm('user', 'add')">Add New User</button>
        <table class="table">
        <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody id="accountContent">
        <?php
        $sql2 = "SELECT * from user";
        $count = 0;
        $result2 = mysqli_query($conn, $sql2);

            while($row2= mysqli_fetch_assoc($result2)){
                if($count<5){
                    echo"<tr class='account'>";
                    }else{
                    echo"<tr class='account rowb hide'>";
                    }
                    $id = htmlspecialchars($row2["userid"], ENT_QUOTES, 'UTF-8');
                    $name = htmlspecialchars($row2["name"], ENT_QUOTES, 'UTF-8'); // Sanitize strings
                    $email = htmlspecialchars($row2["email"], ENT_QUOTES, 'UTF-8');
                    $privilageArray = explode(',', $row2["privilage"]); // Convert string to array
                    $privilage = json_encode($privilageArray); // Convert to JSON
            echo '<td><div class="profile"><img class="circle" src="data:image/png;base64,'.base64_encode($row2['user_pic']).'" alt="Profile">';
            echo  "<div class='activity-info'>".$row2["name"]."</div></td>";
            echo '<td class="account-email">'.$row2["email"].'</td>';
            echo  "<td><div class='account-actions'>";
            echo '<button class="btn btn-privilege ' . $id . '" 
        onclick=\'showForm("user", "edit", {
            id: "' . $id . '", 
            name: "' . $name . '", 
            email: "' . $email . '", 
            privileges: ' . json_encode($privilageArray) . '
        })\'>Edit</button>';
                    if($row2["active"] == "true"){
            echo "<button class='btn btn-suspend ".$id."' onclick='areYouSure(\"Suspend Name: ". $name ." ?\", \"". $id ."\", \"suspend\" ,\"".$name."\")'>Suspend</button>";
                    }else{
            echo "<button class='btn btn-resume ".$id."' onclick='areYouSure(\"Resume Name: ". $name ." ?\", \"". $id ."\", \"resume\", \"".$name."\")'>Resume</button>";
                    };
            echo "<button class='btn btn-delete' onclick = 'Delete(\"".$id."\", \"".$name."\", \"deleteUser\", \"users\")'>Delete</button>
                </div></div></td>";
                $count++;
            };
        ?>
        </table>
        </br>
        <div class="account"><button id="searchAccountshow" onclick="fetchData(true, this, 'account' )" class="hideshow <?php if($count<5){echo"hide";};?> other-activities-button">Show All Accounts</button><button onclick="fetchData(false, this, 'account')" class="hideshow hide other-activities-button ">Hide Accounts</button></div>
        </div>

        <div class="box">
            <h2>All Activities</h2>
            <?php
         $sql = "SELECT user.email, user.name, user.user_pic, log.description, log.date 
                    FROM log 
                    LEFT JOIN user ON log.userid = user.userid 
                    WHERE DATE(log.date) = CURRENT_DATE 
                    ORDER BY log.date DESC;";
         $result = mysqli_query($conn, $sql);
         $count = 0;
         ?>
         <div class="search-box">
            <button class="btn-search" id="activitySearch"><i class="fas fa-search"></i></button>
            <input type="text" id="searchInput" onfocus="addSearch('activitySearch','activityContent','searchInput','searchActivity','searchActivityshow')" onblur="removeSearch('activitySearch')" class="input-search" id="searchInput" placeholder="Type to Search...">
        </div>
            <table class="table">
            <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody id="activityContent">
         <?php
         if(mysqli_num_rows($result)==0){
            echo "<tr><td></td>You have no activities</tr><td></td>";
         }else{
            while($row= mysqli_fetch_assoc($result)){
            if($count<5){
            echo"<tr class='activity'>";
            }else{
            echo"<tr class='activity rowb hide'>";
            }
            echo '<td><div class="profile">
            <img class="circle" src="data:image/png;base64,'.base64_encode($row['user_pic']).'" alt="Profile">'.$row["name"].'
                </div></td>';
            echo  "<td class='activity-email'>".$row["description"]."</td>";
            echo  "<td class='activity-date'>".$row["date"]."</td></tr>";
            $count++;
            }
        };
         ?>
         </table>
        </br>
                <div class="activity"><button id="searchActivityshow" onclick="fetchData(true, this,'activity')" class="hideshow <?php if($count<5){echo"hide";};?> other-activities-button">Show All Activities</button><button onclick="fetchData(false, this, 'activity')" class="hideshow hide other-activities-button ">Hide Activities</button></div>
        </div>