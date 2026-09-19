<?php
require_once __DIR__ . '/includes/layout.php';
$user = require_module('users'); // admin only
$pdo  = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';
    try {
        if ($action === 'save') {
            $id       = (int)($_POST['id'] ?? 0);
            $name     = trim($_POST['name'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $role     = $_POST['role'] === 'admin' ? 'admin' : 'staff';
            $password = $_POST['password'] ?? '';

            if ($name === '' || $email === '') {
                throw new RuntimeException('Name and email are required.');
            }
            // Uniqueness check (excluding self).
            $chk = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id <> ?");
            $chk->execute([$email, $id]);
            if ($chk->fetch()) {
                throw new RuntimeException('That email is already in use.');
            }

            if ($id > 0) {
                if ($password !== '') {
                    $pdo->prepare("UPDATE users SET name=?, email=?, role=?, password_hash=? WHERE id=?")
                        ->execute([$name, $email, $role, password_hash($password, PASSWORD_BCRYPT), $id]);
                } else {
                    $pdo->prepare("UPDATE users SET name=?, email=?, role=? WHERE id=?")
                        ->execute([$name, $email, $role, $id]);
                }
                log_activity('users', "Updated user: $name");
                flash("“$name” updated.");
            } else {
                if (strlen($password) < 3) {
                    throw new RuntimeException('New users need a password (min 3 characters).');
                }
                $pdo->prepare("INSERT INTO users (name, email, role, password_hash, active) VALUES (?,?,?,?,1)")
                    ->execute([$name, $email, $role, password_hash($password, PASSWORD_BCRYPT)]);
                log_activity('users', "Added user: $name");
                flash("“$name” created.");
            }
        } elseif ($action === 'toggle') {
            $id = (int)$_POST['id'];
            if ($id === (int)$user['id']) {
                throw new RuntimeException('You cannot suspend your own account.');
            }
            $pdo->prepare("UPDATE users SET active = 1 - active WHERE id = ?")->execute([$id]);
            $name = $pdo->query("SELECT name FROM users WHERE id = " . $id)->fetchColumn();
            log_activity('users', "Toggled active state: $name");
            flash("Updated status for “$name”.");
        } elseif ($action === 'delete') {
            $id = (int)$_POST['id'];
            if ($id === (int)$user['id']) {
                throw new RuntimeException('You cannot delete your own account.');
            }
            $name = $pdo->query("SELECT name FROM users WHERE id = " . $id)->fetchColumn();
            $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
            log_activity('users', "Deleted user: $name");
            flash("“$name” deleted.", 'warn');
        }
    } catch (Throwable $ex) {
        flash($ex->getMessage(), 'error');
    }
    redirect('users.php');
}

$users = $pdo->query("SELECT id, name, email, role, active, created_at FROM users ORDER BY role, name")->fetchAll();

layout_header('Users', 'users');
?>
<div class="toolbar">
    <div class="search">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="text" placeholder="Search users…" data-filter="usrTable">
    </div>
    <div class="spacer"></div>
    <button class="btn btn-primary" data-modal-open="usrModal" data-fields='{"id":"","name":"","email":"","password":""}' onclick="document.getElementById('usrTitle').textContent='Add user';document.getElementById('pwHint').textContent='Required for new users.'">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
        Add user
    </button>
</div>

<div class="table-wrap">
    <table id="usrTable">
        <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Created</th><th class="right">Actions</th></tr></thead>
        <tbody>
        <?php foreach ($users as $u):
            $fields = json_encode(['id'=>$u['id'],'name'=>$u['name'],'email'=>$u['email'],'role'=>$u['role'],'password'=>''], JSON_HEX_APOS | JSON_HEX_QUOT); ?>
            <tr>
                <td><strong><?= e($u['name']) ?></strong><?= $u['id'] == $user['id'] ? ' <span class="muted">(you)</span>' : '' ?></td>
                <td class="muted"><?= e($u['email']) ?></td>
                <td><span class="badge <?= $u['role'] === 'admin' ? 'badge-green' : 'badge-gray' ?>"><?= e(ucfirst($u['role'])) ?></span></td>
                <td><span class="badge <?= $u['active'] ? 'badge-green' : 'badge-red' ?>"><?= $u['active'] ? 'Active' : 'Suspended' ?></span></td>
                <td class="muted"><?= e(date('M j, Y', strtotime($u['created_at']))) ?></td>
                <td class="right">
                    <button class="btn btn-sm" data-modal-open="usrModal" data-fields='<?= $fields ?>' onclick="document.getElementById('usrTitle').textContent='Edit user';document.getElementById('pwHint').textContent='Leave blank to keep current password.'">Edit</button>
                    <?php if ($u['id'] != $user['id']): ?>
                    <form method="post" class="inline-form"><?= csrf_field() ?><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><button class="btn btn-sm"><?= $u['active'] ? 'Suspend' : 'Activate' ?></button></form>
                    <form method="post" class="inline-form" data-confirm="Delete “<?= e($u['name']) ?>”?"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><button class="btn btn-sm btn-danger">Delete</button></form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal-backdrop" id="usrModal">
    <div class="modal">
        <div class="modal-head"><h3 id="usrTitle">Add user</h3><button class="modal-close" data-modal-close>&times;</button></div>
        <form method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="save"><input type="hidden" name="id" value="">
            <div class="modal-body">
                <div class="field"><label>Name</label><input type="text" name="name" required></div>
                <div class="field"><label>Email</label><input type="email" name="email" required></div>
                <div class="field">
                    <label>Role</label>
                    <select name="role">
                        <option value="staff">Staff — all modules except Users</option>
                        <option value="admin">Administrator — full access</option>
                    </select>
                </div>
                <div class="field"><label>Password</label><input type="password" name="password" autocomplete="new-password"><div class="hint" id="pwHint">Required for new users.</div></div>
            </div>
            <div class="modal-foot"><button type="button" class="btn" data-modal-close>Cancel</button><button class="btn btn-primary">Save user</button></div>
        </form>
    </div>
</div>
<?php layout_footer(); ?>
