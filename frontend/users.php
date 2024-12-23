    <?php
        error_reporting(0);
        include "../backend/resession.php";
        include "../conn.php";
    ?>
    <div class="popup-container Popuser" id="popupForm">
        <div class="popup-content">
            <span class="close-btn" onclick= "hideForm('user')">&times;</span>
            <h2>Edit user</h2>
            <form action="" id="userForm" method="post">
            <input type="hidden" id="id" name="id" value= "" required>
            <div class="form-row">
                <div class="input-data">
                    <input type="text" id="name" name="name" required>
                    <div class="underline"></div>
                    <label for="name">Name:</label>
                </div>
                <div class="input-data">
                    <input type="email" id="email" name="email" required>
                    <div class="underline"></div>
                    <label for="email">Email:</label>
            </div></div>

            <div class="form-row">
                    <div class="checkbox-wrapper-2">
                    <input class= "sc-gJwTLC ikxBAC" type="checkbox" value="users" id="users" name="privilage[]">
                    <label for="users">Users</label>
                </div>

                <div class="checkbox-wrapper-2">
                    <input class= "sc-gJwTLC ikxBAC" type="checkbox" value="inventory" id="inventory" name="privilage[]">
                    <label for="inventory">Inventory</label>
                </div>

                <div class="checkbox-wrapper-2">
                    <input class= "sc-gJwTLC ikxBAC" type="checkbox" value="orders" id="orders" name="privilage[]">
                    <label for="orders">Orders</label>
                </div>
            </div>
            <div class="form-row">
                <div class="checkbox-wrapper-2">
                    <input class= "sc-gJwTLC ikxBAC" type="checkbox" value="production" id="production" name="privilage[]">
                    <label for="production">Production</label>
                </div>

                <div class="checkbox-wrapper-2">
                    <input class= "sc-gJwTLC ikxBAC" type="checkbox" value="suppliers" id="suppliers" name="privilage[]">
                    <label for="suppliers">Suppliers</label>
                </div>

                <div class="checkbox-wrapper-2">
                    <input class= "sc-gJwTLC ikxBAC" type="checkbox" value="reports" id="reports" name="privilage[]">
                    <label for="report">Report</label>
                </div>
            </div>
                <button class="button" onclick="callScript('userForm','scripts/updateUser.php','users')" type="submit">Submit</button>
            </form>
        </div>
    </div>
        <div class="box">
        <h2>All Accounts</h2>
        <div class="search-box">
            <button class="btn-search" id="accountSearch"><i class="fas fa-search"></i></button>
            <input type="text" id="searchAccounts" onfocus="addSearch('accountSearch','accountContent','searchAccounts','searchAccount','searchAccountshow')" class="input-search" placeholder="Type to Search...">
        </div><br>
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
            echo  "<td><div class='account-actions'>
                    <button class='btn btn-privilege ".$id."' onclick ='usersForm(\"user\",\"" . $id . "\", \"" . $name . "\", \"" . $email . "\", " . $privilage .")'>Edit</button>";
                    if($row2["active"] == "true"){
            echo "<button class='btn btn-suspend ".$id."' onclick='areYouSure(\"Suspend Name: ". $name ." ?\", \"". $id ."\", \"suspend\" ,\"".$name."\")'>Suspend</button>";
                    }else{
            echo "<button class='btn btn-resume ".$id."' onclick='areYouSure(\"Resume Name: ". $name ." ?\", \"". $id ."\", \"resume\", \"".$name."\")'>Resume</button>";
                    };
            echo "<button class='btn btn-delete' onclick = 'Delete(\"".$id."\", \"".$name."\")'>Delete</button>
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