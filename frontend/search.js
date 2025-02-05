function Search(table, inputId, phpscript, showmore) {

    let query = document.getElementById(inputId).value;

    // AJAX request
    fetch('scripts/' + phpscript + '.php?query=' + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
            let resultsDiv = document.getElementById(table);
            let count = 0;

            // Clear previous results first
            resultsDiv.innerHTML = '';

            if (data.length > 0) {
                data.forEach(item => {
                    switch(phpscript){
                        case "searchInventory":
                    resultsDiv.innerHTML = `
                        <tr class="activity">
                            <td>${item.item}</td>
                            <td>${item.quantity}</td>
                            <td>₱${item.price}</td> 
                            <td>${item.maximumlvl}</td>
                            <td>${item.minimumlvl}</td>
                            <td class="account-actions">
                                <button class="btn btn-edit" onclick="usersForm(
                                    'inventory',
                                    '${item.itemID}',
                                    '${item.item}',
                                    '${item.price}',
                                    ['${item.quantity}', '${item.minimumlvl}', '${item.maximumlvl}', '${item.type}', '${item.feed.charAt(0).toUpperCase() + item.feed.slice(1)}']
                                )">Edit</button>
                                <button class="btn btn-delete" onclick="Delete('${item.itemID}', '${item.item}')">Delete</button>
                            </td>
                        </tr>`;
                    count++;
                    break;
                    case "searchProduction":
                        resultsDiv.innerHTML = `
                        <tr class="activity">
                            <td>${item.type}</td>
                            <td>${item.item}</td>
                            <td>${item.quantity}</td>
                            <td>${item.ingredients}</td>
                            <td>${item.start_date}</td>
                            <td>${item.end_date}</td>
                            <td>${item.status}</td>
                            <td class="account-actions">
                                <button class="btn btn-edit">Edit</button>
                                <button class="btn btn-delete">Delete</button>
                            </td>
                        </tr>`;
                    break;
                }
                });
            } else {
                resultsDiv.innerHTML = 'No results found.';  // Display message if no results
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