     <!-- Overview Card -->
        <div class="overview-card">
            <div class="overview-profile">
                <div>
                    <h2>Welcome, Mark Angelo Ilagan!</h2>
                    <p>Here's a quick overview of what's happening</p>
                </div>
                <div class="profile-circle"></div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="activity-card">
            <h2>Recent Activities</h2>
            <div class="activity-item">
                <div class="activity-user">
                    <div class="user-circle"></div>
                    <span>Rey Harold Matanguihan</span>
                </div>
                <span>Added 100 units of Corn to Inventory</span>
                <span>2024 - 4 - 13</span>
            </div>
            <div class="activity-item">
                <div class="activity-user">
                    <div class="user-circle"></div>
                    <span>Mark Angelo Ilagan</span>
                </div>
               <span>Added 100 units of Corn to Inventory</span>
                <span>2024 - 4 - 13</span>
            </div>
            <div class="activity-item">
                <div class="activity-user">
                    <div class="user-circle"></div>
                    <span>Kian Derich Manalo</span>
                </div>
                <span>Added 100 units of Wheat to Inventory</span>
                <span>2024 - 4 - 13</span>
            </div>
            <div class="activity-item">
                <div class="activity-user">
                    <div class="user-circle"></div>
                    <span>Justin Joseph Mendoza</span>
                </div>
                <span>Added 100 units of Wheat to Inventory</span>
                <span>2024 - 4 - 13</span>
            </div>
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

        .profile-circle {
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

        .user-circle {
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
