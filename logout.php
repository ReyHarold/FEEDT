<?php 
include "conn.php";
session_start();
$sql2 = "INSERT INTO `log`( `userid`, `type`,`description`) VALUES ('".$_SESSION['id']."','out','Logged out')";
$result = mysqli_query($conn, $sql2);
session_unset();
session_destroy();

header("Location: index.php");
?>