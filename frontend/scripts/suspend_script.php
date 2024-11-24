<?php
include "../../conn.php";
session_start();
$id = $_POST["id"];
$name = $_POST["name"];
$action = $_POST["action"];
$default = "true";
if($action == "suspend"){
    $default = "false";
}else{
    $default = "true";
}
$sql2 = "UPDATE user SET active='".$default."' WHERE userid='".$id."'";
$count = 0;
$result2 = mysqli_query($conn, $sql2);
if($result2){
    $sql = "INSERT INTO `log`( `userid`, `type`,`description`) VALUES ('".$_SESSION['id']."','users','".$action." User: ".$name."')";
    $result = mysqli_query($conn, $sql);
    echo "".ucfirst($action)." Name: ".$name." Success!";
}else{
    echo "alert(Error: Reload Page)";
}
?>