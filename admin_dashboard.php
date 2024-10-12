<?php
session_start();

// Check if the user is logged in as an admin
// if (!isset($_SESSION['admin'])) {
//     header("Location: admin_login.php");
//     exit();
// }

// $admin_username = $_SESSION['admin'];
// $current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f1f4f7;
        }

        .navbar {
            background-color: #28a745;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }

        .btn-logout {
            background-color: #dc3545;
            border: none;
        }

        .btn-logout:hover {
            background-color: #c82333;
        }

        .card {
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .alert {
            background-color: #e2f0d9;
            border-color: #c3e6cb;
        }

        .icon {
            font-size: 2rem;
            color: #28a745;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">EMPC Cooperative Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo ($current_page == 'manage_users.php') ? 'active' : ''; ?>" href="manage_users.php">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo ($current_page == 'view_transactions.php') ? 'active' : ''; ?>" href="view_transactions.php">View Transactions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>" href="settings.php">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <div class="alert alert-primary" role="alert">
            <h2 class="mb-0">Welcome, <?php echo htmlspecialchars($admin_username); ?>!</h2>
        </div>
        <h4>Admin Actions:</h4>
        <div class="row">
            <div class="col-12 col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-users icon me-2"></i>
                            <h5 class="card-title">User Management</h5>
                        </div>
                        <p class="card-text">Add, edit, or delete users.</p>
                        <a href="manage_users.php" class="btn btn-primary">Manage Users</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-file-invoice icon me-2"></i>
                            <h5 class="card-title">Transaction Reports</h5>
                        </div>
                        <p class="card-text">View transaction reports and analytics.</p>
                        <a href="view_transactions.php" class="btn btn-primary">View Reports</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-cog icon me-2"></i>
                            <h5 class="card-title">System Settings</h5>
                        </div>
                        <p class="card-text">Adjust system configurations.</p>
                        <a href="settings.php" class="btn btn-primary">Settings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
