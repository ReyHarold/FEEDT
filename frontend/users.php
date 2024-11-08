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
            while($row= mysqli_fetch_assoc($result)){
            echo"<div class='activity'>";
            echo '<div class="profile"><img src="data:image/png;base64,'.base64_encode($row['user_pic']).'" alt="Profile">';
            echo  "<div class='activity-info'>".$row["name"]."</div></div>";
            echo  "<div class='activity-email'>".$row["description"]."</div>";
            echo  "<div class='activity-date'>".$row["date"]."</div></div>";
            };
         ?>
            <div class="activity">
                <div class="activity-info"></div>
                <div class="activity-email"></div>
                <div class="activity-date"><button class="activity-btn">Show All Activities</button></div>
            </div>
        </div>

        <div class="box">
            <h2>Accounts</h2>
            <div class="search-bar">
                <input type="text" placeholder="Search...">
            </div>
        <?php
        $sql2 = "SELECT * from user";
        $result2 = mysqli_query($conn, $sql2);
            while($row2= mysqli_fetch_assoc($result2)){
            echo"<div class='account'>";
            echo '<div class="profile"><img src="data:image/png;base64,'.base64_encode($row2['user_pic']).'" alt="Profile">';
            echo  "<div class='activity-info'>".$row2["name"]."</div></div>";
            echo '<div class="account-email">'.$row2["email"].'</div>';
            echo  '<div class="account-actions">
                    <button class="btn btn-privilege">Privilege</button>
                    <button class="btn btn-resume">Resume</button>
                    <button class="btn btn-delete">Delete</button>
                </div></div>';
            };
        ?>
        </div>
    </div>
    <style>
        /* Content area styling */

        .box {
            width: 100%;
            background-color: #628338;
            padding: 20px;
            margin-bottom: 20px;
            border: 2px solid #000;
            border-radius: 5px;
            color:#ffff
        }

        .box h2 {
            margin-bottom: 15px;
            color: #ffff;
        }

        .activity, .account {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ccc;
        }
        .profile{
            display:flex;
        }
        .activity:last-child, .account:last-child {
            border-bottom: none;
        }

        .activity img, .account img {
            border-radius: 50%;
            width: 30px;
            height: 30px;
            background-color: #6c8ebf;
        }

        .activity-info, .account-info {
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

        .search-bar input[type="text"] {
            width: 100%;
            padding: 5px;
            font-size: 1em;
            border: 1px solid #000;
            border-radius: 3px;
        }

        .account-actions {
            display: flex;
            gap: 5px;
        }
    </style>