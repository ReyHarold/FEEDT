<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>FeedTrack</title>
</head>
<body>
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

    <style>

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