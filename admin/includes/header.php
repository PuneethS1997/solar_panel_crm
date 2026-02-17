<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: index");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Solar Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/admin.css" rel="stylesheet">
</head>

<body>

<div class="admin-wrapper">

    <!-- Top Navbar -->
    <nav class="navbar navbar-dark admin-topbar px-3">
        <button class="btn btn-outline-light" id="toggleSidebar">☰</button>
        <span class="ms-auto">Welcome, <?php echo $_SESSION['admin_name']; ?></span>
    </nav>

    <div class="d-flex">
