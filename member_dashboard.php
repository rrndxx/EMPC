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

        .sidebar h4 {
            color: white;
        }

        .sidebar a {
            color: white;
            padding: 10px 15px;
            display: block;
            margin: 5px 0;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #218838;
        }

        .content {
            padding: 20px;
            flex: 1;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
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
    </style>
</head>

<body>
    <div class="d-flex">
        <div class="sidebar">
            <h4 class="text-center">Member Dashboard</h4>
            <a href="#">Home</a>
            <a href="#">Profile</a>
            <a href="#">My Loans</a>
            <a href="#">Transaction History</a>
            <a href="#">Settings</a>
            <a href="logout.php" class="btn btn-logout">Logout</a>
        </div>
        <div class="content">
            <div class="header">
                <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
            </div>
            <p>This is your member dashboard where you can manage your account.</p>
            <h4>Quick Actions:</h4>
            <div class="d-flex flex-wrap">
                <div class="card m-2" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">View My Loans</h5>
                        <p class="card-text">Check your current loans and payment status.</p>
                        <a href="#" class="btn btn-primary">Go to Loans</a>
                    </div>
                </div>
                <div class="card m-2" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Transaction History</h5>
                        <p class="card-text">Review your past transactions.</p>
                        <a href="#" class="btn btn-primary">View Transactions</a>
                    </div>
                </div>
                <div class="card m-2" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Update Profile</h5>
                        <p class="card-text">Edit your personal details.</p>
                        <a href="#" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="footer">
                <p>&copy; 2024 EMPC Cooperative. All Rights Reserved.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
