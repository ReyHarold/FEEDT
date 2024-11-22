<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>FeedTrack</title>
</head>
<body>
        <div class="inventory-panel">
            <div class="inventory-header">
                <h3>Feed Mill Suppliers</h3>
                <div class="inventory-actions">

                    <button class="add-item-btn">Add Item</button>
                </div>
            </div>
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Contact Number</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>San jose Farms</td>
                        <td>099999999</td>
                        <td>SanjoseFarms@gmail.com</td>
                        <td>
                        <div class="account-actions">
                            <button class="btn btn-edit">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </div>
                        </td> 
                    </tr>
                    <tr>
                        <td>San jose Farms</td>
                        <td>099999999</td>
                        <td>SanjoseFarms@gmail.com</td>
                        <td>
                        <div class="account-actions">
                            <button class="btn btn-edit">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </div>
                        </td> 
                    </tr>
                    <tr>
                        <td>San jose Farms</td>
                        <td>099999999</td>
                        <td>SanjoseFarms@gmail.com</td>
                        <td>
                        <div class="account-actions">
                            <button class="btn btn-edit">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </div>
                        </td> 
                    </tr>
                    <tr>
                        <td>San jose Farms</td>
                        <td>099999999</td>
                        <td>SanjoseFarms@gmail.com</td>
                        <td>
                        <div class="account-actions">
                            <button class="btn btn-edit">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </div>
                        </td> 
                    </tr>
                    <tr>
                        <td>San jose Farms</td>
                        <td>099999999</td>
                        <td>SanjoseFarms@gmail.com</td>
                        <td>
                        <div class="account-actions">
                            <button class="btn btn-edit">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </div>
                        </td> 
                    </tr>
                    
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    <style>
        
        /* Inventory Panel */
        .inventory-panel {
            width: 100%;
            background-color: #f4f1df;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #706c61;
        }

        .inventory-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #e0d7b0;
            padding: 10px;
            border: 2px solid #706c61;
        }

        .inventory-header h3 {
            font-size: 1.2em;
            color: #333;
        }
        .inventory-actions {
            display: flex;
            align-items: center;
        }
        .add-item-btn {
            padding: 5px 15px;
            background-color: #a2e26a;
            color: #333;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            border: 1px solid #706c61;
        }
        /* Inventory Table */
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
        
        .inventory-table td {
            font-size: 1em;
            color: #333;
        }

        /* Action Buttons */

        .account-actions .btn {
            padding: 5px 10px;
            border: 1px solid #000;
            font-size: 0.8em;
            cursor: pointer;
            color: #fff;
            margin:5px;
        }

        .btn-edit { background-color: #27ae60; }
        .btn-delete { background-color: #c0392b; }
    </style>
</body>
</html>