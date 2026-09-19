<?php
require_once __DIR__ . '/includes/layout.php';
$user = require_module('reports');
$pdo  = db();

$invValue = (float)$pdo->query("SELECT COALESCE(SUM(quantity * price),0) FROM inventory")->fetchColumn();
$ordCount = (int)$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$revenue  = (float)$pdo->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status='delivered'")->fetchColumn();
$prodTotal= (float)$pdo->query("SELECT COALESCE(SUM(quantity),0) FROM production")->fetchColumn();

$topSales = $pdo->query("SELECT item, SUM(quantity) qty, SUM(total) revenue
                         FROM orders WHERE status='delivered' GROUP BY item ORDER BY revenue DESC LIMIT 10")->fetchAll();
$byFeed = $pdo->query("SELECT feed_type, SUM(quantity) qty FROM inventory GROUP BY feed_type ORDER BY qty DESC")->fetchAll();
$prodByProduct = $pdo->query("SELECT product_name, SUM(quantity) qty FROM production GROUP BY product_name ORDER BY qty DESC LIMIT 10")->fetchAll();
$lowStock = $pdo->query("SELECT name, quantity, min_level, unit FROM inventory WHERE quantity <= min_level ORDER BY name")->fetchAll();

layout_header('Reports', 'reports');
?>
<div class="grid stats">
    <div class="card stat accent"><div class="stat-label">Inventory value</div><div class="stat-value" style="font-size:22px"><?= peso($invValue) ?></div><div class="stat-sub">stock × price</div></div>
    <div class="card stat"><div class="stat-label">Total orders</div><div class="stat-value"><?= $ordCount ?></div></div>
    <div class="card stat accent"><div class="stat-label">Revenue (delivered)</div><div class="stat-value" style="font-size:22px"><?= peso($revenue) ?></div></div>
    <div class="card stat"><div class="stat-label">Total produced</div><div class="stat-value" style="font-size:22px"><?= num($prodTotal) ?> kg</div></div>
</div>

<div class="grid charts">
    <div class="card">
        <div class="card-head"><h2>Stock by feed type</h2></div>
        <canvas id="feedChart" height="150"></canvas>
    </div>
    <div class="card">
        <div class="card-head"><h2>Production by product</h2></div>
        <canvas id="prodChart" height="150"></canvas>
    </div>
</div>

<h3 class="section-title">Top selling products</h3>
<div class="table-wrap">
    <table>
        <thead><tr><th>Product</th><th class="right">Units sold</th><th class="right">Revenue</th></tr></thead>
        <tbody>
        <?php if (!$topSales): ?><tr><td colspan="3"><div class="empty">No delivered orders yet.</div></td></tr><?php endif; ?>
        <?php foreach ($topSales as $r): ?>
            <tr><td><strong><?= e($r['item']) ?></strong></td><td class="right"><?= num($r['qty']) ?></td><td class="right"><?= peso($r['revenue']) ?></td></tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<h3 class="section-title">Low-stock items</h3>
<div class="table-wrap">
    <table>
        <thead><tr><th>Item</th><th class="right">On hand</th><th class="right">Minimum</th></tr></thead>
        <tbody>
        <?php if (!$lowStock): ?><tr><td colspan="3"><div class="empty">Everything is above minimum levels.</div></td></tr><?php endif; ?>
        <?php foreach ($lowStock as $r): ?>
            <tr><td><?= e($r['name']) ?></td><td class="right"><span class="badge badge-red"><?= num($r['quantity']) ?> <?= e($r['unit']) ?></span></td><td class="right muted"><?= num($r['min_level']) ?> <?= e($r['unit']) ?></td></tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
const BRAND = '#628338';
new Chart(document.getElementById('feedChart'), {
    type: 'bar',
    data: { labels: <?= json_encode(array_column($byFeed, 'feed_type')) ?>,
        datasets: [{ label: 'kg', data: <?= json_encode(array_map('floatval', array_column($byFeed, 'qty'))) ?>, backgroundColor: BRAND, borderRadius: 6 }] },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});
new Chart(document.getElementById('prodChart'), {
    type: 'bar',
    data: { labels: <?= json_encode(array_column($prodByProduct, 'product_name')) ?>,
        datasets: [{ label: 'kg', data: <?= json_encode(array_map('floatval', array_column($prodByProduct, 'qty'))) ?>, backgroundColor: '#a5cba1', borderRadius: 6 }] },
    options: { indexAxis: 'y', plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true } } }
});
</script>
<?php layout_footer(); ?>
