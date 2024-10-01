<?php
// Placeholder for DB connection
// include 'db_connection.php';

// Get the token from the URL
$token = $_GET['token'] ?? '';

if (!$token) {
    die("Invalid or missing token.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Reset Password</h2>
        <form method="POST" action="process_reset_password.php?token=<?php echo $token; ?>">
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" placeholder="New Password" required>
                <label for="password">New Password</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
                <label for="confirm_password">Confirm Password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>
    </div>
</body>
</html>
