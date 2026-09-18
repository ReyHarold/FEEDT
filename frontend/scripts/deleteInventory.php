<?php
include "../../conn.php";
session_start();
include "../../backend/verify_password.php";

$id       = $_POST["id"];
$name     = $_POST["name"];
$password = $_POST["password"];

if (verify_current_user_password($conn, $password)) {
    $stmt = $conn->prepare("DELETE FROM inventory WHERE `itemID` = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $desc = "Deleted Item: " . $name;
        $log  = $conn->prepare("INSERT INTO `log` (`userid`, `type`, `description`) VALUES (?, 'users', ?)");
        $log->bind_param("is", $_SESSION['id'], $desc);
        $log->execute();
        $log->close();
        echo "Delete Name: " . $name . " Success!";
    } else {
        echo "Error: Reload Page";
    }
    $stmt->close();
} else {
    echo "Wrong";
}
?>
