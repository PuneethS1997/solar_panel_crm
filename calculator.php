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
                <label>Select State</label>

                <select id="state"  class="form-control">
                    <?php
                    $stmt = $pdo->query("SELECT * FROM states");
                    while($row = $stmt->fetch()){
                        echo "<option value='{$row['id']}' >{$row['state_name']}</option>";
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

        <canvas id="projectionChart"></canvas>


        <!-- ENVIRONMENTAL IMPACT -->
        <section id="ecoImpact" class="eco-section">
    <div class="eco-overlay"></div>

    <div class="eco-content">
        <h2 class="eco-title">🌍 Environmental Impact</h2>

        <div class="eco-stats">
            <div class="eco-box">
                <h3 id="treeCount">0</h3>
                <p>Trees Planted</p>
            </div>

            <div class="eco-box">
                <h3 id="co2Count">0</h3>
                <p>kg CO₂ Prevented</p>
            </div>
        </div>

        <div class="eco-message">
            You are officially a Climate Hero 🚀
        </div>
    </div>
</section>


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

<script>
const settings = <?= json_encode($settings); ?>;
</script>
<?php include 'includes/footer.php'; ?>
