<?php
include "../../conn.php";
session_start();

$name = $_POST["addItem"];
$quantity = $_POST["addQuantity"];
$price = $_POST["addPrice"];
$minlvl = $_POST["minLvlAdd"];
$maxlvl = $_POST["maxLvlAdd"];
$ingredientName = $_POST["ingredientAndYieldName"];
$ingredient = $_POST["ingredientAndYield"];
$yield = $_POST["yield"];

$type = ($_POST["feed"] == "other") ? $_POST["newFeed"] : $_POST["feed"];

$ingredientfinal = "";

if (isset($_POST["finish"])) {
    // Insert into `inventory`
    $sql2 = "INSERT INTO `inventory` (`type`, `feed`, `item`, `quantity`, `price`, `maximumlvl`, `minimumlvl`) 
             VALUES ('finish', ?, ?, ?, ?, ?, ?)";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("ssssss", $type, $name, $quantity, $price, $maxlvl, $minlvl);

    // Create the ingredient string
    for ($i = 0; $i < count($ingredientName); $i++) {
        if ($i == count($ingredientName) - 1) {
            $ingredientfinal .= $ingredientName[$i] . "," . $ingredient[$i];
        } else {
            $ingredientfinal .= $ingredientName[$i] . "," . $ingredient[$i] . ", ";
        }
    }

    // Insert into `ingredients`
    $sql3 = "INSERT INTO `ingredients` (`finish_product`, `ingredients`, `yield`) 
             VALUES (?, ?, ?)";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param("sss", $name, $ingredientfinal, $yield);
} else {
    // Insert into `inventory` for ingredients
    $sql2 = "INSERT INTO `inventory` (`type`, `feed`, `item`, `quantity`, `price`, `maximumlvl`, `minimumlvl`) 
             VALUES ('ingredient', ?, ?, ?, ?, ?, ?)";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("ssssss", $type, $name, $quantity, $price, $maxlvl, $minlvl);
}

// Execute the `inventory` insert
if ($stmt2->execute()) {
    echo "Inventory record inserted successfully.";
} else {
    echo "Error inserting inventory record: " . $stmt2->error;
}

// Execute the `ingredients` insert if applicable
if (isset($_POST["finish"]) && !$stmt3->execute()) {
    echo "Error inserting ingredients record: " . $stmt3->error;
}

// Insert into `log`
$sql = "INSERT INTO `log` (`userid`, `type`, `description`) 
        VALUES (?, 'inventory', ?)";
$stmt = $conn->prepare($sql);
$description = "Created New Item: " . ucfirst($name);
$stmt->bind_param("is", $_SESSION['id'], $description);

if ($stmt->execute()) {
    echo "Log record inserted successfully.";
} else {
    echo "Error inserting log record: " . $stmt->error;
}

// Close statements
$stmt2->close();
if (isset($_POST["finish"])) {
    $stmt3->close();
}
$stmt->close();

// Close connection
$conn->close();
?>
