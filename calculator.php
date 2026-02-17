<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';

$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch();


if(!$settings){
    die("Settings not configured. Please configure from admin panel.");
}
?>


<?php include 'includes/header.php'; ?>

<section class="calculator-page py-5">
    <div class="container">
        <h1 class="text-center fw-bold mb-4">Advanced Solar ROI Calculator</h1>

        <div class="card p-4 shadow-lg border-0 rounded-4">

            <div class="row g-3">

                <div class="col-md-4">
                <select id="state">
                    <?php
                    $stmt = $pdo->query("SELECT * FROM states");
                    while($row = $stmt->fetch()){
                        echo "<option value='{$row['id']}'>{$row['state_name']}</option>";
                    }
                    ?>
                </select>

                </div>
                <div class="col-md-4">
                    <label>Monthly Electricity Bill (₹)</label>
                    <input type="number" id="bill" class="form-control">
                </div>

                <div class="col-md-4">
                    <label>Electricity Rate (₹ per unit)</label>
                    <input type="number" id="rate" class="form-control" value="8">
                </div>

                <div class="col-md-4">
                    <label>Sunlight Hours per Day</label>
                    <input type="number" id="sunlight" class="form-control" value="5">
                </div>
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-warning btn-lg px-5" id="calculateBtn">
                    Calculate ROI
                </button>
            </div>

        </div>
    </div>
</section>

<!-- RESULT SECTION -->
<section id="resultSection" class="py-5 d-none">
    <div class="container">

        <h2 class="text-center fw-bold mb-4">Your Solar Impact</h2>

        <div class="row text-center mb-5">
            <div class="col-md-4">
                <h3 id="payback"></h3>
                <p>Payback Period</p>
            </div>

            <div class="col-md-4">
                <h3 id="totalSavings"></h3>
                <p>25 Year Savings</p>
            </div>

            <div class="col-md-4">
                <h3 id="systemSize"></h3>
                <p>Recommended System Size</p>
            </div>
        </div>

        <!-- CHART -->
        <canvas id="roiChart" height="100"></canvas>

        <!-- ENVIRONMENTAL IMPACT -->
        <div class="impact-section text-center mt-5">
            <h2 class="fw-bold mb-3">Your Environmental Contribution 🌍</h2>
            <h3 id="trees"></h3>
            <h3 id="co2"></h3>
        </div>

    </div>
</section>

<script>
const solarSettings = {
    unit_price: <?= $settings['unit_price']; ?>,
    sunlight_factor: <?= $settings['sunlight_factor']; ?>,
    cost_per_kw: <?= $settings['cost_per_kw']; ?>,
    subsidy_percent: <?= $settings['subsidy_percent']; ?>,
    co2_per_kw: <?= $settings['co2_per_kw']; ?>,
    co2_per_tree: <?= $settings['co2_per_tree']; ?>
};
</script>


<?php include 'includes/footer.php'; ?>
