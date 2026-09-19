<?php
require_once __DIR__ . '/includes/layout.php';
$user = require_module('dashboard');
$pdo  = db();

// Stat tiles
$totalItems  = (int)$pdo->query("SELECT COUNT(*) FROM inventory")->fetchColumn();
$lowStock    = (int)$pdo->query("SELECT COUNT(*) FROM inventory WHERE quantity <= min_level")->fetchColumn();
$pendingOrd  = (int)$pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn();
$activeProd  = (int)$pdo->query("SELECT COUNT(*) FROM production WHERE status IN ('pending','late')")->fetchColumn();
$salesTotal  = (float)$pdo->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status = 'delivered'")->fetchColumn();

// Chart: stock by item (top 8 by quantity)
$stock = $pdo->query("SELECT name, quantity FROM inventory ORDER BY quantity DESC LIMIT 8")->fetchAll();
$stockLabels = array_column($stock, 'name');
$stockValues = array_map('floatval', array_column($stock, 'quantity'));

// Chart: orders by status
$ordersByStatus = $pdo->query("SELECT status, COUNT(*) c FROM orders GROUP BY status")->fetchAll();
$osLabels = array_column($ordersByStatus, 'status');
$osValues = array_map('intval', array_column($ordersByStatus, 'c'));

// Low-stock table
$lowRows = $pdo->query("SELECT name, quantity, min_level, unit FROM inventory WHERE quantity <= min_level ORDER BY (quantity - min_level) ASC LIMIT 6")->fetchAll();

// Recent activity
$recent = $pdo->query("SELECT a.description, a.type, a.created_at, u.name
                       FROM activity_log a LEFT JOIN users u ON u.id = a.user_id
                       ORDER BY a.created_at DESC LIMIT 6")->fetchAll();

layout_header('Dashboard', 'dashboard');
?>
<div class="grid stats">
    <div class="card stat accent">
        <div class="stat-label">Inventory items</div>
        <div class="stat-value"><?= $totalItems ?></div>
        <div class="stat-sub">tracked in stock</div>
    </div>
    <div class="card stat <?= $lowStock ? 'warn' : '' ?>">
        <div class="stat-label">Low stock</div>
        <div class="stat-value"><?= $lowStock ?></div>
        <div class="stat-sub">at or below minimum</div>
    </div>
    <div class="card stat">
        <div class="stat-label">Pending orders</div>
        <div class="stat-value"><?= $pendingOrd ?></div>
        <div class="stat-sub">awaiting delivery</div>
    </div>
    <div class="card stat">
        <div class="stat-label">Active production</div>
        <div class="stat-value"><?= $activeProd ?></div>
        <div class="stat-sub">batches in progress</div>
    </div>
    <div class="card stat accent">
        <div class="stat-label">Delivered sales</div>
        <div class="stat-value" style="font-size:22px"><?= peso($salesTotal) ?></div>
        <div class="stat-sub">total revenue</div>
    </div>
</div>

<div class="grid charts">
    <div class="card">
        <div class="card-head"><h2>Stock levels</h2></div>
        <canvas id="stockChart" height="150"></canvas>
    </div>
    <div class="card">
        <div class="card-head"><h2>Orders by status</h2></div>
        <canvas id="ordersChart" height="150"></canvas>
    </div>
</div>

<div class="grid charts" style="margin-top:18px">
    <div class="card">
        <div class="card-head"><h2>Low-stock alerts</h2><a class="btn btn-sm" href="<?= e(url('inventory.php')) ?>">View all</a></div>
        <?php if ($lowRows): ?>
        <table>
            <thead><tr><th>Item</th><th class="right">On hand</th><th class="right">Minimum</th></tr></thead>
            <tbody>
                <?php foreach ($lowRows as $r): ?>
                <tr>
                    <td><?= e($r['name']) ?></td>
                    <td class="right"><span class="badge badge-red"><?= num($r['quantity']) ?> <?= e($r['unit']) ?></span></td>
                    <td class="right muted"><?= num($r['min_level']) ?> <?= e($r['unit']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <div class="empty">All items are above their minimum levels. 🎉</div>
        <?php endif; ?>
    </div>
    <div class="card">
        <div class="card-head"><h2>Recent activity</h2><a class="btn btn-sm" href="<?= e(url('activity.php')) ?>">View all</a></div>
        <?php if ($recent): ?>
        <table>
            <thead><tr><th>Activity</th><th>By</th><th class="right">When</th></tr></thead>
            <tbody>
                <?php foreach ($recent as $r): ?>
                <tr>
                    <td><?= e($r['description']) ?></td>
                    <td class="muted"><?= e($r['name'] ?? '—') ?></td>
                    <td class="right muted"><?= e(date('M j, H:i', strtotime($r['created_at']))) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <div class="empty">No activity yet.</div>
        <?php endif; ?>
    </div>
</div>

<script>
const BRAND = '#628338';
new Chart(document.getElementById('stockChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($stockLabels) ?>,
        datasets: [{ label: 'Quantity', data: <?= json_encode($stockValues) ?>, backgroundColor: BRAND, borderRadius: 6 }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});
new Chart(document.getElementById('ordersChart'), {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($osLabels) ?>,
        datasets: [{ data: <?= json_encode($osValues) ?>, backgroundColor: ['#d97706', BRAND, '#9ca3af', '#b91c1c'] }]
    },
    options: { plugins: { legend: { position: 'bottom' } } }
});
</script>
<?php layout_footer(); ?>
