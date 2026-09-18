<?php
/**
 * Verify a plaintext password against the currently logged-in user's stored
 * password. Supports bcrypt hashes and legacy plaintext rows.
 *
 * Requires an active session (with $_SESSION['id']) and a mysqli $conn.
 *
 * @return bool true when the password matches the logged-in user.
 */
function verify_current_user_password(mysqli $conn, string $password): bool
{
    if (empty($_SESSION['id'])) {
        return false;
    }

    $stmt = $conn->prepare("SELECT password FROM user WHERE userid = ? LIMIT 1");
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$row) {
        return false;
    }

    $stored = $row['password'];
    if (preg_match('/^\$2[aby]\$/', $stored)) {
        return password_verify($password, $stored);
    }
    return hash_equals($stored, $password);
}
?>
