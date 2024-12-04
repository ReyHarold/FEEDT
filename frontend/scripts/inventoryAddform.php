<?php
include "../../conn.php";
session_start();
$name = $_POST["addItem"];
$quantity = $_POST["addQuantity"];
$price = $_POST["addPrice"];
$minlvl = $_POST["minLvlAdd"];
$maxlvl = $_POST["maxLvlAdd"];
$sql2 = "INSERT INTO `inventory`(`item`, `quantity`, `price`, `maximumlvl`, `minimumlvl`) VALUES ('".$name."','".$quantity."','".$price."','".$maxlvl."','".$minlvl."')";
$result2 = mysqli_query($conn, $sql2);


$sql = "INSERT INTO `log`( `userid`, `type`,`description`) VALUES ('".$_SESSION['id']."','inventory','Created New Item: ".$name."')";
$result = mysqli_query($conn, $sql);
?>