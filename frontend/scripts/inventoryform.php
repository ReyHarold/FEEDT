<?php
include "../../conn.php";
session_start();

$id = $_POST["inventoryid"];
$name = $_POST["item"];
$quantity = $_POST["quantity"];
$price = $_POST["price"];
$minlvl = $_POST["minLvl"];
$maxlvl = $_POST["maxLvl"];
$finish = isset($_POST["finish"]) ? 'finish' : 'ingredient';
$feed = $_POST["feed"];

$sql2 = "UPDATE `inventory` SET `feed` = ?, `type` = ?, `item` = ?, `quantity` = ?, `price` = ?, `minimumlvl` = ?, `maximumlvl` = ? WHERE `itemID` = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("sssssssi", $feed, $finish, $name, $quantity, $price, $minlvl, $maxlvl, $id);

if ($stmt2->execute()) {
  echo "Inventory updated successfully.";
} else {
  echo "Error updating inventory: " . $stmt2->error;
}

// Update ingredients if it's a finished product
if ($finish === 'finish') {
  $ingredientNames = $_POST["ingredientAndYieldName"];
  $ingredientQuantities = $_POST["ingredientAndYield"];

  $ingredientfinal = "";
  for ($i = 0; $i < count($ingredientNames); $i++) {
    $ingredientfinal .= $ingredientNames[$i] . "," . $ingredientQuantities[$i];
    if ($i < count($ingredientNames) - 1) {
      $ingredientfinal .= ", ";
    }
  }

  $sql3 = "UPDATE `ingredients` SET `ingredients` = ? WHERE `finish_product` = ?";
  $stmt3 = $conn->prepare($sql3);
  $stmt3->bind_param("ss", $ingredientfinal, $name);
  $stmt3->execute();
}

// Log the update
$sqlLog = "INSERT INTO `log` (`userid`, `type`, `description`) VALUES (?, 'inventory', ?)";
$description = "Edited Item: " . ucfirst($name);
$stmtLog = $conn->prepare($sqlLog);
$stmtLog->bind_param("is", $_SESSION['id'], $description);
$stmtLog->execute();

$stmt2->close();
if (isset($stmt3)) $stmt3->close();
$stmtLog->close();
$conn->close();
?>