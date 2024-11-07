    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/main.css">
        <title>FeedTrack</title>
    </head>
    <body>
        <header>
            <h1>FeedTrack</h1>
        </header>
        <aside>
            <ul>
                <li><a href="#" class="active"><img src="icons/home.png" alt="Home">Home</a></li>
                <li><a href="#"><img src="icons/users.png" alt="Users">Users</a></li>
                <li><a href="#"><img src="icons/inve.png" alt="Inventory">Inventory</a></li>
                <li><a href="#"><img src="icons/orders.png" alt="Orders">Orders</a></li>
                <li><a href="#"><img src="icons/suppliers.png" alt="Suppliers">Suppliers</a></li>
                <li><a href="#"><img src="icons/report.png" alt="Reports">Reports & Analytics</a></li>
            </ul>
        </aside>
        <main>
        <div class="main-content">
        <!-- Overview Card -->
        <div class="overview-card">
            <div class="overview-profile">
                <div>
                    <h2>Welcome, Mark Angelo Ilagan!</h2>
                    <p>Here's a quick overview of what’s happening</p>
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
            <button class="other-activities-button">Other Activities</button>
            </div>
            </div>
        </main>
        <style>

        /* Overview card styling */
        .overview-card, .activity-card {
            width: 1400px;
            background-color: #E9E3CA;
            padding: 40px;
            border-radius: 5px;
            margin: 15px 0;
            border: 1px solid black;
        }

        .overview-card h2, .activity-card h2 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .overview-card p {
            margin-top: 3px;
            color: #333;
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
        }

        .user-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #3B82A0;
            margin-right: 10px;
        }

        .activity-details {
            display: flex;
            justify-content: space;
        }

        .other-activities-button {
            margin-left: 1290px;
            margin-top: 10px;
            padding: 8px;
            background-color: #dcedc8;
            color: black;
            border: 1px solid black;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;

        }
    </style>
    </body>
    </html>