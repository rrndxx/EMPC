<?php
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Regenerate session ID for security
session_regenerate_id(true);

// Sample user data (replace with actual data from a database)
$username = $_SESSION['user'];
$email = "user@example.com";  // Fetch from the database
$phone = "(123) 456-7890";    // Fetch from the database
$message = '';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['newUsername'])) {
        $newUsername = htmlspecialchars(trim($_POST['newUsername']));
        // Update username in the database here
        $_SESSION['user'] = $newUsername; // Update session variable
        $message = "Username updated successfully!";
    }

    if (isset($_POST['newEmail'])) {
        $newEmail = htmlspecialchars(trim($_POST['newEmail']));
        // Update email in the database here
        $message = "Email updated successfully!";
    }

    if (isset($_POST['newPhone'])) {
        $newPhone = htmlspecialchars(trim($_POST['newPhone']));
        // Update phone in the database here
        $message = "Phone number updated successfully!";
    }

    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == UPLOAD_ERR_OK) {
        $targetDir = 'uploads/';
        $targetFile = $targetDir . basename($_FILES['profilePicture']['name']);
        // Ensure only images are uploaded
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetFile)) {
                $_SESSION['profpic'] = $targetFile; // Update session variable
                $message = "Profile picture updated successfully!";
            } else {
                $message = "Error uploading the file.";
            }
        } else {
            $message = "Only image files are allowed.";
        }
    }
}

// Get current page for active class
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Member Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f1f4f7;
        }

        .navbar {
            background-color: #28a745;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            color: white !important;
        }

        .nav-item {
            margin-left: 10px;
        }

        .card {
            margin-top: 20px;
            border: none;
            border-radius: 8px;
        }

        .card-header {
            background-color: #218838;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .profile-img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .alert {
            display: none;
        }

        .profile-section {
            text-align: center;
        }

        .change-pic-btn {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand text-white ms-4">EMPC Cooperative</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : ''; ?>"
                            href="dashboard.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'member_profile.php') ? 'active' : ''; ?>"
                            href="member_profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'loans.php') ? 'active' : ''; ?>" href="loans.php">My
                            Loans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'transactions.php') ? 'active' : ''; ?>"
                            href="transactions.php">Transaction History</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <?php if ($message): ?>
            <div class="alert alert-info text-center" role="alert" id="successMessage">
                <h4 class="mb-0"><?= htmlspecialchars($message); ?></h4>
            </div>
        <?php endif; ?>

        <div class="row profile-section">
            <div class="col-lg-12 text-center mb-4">
                <img src="<?= isset($_SESSION['profpic']) ? htmlspecialchars($_SESSION['profpic']) : 'default-profile.png'; ?>"
                    alt="Profile Picture" class="profile-img">
                <button class="btn btn-secondary change-pic-btn" data-bs-toggle="modal"
                    data-bs-target="#updateProfilePictureModal">Change Profile Picture</button>
            </div>
        </div>

        <div class="card profile-info">
            <div class="card-header">
                <h4 class="mb-0">Profile Information</h4>
            </div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <span class="input-group-text">Username</span>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($username); ?>" disabled>
                    <button class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#updateUsernameModal">Edit</button>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Email</span>
                    <input type="email" class="form-control" value="<?= htmlspecialchars($email); ?>" disabled>
                    <button class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#updateEmailModal">Edit</button>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Phone</span>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($phone); ?>" disabled>
                    <button class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#updatePhoneModal">Edit</button>
                </div>
            </div>
        </div>

        <!-- Modals for updating profile information -->
        <!-- Profile Picture Modal -->
        <div class="modal fade" id="updateProfilePictureModal" tabindex="-1" aria-labelledby="updateProfilePictureLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateProfilePictureLabel">Change Profile Picture</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="profilePicture" class="form-label">Upload New Picture</label>
                                <input type="file" class="form-control" id="profilePicture" name="profilePicture"
                                    accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-success">Update Picture</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Username Update Modal -->
        <div class="modal fade" id="updateUsernameModal" tabindex="-1" aria-labelledby="updateUsernameLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateUsernameLabel">Update Username</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="newUsername" class="form-label">New Username</label>
                                <input type="text" class="form-control" id="newUsername" name="newUsername" required>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Update Modal -->
        <div class="modal fade" id="updateEmailModal" tabindex="-1" aria-labelledby="updateEmailLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateEmailLabel">Update Email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="newEmail" class="form-label">New Email</label>
                                <input type="email" class="form-control" id="newEmail" name="newEmail" required>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Phone Update Modal -->
        <div class="modal fade" id="updatePhoneModal" tabindex="-1" aria-labelledby="updatePhoneLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updatePhoneLabel">Update Phone Number</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="newPhone" class="form-label">New Phone Number</label>
                                <input type="text" class="form-control" id="newPhone" name="newPhone" required>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show success message if it exists
        const successMessage = "<?php echo addslashes($message); ?>";
        if (successMessage) {
            const alertBox = document.getElementById("successMessage");
            alertBox.style.display = "block"; // Show the alert
            setTimeout(() => {
                alertBox.style.display = "none"; // Hide after 3 seconds
            }, 3000);
        }
    </script>
</body>

</html>
