<?php
require_once '../includes/db.php';
include 'includes/header.php';
include 'includes/sidebar.php';

/* =========================
   DELETE STATE
========================= */
if(isset($_GET['delete'])){
    $stmt = $pdo->prepare("DELETE FROM states WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: states.php");
    exit;
}

/* =========================
   ADD / UPDATE STATE
========================= */
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $state_name = trim($_POST['state_name']);

    if(!empty($_POST['id'])){
        // UPDATE
        $stmt = $pdo->prepare("UPDATE states SET state_name=? WHERE id=?");
        $stmt->execute([$state_name, $_POST['id']]);
    } else {
        // INSERT
        $stmt = $pdo->prepare("INSERT INTO states (state_name) VALUES (?)");
        $stmt->execute([$state_name]);
    }

    header("Location: states.php");
    exit;
}

/* =========================
   EDIT FETCH
========================= */
$editData = null;
if(isset($_GET['edit'])){
    $stmt = $pdo->prepare("SELECT * FROM states WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $editData = $stmt->fetch();
}

/* =========================
   FETCH ALL STATES
========================= */
$states = $pdo->query("SELECT * FROM states ORDER BY state_name ASC")->fetchAll();
?>

<div class="container mt-4">
    <h3 class="mb-4">State Management</h3>

    <!-- FORM -->
    <div class="card shadow-sm p-4 mb-4">
        <form method="POST" class="row g-3">

            <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

            <div class="col-md-8">
                <label>State Name</label>
                <input type="text"
                       name="state_name"
                       value="<?= $editData['state_name'] ?? '' ?>"
                       class="form-control"
                       placeholder="Enter State Name"
                       required>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary w-100">
                    <?= isset($editData) ? 'Update State' : 'Add State' ?>
                </button>
            </div>

            <?php if(isset($editData)): ?>
                <div class="col-md-12">
                    <a href="states.php" class="btn btn-secondary">Cancel</a>
                </div>
            <?php endif; ?>

        </form>
    </div>

    <!-- TABLE -->
    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th width="70%">State Name</th>
                        <th width="30%">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($states as $state): ?>
                        <tr>
                            <td><?= $state['state_name'] ?></td>
                            <td>
                                <a href="?edit=<?= $state['id'] ?>"
                                   class="btn btn-sm btn-warning">Edit</a>

                                <a href="?delete=<?= $state['id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this state?')">
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
