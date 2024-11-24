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
                <button onclick="callScript('userForm','scripts/updateUser.php')" type="submit">Submit</button>
            </form>
        </div>
    </div>
    <div class="box">
            <h2>All Activities</h2>
            <?php
         $sql = "SELECT user.email,user.name, user_pic, log.description, log.date FROM log LEFT JOIN user ON log.userid = user.userid ORDER BY log.date DESC;";
         $result = mysqli_query($conn, $sql);
         $count = 0;
         ?>
         <div class="activity">
         <div class="checkbox-container" >
        <input class="c-checkbox" type="checkbox" id="checkbox1">
        <div class="c-formContainer">
            <form class="c-form" onfocusout="remove('1')" action="">
                <input class="c-form__input" id="search1" placeholder="E-mail" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required>
                <label class="c-form__buttonLabel" for="checkbox1">
                    <button class="c-form__button" type="button">Send</button>
                </label>
                <label class="c-form__toggle" onclick="checkboxCheck('1')" data-title="Notify me"></label>
            </form>
        </div>
    </div>
</div><br><br>
         <?php
         if(mysqli_num_rows($result)==0){
            echo "You have no activities";
         }else{
            while($row= mysqli_fetch_assoc($result)){
            if($count<5){
            echo"<div class='activity'>";
            }else{
            echo"<div class='activity rowb hide'>";
            }
            echo '<div class="profile"><div class="img-container"><img class="circle" src="data:image/png;base64,'.base64_encode($row['user_pic']).'" alt="Profile"></div>';
            echo  "<div class='activity-info'>".$row["name"]."</div></div>";
            echo  "<div class='activity-email'>".$row["description"]."</div>";
            echo  "<div class='activity-date'>".$row["date"]."</div></div>";
            $count++;
            }
        };
         ?>
            <div class="activity">
                <div class="activity-info"></div>
                <div class="activity-email"></div>
                <div class="activity-date"><button onclick="fetchData(true, this,'activity')" class="hideshow <?php if($count<5){echo"hide";};?> other-activities-button">Show All Activities</button><button onclick="fetchData(false, this, 'activity')" class="hideshow hide other-activities-button ">Hide Activities</button></div>
            </div>
        </div>
        <div class="box">
        <h2>All Accounts</h2>
        <div class="boxbuttoncontainer">
        <div class="checkbox-container" >
        <input class="c-checkbox" type="checkbox" id="checkbox">
        <div class="c-formContainer">
            <form class="c-form" onfocusout="remove()" action="">
                <input class="c-form__input" id="search" placeholder="E-mail" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required>
                <label class="c-form__buttonLabel" for="checkbox">
                    <button class="c-form__button" type="button">Send</button>
                </label>
                <label class="c-form__toggle" onclick="checkboxCheck()" data-title="Notify me"></label>
            </form>
        </div>
        </div>
        </div><br><br>
        <?php
        $sql2 = "SELECT * from user";
        $count = 0;
        $result2 = mysqli_query($conn, $sql2);

            while($row2= mysqli_fetch_assoc($result2)){
                if($count<5){
                    echo"<div class='account'>";
                    }else{
                    echo"<div class='account rowb hide'>";
                    }
                    $id = htmlspecialchars($row2["userid"], ENT_QUOTES, 'UTF-8');
                    $name = htmlspecialchars($row2["name"], ENT_QUOTES, 'UTF-8'); // Sanitize strings
                    $email = htmlspecialchars($row2["email"], ENT_QUOTES, 'UTF-8');
                    $privilageArray = explode(',', $row2["privilage"]); // Convert string to array
                    $privilage = json_encode($privilageArray); // Convert to JSON
            echo '<div class="profile"><div class="img-container"><img class="circle" src="data:image/png;base64,'.base64_encode($row2['user_pic']).'" alt="Profile"></div>';
            echo  "<div class='activity-info'>".$row2["name"]."</div></div>";
            echo '<div class="account-email">'.$row2["email"].'</div>';
            echo  "<div class='account-actions'>
                    <button class='btn btn-privilege' id='' onclick ='usersForm(\"user\",\"" . $id . "\", \"" . $name . "\", \"" . $email . "\", " . $privilage .")'>Edit</button>";
                    if($row2["active"] == "true"){
            echo "<button class='btn btn-suspend ".$id."' onclick='areYouSure(\"Suspend Name: ". $name ." ?\", \"". $id ."\", \"suspend\" ,\"".$name."\")'>Suspend</button>";
                    }else{
            echo "<button class='btn btn-resume ".$id."' onclick='areYouSure(\"Resume Name: ". $name ." ?\", \"". $id ."\", \"resume\", \"".$name."\")'>Resume</button>";
                    };
            echo "<button class='btn btn-delete'>Delete</button>
                </div></div>";
                $count++;
            };
        ?>
        <div class='account'>
        <div class="profile"></div>
        <div class='activity-info'></div>
        <div class="account-actions">
        <button onclick="fetchData(true, this, 'account' )" class="hideshow <?php if($count<5){echo"hide";};?> other-activities-button">Show All Accounts</button><button onclick="fetchData(false, this, 'account')" class="hideshow hide other-activities-button ">Hide Accounts</button>
        </div>
        </div>
        </div>
    </div>
    <style>
        /* Content area styling */

        .box h2 {
            margin-bottom: 15px;
            color: #ffff;
        }

        .activity, .account {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
        }
        .profile{
            display:flex;
        }

        .activity-info, .account-info, .activity-email  {
            flex: 1;
            padding-left: 10px;
            font-size: 0.9em;
            margin:auto;
            width:200px;
            color:#ffff;
        }

        .activity-date {
            font-size: 0.8em;
            color: #ffff;
        }
        
        .account-email {
            font-size: 0.8em;
            display: flex;
            align-items: center;
            color:#ffff
        }

        .account-actions {
            display: flex;
            gap: 5px;
        }
    </style>