<?php
require_once __DIR__ . '/includes/layout.php';
$user = require_module('inventory');
$pdo  = db();

// ---- Handle actions ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'save') {
        $id        = (int)($_POST['id'] ?? 0);
        $name      = trim($_POST['name'] ?? '');
        $category  = $_POST['category'] === 'finished' ? 'finished' : 'ingredient';
        $feedType  = trim($_POST['feed_type'] ?? 'All') ?: 'All';
        $quantity  = (float)($_POST['quantity'] ?? 0);
        $unit      = trim($_POST['unit'] ?? 'kg') ?: 'kg';
        $price     = (float)($_POST['price'] ?? 0);
        $minLevel  = (float)($_POST['min_level'] ?? 0);
        $maxLevel  = (float)($_POST['max_level'] ?? 0);
        $supplier  = ($_POST['supplier_id'] ?? '') !== '' ? (int)$_POST['supplier_id'] : null;

        if ($name === '') {
            flash('Item name is required.', 'error');
        } elseif ($id > 0) {
            $stmt = $pdo->prepare("UPDATE inventory SET name=?, category=?, feed_type=?, quantity=?, unit=?, price=?, min_level=?, max_level=?, supplier_id=? WHERE id=?");
            $stmt->execute([$name, $category, $feedType, $quantity, $unit, $price, $minLevel, $maxLevel, $supplier, $id]);
            log_activity('inventory', "Updated item: $name");
            flash("“$name” updated.");
        } else {
            $stmt = $pdo->prepare("INSERT INTO inventory (name, category, feed_type, quantity, unit, price, min_level, max_level, supplier_id) VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$name, $category, $feedType, $quantity, $unit, $price, $minLevel, $maxLevel, $supplier]);
            log_activity('inventory', "Added item: $name");
            flash("“$name” added to inventory.");
        }
    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $name = $pdo->query("SELECT name FROM inventory WHERE id = " . $id)->fetchColumn();
        $stmt = $pdo->prepare("DELETE FROM inventory WHERE id = ?");
        $stmt->execute([$id]);
        log_activity('inventory', "Deleted item: $name");
        flash("“$name” deleted.", 'warn');
    }
    redirect('inventory.php');
}

// ---- Data ----
$items = $pdo->query("SELECT i.*, s.name AS supplier_name
                      FROM inventory i LEFT JOIN suppliers s ON s.id = i.supplier_id
                      ORDER BY i.category, i.name")->fetchAll();
$suppliers = $pdo->query("SELECT id, name FROM suppliers ORDER BY name")->fetchAll();

layout_header('Inventory', 'inventory');
?>
<div class="toolbar">
    <div class="search">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="text" placeholder="Search items…" data-filter="invTable">
    </div>
    <div class="spacer"></div>
    <button class="btn btn-primary" data-modal-open="itemModal" data-fields='{"id":"","name":"","feed_type":"","quantity":"","price":"","min_level":"","max_level":""}' onclick="document.getElementById('modalTitle').textContent='Add item'">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
        Add item
    </button>
</div>

<div class="table-wrap">
    <table id="invTable">
        <thead>
            <tr>
                <th>Item</th><th>Category</th><th>Feed</th>
                <th class="right">Quantity</th><th class="right">Price</th>
                <th>Supplier</th><th class="right">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!$items): ?>
            <tr class="empty-row"><td colspan="7"><div class="empty">No inventory items yet.</div></td></tr>
        <?php endif; ?>
        <?php foreach ($items as $it):
            $low = (float)$it['quantity'] <= (float)$it['min_level'];
            $fields = json_encode([
                'id' => $it['id'], 'name' => $it['name'], 'category' => $it['category'],
                'feed_type' => $it['feed_type'], 'quantity' => $it['quantity'], 'unit' => $it['unit'],
                'price' => $it['price'], 'min_level' => $it['min_level'], 'max_level' => $it['max_level'],
                'supplier_id' => $it['supplier_id'],
            ], JSON_HEX_APOS | JSON_HEX_QUOT);
        ?>
            <tr>
                <td><div class="stack"><strong><?= e($it['name']) ?></strong><?php if ($low): ?><small style="color:var(--danger)">Low stock</small><?php endif; ?></div></td>
                <td><span class="badge <?= $it['category'] === 'finished' ? 'badge-green' : 'badge-gray' ?>"><?= e(ucfirst($it['category'])) ?></span></td>
                <td class="muted"><?= e($it['feed_type']) ?></td>
                <td class="right"><?= $low ? '<span class="badge badge-red">' : '' ?><?= num($it['quantity']) ?> <?= e($it['unit']) ?><?= $low ? '</span>' : '' ?></td>
                <td class="right"><?= peso($it['price']) ?></td>
                <td class="muted"><?= e($it['supplier_name'] ?? '—') ?></td>
                <td class="right">
                    <button class="btn btn-sm" data-modal-open="itemModal" data-fields='<?= $fields ?>' onclick="document.getElementById('modalTitle').textContent='Edit item'">Edit</button>
                    <form method="post" class="inline-form" data-confirm="Delete “<?= e($it['name']) ?>”? This cannot be undone.">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= (int)$it['id'] ?>">
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add/Edit modal -->
<div class="modal-backdrop" id="itemModal">
    <div class="modal">
        <div class="modal-head"><h3 id="modalTitle">Add item</h3><button class="modal-close" data-modal-close>&times;</button></div>
        <form method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" value="">
            <div class="modal-body">
                <div class="field">
                    <label>Item name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="row2">
                    <div class="field">
                        <label>Category</label>
                        <select name="category">
                            <option value="ingredient">Ingredient</option>
                            <option value="finished">Finished product</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Feed type</label>
                        <input type="text" name="feed_type" placeholder="All / Hog / Chicken" value="All">
                    </div>
                </div>
                <div class="row2">
                    <div class="field"><label>Quantity</label><input type="number" step="0.01" name="quantity" value="0"></div>
                    <div class="field"><label>Unit</label><input type="text" name="unit" value="kg"></div>
                </div>
                <div class="row2">
                    <div class="field"><label>Price (₱)</label><input type="number" step="0.01" name="price" value="0"></div>
                    <div class="field">
                        <label>Supplier</label>
                        <select name="supplier_id">
                            <option value="">— None —</option>
                            <?php foreach ($suppliers as $s): ?>
                                <option value="<?= (int)$s['id'] ?>"><?= e($s['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row2">
                    <div class="field"><label>Minimum level</label><input type="number" step="0.01" name="min_level" value="0"></div>
                    <div class="field"><label>Maximum level</label><input type="number" step="0.01" name="max_level" value="0"></div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn" data-modal-close>Cancel</button>
                <button class="btn btn-primary">Save item</button>
            </div>
        </form>
    </div>
</div>
<?php layout_footer(); ?>
