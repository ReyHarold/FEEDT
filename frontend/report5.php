<!DOCTYPE html>
< lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report3</title>
</head>
<body>
    <div class="user-panel">
        <div class="user-panel-header">
        <div class="graph-checkbox">
            <div class="user-actions">
                <label>Graph</label>
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
                            <th><input type="checkbox">Responsible</th>
                            <th><input type="checkbox">Order Date</th>
                            <th><input type="checkbox">Quantity</th>
                            <th><input type="checkbox">Price</th>
                            <th><input type="checkbox">Total Price</th>
                            <th><input type="checkbox">Status</th>
                            <th><input type="checkbox">Delivered Date</th>
                            <th><input type="checkbox">Supplier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td><input type="checkbox">Swine</td>
                        <td>Mark Angelo Ilagan</td>
                        <td>2024-17-10</td>
                        <td>20 units</td>
                        <td>200</td>
                        <td>2000</td>
                        <td>Delivered</td>
                        <td>2024-30-10</td>
                        <td>San Jose Farm</td>
                        </tr>
                        <tr>
                        <td><input type="checkbox">Swine</td>
                        <td>Rey Harold Matanguihan</td>
                        <td>2024-17-10</td>
                        <td>20 units</td>
                        <td>200</td>
                        <td>2000</td>
                        <td>Delivered</td>
                        <td>2024-30-10</td>
                        <td>San Jose Farm</td>
                        </tr>
                        <tr>
                        <td><input type="checkbox">Wheat</td>
                        <td>Manalo Kian</td>
                        <td>2024-17-10</td>
                        <td>20 units</td>
                        <td>200</td>
                        <td>2000</td>
                        <td>Pending</td>
                        <td>------</td>
                        <td>San Jose Farm</td>
                        </tr>
                        <tr>
                        <td><input type="checkbox">Soybean</td>
                        <td>Justin Mendoza</td>
                        <td>2024-17-10</td>
                        <td>20 units</td>
                        <td>200</td>
                        <td>2000</td>
                        <td>Pending</td>
                        <td>------</td>
                        <td>San Jose Farm</td>
                        </tr>
                        <td><input type="checkbox">Wheat</td>
                        <td>Manalo Kian</td>
                        <td>2024-17-10</td>
                        <td>20 units</td>
                        <td>200</td>
                        <td>2000</td>
                        <td>Delivered</td>
                        <td>2024-30-10</td>
                        <td>San Jose Farm</td>
                        </tr>
                        <tr>
                        <td><input type="checkbox">Soybean</td>
                        <td>Justin Mendoza</td>
                        <td>2024-17-10</td>
                        <td>20 units</td>
                        <td>200</td>
                        <td>2000</td>
                        <td>Pending</td>
                        <td>------</td>
                        <td>San Jose Farm</td>
                        </tr>
                        <tr>
                        <td></td>
                        <td>Total</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>12000</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        </tr>
                    </tbody>
    </table>
    <button class="Print-button">Print</button>

    <style>
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