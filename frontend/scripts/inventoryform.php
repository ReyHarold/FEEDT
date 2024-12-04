<?php
include "../../conn.php";
session_start();
$id = $_POST["inventoryid"];
$name = $_POST["item"];
$quantity = $_POST["quantity"];
$price = $_POST["price"];
$minlvl = $_POST["minLvl"];
$maxlvl = $_POST["maxLvl"];
$sql2 = "UPDATE `inventory` SET `item`='".$name."',`quantity`='".$quantity."',`price`='".$price."',`minimumlvl`='".$minlvl."',`maximumlvl`='".$maxlvl."' WHERE `itemID`='".$id."'";
$result2 = mysqli_query($conn, $sql2);


$sql = "INSERT INTO `log`( `userid`, `type`,`description`) VALUES ('".$_SESSION['id']."','inventory','Edited Item: ".$name."')";
$result = mysqli_query($conn, $sql);
?>