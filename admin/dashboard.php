<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php require_once '../includes/db.php'; ?>

<?php
// Total Leads
$stmt = $pdo->query("SELECT COUNT(*) as total FROM leads");
$totalLeads = $stmt->fetch()['total'];

// Total Projects
$stmt = $pdo->query("SELECT COUNT(*) as total FROM projects");
$totalProjects = $stmt->fetch()['total'];

// Closed Deals
$stmt = $pdo->query("SELECT COUNT(*) as total FROM leads WHERE status = 'closed'");
$closedDeals = $stmt->fetch()['total'];

// Revenue (sum of estimated_cost from closed deals)
$stmt = $pdo->query("SELECT SUM(estimated_cost) as revenue FROM leads WHERE status = 'closed'");
$revenue = $stmt->fetch()['revenue'];
$revenue = $revenue ? $revenue : 0;
?>

<div class="content p-4 w-100">

    <h2 class="mb-4">Dashboard Overview 📊</h2>

    <div class="row">

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card dashboard-card">
                <h6>Total Leads</h6>
                <h3><?php echo $totalLeads; ?></h3>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card dashboard-card">
                <h6>Total Projects</h6>
                <h3><?php echo $totalProjects; ?></h3>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card dashboard-card">
                <h6>Closed Deals</h6>
                <h3><?php echo $closedDeals; ?></h3>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card dashboard-card">
                <h6>Revenue</h6>
                <h3>₹<?php echo number_format($revenue); ?></h3>
            </div>
        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>
