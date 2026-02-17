<?php
require_once '../../includes/db.php';

$stmt = $pdo->prepare("
    UPDATE settings SET
    cost_per_kw = ?,
    unit_price = ?,
    sunlight_factor = ?,
    co2_per_kw = ?,
    co2_per_tree = ?,
    whatsapp_number = ?
    WHERE id = ?
");

$stmt->execute([
    $_POST['cost_per_kw'],
    $_POST['unit_price'],
    $_POST['sunlight_factor'],
    $_POST['co2_per_kw'],
    $_POST['co2_per_tree'],
    $_POST['whatsapp_number'],
    $_POST['id']
]);

header("Location: ../settings.php");
