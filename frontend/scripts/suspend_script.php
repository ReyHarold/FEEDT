<?php
include "../../conn.php";
$id = $_POST["id"];
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
    echo "".ucfirst($action)." ID: ".$id." Success!";
}else{
    echo "Error: Reload Page";
}
?>