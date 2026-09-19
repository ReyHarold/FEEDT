<?php
require_once __DIR__ . '/db.php';

/** HTML-escape a value for safe output. */
function e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

/** Build a URL within the app. */
function url(string $path = ''): string
{
    return BASE_URL . '/' . ltrim($path, '/');
}

/** Redirect and stop. */
function redirect(string $path): void
{
    header('Location: ' . url($path));
    exit();
}

/** Store a one-shot flash message. */
function flash(string $message, string $type = 'success'): void
{
    $_SESSION['flash'][] = ['message' => $message, 'type' => $type];
}

/** Pull and clear flash messages. */
function take_flashes(): array
{
    $f = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $f;
}

/** CSRF token for forms. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

/** Hidden CSRF input for forms. */
function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

/** Verify a submitted CSRF token; aborts on failure. */
function csrf_check(): void
{
    $ok = isset($_POST['_csrf']) && hash_equals($_SESSION['csrf'] ?? '', $_POST['_csrf']);
    if (!$ok) {
        http_response_code(419);
        exit('Invalid or expired form token. Go back and try again.');
    }
}

/** Record an entry in the activity log. */
function log_activity(string $type, string $description): void
{
    $stmt = db()->prepare(
        'INSERT INTO activity_log (user_id, type, description) VALUES (?, ?, ?)'
    );
    $stmt->execute([$_SESSION['uid'] ?? null, $type, $description]);
}

/** Format a number for display (drops trailing .00). */
function num($n): string
{
    $n = (float)$n;
    return rtrim(rtrim(number_format($n, 2), '0'), '.');
}

/** Format currency (Philippine peso). */
function peso($n): string
{
    return '₱' . number_format((float)$n, 2);
}
