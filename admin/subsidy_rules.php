<?php
require_once '../includes/db.php';
include 'includes/header.php';
include 'includes/sidebar.php';

/* =========================
   HANDLE DELETE
========================= */
if(isset($_GET['delete'])){
    $stmt = $pdo->prepare("DELETE FROM subsidy_rules WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: subsidy_rules.php");
    exit;
}

/* =========================
   HANDLE ADD / UPDATE
========================= */
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(!empty($_POST['id'])){
        // UPDATE
        $stmt = $pdo->prepare("
            UPDATE subsidy_rules
            SET state_id=?, subsidy_percent=?, max_subsidy_kw=?
            WHERE id=?
        ");
        $stmt->execute([
            $_POST['state_id'],
            $_POST['subsidy_percent'],
            $_POST['max_subsidy_kw'],
            $_POST['id']
        ]);
    } else {
        // INSERT
        $stmt = $pdo->prepare("
            INSERT INTO subsidy_rules (state_id, subsidy_percent, max_subsidy_kw)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([
            $_POST['state_id'],
            $_POST['subsidy_percent'],
            $_POST['max_subsidy_kw']
        ]);
    }

    header("Location: subsidy_rules.php");
    exit;
}

/* =========================
   FETCH EDIT DATA
========================= */
$editData = null;
if(isset($_GET['edit'])){
    $stmt = $pdo->prepare("SELECT * FROM subsidy_rules WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $editData = $stmt->fetch();
}

/* =========================
   FETCH STATES & RULES
========================= */
$states = $pdo->query("SELECT * FROM states")->fetchAll();

$rules = $pdo->query("
    SELECT sr.*, s.state_name
    FROM subsidy_rules sr
    LEFT JOIN states s ON sr.state_id = s.id
")->fetchAll();
?>

<div class="container mt-4">
    <h3 class="mb-4">Subsidy Rules Management</h3>

    <!-- FORM -->
    <div class="card shadow-sm p-4 mb-4">
        <form method="POST" class="row g-3">

            <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

            <div class="col-md-4">
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

            <div class="col-md-4">
                <label>Subsidy %</label>
                <input type="number" step="0.01"
                       name="subsidy_percent"
                       value="<?= $editData['subsidy_percent'] ?? '' ?>"
                       class="form-control" required>
            </div>

            <div class="col-md-4">
                <label>Max Subsidy kW</label>
                <input type="number" step="0.01"
                       name="max_subsidy_kw"
                       value="<?= $editData['max_subsidy_kw'] ?? '' ?>"
                       class="form-control" required>
            </div>

            <div class="col-md-12">
                <button class="btn btn-primary">
                    <?= isset($editData) ? 'Update Rule' : 'Add Rule' ?>
                </button>

                <?php if(isset($editData)): ?>
                    <a href="subsidy_rules.php" class="btn btn-secondary">Cancel</a>
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
                        <th>Subsidy %</th>
                        <th>Max kW</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($rules as $rule): ?>
                        <tr>
                            <td><?= $rule['state_name'] ?></td>
                            <td><?= $rule['subsidy_percent'] ?>%</td>
                            <td><?= $rule['max_subsidy_kw'] ?> kW</td>
                            <td>
                                <a href="?edit=<?= $rule['id'] ?>"
                                   class="btn btn-sm btn-warning">Edit</a>

                                <a href="?delete=<?= $rule['id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this rule?')">
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
