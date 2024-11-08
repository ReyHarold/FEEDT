<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FeedTrack</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to bottom, #628338, #FFFFFF);
            overflow:hidden;
        }

        /* Header styling */
        .header {
            position: absolute;
            top: 0;
            width: 100%;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: #628338;
        }

        .header img {
            height: 24px;
            margin-right: 10px;
        }

        /* Container styling */
        .container {
            background-color: #FFFFFF;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 50%;
            max-width:400px;
        }

        h1 {
            font-size: 1.5em;
            margin: 0 0 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            align-self: flex-start;
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #F5F5F5;
        }

        button {
            background-color: #628338;
            border: none;
            color: white;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            transition:0.3s;
            width: 100%;
        }
        button:hover {
            background-color: #a5cba1;
        }

        /* Footer styling */
        .footer {
            position: absolute;
            bottom: 10px;
            left: 20px;
            font-size: 12px;
            color: black;
            text-align: left;
        }

        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="logo.png">
        <span>FeedTrack</span>
    </div>

    <div class="container">
        <form action="login.php" method="post">
        <h1>Welcome to FeedTrack</h1>
        <?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
            <label for="username">Username</label>
            <input type="text" id="username" name="name" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Sign In</button>
            </div>
    </form>

    <div class="footer">
        <p>Privacy Policy</p>
        <p>Contact Us</p>
        <p>© 2024 Goodwill Farms All Rights Reserved.</p>
    </div>
</body>
</html>
