<?php
include "../../conn.php";

$item = $_GET['item'];
$response = [];

$sql = "SELECT `ingredients` FROM `ingredients` WHERE `finish_product` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $item);
$stmt->execute();
$stmt->bind_result($ingredients);

if ($stmt->fetch()) {
  $ingredientPairs = explode(", ", $ingredients);
  foreach ($ingredientPairs as $pair) {
    list($ingredient, $quantity) = explode(",", $pair);
    $response[] = ["ingredient" => $ingredient, "quantity" => $quantity];
  }
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
