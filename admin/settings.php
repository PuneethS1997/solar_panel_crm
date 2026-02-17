<?php
require_once '../includes/db.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch();
?>

<div class="container mt-4">
    <h3>Global Calculator Settings</h3>

    <form action="actions/save_settings.php" method="POST">
        <input type="hidden" name="id" value="<?= $settings['id'] ?>">

        <div class="row">
            <div class="col-md-4">
                <label>Cost per kW</label>
                <input type="number" step="0.01" name="cost_per_kw" class="form-control"
                       value="<?= $settings['cost_per_kw'] ?>">
            </div>

            <div class="col-md-4">
                <label>Unit Price</label>
                <input type="number" step="0.01" name="unit_price" class="form-control"
                       value="<?= $settings['unit_price'] ?>">
            </div>

            <div class="col-md-4">
                <label>Sunlight Factor</label>
                <input type="number" step="0.01" name="sunlight_factor" class="form-control"
                       value="<?= $settings['sunlight_factor'] ?>">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <label>CO2 per kW</label>
                <input type="number" step="0.01" name="co2_per_kw" class="form-control"
                       value="<?= $settings['co2_per_kw'] ?>">
            </div>

            <div class="col-md-4">
                <label>CO2 per Tree</label>
                <input type="number" step="0.01" name="co2_per_tree" class="form-control"
                       value="<?= $settings['co2_per_tree'] ?>">
            </div>

            <div class="col-md-4">
                <label>WhatsApp Number</label>
                <input type="text" name="whatsapp_number" class="form-control"
                       value="<?= $settings['whatsapp_number'] ?>">
            </div>
        </div>

        <button class="btn btn-primary mt-3">Save Settings</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
