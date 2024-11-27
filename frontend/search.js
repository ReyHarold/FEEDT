// Define the function to be added to the button
function Search(table, inputId, phpscript,showmore) {
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
                            <tr class='${activityClass}'>
                                <td>
                                    <div class="profile">
                                        <img class="circle" src="data:image/png;base64,${item.user_pic}" alt="Profile">
                                        ${item.name}
                                    </div>
                                <td>
                                <td class='activity-email'>${item.description}</td>
                                <td class='activity-date'>${item.date}</td>
                            </tr>`;

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
                            <tr class='${accountClass}'>
                                    <td>
                                        <div class="profile">
                                            <img class="circle" alt="Profile" src="data:image/png;base64,${item.user_pic}">
                                            ${item.name}
                                        </div>
                                    </td>
                                    <td class="account-email">${item.email}</td>
                                    <td>
                                    <div class="account-actions">
                                        <button class="btn btn-privilege ${item.userid}" onclick="usersForm('user','${item.userid}', '${item.name}','${item.email}',[${item.privilage.map(priv => `'${priv}'`).join(", ")}])">Edit</button>
                                        `+button+`
                                        <button class='btn btn-delete' onclick = 'Delete(\""${item.id}"\", \""${item.name}"\")'>Delete</button>
                                    </div>
                                    </td>
                                </tr>
                                `
                            count++;
                        break;
                    }
                });
            } else {
                resultsDiv.innerHTML = 'No results found.';  // Display when no results
            }
                        if(showmore){
                            let showmorebutt = document.getElementById(showmore);
                            if(count>5){
                            showmorebutt.classList.remove("hide")
                            }else{
                            showmorebutt.classList.add("hide")
                            }
                        }
        })
        .catch(error => console.error('Error:', error));
}



// Add the event listener to add the onclick function
function addSearch(buttonId, table, inputId, phpscript, showmore) {
    var button = document.getElementById(buttonId);
    // Use an anonymous function to delay calling searchFunction
    button.onclick = function() {
        Search(table, inputId, phpscript, showmore);
    };
}

// Remove the event listener to remove the onclick function
function removeSearch(buttonId) {
    var button = document.getElementById(buttonId);
    // Remove the onclick event by setting it to null
    setTimeout(() => button.onclick = null, 500);
}