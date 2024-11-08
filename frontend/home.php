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
                <div class="profile-circle"><?php $takepic= mysqli_fetch_array($asd); echo "<div class='img-container'><img class='circle' width='100%' src='data:image/png;base64,".base64_encode($takepic["user_pic"])."' alt='Profile'></div>"?></div>
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
                    <div class='user-circle'><div class='img-container'><img class= 'circle'width='100%' src='data:image/png;base64,".base64_encode($row["user_pic"])."' alt='Profile'></div></div>
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

        .overview-profile {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
