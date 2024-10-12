<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Regenerate session ID for security
session_regenerate_id(true);

$username = $_SESSION['user'];
$current_page = basename($_SERVER['PHP_SELF']);

// Sample data for loans and transactions (replace with actual database queries)
$loans = [
    ['amount' => 1500, 'due_date' => '2024-10-15', 'status' => 'Pending'],
    ['amount' => 2000, 'due_date' => '2024-11-05', 'status' => 'Active'],
];

$transactions = [
    ['date' => '2024-10-01', 'description' => 'Deposit', 'amount' => 500],
    ['date' => '2024-10-10', 'description' => 'Loan Payment', 'amount' => -200],
];

// Additional data for analytics
$totalLoanAmount = array_sum(array_column($loans, 'amount'));
$totalTransactions = array_sum(array_column($transactions, 'amount'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
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

        .navbar-nav .nav-link.active {
            font-weight: bold;
        }

        .card {
            transition: box-shadow 0.3s;
        }

        .card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
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

        .section-title {
            background-color: #218838;
            color: white;
        }

        .table-responsive {
            max-height: 300px;
            overflow-y: auto;
            overflow-x: auto;
        }

        .table thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 10;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .icon {
            margin-right: 5px;
        }

        @media (max-width: 576px) {
            h4 {
                font-size: 1.25rem;
            }

            .btn {
                width: 100%;
                margin: 5px 0;
            }
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
                        <a class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>"
                            href="dashboard.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'profile.php') ? 'active' : ''; ?>"
                            href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'loans.php') ? 'active' : ''; ?>"
                            href="loans.php">My Loans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'transactions.php') ? 'active' : ''; ?>"
                            href="transactions.php">Transaction History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>"
                            href="settings.php">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <div class="alert alert-info" role="alert">
            <h2 class="mb-0">Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        </div>

        <hr>

        <div class="row mb-4">
            <div class="col-lg-6 col-md-12 mb-2">
                <div class="card h-100">
                    <div class="card-header">
                        <h4 class="mb-0">User Profile</h4>
                    </div>
                    <div class="card-body">
                        <p><i class="fas fa-user icon"></i><strong>Username:</strong>
                            <?php echo htmlspecialchars($username); ?></p>
                        <p><i class="fas fa-envelope icon"></i><strong>Email:</strong> user@example.com</p>
                        <p><i class="fas fa-phone icon"></i><strong>Phone:</strong> (123) 456-7890</p>
                        <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 mb-2">
                <div class="card h-100">
                    <div class="card-header">
                        <h4 class="mb-0">Quick Actions</h4>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <a href="apply_loan.php" class="btn btn-success mb-2 w-75">
                            <i class="fas fa-plus-circle icon"></i> Apply for a Loan
                        </a>
                        <a href="view_loans.php" class="btn btn-info w-75">
                            <i class="fas fa-eye icon"></i> View All Loans
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-lg-12">
                <div class="card h-100">
                    <div class="card-header">
                        <h4 class="mb-0">Financial Overview</h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="row">
                            <?php
                            $financials = [
                                'Total Loans' => $totalLoanAmount,
                                'Total Transactions' => abs($totalTransactions),
                            ];
                            foreach ($financials as $title => $amount): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-3 bg-light">
                                        <h5><?php echo $title; ?></h5>
                                        <p class="h2 mb-0">$<?php echo number_format($amount, 2); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <hr>
        <br>

        <h4 class="section-title text-center p-3">Loan Details</h4>
        <br>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Loan Amount</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($loans as $loan): ?>
                        <tr>
                            <td>$<?php echo number_format($loan['amount'], 2); ?></td>
                            <td><?php echo $loan['due_date']; ?></td>
                            <td><?php echo $loan['status']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="text-end mt-4">
            <a href="view_full_loans.php" class="btn btn-primary">View All Loans</a>
        </div>

        <hr>
        <br>

        <h4 class="section-title text-center p-3">Transaction History</h4>
        <br>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td><?php echo $transaction['date']; ?></td>
                            <td><?php echo $transaction['description']; ?></td>
                            <td><?php echo ($transaction['amount'] < 0 ? '-' : '') . '$' . number_format(abs($transaction['amount']), 2); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="text-end mt-4">
            <a href="view_full_transactions.php" class="btn btn-primary">View All Transactions</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
