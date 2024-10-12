<?php
session_start();
include 'connection.php'; // database connection

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = trim($_POST['email']);
    $profile_picture = $_FILES['profile_picture'];
    $errors = [];
    $success = "";

    // Validate username
    if (empty($username)) {
        $errors[] = "Username is required.";
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $errors[] = "Username can only contain letters and numbers.";
    }

    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
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

    // Validate profile picture
    if ($profile_picture['error'] === UPLOAD_ERR_OK) {
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_extension = strtolower(pathinfo($profile_picture['name'], PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            $errors[] = "Invalid file type for profile picture. Only JPG, JPEG, and PNG are allowed.";
        } elseif ($profile_picture['size'] > 2 * 1024 * 1024) { // 2MB limit
            $errors[] = "Profile picture must be less than 2MB.";
        }
    } else {
        $errors[] = "Error uploading file.";
    }

    // If no errors, proceed with account creation
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Prepare file for upload
        $upload_dir = 'uploads/';
        $file_name = uniqid() . '.' . $file_extension;
        $file_path = $upload_dir . $file_name;

        // Check for existing user
        $query = "SELECT * FROM users WHERE Username = :username OR Email = :email";
        $stmt = $con->prepare($query);
        $stmt->execute(['username' => $username, 'email' => $email]);

        if ($stmt->rowCount() > 0) {
            $errors[] = "Username or email already exists. Please choose another.";
        } else {
            // Insert user into database
            $insert_query = "INSERT INTO users (Username, Password, Email, profile_picture) VALUES (:username, :password, :email, :profile_picture)";
            $insert_stmt = $con->prepare($insert_query);

            if ($insert_stmt->execute(['username' => $username, 'password' => $hashed_password, 'email' => $email, 'profile_picture' => $file_path])) {
                // Move the uploaded file to the designated directory
                move_uploaded_file($profile_picture['tmp_name'], $file_path);
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
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f4f7;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            max-width: 400px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        h2 {
            text-align: center;
            color: #28a745;
        }

        .btn-primary {
            background-color: #28a745;
            border: none;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <nav class="top-0 p-3">

    </nav>

    <div class="container">
        <h2 class="mb-4">Member Sign Up</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger"><?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p><?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                <label for="username">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                    required>
                <label for="password">Password</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                    placeholder="Confirm Password" required>
                <label for="confirm_password">Confirm Password</label>
            </div>
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Profile Picture</label>
                <input type="file" class="form-control" id="profile_picture" name="profile_picture"
                    accept=".jpg,.jpeg,.png,.gif" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-2">Sign Up</button>
            <hr>
            <div class="footer">
                <p class="text-muted">Already have an account? <a href="login.php"
                        class="text-decoration-none">Login</a></p>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
