<?php
include "../../conn.php";
session_start();

$id     = $_POST["id"];
$name   = $_POST["name"];
$action = $_POST["action"];

$active = ($action == "suspend") ? "false" : "true";

$stmt = $conn->prepare("UPDATE user SET active = ? WHERE userid = ?");
$stmt->bind_param("si", $active, $id);

if ($stmt->execute()) {
    $desc = $action . " User: " . $name;
    $log  = $conn->prepare("INSERT INTO `log` (`userid`, `type`, `description`) VALUES (?, 'users', ?)");
    $log->bind_param("is", $_SESSION['id'], $desc);
    $log->execute();
    $log->close();
    echo ucfirst($action) . " Name: " . $name . " Success!";
} else {
    echo "Error: Reload Page";
}

$stmt->close();
?>
