<?php
require_once __DIR__ . '/auth.php';

/**
 * Render the page chrome (sidebar + topbar) and open the main content area.
 * Call layout_footer() to close it.
 *
 * @param string $title  Page title shown in the topbar.
 * @param string $active Active nav module key.
 */
function layout_header(string $title, string $active): void
{
    $user = current_user();
    $role = $user['role'] ?? 'staff';

    $nav = [
        'dashboard'  => ['Dashboard',  'M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z'],
        'inventory'  => ['Inventory',  'M20 7 12 3 4 7m16 0-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
        'production' => ['Production', 'M2 20h20M4 20V10l5-3 5 3M14 20V7l6-4v17'],
        'orders'     => ['Orders',     'M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4H6zM3 6h18M16 10a4 4 0 0 1-8 0'],
        'suppliers'  => ['Suppliers',  'M16 3h5v5M21 3l-7 7M8 21H3v-5M3 21l7-7'],
        'reports'    => ['Reports',    'M3 3v18h18M18 17V9M13 17V5M8 17v-3'],
        'activity'   => ['Activity',   'M22 12h-4l-3 9L9 3l-3 9H2'],
        'users'      => ['Users',      'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75'],
    ];
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?> · <?= e(APP_NAME) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(url('assets/css/app.css')) ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <div class="brand">
            <span class="brand-mark">GW</span>
            <span class="brand-name"><?= e(APP_NAME) ?></span>
        </div>
        <nav class="nav">
            <?php foreach ($nav as $key => [$label, $icon]):
                if (!role_can($role, $key)) continue; ?>
                <a href="<?= e(url($key . '.php')) ?>" class="nav-item <?= $active === $key ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="<?= $icon ?>"/></svg>
                    <span><?= e($label) ?></span>
                </a>
            <?php endforeach; ?>
        </nav>
        <a href="<?= e(url('logout.php')) ?>" class="nav-item logout">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
            <span>Sign out</span>
        </a>
    </aside>

    <div class="main">
        <header class="topbar">
            <h1><?= e($title) ?></h1>
            <div class="user-chip">
                <span class="avatar"><?= e(strtoupper(substr($user['name'] ?? '?', 0, 1))) ?></span>
                <span class="user-meta">
                    <strong><?= e($user['name'] ?? '') ?></strong>
                    <small><?= e(ucfirst($role)) ?></small>
                </span>
            </div>
        </header>

        <main class="content">
            <?php foreach (take_flashes() as $f): ?>
                <div class="alert alert-<?= e($f['type']) ?>"><?= e($f['message']) ?></div>
            <?php endforeach; ?>
<?php
}

function layout_footer(): void
{
    ?>
        </main>
    </div>
</div>
<script src="<?= e(url('assets/js/app.js')) ?>"></script>
</body>
</html>
<?php
}
