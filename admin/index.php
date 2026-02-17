<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="../assets/css/admin.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark d-flex justify-content-center align-items-center vh-100">

<div class="card p-4 shadow-lg" style="width: 350px;">
    <h4 class="text-center mb-3">Admin Login</h4>

    <form action="actions/login_process" method="POST">
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>

</body>
</html>
