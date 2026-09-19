<?php
require_once __DIR__ . '/includes/layout.php';
$user = require_module('production');
$pdo  = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';
    try {
        if ($action === 'create') {
            $product = trim($_POST['product_name'] ?? '');
            $yield   = (float)($_POST['quantity'] ?? 0);
            $start   = $_POST['start_date'] ?: date('Y-m-d');
            $end     = $_POST['end_date'] ?: date('Y-m-d');

            if ($product === '' || $yield <= 0) {
                throw new RuntimeException('Product and a positive yield are required.');
            }

            $pdo->beginTransaction();
            // Load recipe.
            $rc = $pdo->prepare("SELECT id, yield_qty FROM recipes WHERE product_name = ?");
            $rc->execute([$product]);
            $recipe = $rc->fetch();
            if (!$recipe || (float)$recipe['yield_qty'] <= 0) {
                throw new RuntimeException('No recipe defined for this product.');
            }
            $factor = $yield / (float)$recipe['yield_qty'];

            $ri = $pdo->prepare("SELECT ingredient, quantity FROM recipe_items WHERE recipe_id = ?");
            $ri->execute([$recipe['id']]);
            $items = $ri->fetchAll();

            $parts = [];
            foreach ($items as $ing) {
                $need = (float)$ing['quantity'] * $factor;
                $stockStmt = $pdo->prepare("SELECT id, quantity FROM inventory WHERE name = ? AND category = 'ingredient' FOR UPDATE");
                $stockStmt->execute([$ing['ingredient']]);
                $stock = $stockStmt->fetch();
                if (!$stock) {
                    throw new RuntimeException("Ingredient not in inventory: {$ing['ingredient']}.");
                }
                if ((float)$stock['quantity'] < $need) {
                    throw new RuntimeException("Insufficient {$ing['ingredient']} (need " . num($need) . ", have " . num($stock['quantity']) . ").");
                }
                $pdo->prepare("UPDATE inventory SET quantity = quantity - ? WHERE id = ?")->execute([$need, $stock['id']]);
                $parts[] = $ing['ingredient'] . ' ' . num($need);
            }

            $feedType = $pdo->query("SELECT feed_type FROM inventory WHERE name = " . $pdo->quote($product) . " LIMIT 1")->fetchColumn() ?: 'All';
            $status = (strtotime($end) < strtotime(date('Y-m-d'))) ? 'late' : 'pending';

            $pdo->prepare("INSERT INTO production (product_name, feed_type, quantity, ingredients, start_date, end_date, status, created_by) VALUES (?,?,?,?,?,?,?,?)")
                ->execute([$product, $feedType, $yield, implode(', ', $parts), $start, $end, $status, $user['id']]);

            // Add produced goods to finished inventory (create the row if missing).
            $exists = $pdo->prepare("SELECT id FROM inventory WHERE name = ? AND category = 'finished'");
            $exists->execute([$product]);
            if ($fid = $exists->fetchColumn()) {
                $pdo->prepare("UPDATE inventory SET quantity = quantity + ? WHERE id = ?")->execute([$yield, $fid]);
            } else {
                $pdo->prepare("INSERT INTO inventory (name, category, feed_type, quantity, unit, price) VALUES (?, 'finished', ?, ?, 'kg', 0)")
                    ->execute([$product, $feedType, $yield]);
            }

            $pdo->commit();
            log_activity('production', "Produced {$product} (" . num($yield) . " kg)");
            flash('Production batch recorded and inventory updated.');
        } elseif ($action === 'complete') {
            $id = (int)$_POST['id'];
            $stmt = $pdo->prepare("UPDATE production SET status = 'complete' WHERE id = ? AND status <> 'complete'");
            $stmt->execute([$id]);
            if ($stmt->rowCount()) { log_activity('production', "Completed batch #{$id}"); flash('Batch marked complete.'); }
        } elseif ($action === 'delete') {
            $id = (int)$_POST['id'];
            $pdo->prepare("DELETE FROM production WHERE id = ?")->execute([$id]);
            log_activity('production', "Deleted batch #{$id}");
            flash('Batch record deleted.', 'warn');
        }
    } catch (Throwable $ex) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        flash($ex->getMessage(), 'error');
    }
    redirect('production.php');
}

$batches = $pdo->query("SELECT * FROM production ORDER BY start_date DESC, id DESC")->fetchAll();
$recipes = $pdo->query("SELECT product_name, yield_qty FROM recipes ORDER BY product_name")->fetchAll();
$badge = ['pending' => 'badge-amber', 'late' => 'badge-red', 'complete' => 'badge-green'];

layout_header('Production', 'production');
?>
<div class="toolbar">
    <div class="search">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="text" placeholder="Search batches…" data-filter="prodTable">
    </div>
    <div class="spacer"></div>
    <button class="btn btn-primary" data-modal-open="prodModal">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
        New batch
    </button>
</div>

<div class="table-wrap">
    <table id="prodTable">
        <thead><tr><th>#</th><th>Product</th><th>Feed</th><th class="right">Yield</th><th>Ingredients used</th><th>Schedule</th><th>Status</th><th class="right">Actions</th></tr></thead>
        <tbody>
        <?php if (!$batches): ?><tr class="empty-row"><td colspan="8"><div class="empty">No production batches yet.</div></td></tr><?php endif; ?>
        <?php foreach ($batches as $b): ?>
            <tr>
                <td class="muted">#<?= (int)$b['id'] ?></td>
                <td><strong><?= e($b['product_name']) ?></strong></td>
                <td class="muted"><?= e($b['feed_type']) ?></td>
                <td class="right"><?= num($b['quantity']) ?> kg</td>
                <td class="muted" style="max-width:260px"><?= e($b['ingredients']) ?></td>
                <td class="muted"><?= e(date('M j', strtotime($b['start_date']))) ?> – <?= e(date('M j', strtotime($b['end_date']))) ?></td>
                <td><span class="badge <?= $badge[$b['status']] ?? 'badge-gray' ?>"><?= e(ucfirst($b['status'])) ?></span></td>
                <td class="right">
                    <?php if ($b['status'] !== 'complete'): ?>
                        <form method="post" class="inline-form"><?= csrf_field() ?><input type="hidden" name="action" value="complete"><input type="hidden" name="id" value="<?= (int)$b['id'] ?>"><button class="btn btn-sm btn-primary">Complete</button></form>
                    <?php endif; ?>
                    <form method="post" class="inline-form" data-confirm="Delete this batch record?"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$b['id'] ?>"><button class="btn btn-sm btn-danger">Delete</button></form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal-backdrop" id="prodModal">
    <div class="modal">
        <div class="modal-head"><h3>New production batch</h3><button class="modal-close" data-modal-close>&times;</button></div>
        <form method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="create">
            <div class="modal-body">
                <div class="field">
                    <label>Product (recipe)</label>
                    <select name="product_name" required>
                        <option value="">— Select a product —</option>
                        <?php foreach ($recipes as $r): ?>
                            <option value="<?= e($r['product_name']) ?>"><?= e($r['product_name']) ?> (base yield <?= num($r['yield_qty']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <div class="hint">Ingredients are scaled to your target yield and deducted from stock.</div>
                </div>
                <div class="field"><label>Target yield (kg)</label><input type="number" step="0.01" min="0.01" name="quantity" required></div>
                <div class="row2">
                    <div class="field"><label>Start date</label><input type="date" name="start_date" value="<?= e(date('Y-m-d')) ?>"></div>
                    <div class="field"><label>End date</label><input type="date" name="end_date" value="<?= e(date('Y-m-d')) ?>"></div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn" data-modal-close>Cancel</button>
                <button class="btn btn-primary">Record batch</button>
            </div>
        </form>
    </div>
</div>
<?php layout_footer(); ?>
