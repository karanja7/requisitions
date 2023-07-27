<?php
// Handle sign-out button click
if (isset($_POST['sign-out-btn'])) {
    // Destroy the session to log the user out
    session_destroy();
    // Redirect to the login page
    header("Location: login.php");
    exit();

    $sql = "SELECT * FROM budgets";
    $result = $conn2->query($sql);
} 
session_start();
include("connection.php");
// Create the 'transactions' table if it doesn't exist
$createTransactionsTableSql = "CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    transaction_type VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    department VARCHAR(100) NOT NULL
)";

if ($conn2->query($createTransactionsTableSql) === TRUE) {
    echo "";
} else {
    echo "Error creating table: " . $conn2->error;
}


        // Handle the form submission for inserting budget data
if (isset($_POST['insert_budget'])) {
    $department = $_POST['department'];
    $allocatedBudget = $_POST['allocated_budget'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $description = $_POST['description'];

    // Insert the budget data into the budgets table
    $insertBudgetSql = "INSERT INTO budgets (department, allocated_budget, spending_to_date, remaining_balance, start_date, end_date, description) VALUES (?, ?, 0, ?, ?, ?, ?)";
    $insertBudgetStmt = $conn2->prepare($insertBudgetSql);
    // Set the remaining balance to the allocated budget initially
    $remainingBalance = $allocatedBudget;
    $insertBudgetStmt->bind_param("sddsss", $department, $allocatedBudget, $remainingBalance, $startDate, $endDate, $description);
    if ($insertBudgetStmt->execute()) {
        echo "Budget inserted successfully.";
    } else {
        echo "Error inserting budget: " . $insertBudgetStmt->error;
    }
    $insertBudgetStmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REQUISMART | Budgets</title>
    <link rel="stylesheet" type="text/css" href="home.css">
    <script src="script.js"></script>
    
</head>
<body>
    <div class="header">
        <a href="home.php"><img src="images/SOLNs.png" alt="REQUISMART " class="logo"></a>
        <a href="home.php" ><ion-icon name="home-sharp"></ion-icon></a>
        <nav> 
        <a href="#main" class="direct"></a>
        <a href="#help-support" class="direct"></a>  
        </nav>
    </div>
    
    <div class="sidebar">
        <div class="user-info">
            <?php
            if (isset($_SESSION['username'])) {
                echo "You are logged in as: " . $_SESSION['username'];
            }
            ?>
        </div>
        <ul class="menu">
            <li>
                <a href="budgets.php"><ion-icon name="podium"></ion-icon> Budgets</a>
                <a href="requisitions.php"><ion-icon name="newspaper"></ion-icon></ion-icon> Requisitions</a>  
                <a href="myprofile.php"><ion-icon name="person-circle-sharp"></ion-icon> Profile</a>
                <a href="F.A.Qs.php"><ion-icon name="help-circle"></ion-icon> F.A.Qs</a>
                <a href="reports.php"><ion-icon name="settings"></ion-icon> Reports</a>
            </li>
        </ul>
            <form method="post">
                <button type="submit" id="sign-out-btn" name="sign-out-btn"> <ion-icon name="log-out"></ion-icon> Sign Out</button>
            </form>  
     </div>
    
    <div class="main-content">
        <!-- Budgets content goes here -->
        <h1>Budgets</h1>

        <div class="tabular--wrapper">
    <h3 class="main-title">Transaction History</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Transaction Type</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Department</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve transaction history from the database
                $transactionSql = "SELECT * FROM transactions";
                $transactionResult = $conn2->query($transactionSql);

                if ($transactionResult->num_rows > 0) {
                    while ($transaction = $transactionResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $transaction['date'] . "</td>";
                        echo "<td>" . $transaction['transaction_type'] . "</td>";
                        echo "<td>" . $transaction['description'] . "</td>";
                        echo "<td>$" . $transaction['amount'] . "</td>";
                        echo "<td>" . $transaction['department'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No transactions found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


 <!-- Add a form for manual budget insertion -->
<form method="post">
    <label for="department" class="req-label">Department:</label>
    <input type="text" name="department" class="req-input" required>

    <label for="allocated_budget" class="req-label">Allocated Budget:</label>
    <input type="number" step="0.01" name="allocated_budget" class="req-input" required>

    <label for="start_date" class="req-label">Start Date:</label>
    <input type="date" name="start_date" class="req-input" required>

    <label for="end_date" class="req-label">End Date:</label>
    <input type="date" name="end_date" class="req-input" required>

    <label for="description" class="req-label">Description:</label>
    <textarea name="description" class="req-input" rows="3"></textarea>

    <button type="submit" name="insert_budget">Insert Budget</button>
</form>
    <div class="budget-item">
        <div class="budget-card">
            <div class="budget-title">PRODUCTION Budget</div>
            <div class="budget-amount">Total Amount: $10,000</div>
            <div class="budget-spending">Spending to Date: $4,500</div>
            <div class="budget-remaining">Remaining Balance: $5,500</div>
            <div class="budget-details">
                <p>Description: This budget is allocated for marketing campaigns.</p>
                <p>Start Date: January 1, 2023</p>
                <p>End Date: December 31, 2023</p>
            </div>
        </div>
    </div>

    <div class="budget-item">
        <div class="budget-card">
            <div class="budget-title">IT & TECH Budget</div>
            <div class="budget-amount">Total Amount: $20,000</div>
            <div class="budget-spending">Spending to Date: $15,000</div>
            <div class="budget-remaining">Remaining Balance: $5,000</div>
            <div class="budget-details">
                <p>Description: This budget is allocated for IT infrastructure and software.</p>
                <p>Start Date: January 1, 2023</p>
                <p>End Date: December 31, 2023</p>
            </div>
        </div>
    </div>
    <div class="tabular--wrapper">
                <h3 class="main-title">Download Statement</h3>
        <div class="table-container">
            <a href="generate_statement.php" target="_blank">Download Statement</a>
        </div>
    </div>
</div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
