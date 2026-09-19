<?php
require_once __DIR__ . '/includes/auth.php';

// Already signed in? Go to dashboard.
if (current_user()) {
    redirect('dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}
csrf_check();

$login = trim($_POST['login'] ?? '');
$pass  = $_POST['password'] ?? '';

if ($login === '' || $pass === '') {
    redirect('index.php?error=' . urlencode('Username and password are required.'));
}

$stmt = db()->prepare(
    'SELECT id, name, password_hash, role, active FROM users WHERE name = ? OR email = ? LIMIT 1'
);
$stmt->execute([$login, $login]);
$user = $stmt->fetch();

if (!$user || !password_verify($pass, $user['password_hash'])) {
    redirect('index.php?error=' . urlencode('Incorrect username or password.'));
}
if ((int)$user['active'] !== 1) {
    redirect('index.php?error=' . urlencode('This account is suspended.'));
}

// Rehash if the algorithm/cost has changed.
if (password_needs_rehash($user['password_hash'], PASSWORD_BCRYPT)) {
    $newHash = password_hash($pass, PASSWORD_BCRYPT);
    $upd = db()->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
    $upd->execute([$newHash, $user['id']]);
}

session_regenerate_id(true);
$_SESSION['uid'] = (int)$user['id'];
log_activity('auth', 'Logged in');

redirect('dashboard.php');
