<?php
include "../backend/resession.php";
include "../conn.php";
include "../backend/verify_password.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productionId = $_POST['id'];
    $password = $_POST['password'];

    // Verify the password against the logged-in user's stored credentials
    if (verify_current_user_password($conn, $password)) {
        // Update status to 'complete'
        $stmt = $conn->prepare("UPDATE production SET status = 'complete' WHERE production_id = ?");
        $stmt->bind_param("i", $productionId);

        if ($stmt->execute()) {
            echo "Status updated to 'complete' successfully.";
        } else {
            echo "Error updating status.";
        }

        $stmt->close();
    } else {
        echo "Incorrect password. Status update failed.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
