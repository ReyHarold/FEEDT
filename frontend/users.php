    <?php
        error_reporting(0);
        include "../backend/resession.php";
        include "../conn.php";
    ?>
    <div class="box">
            <h2>Recent Activities</h2>
            <?php
         $sql = "SELECT user.email,user.name, user_pic, log.description, log.date FROM log LEFT JOIN user ON log.userid = user.userid;";
         $result = mysqli_query($conn, $sql);
         $count = 0;
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
        <div class="textbox">
            <label for='input' class="text">Accounts</label>
            <input type="text" class="input" placeholder="Search...">
        </div>
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
            echo '<div class="profile"><div class="img-container"><img class="circle" src="data:image/png;base64,'.base64_encode($row2['user_pic']).'" alt="Profile"></div>';
            echo  "<div class='activity-info'>".$row2["name"]."</div></div>";
            echo '<div class="account-email">'.$row2["email"].'</div>';
            echo  '<div class="account-actions">
                    <button class="btn btn-privilege">Privilege</button>
                    <button class="btn btn-resume">Resume</button>
                    <button class="btn btn-delete">Delete</button>
                </div></div>';
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

        .search-bar {
            margin: 10px 0;
            display: flex;
            align-items: center;
        }

        .account-actions {
            display: flex;
            gap: 5px;
        }
    </style>