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
            <!-- Dashboard Content -->
            <div class="dashboard">
                <!-- Inventory Chart -->
                <div class="card card-inventory">
                    <h2>Inventory</h2>
                </div>
                <!-- Sales Chart -->
                <div class="card card-sales">
                    <h2>Sales</h2>
                </div>
                <!-- Forecasting Chart -->
                <div class="card card-forecasting">
                    <h2>Forecasting</h2>
                </div>
                <!-- Cost Chart -->
                <div class="card card-cost">
                    <h2>Cost</h2>
                </div>
            </div>
        </div>
  </div>
    </main>

    <style>

    body 
    {
        font-family: Arial, sans-serif;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }
   .main-content {
    background-color: #DCE9E2;
    flex: 1;
    padding: 300px;
    }

    /* Dashboard grid layout */
    .dashboard {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-gap: 20px;
    }

    /* Card styling */
    .card {
        background-color: white;
        padding: 100px;
        border: 2px solid #000;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    </style>

</body>
</html>