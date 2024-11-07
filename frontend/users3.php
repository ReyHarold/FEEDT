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
    <?php
    include "side-nav.php";
    ?>
    <main>
    <!-- Main Content -->
    <div class="main-content">
        <div class="user-panel">
            <div class="user-panel-header">
                <img src="user-avatar.png" alt="User Avatar">
                <div class="user-info">
                    <h3>Rey Harold Matanguihan</h3>
                    <p>Reyharold@gmail.com</p>
                </div>
            </div>

            <!-- Admin Level Checkbox Positioned on Top Right -->
            <div class="admin-checkbox">
                <label>Admin Level</label>
                <input type="checkbox">
            </div>

            <!-- Permissions Section -->
            <div class="permissions">
                <label>
                    <span>Orders</span>
                    <input type="checkbox" checked>
                </label>
                <label>
                    <span>Suppliers</span>
                    <input type="checkbox">
                </label>
                <label>
                    <span>Reports & Analytics</span>
                    <input type="checkbox">
                </label>
            </div>

            <div class="buttons">
                <button class="cancel-btn">Cancel</button>
                <button class="accept-btn">Accept</button>
            </div>
        </div>
    </div>
    </div>
    </main>
    <style>
        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .user-panel {
            width: 500px;
            background-color: #e0d7b0;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #706c61;
            position: relative;
        }
        .user-panel-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .user-panel-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            background-color: #a0a0a0;
        }
        .user-info h3 {
            font-size: 1.2em;
            color: #333;
            margin: 0;
        }
        .user-info p {
            font-size: 0.9em;
            color: #333;
        }
        /* Admin Checkbox in Top Right */
        .admin-checkbox {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            font-size: 1em;
            color: #333;
        }
        .admin-checkbox label {
            margin-right: 5px;
        }
        .permissions {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .permissions label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 1em;
            background-color: #f0e5b9;
            padding: 10px;
            border: 1px solid #706c61;
            color: #333;
        }
        .permissions label span {
            flex: 1;
            text-align: left;
        }
        .permissions input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #333;
        }
        /* Buttons */
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .cancel-btn, .accept-btn {
            padding: 10px 30px;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            font-weight: bold;
        }
        .cancel-btn {
            margin-left: 250px;
            background-color: #f44336;
            color: #fff;
            border: 1px solid #706c61;
        }
        .accept-btn {
            background-color: #a2e26a;
            color: #333;
            border: 1px solid #706c61;
        }   
    </style>

</body>
</html>