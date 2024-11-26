// Define the function to be added to the button
function Search(table, inputId, phpscript) {
    let query = document.getElementById(inputId).value;

    // AJAX request
    fetch('scripts/'+phpscript+'.php?query=' + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
            let resultsDiv = document.getElementById(table);
            var count = 0;
            resultsDiv.innerHTML = '';  // Clear previous results first
            if (data.length > 0) {
                data.forEach(item => {
                    switch(table){
                        case "activityContent":
                            // Debugging: log class names assigned
                            let activityClass = count < 5 ? 'activity' : 'activity rowb hide';

                            resultsDiv.innerHTML += `
                            <div class='${activityClass}'>
                                <div class="profile">
                                    <div class="img-container">
                                        <img class="circle" src="data:image/png;base64,${item.user_pic}" alt="Profile">
                                    </div>
                                    <div class='activity-info'>${item.name}</div>
                                </div>
                                <div class='activity-email'>${item.description}</div>
                                <div class='activity-date'>${item.date}</div>
                            </div>`;

                            count++;
                        break;

                        case "accountContent":
                            if (typeof item.privilage === 'string') {
                                item.privilage = item.privilage.split(',');  // Convert string to array
                            }
                        let accountClass = count < 5 ? 'account' : 'account rowb hide';
                        let button = item.active == "true" ?
                        `<button class='btn btn-suspend ${item.userid}' onclick='areYouSure(\"Suspend Name: ${item.name} ?","${item.userid}", \"suspend\" ,"${item.name}")'>Suspend</button>` : 
                        `<button class='btn btn-resume ${item.userid}' onclick='areYouSure(\"Resume Name: ${item.name} ?", "${item.userid}", \"resume\", "${item.name}")'>Resume</button>`;
                        resultsDiv.innerHTML += `
                            <div class='${accountClass}'>
                                    <div class="profile">
                                        <div class="img-container">
                                            <img class="circle" alt="Profile" src="data:image/png;base64,${item.user_pic}">
                                        </div>
                                        <div class="activity-info">${item.name}</div>
                                    </div>
                                    <div class="account-email">${item.email}</div>
                                    <div class="account-actions">
                                        <button class="btn btn-privilege ${item.userid}" onclick="usersForm('user','${item.userid}', '${item.name}','${item.email}',[${item.privilage.map(priv => `'${priv}'`).join(", ")}])">Edit</button>
                                        `+button+`
                                        <button class='btn btn-delete' onclick = 'Delete(\""${item.id}"\", \""${item.name}"\")'>Delete</button>
                                    </div>
                                </div>
                                `
                            count++;
                        break;
                    }
                });
            } else {
                resultsDiv.innerHTML = 'No results found.';  // Display when no results
            }
        })
        .catch(error => console.error('Error:', error));
}



// Add the event listener to add the onclick function
function addSearch(buttonId, table, inputId, phpscript) {
    var button = document.getElementById(buttonId);
    // Use an anonymous function to delay calling searchFunction
    button.onclick = function() {
        Search(table, inputId, phpscript);
    };
}

// Remove the event listener to remove the onclick function
function removeSearch(buttonId) {
    var button = document.getElementById(buttonId);
    // Remove the onclick event by setting it to null
    setTimeout(() => button.onclick = null, 500);
}