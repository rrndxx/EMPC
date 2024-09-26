<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Add the same styles as before */
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h3 class="text-center">Member Dashboard</h3>
    <a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="#"><i class="fas fa-users"></i> Profile</a>
    <a href="#"><i class="fas fa-hand-holding-usd"></i> Loans</a>
    <a href="#"><i class="fas fa-chart-line"></i> Reports</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="header">
        <h3>Member Overview</h3>
        <a href="logout.php" class="btn btn-logout">Logout</a>
    </div>
    
    <div class="row mt-5">
        <div class="col-md-6 mb-4">
            <div class="card card-custom">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <p><strong>Name:</strong> <?php echo $_SESSION['user']; ?></p>
                    <p><strong>Email:</strong> john@example.com</p>
                    <button class="btn btn-primary w-100">Edit Profile</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card card-custom">
                <div class="card-header">Loan Information</div>
                <div class="card-body">
                    <p><strong>Active Loans:</strong> 2</p>
                    <button class="btn btn-primary w-100">View Loans</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2024 EMPC Cooperative
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
