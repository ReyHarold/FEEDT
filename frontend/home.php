     <?php
        error_reporting(0);
        include "../backend/resession.php";
        include "../conn.php";
        $sql = "SELECT log.*,user.name, user.user_pic from log Left Join user on log.userid = user.userid WHERE log.userid ORDER BY log.date DESC LIMIT 10;" ;
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
         $count = 0;
         if(mysqli_num_rows($result)==0){
            echo "You have no activities";
         }else{
            while($row= mysqli_fetch_assoc($result)){
            if($count<5){
            echo"<div class='activity-item'>";
            }else{
            echo"<div class='activity-item rowb hide'>";
            }
            echo "<div class='activity-user'>";
            echo  "<div class='user-circle'><div class='img-container'><img class= 'circle'width='100%' src='data:image/png;base64,".base64_encode($row["user_pic"])."' alt='Profile'></div></div>
                    <span>".$row['name']."</span>
                </div>";
            echo "<span>".$row['description']."</span>";
            echo "<span>".$row['date']."</span>
            </div>";
            $count++;
         };
        }
         ?>
            <div class="activity-item">
                <div class="activity-button">
                    <div></div>
                    <span></span>
                </div>
                <span></span>
                <span></span>
                <span><button onclick="fetchData(true, this, 'activity-item.rowb' )" class="hideshow <?php if($count<5){echo"hide";};?> other-activities-button">Other Activities</button><button onclick="fetchData(false, this)" class="hideshow hide other-activities-button ">Hide Activities</button></span>
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
