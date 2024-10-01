<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];
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
        body {
            background-color: #f1f4f7;
        }
        .sidebar {
            background-color: #28a745;
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
            background-color: #218838;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar">
            <h4 class="text-center text-white">Member Dashboard</h4>
            <a href="#">Home</a>
            <a href="#">Profile</a>
            <a href="#">My Loans</a>
            <a href="#">Transaction History</a>
            <a href="#">Settings</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <div class="content">
            <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
            <p>This is your member dashboard where you can manage your account.</p>
            <!-- Add more member-specific content here -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
