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

function areYouSure(message, id, action) {
    return new Promise((resolve, reject) => {
      const confirmation = window.confirm(message);
      if (confirmation) {
        $.post('scripts/suspend_script.php', { action: action, id: id }, function(result) { 
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
  function callScript(formid, page){
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
    .then(response => response.text())
    .then(data => console.log("Server Response:", data))
    .catch(error => console.error('Error:', error));
});
loadContent('users', document.getElementById("users-link"));
}