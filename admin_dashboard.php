<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$admin_username = $_SESSION['admin'];
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
        .sidebar {
            background-color: #007bff;
            height: 100vh;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            padding: 10px 15px;
            display: block;
            margin: 5px 0;
            text-decoration: none;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #0056b3;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar">
            <h4 class="text-center text-white">Admin Dashboard</h4>
            <a href="#">Home</a>
            <a href="#">Manage Users</a>
            <a href="#">View Transactions</a>
            <a href="#">Settings</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <div class="content">
            <h2>Welcome, <?php echo htmlspecialchars($admin_username); ?>!</h2>
            <p>This is your admin dashboard where you can manage the system.</p>
            <!-- Add more admin-specific content here -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
