<?php
include "../../conn.php";
session_start();
$id = $_POST["id"];
$name = $_POST["name"];
$password = $_POST["password"];
if($password == $_SESSION['password']){
    $sql2 = "DELETE FROM user WHERE userid='".$id."'";
    $result2 = mysqli_query($conn, $sql2);
    if($result2){
        $sql = "INSERT INTO `log`( `userid`, `type`,`description`) VALUES ('".$_SESSION['id']."','users','Deleted User: ".$name."')";
        $result = mysqli_query($conn, $sql);
        echo "Delete Name: ".$name." Success!";
    }else{
        echo "Error: Reload Page";
    }
}else{
    echo "Wrong";
}
?>