
<link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/reports.css">
    <link rel="stylesheet" href="css/buttons.css">
    <link rel="stylesheet" href="css/table.css">

<div class="panel">
            <div class="header">
                <h3>Feed Mill Production</h3> 
                <form id="searchForm">
                <label>
                <input type="text" id="searchProduct" placeholder="Product Search">
                </label>
                <button class="add-item-btn">Search</button>
                <button class="add-item-btn" onclick="prod2()">Add Item</button>

                </form>
            </div>

            <table class="table">
                <thead>
                    <tr>
                    <th>Date</th>
                    <th>Raw Materials Used</th>
                    <th>Finished Product</th>
                    <th>Quantity Produced(UoM)</th>
                    </tr>
                </thead>
            <tbody>

                <tr>
                    <td>November 20, 2024</td>
                    <td>Yellow Corn, Soya, Copra, Rice Bran (D1), Coconut Oil</td>
                    <td>Laying Mash</td>
                    <td>50kgs</td>
                </tr>

                <tr>
                    <td>November 21, 2024</td>
                    <td>Yellow Corn, Soya, Copra, Rice Bran (D1), Coconut Oil</td>
                    <td>Hog starter</td>
                    <td>50kgs</td>
                </tr>
                
                <tr>
                    <td>November 22, 2024</td>
                    <td>Yellow Corn, Soya, Copra, Rice Bran (D1), Coconut Oil</td>
                    <td>Hog grower</td>
                    <td>50kgs</td>
                </tr>
                
                <tr>
                    <td>November 23, 2024</td>
                    <td>Yellow Corn, Soya, Copra, Rice Bran (D1), Coconut Oil</td>
                    <td>Hog breeder</td>
                    <td>50kgs</td>
                </tr>
                
            </tbody>

    </div>
    </div>
    <script>
        document.getElementById("searchForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent form submission

    const searchQuery = document.getElementById("searchProduct").value.toLowerCase();
    const tableRows = document.querySelectorAll(".table tbody tr");

    tableRows.forEach((row) => {
        const product = row.children[2].textContent.toLowerCase(); // Finished Product column
        if (product.includes(searchQuery)) {
            row.style.display = ""; // Show row if it matches
        } else {
            row.style.display = "none"; // Hide row if it doesn't match
        }
        });
    });

    
    function prod2() {
        window.location.href = "prod2.php"; // Replace "/path/to/users2" with the actual file path
    }

    </script>