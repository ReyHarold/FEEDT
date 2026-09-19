<?php
require_once __DIR__ . '/includes/layout.php';
$user = require_module('suppliers');
$pdo  = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';
    if ($action === 'save') {
        $id      = (int)($_POST['id'] ?? 0);
        $name    = trim($_POST['name'] ?? '');
        $contact = trim($_POST['contact'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $address = trim($_POST['address'] ?? '');
        if ($name === '') {
            flash('Supplier name is required.', 'error');
        } elseif ($id > 0) {
            $pdo->prepare("UPDATE suppliers SET name=?, contact=?, email=?, address=? WHERE id=?")
                ->execute([$name, $contact, $email, $address, $id]);
            log_activity('supplier', "Updated supplier: $name");
            flash("“$name” updated.");
        } else {
            $pdo->prepare("INSERT INTO suppliers (name, contact, email, address) VALUES (?,?,?,?)")
                ->execute([$name, $contact, $email, $address]);
            log_activity('supplier', "Added supplier: $name");
            flash("“$name” added.");
        }
    } elseif ($action === 'delete') {
        $id = (int)$_POST['id'];
        $name = $pdo->query("SELECT name FROM suppliers WHERE id = " . $id)->fetchColumn();
        $pdo->prepare("DELETE FROM suppliers WHERE id = ?")->execute([$id]);
        log_activity('supplier', "Deleted supplier: $name");
        flash("“$name” deleted.", 'warn');
    }
    redirect('suppliers.php');
}

$suppliers = $pdo->query("SELECT s.*, (SELECT COUNT(*) FROM inventory i WHERE i.supplier_id = s.id) AS items
                          FROM suppliers s ORDER BY s.name")->fetchAll();

layout_header('Suppliers', 'suppliers');
?>
<div class="toolbar">
    <div class="search">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="text" placeholder="Search suppliers…" data-filter="supTable">
    </div>
    <div class="spacer"></div>
    <button class="btn btn-primary" data-modal-open="supModal" data-fields='{"id":"","name":"","contact":"","email":"","address":""}' onclick="document.getElementById('supTitle').textContent='Add supplier'">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
        Add supplier
    </button>
</div>

<div class="table-wrap">
    <table id="supTable">
        <thead><tr><th>Name</th><th>Contact</th><th>Email</th><th>Address</th><th class="right">Items</th><th class="right">Actions</th></tr></thead>
        <tbody>
        <?php if (!$suppliers): ?><tr class="empty-row"><td colspan="6"><div class="empty">No suppliers yet.</div></td></tr><?php endif; ?>
        <?php foreach ($suppliers as $s):
            $fields = json_encode(['id'=>$s['id'],'name'=>$s['name'],'contact'=>$s['contact'],'email'=>$s['email'],'address'=>$s['address']], JSON_HEX_APOS | JSON_HEX_QUOT); ?>
            <tr>
                <td><strong><?= e($s['name']) ?></strong></td>
                <td class="muted"><?= e($s['contact'] ?: '—') ?></td>
                <td class="muted"><?= e($s['email'] ?: '—') ?></td>
                <td class="muted"><?= e($s['address'] ?: '—') ?></td>
                <td class="right"><span class="badge badge-gray"><?= (int)$s['items'] ?></span></td>
                <td class="right">
                    <button class="btn btn-sm" data-modal-open="supModal" data-fields='<?= $fields ?>' onclick="document.getElementById('supTitle').textContent='Edit supplier'">Edit</button>
                    <form method="post" class="inline-form" data-confirm="Delete “<?= e($s['name']) ?>”?"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$s['id'] ?>"><button class="btn btn-sm btn-danger">Delete</button></form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal-backdrop" id="supModal">
    <div class="modal">
        <div class="modal-head"><h3 id="supTitle">Add supplier</h3><button class="modal-close" data-modal-close>&times;</button></div>
        <form method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="save"><input type="hidden" name="id" value="">
            <div class="modal-body">
                <div class="field"><label>Name</label><input type="text" name="name" required></div>
                <div class="row2">
                    <div class="field"><label>Contact number</label><input type="text" name="contact"></div>
                    <div class="field"><label>Email</label><input type="email" name="email"></div>
                </div>
                <div class="field"><label>Address</label><input type="text" name="address"></div>
            </div>
            <div class="modal-foot"><button type="button" class="btn" data-modal-close>Cancel</button><button class="btn btn-primary">Save supplier</button></div>
        </form>
    </div>
</div>
<?php layout_footer(); ?>
