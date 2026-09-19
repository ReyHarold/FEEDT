<?php
require_once __DIR__ . '/includes/layout.php';
$user = require_module('activity');
$pdo  = db();

$logs = $pdo->query("SELECT a.type, a.description, a.created_at, u.name
                     FROM activity_log a LEFT JOIN users u ON u.id = a.user_id
                     ORDER BY a.created_at DESC LIMIT 300")->fetchAll();

$typeBadge = ['auth'=>'badge-gray','inventory'=>'badge-green','order'=>'badge-amber','production'=>'badge-green','users'=>'badge-red','supplier'=>'badge-gray'];

layout_header('Activity log', 'activity');
?>
<div class="toolbar">
    <div class="search">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="text" placeholder="Search activity…" data-filter="logTable">
    </div>
</div>
<div class="table-wrap">
    <table id="logTable">
        <thead><tr><th>Type</th><th>Description</th><th>User</th><th class="right">When</th></tr></thead>
        <tbody>
        <?php if (!$logs): ?><tr class="empty-row"><td colspan="4"><div class="empty">No activity recorded.</div></td></tr><?php endif; ?>
        <?php foreach ($logs as $l): ?>
            <tr>
                <td><span class="badge <?= $typeBadge[$l['type']] ?? 'badge-gray' ?>"><?= e(ucfirst($l['type'])) ?></span></td>
                <td><?= e($l['description']) ?></td>
                <td class="muted"><?= e($l['name'] ?? '—') ?></td>
                <td class="right muted"><?= e(date('M j, Y H:i', strtotime($l['created_at']))) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php layout_footer(); ?>
