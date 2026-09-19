<?php
require_once __DIR__ . '/includes/layout.php';
$user = require_module('orders');
$pdo  = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    try {
        if ($action === 'create') {
            $customer = trim($_POST['customer'] ?? '');
            $item     = trim($_POST['item'] ?? '');
            $qty      = (float)($_POST['quantity'] ?? 0);
            $price    = (float)($_POST['unit_price'] ?? 0);

            if ($customer === '' || $item === '' || $qty <= 0) {
                throw new RuntimeException('Customer, item and a positive quantity are required.');
            }

            $pdo->beginTransaction();
            // Lock the inventory row for this finished product.
            $inv = $pdo->prepare("SELECT id, quantity, price FROM inventory WHERE name = ? AND category = 'finished' FOR UPDATE");
            $inv->execute([$item]);
            $row = $inv->fetch();
            if (!$row) {
                throw new RuntimeException('Selected product is not a finished inventory item.');
            }
            if ((float)$row['quantity'] < $qty) {
                throw new RuntimeException('Insufficient stock. Available: ' . num($row['quantity']) . '.');
            }
            if ($price <= 0) {
                $price = (float)$row['price'];
            }
            $total = $qty * $price;

            $pdo->prepare("INSERT INTO orders (customer, item, quantity, unit_price, total, status, created_by) VALUES (?,?,?,?,?, 'pending', ?)")
                ->execute([$customer, $item, $qty, $price, $total, $user['id']]);
            $pdo->prepare("UPDATE inventory SET quantity = quantity - ? WHERE id = ?")
                ->execute([$qty, $row['id']]);
            $pdo->commit();
            log_activity('order', "Placed order: {$item} x" . num($qty) . " for {$customer}");
            flash('Order placed and stock updated.');
        } elseif ($action === 'deliver') {
            $id = (int)$_POST['id'];
            $stmt = $pdo->prepare("UPDATE orders SET status = 'delivered', delivered_date = NOW() WHERE id = ? AND status = 'pending'");
            $stmt->execute([$id]);
            if ($stmt->rowCount()) {
                log_activity('order', "Marked order #{$id} delivered");
                flash('Order marked as delivered.');
            } else {
                flash('Order was not pending.', 'warn');
            }
        } elseif ($action === 'cancel' || $action === 'delete') {
            $id = (int)$_POST['id'];
            $pdo->beginTransaction();
            $o = $pdo->prepare("SELECT item, quantity, status FROM orders WHERE id = ? FOR UPDATE");
            $o->execute([$id]);
            $ord = $o->fetch();
            if ($ord) {
                // Restock only if the order had reserved stock (pending).
                if ($ord['status'] === 'pending') {
                    $pdo->prepare("UPDATE inventory SET quantity = quantity + ? WHERE name = ? AND category = 'finished'")
                        ->execute([$ord['quantity'], $ord['item']]);
                }
                if ($action === 'delete') {
                    $pdo->prepare("DELETE FROM orders WHERE id = ?")->execute([$id]);
                    log_activity('order', "Deleted order #{$id}");
                    flash('Order deleted' . ($ord['status'] === 'pending' ? ' and stock restored.' : '.'), 'warn');
                } else {
                    $pdo->prepare("UPDATE orders SET status = 'cancelled' WHERE id = ?")->execute([$id]);
                    log_activity('order', "Cancelled order #{$id}");
                    flash('Order cancelled and stock restored.', 'warn');
                }
            }
            $pdo->commit();
        }
    } catch (Throwable $ex) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        flash($ex->getMessage(), 'error');
    }
    redirect('orders.php');
}

$orders = $pdo->query("SELECT * FROM orders ORDER BY order_date DESC")->fetchAll();
$products = $pdo->query("SELECT name, price, quantity FROM inventory WHERE category = 'finished' ORDER BY name")->fetchAll();

$badge = ['pending' => 'badge-amber', 'delivered' => 'badge-green', 'cancelled' => 'badge-gray'];

layout_header('Orders', 'orders');
?>
<div class="toolbar">
    <div class="search">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="text" placeholder="Search orders…" data-filter="ordTable">
    </div>
    <div class="spacer"></div>
    <button class="btn btn-primary" data-modal-open="orderModal">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
        New order
    </button>
</div>

<div class="table-wrap">
    <table id="ordTable">
        <thead><tr><th>#</th><th>Customer</th><th>Item</th><th class="right">Qty</th><th class="right">Unit price</th><th class="right">Total</th><th>Status</th><th>Date</th><th class="right">Actions</th></tr></thead>
        <tbody>
        <?php if (!$orders): ?><tr class="empty-row"><td colspan="9"><div class="empty">No orders yet.</div></td></tr><?php endif; ?>
        <?php foreach ($orders as $o): ?>
            <tr>
                <td class="muted">#<?= (int)$o['id'] ?></td>
                <td><strong><?= e($o['customer']) ?></strong></td>
                <td><?= e($o['item']) ?></td>
                <td class="right"><?= num($o['quantity']) ?></td>
                <td class="right"><?= peso($o['unit_price']) ?></td>
                <td class="right"><strong><?= peso($o['total']) ?></strong></td>
                <td><span class="badge <?= $badge[$o['status']] ?? 'badge-gray' ?>"><?= e(ucfirst($o['status'])) ?></span></td>
                <td class="muted"><?= e(date('M j, Y', strtotime($o['order_date']))) ?></td>
                <td class="right">
                    <?php if ($o['status'] === 'pending'): ?>
                        <form method="post" class="inline-form"><?= csrf_field() ?><input type="hidden" name="action" value="deliver"><input type="hidden" name="id" value="<?= (int)$o['id'] ?>"><button class="btn btn-sm btn-primary">Deliver</button></form>
                        <form method="post" class="inline-form" data-confirm="Cancel this order and restore stock?"><?= csrf_field() ?><input type="hidden" name="action" value="cancel"><input type="hidden" name="id" value="<?= (int)$o['id'] ?>"><button class="btn btn-sm">Cancel</button></form>
                    <?php endif; ?>
                    <form method="post" class="inline-form" data-confirm="Delete this order permanently?"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$o['id'] ?>"><button class="btn btn-sm btn-danger">Delete</button></form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal-backdrop" id="orderModal">
    <div class="modal">
        <div class="modal-head"><h3>New order</h3><button class="modal-close" data-modal-close>&times;</button></div>
        <form method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="create">
            <div class="modal-body">
                <div class="field"><label>Customer</label><input type="text" name="customer" required></div>
                <div class="field">
                    <label>Product</label>
                    <select name="item" id="orderItem" required>
                        <option value="">— Select a finished product —</option>
                        <?php foreach ($products as $p): ?>
                            <option value="<?= e($p['name']) ?>" data-price="<?= e($p['price']) ?>" data-stock="<?= e($p['quantity']) ?>">
                                <?= e($p['name']) ?> — <?= num($p['quantity']) ?> in stock
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="row2">
                    <div class="field"><label>Quantity</label><input type="number" step="0.01" min="0.01" name="quantity" id="orderQty" required></div>
                    <div class="field"><label>Unit price (₱)</label><input type="number" step="0.01" name="unit_price" id="orderPrice" placeholder="auto"></div>
                </div>
                <div class="field"><div class="hint">Total: <strong id="orderTotal">₱0.00</strong></div></div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn" data-modal-close>Cancel</button>
                <button class="btn btn-primary">Place order</button>
            </div>
        </form>
    </div>
</div>
<script>
(function () {
    var sel = document.getElementById('orderItem'),
        qty = document.getElementById('orderQty'),
        price = document.getElementById('orderPrice'),
        total = document.getElementById('orderTotal');
    function fillPrice() {
        var opt = sel.options[sel.selectedIndex];
        if (opt && opt.dataset.price && !price.value) price.value = opt.dataset.price;
        calc();
    }
    function calc() {
        var t = (parseFloat(qty.value) || 0) * (parseFloat(price.value) || 0);
        total.textContent = '₱' + t.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
    sel.addEventListener('change', fillPrice);
    qty.addEventListener('input', calc);
    price.addEventListener('input', calc);
})();
</script>
<?php layout_footer(); ?>
