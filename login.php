<?php
session_start();
include 'connection.php'; // database connection

// Maximum login attempts and lockout duration
$max_attempts = 5;
$lockout_time = 5 * 60; // 10 minutes

// Track login attempts by username
if (!isset($_SESSION['failed_attempts'])) {
    $_SESSION['failed_attempts'] = [];
}

// CSRF Token Generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle form submission for login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json'); // For AJAX response

    // Validate CSRF token
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token']);
        exit();
    }

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Track failed attempts per user
    if (!isset($_SESSION['failed_attempts'][$username])) {
        $_SESSION['failed_attempts'][$username] = ['count' => 0, 'lockout_time' => 0];
    }

    $user_attempts = $_SESSION['failed_attempts'][$username];

    // Lockout check
    if ($user_attempts['count'] >= $max_attempts && time() - $user_attempts['lockout_time'] < $lockout_time) {
        $remaining_time = ceil(($lockout_time - (time() - $user_attempts['lockout_time'])) / 60);
        echo json_encode(['status' => 'error', 'message' => "Too many failed attempts. Please try again after $remaining_time minutes."]);
        exit();
    } else {
        // Check username and password
        $stmt = $con->prepare("SELECT * FROM users WHERE Username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Verify password and reset attempts on success
        if ($user && password_verify($password, $user->Password)) {
            session_regenerate_id(); // Secure session ID
            $_SESSION['user'] = $username;

            // Reset failed attempts after successful login
            $_SESSION['failed_attempts'][$username] = ['count' => 0, 'lockout_time' => 0];

            echo json_encode(['status' => 'success', 'redirect' => 'member_dashboard.php']);
            exit();
        } else {
            // Track failed attempts on failure
            $_SESSION['failed_attempts'][$username]['count']++;
            $_SESSION['failed_attempts'][$username]['lockout_time'] = time();
            echo json_encode(['status' => 'error', 'message' => 'Invalid username or password!']);
            exit();
        }
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

        .btn-custom:hover {
            color: white;
            background-color: #218838;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <nav class="position-absolute top-0 end-0 p-3">
        <a href="admin_login.php" class="btn btn-custom btn-outline-dark fw-bold">Admin</a>
    </nav>

    <div class="container">
        <h2 class="mb-4">Member Login</h2>
        <div id="error-message" class="alert alert-danger d-none"></div>

        <form id="login-form">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                <label for="username">Username</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                    required>
                <label for="password">Password</label>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">
                Login
            </button>

            <div class="text-end mb-3">
                <a href="#" class="text-decoration-none">Forgot Password?</a>
            </div>

            <hr>

            <div class="text-center">
                <p class="text-muted">Don't have an account yet? <a href="signup.php"
                        class="text-decoration-none">Signup</a></p>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("login-form").addEventListener("submit", function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch("", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        window.location.href = data.redirect;
                    } else {
                        const errorMessage = document.getElementById("error-message");
                        errorMessage.textContent = data.message;
                        errorMessage.classList.remove("d-none");
                    }
                })
                .catch(error => console.error("Error:", error));
        });
    </script>
</body>

</html>
