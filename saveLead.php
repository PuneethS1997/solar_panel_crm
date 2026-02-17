<?php
header('Content-Type: application/json');

require_once 'config/config.php';

// Create DB Connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . $conn->connect_error
    ]);
    exit;
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit;
}

$name = $data['name'] ?? '';
$phone = $data['phone'] ?? '';
$email = $data['email'] ?? '';
$city = $data['city'] ?? '';
$monthly_bill = floatval($data['monthly_bill'] ?? 0);
$estimated_kw = floatval($data['estimated_kw'] ?? 0);
$estimated_cost = floatval($data['estimated_cost'] ?? 0);
$yearly_savings = floatval($data['yearly_savings'] ?? 0);
$message = $data['message'] ?? 'Lead from Solar Calculator';

// Prepare insert
$stmt = $conn->prepare("
    INSERT INTO leads 
    (name, phone, email, city, monthly_bill, estimated_kw, estimated_cost, yearly_savings, message) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => $conn->error
    ]);
    exit;
}

$stmt->bind_param(
    "ssssdddds",
    $name,
    $phone,
    $email,
    $city,
    $monthly_bill,
    $estimated_kw,
    $estimated_cost,
    $yearly_savings,
    $message
);

$stmt->execute();

echo json_encode(["status" => "success"]);

$conn->close();
?>
