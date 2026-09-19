<?php
require_once __DIR__ . '/includes/auth.php';
if (current_user()) {
    redirect('dashboard.php');
}
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(APP_NAME) ?> — Sign In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(url('assets/css/login.css')) ?>">
</head>
<body>
    <div class="card">
        <aside class="brand">
            <div class="brand-logo">
                <span class="brand-mark">GW</span>
                <span><?= e(APP_NAME) ?></span>
            </div>
            <div class="brand-copy">
                <h2>Manage your farm inventory with confidence.</h2>
                <p>Track feed stock, production, and orders — all in one place.</p>
                <ul class="brand-features">
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg> Real-time inventory tracking</li>
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg> Production &amp; order management</li>
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg> Reports &amp; activity logs</li>
                </ul>
            </div>
            <div class="brand-foot">© <?= date('Y') ?> Goodwill Farms. All rights reserved.</div>
        </aside>

        <main class="form-panel">
            <h1>Welcome back</h1>
            <p class="subtitle">Sign in to your <?= e(APP_NAME) ?> account.</p>

            <?php if ($error): ?>
                <div class="alert" role="alert">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span><?= e($error) ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= e(url('login.php')) ?>" method="post">
                <?= csrf_field() ?>
                <div class="field">
                    <label for="login">Username or email</label>
                    <div class="input-wrap">
                        <span class="icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
                        <input type="text" id="login" name="login" placeholder="Enter your username" required autofocus>
                    </div>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <span class="icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <button type="button" class="toggle-pass" id="togglePass" aria-label="Show password">
                            <svg id="eyeIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>
                <button type="submit" class="submit">Sign In</button>
            </form>

            <div class="demo">
                <div class="demo-head">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    Demo credentials
                </div>
                <div class="demo-grid">
                    <button type="button" class="demo-btn" data-user="admin1" data-pass="123">
                        <span class="demo-role"><strong>Administrator</strong><span>Full access — all modules</span></span>
                        <span class="demo-cred"><b>admin1</b> / 123</span>
                    </button>
                    <button type="button" class="demo-btn" data-user="admin2" data-pass="123">
                        <span class="demo-role"><strong>Staff</strong><span>All modules except Users</span></span>
                        <span class="demo-cred"><b>admin2</b> / 123</span>
                    </button>
                </div>
                <p class="demo-hint">Click a role to auto-fill, then press Sign In.</p>
            </div>
        </main>
    </div>

    <script>
        (function () {
            var btn = document.getElementById('togglePass'),
                pass = document.getElementById('password'),
                eye = document.getElementById('eyeIcon'),
                login = document.getElementById('login'),
                shown = '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>',
                hidden = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-10-7-10-7a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 10 7 10 7a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            btn.addEventListener('click', function () {
                var isPw = pass.type === 'password';
                pass.type = isPw ? 'text' : 'password';
                eye.innerHTML = isPw ? hidden : shown;
            });
            document.querySelectorAll('.demo-btn').forEach(function (b) {
                b.addEventListener('click', function () {
                    login.value = b.getAttribute('data-user');
                    pass.value = b.getAttribute('data-pass');
                    login.focus();
                });
            });
        })();
    </script>
</body>
</html>
