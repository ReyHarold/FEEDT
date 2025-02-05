<?php
include "../../conn.php";

// Check action (add or update)
$action = $_POST['action'];

if ($action == 'update') {
    // Update the user
    $userId = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $privilage = implode(",", $_POST['privilage']);  // Convert array to comma-separated string
    
    // Optional: Handle file upload for profile picture
    if (isset($_FILES['user_pic']) && $_FILES['user_pic']['error'] == 0) {
        // Handle the image upload and save it as BLOB in the database
        $user_pic = file_get_contents($_FILES['user_pic']['tmp_name']);
    } else {
        // If no new picture is uploaded, keep the old picture
        $user_pic = null;
    }

    // If a password is provided, hash it
    if ($password) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    }

    // Prepare the SQL for update
    $sql = "UPDATE user SET name = ?, email = ?, password = ?, privilage = ?, user_pic = ? WHERE userid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssbi", $name, $email, $passwordHash, $privilage, $user_pic, $userId);

    if ($stmt->execute()) {
        echo "User updated successfully!";
    } else {
        echo "Error updating user: " . $stmt->error;
    }

    $stmt->close();
} elseif ($action == 'add') {
    // Add new user logic (similar to what we discussed earlier)
}

?>
