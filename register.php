<?php
// Placeholder: Include database connection file here
// include 'db_connection.php';

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $errors = [];

    // Validate username
    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    // Validate passwords
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match!";
    }

    // If no errors, proceed with account creation
    if (empty($errors)) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Placeholder for actual user creation logic
        // Insert user into database (pseudo code)
        /*
        $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        $result = mysqli_query($connection, $query);
        if ($result) {
            $success = "Account created successfully!";
        } else {
            $errors[] = "Error creating account. Please try again.";
        }
        */

        // For demonstration, we'll assume account creation is successful
        $success = "Account created successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f1f4f7;
        }

        .register-container {
            max-width: 400px;
            margin: auto;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }

        h2 {
            text-align: center;
            color: #28a745;
            font-weight: 600;
        }

        .alert {
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
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
        }
    </style>
</head>

<body>

    <div class="register-container">
        <h2 class="mb-5 mt-2">Create an Account</h2>

        <!-- Display Errors -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Display Success Message -->
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
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
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                <label for="floatingPassword">Confirm Password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">Register</button>

            <div class="footer">
                <p class="text-muted">Already have an account? <a href="login.php">Login here</a>.</p>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
