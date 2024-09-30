<?php
session_start();

// Placeholder: Include your database connection file here
// include 'db_connection.php';

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $errors = [];
    $success = "";

    // Validate username
    if (empty($username)) {
        $errors[] = "Username is required.";
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $errors[] = "Username can only contain letters and numbers.";
    }

    // Validate passwords
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $errors[] = "Password must contain at least one uppercase letter.";
    } elseif (!preg_match("/[a-z]/", $password)) {
        $errors[] = "Password must contain at least one lowercase letter.";
    } elseif (!preg_match("/[0-9]/", $password)) {
        $errors[] = "Password must contain at least one number.";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Passwords do not match!";
    }

    // If no errors, proceed with account creation
    if (empty($errors)) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Check for existing user
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
            $errors[] = "Username already exists. Please choose another.";
        } else {
            // Insert user into database
            $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
            if (mysqli_query($connection, $insert_query)) {
                $success = "Account created successfully! You can now log in.";
            } else {
                $errors[] = "Error creating account. Please try again.";
            }
        }
    }
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
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #28a745;
            padding-top: 20px;
            transition: all 0.3s ease;
        }

        .sidebar h3 {
            color: white;
            text-align: center;
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar a:hover {
            background-color: #218838;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }

        .card-custom {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #28a745;
            color: white;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding-top: 10px;
            }

            .main-content {
                margin-left: 0;
                padding: 10px;
            }

            .sidebar a {
                font-size: 16px;
                padding: 10px;
            }

            .sidebar h3 {
                font-size: 20px;
            }

            .card-custom {
                margin-bottom: 20px;
            }
        }
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
        <h3>Member Overview</h3>

        <div class="row mt-5">
            <div class="col-12 mb-4">
                <div class="card card-custom">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <p><strong>Name:</strong> <?php echo $_SESSION['user']; ?></p>
                        <p><strong>Email:</strong> john@example.com</p>
                        <button class="btn btn-custom w-100">Edit Profile</button>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-4">
                <div class="card card-custom">
                    <div class="card-header">Loan Information</div>
                    <div class="card-body">
                        <p><strong>Active Loans:</strong> 2</p>
                        <button class="btn btn-custom w-100">View Loans</button>
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
