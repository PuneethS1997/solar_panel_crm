<?php
require_once '../includes/db.php';
include 'includes/header.php';
include 'includes/sidebar.php';

/* =========================
   DELETE
========================= */
if(isset($_GET['delete'])){
    $stmt = $pdo->prepare("DELETE FROM tariffs WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: tariffs.php");
    exit;
}

/* =========================
   ADD / UPDATE
========================= */
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(!empty($_POST['id'])){
        // UPDATE
        $stmt = $pdo->prepare("
            UPDATE tariffs
            SET state_id=?, connection_type=?, tariff_rate=?, export_rate=?
            WHERE id=?
        ");
        $stmt->execute([
            $_POST['state_id'],
            $_POST['connection_type'],
            $_POST['tariff_rate'],
            $_POST['export_rate'],
            $_POST['id']
        ]);
    } else {
        // INSERT
        $stmt = $pdo->prepare("
            INSERT INTO tariffs (state_id, connection_type, tariff_rate, export_rate)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $_POST['state_id'],
            $_POST['connection_type'],
            $_POST['tariff_rate'],
            $_POST['export_rate']
        ]);
    }

    header("Location: tariffs.php");
    exit;
}

/* =========================
   EDIT FETCH
========================= */
$editData = null;
if(isset($_GET['edit'])){
    $stmt = $pdo->prepare("SELECT * FROM tariffs WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $editData = $stmt->fetch();
}

/* =========================
   FETCH STATES & TARIFFS
========================= */
$states = $pdo->query("SELECT * FROM states")->fetchAll();

$tariffs = $pdo->query("
    SELECT t.*, s.state_name
    FROM tariffs t
    LEFT JOIN states s ON t.state_id = s.id
")->fetchAll();
?>

<div class="container mt-4">
    <h3 class="mb-4">Tariff Management</h3>

    <!-- FORM -->
    <div class="card shadow-sm p-4 mb-4">
        <form method="POST" class="row g-3">

            <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

            <div class="col-md-3">
                <label>State</label>
                <select name="state_id" class="form-control" required>
                    <option value="">Select State</option>
                    <?php foreach($states as $state): ?>
                        <option value="<?= $state['id'] ?>"
                            <?= (isset($editData) && $editData['state_id']==$state['id']) ? 'selected' : '' ?>>
                            <?= $state['state_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label>Connection Type</label>
                <select name="connection_type" class="form-control" required>
                    <option value="">Select Type</option>
                    <?php 
                    $types = ['residential','commercial','industrial'];
                    foreach($types as $type): ?>
                        <option value="<?= $type ?>"
                            <?= (isset($editData) && $editData['connection_type']==$type) ? 'selected' : '' ?>>
                            <?= ucfirst($type) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label>Tariff Rate (₹ / unit)</label>
                <input type="number" step="0.01"
                       name="tariff_rate"
                       value="<?= $editData['tariff_rate'] ?? '' ?>"
                       class="form-control" required>
            </div>

            <div class="col-md-3">
                <label>Export Rate (₹ / unit)</label>
                <input type="number" step="0.01"
                       name="export_rate"
                       value="<?= $editData['export_rate'] ?? '' ?>"
                       class="form-control" required>
            </div>

            <div class="col-md-12">
                <button class="btn btn-primary">
                    <?= isset($editData) ? 'Update Tariff' : 'Add Tariff' ?>
                </button>

                <?php if(isset($editData)): ?>
                    <a href="tariffs.php" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>
            </div>

        </form>
    </div>

    <!-- TABLE -->
    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>State</th>
                        <th>Connection</th>
                        <th>Tariff ₹</th>
                        <th>Export ₹</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($tariffs as $tariff): ?>
                        <tr>
                            <td><?= $tariff['state_name'] ?></td>
                            <td><?= ucfirst($tariff['connection_type']) ?></td>
                            <td>₹<?= $tariff['tariff_rate'] ?></td>
                            <td>₹<?= $tariff['export_rate'] ?></td>
                            <td>
                                <a href="?edit=<?= $tariff['id'] ?>"
                                   class="btn btn-sm btn-warning">Edit</a>

                                <a href="?delete=<?= $tariff['id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this tariff?')">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

<?php include 'includes/footer.php'; ?>
