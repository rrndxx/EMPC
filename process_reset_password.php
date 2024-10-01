<?php
// Placeholder for DB connection
// include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_GET['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Update user password if token is valid and not expired
        $query = "UPDATE users SET password='$hashed_password', reset_token=NULL, token_expiry=NULL WHERE reset_token='$token' AND token_expiry > NOW()";
        $result = mysqli_query($connection, $query);

        if (mysqli_affected_rows($connection) > 0) {
            echo "Password reset successfully!";
        } else {
            echo "Invalid or expired token!";
        }
    } else {
        echo "Passwords do not match!";
    }
}
?>
