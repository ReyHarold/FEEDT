<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>FeedTrack</title>
    <body>
        <header>
            <h1>FeedTrack</h1>
        </header>
        <aside>
    <ul>
        <li><a href="#" id="home-link" class="active" onclick="loadContent('home', this)"><img src="icons/home.png" alt="Home">Home</a></li>
        <li><a href="#" id="users-link" onclick="loadContent('users', this)" ><img src="icons/users.png" alt="Users">Users</a></li>
        <li><a href="#" id="inven-link" onclick="loadContent('inven', this)" ><img src="icons/inve.png" alt="Inventory">Inventory</a></li>
        <li><a href="#" id="order-link" onclick="loadContent('order', this)" ><img src="icons/orders.png" alt="Orders">Orders</a></li>
        <li><a href="#" id="supp-link" onclick="loadContent('supp', this)" ><img src="icons/suppliers.png" alt="Suppliers">Suppliers</a></li>
        <li><a href="#" id="report-link" onclick="loadContent('report', this)" ><img src="icons/report.png" alt="Reports">Reports & Analytics</a></li>
    </ul>
</aside>
            <div id="main-content" class="main-content">
                <?php include "home.php";?>
            </div>
    </body>
    <script>
    function loadContent(page, element) {
    const contentArea = document.getElementById("main-content");
    const xhr = new XMLHttpRequest();

     // Check if element is defined
     if (element) {
        // Remove 'active' class from all links
        const links = document.querySelectorAll("a.active");
        links.forEach(link => link.classList.remove("active"));

        // Add 'active' class to the clicked link
        element.classList.add("active");
    }

    xhr.open("GET", page+".php", true); // Request the PHP page
    xhr.onload = function () {
        if (xhr.status === 200) {
            contentArea.innerHTML = xhr.responseText; // Insert response into content area
        } else {
            contentArea.innerHTML = "<p>Content could not be loaded.</p>";
        }
    };
    xhr.onerror = function () {
        contentArea.innerHTML = "<p>Error loading content.</p>";
    };
    xhr.send();
};
        </script>
    </html>