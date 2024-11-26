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
}
}

function usersForm(page, id, name, email, privilage){
    document.getElementById("id").value= id;
    document.getElementById("name").value= name;
    document.getElementById("email").value= email;

    privilage.forEach(function(priv) {
        const checkbox = document.getElementById(priv);  // Get the checkbox by id
        if (checkbox) {  // Ensure the element exists
            checkbox.checked = true;
        }
    });

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
  function callScript(formid, page) {
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
            loadContent('users', document.getElementById("users-link"));
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