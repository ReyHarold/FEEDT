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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/reports.css">
    <link rel="stylesheet" href="css/buttons.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/formstyle.css">
    <link rel="stylesheet" href="css/dropbox.css">
    <script src="../backend/showandhide_script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/1fc4ea1c6a.js"></script>
    <title>FeedTrack</title>
    <?php
    /**
     * Feather-style inline SVG icons for the side navigation, keyed by
     * privilege/section name so they match the crisp line icons used on the
     * sign-in page. Falls back to a neutral dot for unknown sections.
     */
    function navIcon($name) {
        $open = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">';
        $close = '</svg>';
        $icons = [
            'home'       => '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
            'inventory'  => '<path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/>',
            'production' => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',
            'orders'     => '<circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>',
            'reports'    => '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>',
            'suppliers'  => '<rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>',
            'users'      => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        ];
        $path = isset($icons[$name]) ? $icons[$name] : '<circle cx="12" cy="12" r="9"/>';
        return $open . $path . $close;
    }
    ?>
    <body>
        <!-- Loading Screen -->
    <div id="loading-screen" class="loading-screen">
    <div class="spinner"></div> <!-- You can customize this spinner or use a library like FontAwesome -->
    <p>Loading...</p>
    </div>
    <style>
        /* Add to your existing CSS file */
.loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: none; /* Hide by default */
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.spinner {
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-top: 4px solid #ffffff;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loading-screen p {
    color: white;
    font-size: 16px;
    margin-top: 10px;
    text-align: center;
}
    </style>
        <div class= "nav-header">
            <div class="brand">
                <img src="icons/goodwill logo.jfif" alt="Goodwill Farms logo">
                <h1>FeedTrack</h1>
            </div>
            <a href="../logout.php" class="logout-btn" title="Log out">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span>Log out</span>
            </a>
        </div>
        <aside>
    <ul>
    <li><a href="#" id="home-link" class="active" onclick="loadContent('home', this)"><div class="img-container"><?php echo navIcon('home'); ?></div>Home</a></li>
        <?php
        for($i=0;$i<count($privilage);$i++ ){
            echo '<li><a href="#" id="',$privilage[$i],'-link" onclick="loadContent(\'',$privilage[$i],'\', this)"><div class="img-container">',navIcon($privilage[$i]),'</div>',ucfirst($privilage[$i]),'</a></li>';
        }
        ?>
    </ul>
</aside>
<div class="popup-container Popmain box" id="popupForm">
        <div class="popup-content">
            <span class="close-btn" onclick= "hideForm('main')">&times;</span>
            <h2 id="message"></h2>
        </div>
    </div>
            <div id="main-content" class="main-content">
                <?php include "home.php";?>
            </div>
    </body>
    <script>
   function loadContent(page, element) {
    const contentArea = document.getElementById("main-content");
    const loadingScreen = document.getElementById("loading-screen"); // Get the loading screen element
    const xhr = new XMLHttpRequest();

    // Show loading screen
    loadingScreen.style.display = 'flex';

    // Check if element is defined
    if (element) {
        // Remove 'active' class from all links
        const links = document.querySelectorAll("a.active");
        links.forEach(link => link.classList.remove("active"));

        // Add 'active' class to the clicked link
        element.classList.add("active");
    }

    xhr.open("GET", page + ".php", true); // Request the PHP page
    xhr.onload = function () {
        if (xhr.status === 200) {
            contentArea.innerHTML = xhr.responseText; // Insert response into content area
        } else {
            contentArea.innerHTML = "<p>Content could not be loaded.</p>";
        }
        
        // Hide loading screen when content is loaded
        loadingScreen.style.display = 'none';
        if(page=='reports'){
            loadInventoryChart();  // Load the Inventory Chart
            loadProductionChart(); // Load the Production Chart
            loadSalesChart();      // Load the Sales Chart
        }
    };
    xhr.onerror = function () {
        contentArea.innerHTML = "<p>Error loading content.</p>";

        // Hide loading screen on error
        loadingScreen.style.display = 'none';
    };
    xhr.send();
};

        </script>
        <script src="search.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="formScript.js"></script>
    </html>