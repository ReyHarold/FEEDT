<?php
include "../../conn.php";
session_start();

$feed = $_GET['feed'] ?? '';

// Fetch data from the `ingredients` table
$sql = "SELECT * FROM ingredients WHERE finish_product = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $feed);
$stmt->execute();
$result = $stmt->get_result();

// Display results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        // Split the ingredients string by period (.)
        $ingredients = explode(',', $row['ingredients']);
        
        for ($i = 0; $i < count($ingredients) - 1; $i += 2) {
            $current = trim($ingredients[$i]);
            $next = trim($ingredients[$i + 1]);

            if (!empty($current)) {
                echo '<div class="form-row finish" id="ingredientrow">
                <div class="input-data" id="' . htmlspecialchars($current);
                if (!empty($next)) {
                    echo '"><input type="number" id="ingredientQuantity" name="ingredientAndYield[]" value='. htmlspecialchars($next).' required="">
                    <input type="hidden" name="ingredientAndYieldName[]" value="'. htmlspecialchars($current).'">
                    <div class="underline"></div>
                    <label for="ingredientQuantity">'. htmlspecialchars($current).' Quantity(KG:)';
                }
                echo "</label>";
                echo '</div></div>';
            }
        }
        echo '<div class="form-row">
                <div class="input-data">
                    <input type="text" id="yield" name="yield" value="'.$row['yield'].'" required>
                    <div class="underline"></div>
                    <label for="name">Yield:</label>
                </div>
                </div>';
    }
} else {
    echo "No ingredients found for '$feed'";
}

// Close connection
$stmt->close();
$conn->close();
?>
