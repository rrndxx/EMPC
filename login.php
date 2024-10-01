<?php
session_start();

// Include database connection
// include 'db_connection.php';

// Maximum login attempts before lockout
$max_attempts = 5;
$lockout_time = 15 * 60; // 15 minutes

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
    // Validate CSRF token
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Track failed attempts per user
    if (!isset($_SESSION['failed_attempts'][$username])) {
        $_SESSION['failed_attempts'][$username] = ['count' => 0, 'lockout_time' => 0];
    }

    $user_attempts = $_SESSION['failed_attempts'][$username];

    // Lockout Check
    if ($user_attempts['count'] >= $max_attempts && time() - $user_attempts['lockout_time'] < $lockout_time) {
        $error = "Too many failed attempts. Please try again after " . ceil(($lockout_time - (time() - $user_attempts['lockout_time'])) / 60) . " minutes.";
    } else {
        // Use prepared statements for secure database queries
        if ($stmt = $connection->prepare("SELECT * FROM users WHERE username = ?")) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            // Verify password
            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(); // Secure session ID
                $_SESSION['user'] = $username;

                // Reset failed attempts after successful login
                $_SESSION['failed_attempts'][$username] = ['count' => 0, 'lockout_time' => 0];

                echo json_encode(['status' => 'success', 'redirect' => 'member_dashboard.php']);
                exit();
            } else {
                // Track failed attempts
                $_SESSION['failed_attempts'][$username]['count']++;
                $_SESSION['failed_attempts'][$username]['lockout_time'] = time();
                $error = "Invalid username or password!";
            }

            $stmt->close();
        }
    }
    // Return error as JSON for AJAX handling
    echo json_encode(['status' => 'error', 'message' => $error]);
    exit();
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
        body {
            background-color: #f1f4f7;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .login-container {
            max-width: 400px;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
            border: 2px solid white;
            position: relative;
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

        .forgot-password,
        .signup-container {
            text-align: center;
        }

        .admin-link {
            position: absolute;
            top: 10px;
            right: 20px;
        }

        .admin-link a {
            color: #6c757d;
            font-weight: 600;
            text-decoration: none;
        }

        .admin-link a:hover {
            color: #28a745;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 55%;
            cursor: pointer;
        }

        .spinner-border {
            display: none;
            width: 1.5rem;
            height: 1.5rem;
            vertical-align: middle;
        }

        /* Responsive design */
        @media (max-width: 600px) {
            .login-container {
                width: 100%;
                margin: 10px;
            }

            h2 {
                font-size: 1.5rem;
            }
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
        <h2 class="mb-5">Member Login</h2>

        <div id="error-message" class="alert alert-danger d-none"></div>

        <form method="POST" id="login-form">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <div class="form-floating mb-3 position-relative">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                <label for="username">Username</label>
            </div>

            <div class="form-floating mb-3 position-relative">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">Password</label>
                <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3" id="login-btn">
                Login
                <span class="spinner-border" role="status" aria-hidden="true" id="loading-spinner"></span>
            </button>

            <div class="forgot-password">
                <a href="#" class="text-muted">Forgot Password?</a>
            </div>

            <div class="signup-container">
                <p class="text-muted">Don't have an account yet? <a href="register.php">Signup</a>.</p>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            document.getElementById('login-btn').disabled = true;
            document.getElementById('loading-spinner').style.display = 'inline-block';

            fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('login-btn').disabled = false;
                    document.getElementById('loading-spinner').style.display = 'none';

                    if (data.status === 'error') {
                        const errorMessage = document.getElementById('error-message');
                        errorMessage.innerHTML = data.message;
                        errorMessage.classList.remove('d-none');
                    } else if (data.status === 'success') {
                        window.location.href = data.redirect;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('login-btn').disabled = false;
                    document.getElementById('loading-spinner').style.display = 'none';
                });
        });
    </script>
</body>

</html>
