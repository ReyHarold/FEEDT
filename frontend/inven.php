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
    <div class="main-content">
        <div class="inventory-panel">
            <div class="inventory-header">
                <h3>Feed Mill Inventory</h3>
                <div class="inventory-actions">
                    <input type="text" placeholder="Search...">
                    <button class="add-item-btn">Add Item</button>
                </div>
            </div>
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Item</td>
                        <td>10 units</td>
                        <td>200</td>
                        <td>
                        <div class="account-actions">
                            <button class="btn btn-edit">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </div>
                        </td> 
                    </tr>
                    <tr>
                        <td>Item</td>
                        <td>10 units</td>
                        <td>200</td>
                        <td>
                        <div class="account-actions">
                            <button class="btn btn-edit">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </div>
                        </td> 
                    </tr>
                    <tr>
                        <td>Item</td>
                        <td>10 units</td>
                        <td>200</td>
                        <td>
                        <div class="account-actions">
                            <button class="btn btn-edit">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </div>
                        </td> 
                    </tr>
                    <tr>
                        <td>Item</td>
                        <td>10 units</td>
                        <td>200</td>
                        <td>
                        <div class="account-actions">
                            <button class="btn btn-edit">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </div>
                        </td> 
                    </tr>
                    <tr>
                        <td>Item</td>
                        <td>10 units</td>
                        <td>200</td>
                        <td>
                        <div class="account-actions">
                            <button class="btn btn-edit">Edit</button>
                            <button class="btn btn-delete">Delete</button>
                        </div>
                        </td> 
                    </tr>
                    <tr>
                        <td>Item</td>
                        <td>10 units</td>
                        <td>200</td>
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
    </div>
    </main>
    
    <style>
        .main-content {
            flex: 1;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .inventory-panel {
            width: 1400px;
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
            border-bottom: 2px solid #706c61;
        }

        .inventory-header h3 {
            font-size: 1.2em;
            color: #333;
        }

        .inventory-actions {
            display: flex;
            align-items: center;
        }

        .inventory-actions input[type="text"] {
            padding: 5px;
            font-size: 1em;
            border: 1px solid #706c61;
            border-radius: 4px;
            margin-right: 10px;
        }

        .add-item-btn {
            padding: 5px 15px;
            background-color: #a2e26a;
            color: #333;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
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

        .inventory-table th {
            background-color: #e0d7b0;
            font-size: 1em;
            color: #333;
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
        }

        .btn-edit { background-color: #27ae60; }
        .btn-delete { background-color: #c0392b; }
    </style>
</body>

</html>