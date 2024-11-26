<?php
include "../../conn.php";
session_start();
$name = $_POST["addItem"];
$quantity = $_POST["addQuantity"];
$price = $_POST["addPrice"];
$sql2 = "INSERT INTO `inventory`(`item`, `quantity`, `price`) VALUES ('".$name."','".$quantity."','".$price."')";
$result2 = mysqli_query($conn, $sql2);


$sql = "INSERT INTO `log`( `userid`, `type`,`description`) VALUES ('".$_SESSION['id']."','inventory','Created New Item: ".$name."')";
$result = mysqli_query($conn, $sql);
?>