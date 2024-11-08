     <?php
        error_reporting(0);
        include "../backend/resession.php";
        include "../conn.php";
        $sql = "SELECT user.name, user_pic, log.description, log.date FROM log LEFT JOIN user ON log.userid = user.userid where user.userid = $id;";
         $result = mysqli_query($conn, $sql);
         $asd = mysqli_query($conn, $sql);
    ?>
        <div class="overview-card">
            <div class="overview-profile">
                <div>
                    <h2>Welcome, <?php echo $name; ?>!</h2>
                    <p>Here's a quick overview of what's happening</p>
                </div>
                <div class="profile-circle"><?php $takepic= mysqli_fetch_array($asd); echo "<img width='100%' src='data:image/png;base64,".base64_encode($takepic["user_pic"])."' alt='Profile'>"?></div>
            </div>
        </div>
        <div class="activity-card">
        <h2>Your Recent Activities</h2>
        <!-- Recent Activities -->
         <?php
         if(mysqli_num_rows($result)==0){
            echo "You have no activities";
         }else{
            while($row= mysqli_fetch_assoc($result)){
            echo"<div class='activity-item'>
                <div class='activity-user'>
                    <div class='user-circle'><img width='100%' src='data:image/png;base64,".base64_encode($row["user_pic"])."' alt='Profile'></div>
                    <span>".$row['name']."</span>
                </div>
                <span>".$row['description']."</span>
                <span>".$row['date']."</span>
            </div>";
         };
        }
         ?>
            <div class="activity-item">
                <div class="activity-button">
                    <div></div>
                    <span></span>
                </div>
                <span></span>
                <span><button class="other-activities-button">Other Activities</button></span>
            </div>
            </div>
        <style>

        /* Overview card styling */
        .overview-card, .activity-card {
            width: 100%;
            background-color: #628338;
            padding: 40px;
            border-radius: 5px;
            margin: 15px 0;
            border: 1px solid black;
        }

        .overview-card h2, .activity-card h2 {
            margin:0;
            padding-bottom:10px;
            font-size: 18px;
            color: #FFFFFF;
        }
        span{
            color:#FFFFFF;
        }

        .overview-card p {
            margin-top: 3px;
            color: #FFFFFF;
        }

        .overview-profile {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile-circle img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #3B82A0;
        }

        /* Recent activities styling */
        .activity-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ccc;
        }

        .activity-user {
            display: flex;
            align-items: center;
            width:200px;
        }
        .activity-item span {
            display: flex;
            align-items: center; /* Vertically center each span within the flex container */
}

        .user-circle img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #3B82A0;
            margin-right: 10px;
            flex-shrink:0;
        }

        .activity-details {
            display: flex;
            justify-content: space;
        }
    </style>
