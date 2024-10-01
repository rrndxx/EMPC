<?php
// Placeholder for database connection
// include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    
    // Check if the email exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        // Generate a secure token
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Store token and expiry in the database
        $query = "UPDATE users SET reset_token='$token', token_expiry='$expiry' WHERE email='$email'";
        mysqli_query($connection, $query);

        // Prepare the reset link
        $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";

        // Send reset email (Placeholder for actual mail function)
        $to = $email;
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: $reset_link";
        // mail($to, $subject, $message); // Uncomment to send the email

        echo "An email with the reset link has been sent to your email address.";
    } else {
        echo "No account found with that email.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f4f7;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .forgot-password-container {
            max-width: 400px;
            margin: auto;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
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

        .login-container {
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="forgot-password-container">
        <h2 class="mb-5 mt-2">Forgot Password</h2>
        <form method="POST" action="process_forgot_password.php">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                <label for="email">Enter your email</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-2">Send Reset Link</button>
        </form>

        <div class="footer login-container">
            <p class="text-muted">Remembered? <a href="login.php">Login</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
