


<div id="addItemForm">
            <h4>Add New Production</h4>
            <form id="addForm">
                <label>
                    Date:
                    <input type="date" id="addDate" required>
                </label>
                <label>
                    Raw Materials:
                    <input type="text" id="addMaterials" required>
                </label>
                <label>
                    Finished Product:
                    <input type="text" id="addProduct" required>
                </label>
                <label>
                    Quantity Produced:
                    <input type="number" id="addQuantity" required>
                </label>
                <button class="add-item-btn" type="submit">Save</button>
            </form>
            </div>


            <style>
   /* Add Item Button */
.add-item-btn {
    padding: 8px 15px;
    background-color: #a2e26a;
    color: #333;
    border: 1px solid #706c61;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    text-align: center;
}

.add-item-btn:hover {
    background-color: #8bd65c;
}

/* Modal Container */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

/* Modal Content */
.modal-content {
    background-color: #f4f1df;
    margin: 10% auto;
    padding: 20px;
    border-radius: 8px;
    border: 2px solid #706c61;
    width: 40%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-align: left;
}

/* Close Button */
.close-btn {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 1.5em;
    color: #333;
    cursor: pointer;
}

.close-btn:hover {
    color: #a94442;
}

/* Form Labels */
form label {
    display: block;
    margin-bottom: 10px;
    color: #333;
    font-size: 0.9em;
}

form input {
    width: 100%;
    padding: 8px;
    margin: 5px 0 15px 0;
    border: 1px solid #706c61;
    border-radius: 4px;
    font-size: 0.9em;
}

/* Save Button in Modal */
form .add-item-btn {
    background-color: #e0d7b0;
    color: #333;
    border: 1px solid #706c61;
    padding: 8px 15px;
    cursor: pointer;
    font-weight: bold;
}

form .add-item-btn:hover {
    background-color: #d1c89b;
}

            </style>