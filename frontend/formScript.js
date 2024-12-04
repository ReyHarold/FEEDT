// Function to show the form
function showForm(page) {
    switch(page){
        case "user":
    const popupFormuser = document.querySelector('.Popuser');
    const bodyuser = document.querySelector('body');
    popupFormuser.style.display = 'flex';
    bodyuser.style.overflow = 'hidden';
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
        
        document.getElementById("addItem").value= " ";
        document.getElementById("addQuantity").value= 0;
        document.getElementById("addPrice").value= 0;
        document.getElementById("minLvlAdd").value= 0;
        document.getElementById("maxLvlAdd").value= 0;
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
        document.getElementById("quantity").value= 0;
        document.getElementById("price").value= 0;
        document.getElementById("minLvl").value= 0;
        document.getElementById("maxLvl").value= 0;
    break;
}
}

function usersForm(page, id, name, email, privilage){
    switch(page){
        case "user":
            document.getElementById("id").value= id;
            document.getElementById("name").value= name;
            document.getElementById("email").value= email;

            privilage.forEach(function(priv) {
                const checkbox = document.getElementById(priv);  // Get the checkbox by id
                if (checkbox) {  // Ensure the element exists
                    checkbox.checked = true;
                }
            });
        break;

        case "inventory":
            document.getElementById("inventoryid").value= id;
            document.getElementById("item").value= name;
            document.getElementById("price").value= email;
            document.getElementById("quantity").value= privilage[0];
            document.getElementById("minLvl").value= privilage[1];
            document.getElementById("maxLvl").value= privilage[2];
        break;

        case "production":

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
function Delete(id, name) {
    var password = prompt("Delete Username:"+name+"\nInput password to continue:");
    if (password === null || password.trim() === "") {
        alert("Deletion canceled or invalid input.");
        return;  // Exit the function if the prompt was canceled or empty
    }
        $.post('scripts/deleteUser.php', { id: id, password: password, name: name}, function(result) { 
            if (result == "Wrong"){
                alert("Wrong Password, Logging out!");
                window.location.replace("../logout.php");
            }else{
                alert(result);
                loadContent('users', document.getElementById("users-link"));
            }; 
         });
      };