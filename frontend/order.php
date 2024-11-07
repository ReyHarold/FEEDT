<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>FeedTrack</title>
</head>
<body>
        <div class="Order-panel">
            <div class="Order-header">
                <h3>Feed Mill Order</h3>
                <div class="Order-actions">
                    <button class="add-item-btn">Add Item</button>
                </div>
            </div>
            <table class="Order-table">
                <thead>
                    <tr>
                    <th>Responsible</th>
                    <th>Order Date</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Delivered Date</th>
                    <th>Supplier</th>
                    <th>Actions</th>
                    </tr>
                </thead>
            <tbody>

                <tr>
                    <td>Rey Harold Matanguihan</td>
                    <td>2024/17/10</td>
                    <td>Corn</td>
                    <td>10 units</td>
                    <td>200</td>
                    <td>2000</td>
                    <td>Delivered</td>
                    <td>2024/3/10</td>
                    <td>San jose Farms</td>
                    <td>   
                        <div class="account-actions">
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Kian Manalo</td>
                    <td>2024/17/10</td>
                    <td>Wheat</td>
                    <td>15 units</td>
                    <td>200</td>
                    <td>3000</td>
                    <td>Pending</td>
                    <td>---</td>
                    <td>San jose Farms</td>
                    <td>   
                        <div class="account-actions">
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Justin Mendoza</td>
                    <td>2024/17/10</td>
                    <td>Soybean</td>
                    <td>5 units</td>
                    <td>200</td>
                    <td>1000</td>
                    <td>Pending</td>
                    <td>---</td>
                    <td>San jose Farms</td>
                    <td>   
                        <div class="account-actions">
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Mark Angelo Ilagan</td>
                    <td>2024/17/10</td>
                    <td>Corn</td>
                    <td>50 units</td>
                    <td>200</td>
                    <td>10,000</td>
                    <td>Delivered</td>
                    <td>2024/3/10</td>
                    <td>San jose Farms</td>
                    <td>   
                        <div class="account-actions">
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>John Paul Santos</td>
                    <td>2024/17/10</td>
                    <td>Wheat</td>
                    <td>20 units</td>
                    <td>200</td>
                    <td>4000</td>
                    <td>Pending</td>
                    <td>---</td>
                    <td>San jose Farms</td>
                    <td>   
                        <div class="account-actions">
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                        </div>
                    </td>
                </tr>
            </tbody>
    </div>
    <style>

        /* Order Panel */
        .Order-panel {
            width: 1400px;
            background-color: #f4f1df;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #706c61;
        }

        .Order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #e0d7b0;
            padding: 10px;
            border-bottom: 2px solid #706c61;
        }

        .Order-header h3 {
            font-size: 1.2em;
            color: #333;
        }

        .Order-actions {
            display: flex;
            align-items: center;
        }

        .add-item-btn {
            padding: 5px 15px;
            background-color: #a2e26a;
            color: #333;
            border: 1px solid #706c61;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        /* Order Table */
        .Order-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .Order-table th,
        .Order-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #706c61;
        }

        .Order-table th {
            background-color: #e0d7b0;
            font-size: 1em;
            color: #333;
        }

        .Order-table td {
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