<?php
session_start();
include "conn.php";

// Only handle actual login submissions.
if (!isset($_POST['name'], $_POST['password'])) {
    header("Location: index.php");
    exit();
}

$uname = trim($_POST['name']);
$pass  = $_POST['password'];

if ($uname === '') {
    header("Location: index.php?error=" . urlencode("User Name is required"));
    exit();
}
if ($pass === '') {
    header("Location: index.php?error=" . urlencode("Password is required"));
    exit();
}

// Look the user up by name OR email using a prepared statement (no SQL injection).
$sql  = "SELECT userid, name, email, password, privilage, active
         FROM user
         WHERE name = ? OR email = ?
         LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $uname, $uname);
$stmt->execute();
$result = $stmt->get_result();
$row    = $result->fetch_assoc();
$stmt->close();

if (!$row) {
    header("Location: index.php?error=" . urlencode("Incorrect User name or password"));
    exit();
}

// Verify the password. Support both bcrypt hashes and legacy plaintext rows,
// upgrading legacy passwords to a bcrypt hash on first successful login.
$stored     = $row['password'];
$isHashed   = (bool) preg_match('/^\$2[aby]\$/', $stored);
$passwordOk = $isHashed ? password_verify($pass, $stored) : hash_equals($stored, $pass);

if (!$passwordOk) {
    header("Location: index.php?error=" . urlencode("Incorrect User name or password"));
    exit();
}

if ($row['active'] === "false") {
    header("Location: index.php?error=" . urlencode("Account is suspended!"));
    exit();
}

// Opportunistically migrate legacy plaintext passwords to bcrypt.
if (!$isHashed) {
    $newHash = password_hash($pass, PASSWORD_BCRYPT);
    $upd = $conn->prepare("UPDATE user SET password = ? WHERE userid = ?");
    $upd->bind_param("si", $newHash, $row['userid']);
    $upd->execute();
    $upd->close();
}

// Prevent session fixation.
session_regenerate_id(true);

$_SESSION['name']      = $row['name'];
$_SESSION['privilage'] = $row['privilage'];
$_SESSION['id']        = $row['userid'];

// Record the login. (Password is never stored in the session.)
$log = $conn->prepare("INSERT INTO `log` (`userid`, `type`, `description`) VALUES (?, 'in', 'Logged in')");
$log->bind_param("i", $row['userid']);
$log->execute();
$log->close();

header("Location: frontend/main.php");
exit();
?>
