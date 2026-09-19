<?php
require_once __DIR__ . '/helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Permission map. 'admin' can do everything; 'staff' is limited.
 * Modules: dashboard, inventory, production, orders, suppliers, reports, activity, users
 */
function role_can(string $role, string $module): bool
{
    if ($role === 'admin') {
        return true;
    }
    // Staff: everything except user management.
    $staffModules = ['dashboard', 'inventory', 'production', 'orders', 'suppliers', 'reports', 'activity'];
    return in_array($module, $staffModules, true);
}

/** The currently logged-in user, or null. */
function current_user(): ?array
{
    if (empty($_SESSION['uid'])) {
        return null;
    }
    static $user = null;
    if ($user === null) {
        $stmt = db()->prepare('SELECT id, name, email, role, active FROM users WHERE id = ?');
        $stmt->execute([$_SESSION['uid']]);
        $user = $stmt->fetch() ?: null;
    }
    return $user;
}

/** Require a logged-in, active user or bounce to login. */
function require_login(): array
{
    $user = current_user();
    if (!$user || (int)$user['active'] !== 1) {
        session_unset();
        redirect('index.php?error=' . urlencode('Please sign in to continue.'));
    }
    return $user;
}

/** Require access to a module or show 403. */
function require_module(string $module): array
{
    $user = require_login();
    if (!role_can($user['role'], $module)) {
        http_response_code(403);
        exit('<h2 style="font-family:sans-serif;color:#b91c1c">403 — Access denied.</h2>');
    }
    return $user;
}

/** Verify a password against the logged-in user's stored hash. */
function verify_current_password(string $password): bool
{
    $user = current_user();
    if (!$user) {
        return false;
    }
    $stmt = db()->prepare('SELECT password_hash FROM users WHERE id = ?');
    $stmt->execute([$user['id']]);
    $hash = $stmt->fetchColumn();
    return $hash && password_verify($password, $hash);
}
