<?php
session_start();

// Placeholder: Include your database connection file here
// include 'db_connection.php'; // Ensure this file establishes a connection to your database

// Handle form submission for login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = $_POST['password'];

    // Fetch the user from the database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);

    // Check if the user exists and verify the password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $username;
        header("Location: member_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Background Image for Entire Body */
        body {
            /* background-image: url('img/logo.png'); */
            /* background-size: cover; */
            /* background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed; */
            background-color: #f1f4f7;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.9);
            /* Semi-transparent background */
            border-radius: 10px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
            border: white 2px solid;
            opacity: 90%;
        }

        h2 {
            text-align: center;
            color: #28a745;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #28a745;
            border: none;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .text-muted {
            color: #6c757d;
            text-decoration: none;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }

        .signup-container {
            margin-top: 30px;
            text-align: center;
        }

        nav {
            padding: 10px;
            position: relative;
            margin-bottom: -50px;
        }

        .admin-link {
            float: right;
            font-size: 14px;
            position: absolute;
            top: 0;
            right: 20px;
            margin-top: 20px;
        }

        .admin-link a {
            text-decoration: none;
            color: #6c757d;
            font-weight: 600;
        }

        .admin-link a:hover {
            color: #28a745;
        }
    </style>
</head>

<body>
    <nav>
        <div class="admin-link">
            <a href="admin_dashboard.php">Admin Login</a>
        </div>
    </nav>
    <div class="login-container">
        <h2 class="mb-5 mt-2">Member Login</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-2">Login</button>

            <div class="footer forgot-password">
                <a href="#" class="text-muted">Forgot Password?</a>
            </div>

            <div class="footer signup-container">
                <p class="text-muted">Don't have an account yet? <a href="register.php">Signup</a>.</p>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
