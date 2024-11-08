<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
$id = $_SESSION['id'];
$name = $_SESSION['name'];
$privilage = explode(",",$_SESSION['privilage']);
}else{
    header("Location: ../index.php");
    exit();
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/reports.css">
    <link rel="stylesheet" href="css/buttons.css">
    <link rel="stylesheet" href="css/table.css">
    <title>FeedTrack</title>
    <body>
        <header class= "nav-header">
            <h1>FeedTrack</h1>
        </header>
        <aside>
    <ul>
    <li><a href="#" id="home-link" class="active" onclick="loadContent('home', this)"><div class="img-container"><img src="icons/home.png" alt="Home"></div>Home</a></li>
        <?php
        for($i=0;$i<count($privilage);$i++ ){
            echo '<li><a href="#" id="',$privilage[$i],'-link" onclick="loadContent(\'',$privilage[$i],'\', this)"><div class="img-container"><img src="icons/',$privilage[$i],'.png" alt="',$privilage[$i],'"></div>',ucfirst($privilage[$i]),'</a></li>';
        }
        ?>
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