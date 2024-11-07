<!DOCTYPE html>
< lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report2</title>
</head>
<body>
    <header>
        <h1>FeedTrack</h1>
    </header>



<!-- Main Content -->
<main>
<div class="main-content">
    <div class="user-panel">
        <div class="user-panel-header">
        <div class="graph-checkbox">
            <div class="user-actions">
                <label>Chart</label>
                <input type="checkbox">

                <label>From</label>
                <input type="text">

                <label>To</label>
                <input type="text" >

                <label>Item</label>
                <input type="text" >
            </div>
    </div>
</div>
    <table class="inventory-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox">Select All</th>
                            <th><input type="checkbox">From</th>
                            <th><input type="checkbox">To Quantity</th>
                            <th><input type="checkbox">Consumption</th>
                            <th><input type="checkbox">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td><input type="checkbox">Item</td>
                        <td>10</td>
                        <td>10 units</td>
                        <td>0 units</td>
                        <td>200</td>
                        </tr>
                        <tr>
                        <td><input type="checkbox">Item</td>
                        <td>10</td>
                        <td>10 units</td>
                        <td>0 units</td>
                        <td>200</td>
                        </tr>
                        <tr>
                        <td><input type="checkbox">Item</td>
                        <td>10</td>
                        <td>10 units</td>
                        <td>0 units</td>
                        <td>200</td>
                        </tr>
                        <tr>
                        <td><input type="checkbox">Item</td>
                        <td>10</td>
                        <td>10 units</td>
                        <td>0 units</td>
                        <td>200</td>
                        </tr>
                        <tr>
                        <td><input type="checkbox">Item</td>
                        <td>10</td>
                        <td>10 units</td>
                        <td>0 units</td>
                        <td>200</td>
                        </tr>
                        <tr>
                        <td><input type="checkbox">Item</td>
                        <td>10</td>
                        <td>10 units</td>
                        <td>0 units</td>
                        <td>200</td>
                        </tr>
                        <tr>
                        <td><input type="checkbox">Item</td>
                        <td>10</td>
                        <td>10 units</td>
                        <td>0 units</td>
                        <td>200</td>
                        </tr>
                    </tbody>
    </table>
    <button class="Print-button">Print</button>
    </main>

    <style>
    .main-content {
        flex: 1;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    header {
    background-color: #63d067;
    color: white;
    padding: 20px;
    text-align: left;
    text-indent: 190px;
    width: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    border-bottom: 2px solid #000;
    }

    h1 {
        margin: 0;
    }

    .user-panel {
            width: 1400px;
            background-color: #f4f1df;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #706c61;
            margin-top: 60px;
    }

    label {
        margin-left: 110px;
    }
    .user-actions {
            display: flex;
            align-items: center;
            
    }
    
    .user-actions input[type="text"] {
        font-size: 1em;
        border: 1px solid #706c61;
        border-radius: 4px;
        margin-left: 20px;
    }
    /* Table */
    .inventory-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .inventory-table th,
    .inventory-table td {
        padding: 10px;
        text-align: center;
        border: 1px solid #706c61;
    }

    .inventory-table th {
        background-color: #e0d7b0;
        font-size: 1em;
        color: #333;
    }

    .inventory-table td {
        font-size: 1em;
        color: #333;
    }

    
    .Print-button {
        width: 100px;
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