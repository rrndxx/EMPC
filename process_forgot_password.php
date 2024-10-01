<?php
// Placeholder for DB connection
// include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($connection, $_POST['email']);

    // Check if the user exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $token = bin2hex(random_bytes(50));  // Generate reset token
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));  // Token expires in 1 hour

        // Update user record with reset token and expiry
        $update_query = "UPDATE users SET reset_token='$token', token_expiry='$expiry' WHERE email='$email'";
        mysqli_query($connection, $update_query);

        // Prepare the reset link (adjust the URL as per your domain)
        $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";

        // Send email (adjust this section to use your mail sending service)
        $to = $email;
        $subject = "Password Reset";
        $message = "Click on the link below to reset your password:\n\n$reset_link";
        $headers = "From: no-reply@yourwebsite.com";

        if (mail($to, $subject, $message, $headers)) {
            echo "A reset link has been sent to your email.";
        } else {
            echo "Failed to send reset link.";
        }
    } else {
        echo "No account found with that email.";
    }
}
?>
