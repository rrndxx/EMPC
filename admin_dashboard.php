<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$admin_username = $_SESSION['admin'];
$current_page = basename($_SERVER['PHP_SELF']);
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

        .card {
            transition: box-shadow 0.3s;
        }

        .card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: #218838;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .icon {
            margin-right: 5px;
        }

        .section-title {
            background-color: #218838;
            color: white;
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

        @media (max-width: 576px) {
            h4 {
                font-size: 1.25rem;
            }

            .btn {
                width: 100%;
                margin: 5px 0;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">EMPC Cooperative Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo ($current_page == 'admin_dashboard.php') ? 'active' : ''; ?>"
                            href="admin_dashboard.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo ($current_page == 'manage_users.php') ? 'active' : ''; ?>"
                            href="manage_users.php">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo ($current_page == 'view_transactions.php') ? 'active' : ''; ?>"
                            href="view_transactions.php">View Transactions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>"
                            href="settings.php">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <div class="alert alert-info" role="alert">
            <h2 class="mb-0">Welcome, <?php echo htmlspecialchars($admin_username); ?>!</h2>
        </div>

        <hr>

        <div class="row mb-4">
            <div class="col-lg-6 col-md-12 mb-2">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">User Management</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-users icon me-2"></i>
                            <p class="card-text">Add, edit, or delete users.</p>
                        </div>
                        <a href="manage_users.php" class="btn btn-primary">Manage Users</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 mb-2">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Transaction Reports</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-file-invoice icon me-2"></i>
                            <p class="card-text">View transaction reports and analytics.</p>
                        </div>
                        <a href="view_transactions.php" class="btn btn-primary">View Reports</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
