// Function to show the form
function showForm(page, mode = "add", userData = {}) {
    switch (page) {
        case "user":
            const popupFormuser = document.querySelector('.Popuser');
            const bodyuser = document.querySelector('body');
            popupFormuser.style.display = 'flex';
            bodyuser.style.overflow = 'hidden';

            // Update form for add or edit mode
            const formTitle = document.getElementById("formTitle");
            if (mode === "add") {
                formTitle.innerText = "Add New User";
                document.getElementById("id").value = "";
                document.getElementById("name").value = "";
                document.getElementById("email").value = "";
                document.querySelectorAll('input[type=checkbox]').forEach(checkbox => checkbox.checked = false);
            } else if (mode === "edit" && userData) {
                formTitle.innerText = "Edit User";
                document.getElementById("id").value = userData.id || "";
                document.getElementById("name").value = userData.name || "";
                document.getElementById("email").value = userData.email || "";

                // Populate checkboxes based on privileges
                const privileges = userData.privileges || [];
                document.querySelectorAll('input[type=checkbox]').forEach(checkbox => {
                    checkbox.checked = privileges.includes(checkbox.value);
                });
            }
            break;

        case "main":
            const popupFormmain = document.querySelector('.Popmain');
            const bodymain = document.querySelector('body');
            popupFormmain.style.display = 'flex';
            bodymain.style.overflow = 'hidden';
            break;

        case "inventoryAdd":
            const popupForminventoryAdd = document.querySelector('.PopinventoryAdd');
            const bodyinventoryAdd = document.querySelector('body');
            popupForminventoryAdd.style.display = 'flex';
            bodyinventoryAdd.style.overflow = 'hidden';
            break;

        case "production":
            const popupFormproduction = document.querySelector('.Popproduction');
            const bodyproduction = document.querySelector('body');
            popupFormproduction.style.display = 'flex';
            bodyproduction.style.overflow = 'hidden';
            break;

        case "inventory":
            const popupForminventory = document.querySelector('.Popinventory');
            const bodyinventory = document.querySelector('body');
            popupForminventory.style.display = 'flex';
            bodyinventory.style.overflow = 'hidden';
            break;

        case "order":
            const popupOrder = document.querySelector('.Poporder');
            const bodyOrder = document.querySelector('body');
            popupOrder.style.display = 'flex';
            bodyOrder.style.overflow = 'hidden';
            break;
    }
}


// Function to hide the form
function hideForm(page) {
    const popupForm = "";
    switch(page){
        case "user":
    const privilage2 = ["users", "inventory", "orders", "production", "suppliers", "reports"]
    const popupFormuser = document.querySelector('.Popuser');
    const bodyuser = document.querySelector('body');
        bodyuser.style.overflow = 'auto';
        popupFormuser.style.display = 'none';
    
    document.getElementById("id").value= " ";
    document.getElementById("name").value= " ";
    document.getElementById("email").value= " ";
    privilage2.forEach(function(priv2) {
        const checkbox = document.getElementById(priv2);  // Get the checkbox by id
        if (checkbox) {  // Ensure the element exists
            checkbox.checked = false;
        }
    })
    break;
        case "main":
    const popupFormmain = document.querySelector('.Popmain');
    const bodymain = document.querySelector('body');
        bodymain.style.overflow = 'auto';
        popupFormmain.style.display = 'none';
    break;
    case "inventoryAddform":
        const popupFormaddInventory = document.querySelector('.PopinventoryAdd');
        const bodyaddInventory = document.querySelector('body');
            bodyaddInventory.style.overflow = 'auto';
            popupFormaddInventory.style.display = 'none';
        document.getElementById("Addfeed").value= " ";
        document.getElementById("Addfinish").value= false;
        document.getElementById("AddDropTitle").innerHTML= "Feed";
        document.getElementById("addItem").value= " ";
        document.getElementById("addQuantity").value= 0;
        document.getElementById("addPrice").value= 0;
        document.getElementById("minLvlAdd").value= 0;
        document.getElementById("maxLvlAdd").value= 0;
        document.getElementById("searchBox").value= "";
        document.getElementById("otherDiv").style.display = 'none' 
        const elements = document.getElementsByClassName("ingredients");
        while (elements.length > 0) elements[0].remove();
    break;
    case "production":
        const popupFormproduction = document.querySelector('.Popproduction');
        const bodyproduction = document.querySelector('body');
        bodyproduction.style.overflow = 'auto';
        popupFormproduction.style.display = 'none';
    break;

    case "inventory":
    const popupFormInventory = document.querySelector('.Popinventory');
        const bodyInventory = document.querySelector('body');
        bodyInventory.style.overflow = 'auto';
        popupFormInventory.style.display = 'none';
        
        document.getElementById("item").value= " ";
        document.getElementById("feed").value= " ";
        document.getElementById("finish").checked= false;
        document.getElementById("dropTitle").innerHTML= "Feed";
        document.getElementById("quantity").value= 0;
        document.getElementById("price").value= 0;
        document.getElementById("minLvl").value= 0;
        document.getElementById("maxLvl").value= 0;
        document.getElementById("searchBox").value= "";
        const elementss = document.getElementsByClassName("ingredients");
        while (elementss.length > 0) elementss[0].remove();
    break;
    case "orders":
    const popupOrder = document.querySelector('.Poporder');
        const bodyOrder = document.querySelector('body');
        bodyOrder.style.overflow = 'auto';
        popupOrder.style.display = 'none';
    break;
}
}

function usersForm(page, id, name, email, privilage){
    switch(page){
        case "user":
            ddocument.getElementById('action').value = 'update';  // Change action to 'update'
            document.getElementById('userId').value = id;  // Set the user ID
            document.getElementById('name').value = name;
            document.getElementById('email').value = email;

            privilage.forEach(function(priv) {
                const checkbox = document.getElementById(priv);  // Get the checkbox by id
                if (checkbox) {  // Ensure the element exists
                    checkbox.checked = true;
                }
            });
        break;

        case "inventory":
        document.getElementById("inventoryid").value = id;
        document.getElementById("item").value = name;
        document.getElementById("price").value = email;
        document.getElementById("quantity").value = privilage[0];
        document.getElementById("minLvl").value = privilage[1];
        document.getElementById("maxLvl").value = privilage[2];

  if (privilage[3] === 'finish') {
    document.getElementById("finish").checked = true;
    IngredientShow('finish', privilage[4]); // Show the ingredient section

    // Fetch the ingredients via AJAX
    fetch(`scripts/getIngredients.php?item=${encodeURIComponent(name)}`)
      .then(response => response.json())
      .then(data => {
        data.forEach(({ ingredient, quantity }) => {
          const nyak = `
            <div class="form-row finish ingredients">
              <div class="input-data">
                <input type="number" name="ingredientAndYield[]" value="${quantity}" required>
                <input type="hidden" name="ingredientAndYieldName[]" value="${ingredient}">
                <div class="underline"></div>
                <label>${ingredient} Quantity(KG):</label>
              </div>
            </div>`;
          document.getElementById("ingredientrow").insertAdjacentHTML("afterend", nyak);
        });
      })
      .catch(error => console.error('Error fetching ingredients:', error));
  }

  document.getElementById("feed").value = privilage[4];
  document.getElementById("dropTitle").innerHTML = privilage[4];
  break;


        case "production":

        break;

        case "order":

        break;
    }

    showForm(page);
}

function areYouSure(message, id, action, name) {
    return new Promise((resolve, reject) => {
      const confirmation = window.confirm(message);
      if (confirmation) {
        $.post('scripts/suspend_script.php', { action: action, id: id, name: name}, function(result) { 
            if (result){
                alert(result);
                loadContent('users', document.getElementById("users-link"));
            }; 
         });
      } else {
        reject(false); // User clicked 'Cancel'
      }
    });
  }
  function callScript(formid, page, load) {
    const bodyuser = document.querySelector('body');
    bodyuser.style.overflow = 'auto';

    document.getElementById(formid).addEventListener("submit", function(e) {
        e.preventDefault(); // Prevent form from submitting traditionally
        
        const formData = new FormData(this);

        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        fetch(page, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
        })
        .then(data => {
            console.log('Success:', data);
            // Call loadContent only after successful form submission
        switch(load){
            case "users":
                loadContent('users', document.getElementById("users-link"));
            break;
            case "inventory":
            loadContent('inventory', document.getElementById("inventory-link"));
            break;
            case "production":
            loadContent('production', document.getElementById("production-link"));
            break;
            case "orders":
            loadContent('orders', document.getElementById("orders-link"));
            break;
        }
        })
    });
}


function checkboxCheck(num){
    if(num==!undefined){
    document.getElementById("checkbox"+num+"").checked = true;
    setTimeout(() => document.getElementById("search"+num+"").focus(), 500);

    }else{
    document.getElementById("checkbox").checked = true;
    setTimeout(() => document.getElementById("search").focus(), 500);
    }
}
function remove(num){
    if(num== !undefined){
    document.getElementById("checkbox"+num+"").checked = false;
    }else{
    document.getElementById("checkbox").checked = false;
    }
}
function Delete(id, name, page, back) {
    var password = prompt("Delete :"+name+"\nInput password to continue:");
    if (password === null || password.trim() === "") {
        alert("Deletion canceled or invalid input.");
        return;  // Exit the function if the prompt was canceled or empty
    }
        $.post('scripts/'+page+'.php', { id: id, password: password, name: name}, function(result) { 
            if (result == "Wrong"){
                alert("Wrong Password, Logging out!");
                window.location.replace("../logout.php");
            }else{
                alert(result);
                loadContent(back, document.getElementById(back+"-link"));
            }; 
         });
      };

      function setDrop(feed, add, type) {
        if (!feed) {
            console.error('Feed is undefined in setDrop.');
            return;
        }
    
        if (add === 'add') {
            document.getElementById("Addfeed").value = feed;
            document.getElementById("AddDropTitle").innerHTML = feed.toUpperCase();
            if (feed !== 'other') {
                document.getElementById("otherDiv").style.display = 'none';
            }
        } else if (add === 'production') {
            document.getElementById("type").value = type || '';
            document.getElementById("name").value = feed;
            document.getElementById("dropTitle").innerHTML = feed.toUpperCase();
    
            fetch(`scripts/generateIngredient.php?feed=${encodeURIComponent(feed)}`)
                .then(response => response.text())
                .then(data => {
                    const container = document.getElementById("ingredientContainers");
                    if (container) {
                        container.innerHTML = data;
                    } else {
                        console.error('ingredientContainers element not found.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const container = document.getElementById("ingredientContainers");
                    if (container) {
                        container.innerHTML = 'Error fetching data.';
                    }
                });
        } else {
            document.getElementById("feed").value = feed;
            document.getElementById("dropTitle").innerHTML = feed.toUpperCase();
        }
    }
    
function otherFeed(){
    document.getElementById("otherDiv").style.display = 'block';
    document.getElementById("AddDropTitle").innerHTML = "Other";

    setDrop('other', 'add')
}

function suggest(data, generate) {
    const searchBox = document.getElementById("searchBox");
    const suggestions = document.getElementById("suggestions");

    const query = searchBox.value.toLowerCase(); // Get input value
    suggestions.innerHTML = ""; // Clear previous suggestions

    if (query) {
        const filtered = data.filter((item) =>
            item.toLowerCase().includes(query)
        );

        filtered.forEach((item) => {
            const listItem = document.createElement("li");
            listItem.textContent = item;

            // Add the onclick event
            listItem.onclick = () => {
                const nyak=
                `<div class="form-row finish ingredients" id="ingredientrow">
                <div class="input-data" id="`+item+`">
                    <input type="number" id="ingredientQuantity" name="ingredientAndYield[]" required>
                    <input type="hidden" name="ingredientAndYieldName[]" value="`+item+`">
                    <div class="underline"></div>
                    <label for="ingredientQuantity">`+item+` Quantity(KG):</label>
                </div></div>`;
                document.getElementById("ingredientrow").insertAdjacentHTML("afterend",nyak);
                suggestions.innerHTML = ""; // Clear suggestions

                if(generate){
                    $.post('scripts/generate.php', { id: id, password: password, name: name}, function(result) { 
                        if (result == "Wrong"){
                            alert("Wrong Password, Logging out!");
                            window.location.replace("../logout.php");
                        }else{
                            alert(result);
                            loadContent('users', document.getElementById("users-link"));
                        }; 
                     });
                }
            };

            suggestions.appendChild(listItem);
        });
    }
};

function IngredientShow(id, value) {
    const ingredients = document.getElementsByClassName(id);
    if (!ingredients) {
        console.error(`No elements found with class name ${id}`);
        return;
    }

    if (document.getElementById(id).checked) {
        for (let i = 0; i < ingredients.length; i++) {
            ingredients[i].style.display = 'flex';
        }
        if (id === 'finish') {
            setDrop(value, 'inventory');
        }
    } else {
        for (let i = 0; i < ingredients.length; i++) {
            ingredients[i].style.display = 'none';
        }
    }
}
function updateStatus(productionId) {
    const password = prompt("Enter your password to confirm the update:");
    if (password !== null) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert(xhr.responseText);
                location.reload();
            }
        };
        xhr.send(`id=${productionId}&password=${encodeURIComponent(password)}`);
    }
}
function promptPasswordAndUpdate(orderId) {
    const password = prompt("Please enter your password to update the order status:");

    if (password !== null) {
        // Send an AJAX request to the server with order ID and password
        fetch('scripts/UpdateOrder.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `orderId=${orderId}&password=${encodeURIComponent(password)}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            if (data.includes("successfully")) {
                loadContent('orders', document.getElementById("orders-link"));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the order.');
        });
    }
}
function deleteOrder(orderId) {
    if (confirm("Are you sure you want to delete this order?")) {
        fetch('scripts/DeleteOrder.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `orderId=${orderId}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            if (data.includes("successfully")) {
                loadContent('orders', document.getElementById("orders-link"));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the order.');
        });
    }
}

// Function to open the edit form with existing data
function openEditForm(orderId, item, quantity, price) {
    document.getElementById('editOrderId').value = orderId;
    document.getElementById('editItem').value = item;
    document.getElementById('editQuantity').value = quantity;
    document.getElementById('editPrice').value = price;
    document.getElementById('editPopupForm').style.display = 'flex';
}

// Function to close the edit form
function closeEditForm() {
    document.getElementById('editPopupForm').style.display = 'none';
}
function promptUpdateAndUpdate(orderId) {
    if (confirm("Are you sure you want to mark this order as delivered?")) {
        fetch('scripts/UpdateOrderStatus.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `orderId=${orderId}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            if (data.includes("successfully")) {
                loadContent('orders', document.getElementById("orders-link"));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the order.');
        });
    }
}
function printReport() {
    // Get the content of the printable area
    var printContent = document.getElementById('printableArea').innerHTML;

    // Create a new window for printing
    var printWindow = window.open('', '', 'height=400,width=800');

    // Add styles and content to the print window
    printWindow.document.write('<html><head><title>Inventory Report</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
    printWindow.document.write('th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('</style></head><body>');

    // Write the content to the print window
    printWindow.document.write(printContent);
    printWindow.document.write('</body></html>');

    // Close the document to finish writing
    printWindow.document.close();

    // Trigger the print dialog
    printWindow.print();
}
// Fetch and display Inventory Chart
function loadInventoryChart() {
    fetch('inventoryData.php')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('inventoryChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.values,
                        backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56'],
                    }]
                }
            });
        });
}

// Fetch and display Production Chart
function loadProductionChart() {
    fetch('productionData.php')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('productionChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels, // x-axis: item names
                    datasets: [{
                        label: 'Total Production',
                        data: data.totals, // y-axis: totals
                        borderColor: '#36a2eb',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false // Hide the legend since there’s only one dataset
                        },
                        title: {
                            display: true,
                            text: 'Production Totals by Item'
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Items'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Total Quantity'
                            }
                        }
                    }
                }
            });
        });
}


// Fetch and display Sales Chart
function loadSalesChart() {
    fetch('salesData.php')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('salesChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Best Selling Products',
                        data: data.values,
                        backgroundColor: '#4bc0c0',
                    }]
                }
            });
        });
}
function submitUser() {
    const id = document.getElementById('id').value;
    const actionURL = id ? 'scripts/updateUser.php' : 'scripts/addUser.php';

    callScript('userForm', actionURL, 'users');
}
function populateUserForm(user) {
    document.getElementById('action').value = 'update'; // Update action
    document.getElementById('userId').value = user.userid; // Set user ID
    document.getElementById('name').value = user.name; // Set name
    document.getElementById('email').value = user.email; // Set email

    // Pre-fill checkboxes
    user.privilage.forEach(function(privilege) {
        const checkbox = document.getElementById(privilege);
        if (checkbox) {
            checkbox.checked = true;
        }
    });

    // Optionally, pre-fill the password fields if necessary (usually they should remain empty)
}
