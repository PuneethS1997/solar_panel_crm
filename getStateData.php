<?php
require_once 'includes/db.php';

$state_id = $_GET['state_id'];
$type = $_GET['connection_type'];

$response = [];

// Tariff
$stmt = $pdo->prepare("SELECT * FROM tariffs WHERE state_id = ? AND connection_type = ?");
$stmt->execute([$state_id, $type]);
$response['tariff'] = $stmt->fetch();

// Subsidy
$stmt2 = $pdo->prepare("SELECT * FROM subsidy_rules WHERE state_id = ?");
$stmt2->execute([$state_id]);
$response['subsidy'] = $stmt2->fetch();

echo json_encode($response);
