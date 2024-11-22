    <div class="box">
            <h2>Recent Activities</h2>
            <div class="activity">
                <div class="profile"><img src="profile1.png" alt="Profile">
                <div class="activity-info">Rey Harold Matanguihan </div>
                </div>
                <div class="activity-email">Reyharold@gmail.com</div>
                <div class="activity-date">2024 - 4 - 13</div>
            </div>
            <div class="activity">
            <div class="profile"><img src="profile2.png" alt="Profile">
                <div class="activity-info">Mark Angelo Ilagan </div>
            </div>
                <div class="activity-email">MarkAngelo@gmail.com</div>
                <div class="activity-date">2024 - 4 - 13</div>
            </div>
            <div class="activity">
            <div class="profile"><img src="profile3.png" alt="Profile">
                <div class="activity-info">Kian Derich Manalo </div>
            </div>
                <div class="activity-email">KianManalo@gmail.com</div>
                <div class="activity-date">2024 - 4 - 13</div>
            </div>
            <div class="activity">
                <div class="activity-info"></div>
                <div class="activity-email"></div>
                <div class="activity-date"><button class="activity-btn">User Activities</button></div>
            </div>
        </div>

        <div class="box">
            <h2>Accounts</h2>
            <div class="search-bar">
                <input type="text" placeholder="Search...">
            </div>
            <div class="account">
            <div class="profile"><img src="profile1.png" alt="Profile">
                <div class="account-info">Rey Harold Matanguihan </div>
            </div>
                <div class="account-email">Reyharold@gmail.com</div>
                <div class="account-actions">
                    <button class="btn btn-privilege">Privilege</button>
                    <button class="btn btn-resume">Resume</button>
                    <button class="btn btn-delete">Delete</button>
                </div>
            </div>
            <div class="account">
            <div class="profile"><img src="profile2.png" alt="Profile">
                <div class="account-info">Kian Derich Manalo </div>
            </div>
                <div class="account-email">KianManalo@gmail.com</div>
                <div class="account-actions">
                    <button class="btn btn-privilege">Privilege</button>
                    <button class="btn btn-suspend">Suspend</button>
                    <button class="btn btn-delete">Delete</button>
                </div>
            </div>
            <div class="account">
                <div class="profile"><img src="profile3.png" alt="Profile">
                <div class="account-info">Kian Derich Manalo </div>
                </div>
                <div class="account-email">KianManalo@gmail.com</div>
                <div class="account-actions">
                    <button class="btn btn-privilege">Privilege</button>
                    <button class="btn btn-suspend">Suspend</button>
                    <button class="btn btn-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Content area styling */

        .box {
            width: 100%;
            background-color: #f5f1dc;
            padding: 20px;
            margin-bottom: 20px;
            border: 2px solid #000;
            border-radius: 5px;
        }

        .box h2 {
            margin-bottom: 15px;
            color: #333;
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
        }

        .activity-date {
            font-size: 0.8em;
            color: #666;
        }
        
        .account-email {
            font-size: 0.8em;
            display: flex;
            align-items: center;
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