<?php
require_once __DIR__ . '/includes/auth.php';

if (current_user()) {
    log_activity('auth', 'Logged out');
}
session_unset();
session_destroy();
redirect('index.php');
