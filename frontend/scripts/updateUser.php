<?php
include "../../conn.php";
session_start();
$id = $_POST["id"];
$name = $_POST["name"];
$email = $_POST["email"];
if(!empty($_POST["privilage"])){
    $privilage = $_POST["privilage"];
    $comma_separated = implode(",", $privilage);
}else{
    $comma_separated = "";
}
$sql2 = "UPDATE `user` SET `name`='".$name."',`privilage`='".$comma_separated."',`email`='".$email."' WHERE `userid`='".$id."'";
$result2 = mysqli_query($conn, $sql2);

$sql = "INSERT INTO `log`( `userid`, `type`,`description`) VALUES ('".$_SESSION['id']."','users','Updated ".$name."')";
$result = mysqli_query($conn, $sql);
?>