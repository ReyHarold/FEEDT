
            <!-- Dashboard Content -->
            <div class="dashboard">
                <!-- Inventory Chart -->
                <a onclick="loadContent('report2', this)"><div class="card card-inventory">
                    <h2>Inventory</h2>
                </div></a>
                <!-- Sales Chart -->
                <a onclick="loadContent('report3', this)"><div class="card card-sales">
                    <h2>Sales</h2>
                </div></a>
                <!-- Forecasting Chart -->
                <a onclick="loadContent('report4', this)"><div class="card card-forecasting">
                    <h2>Forecasting</h2>
                </div></a>
                <!-- Cost Chart -->
                <a onclick="loadContent('report5', this)"><div class="card card-cost">
                    <h2>Cost</h2>
                </div></a>
            </div>
        </div>

    <style>

    /* Dashboard grid layout */
    .dashboard {
        width: 100%;
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