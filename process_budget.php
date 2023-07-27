<?php
// process_budget.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $date = $_POST['date'];
    $transactionType = $_POST['transaction_type'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $department = $_POST['department'];

    // Insert record into budgets table
    $sql = "INSERT INTO budgets (department, budget_amount, spending_to_date) 
            VALUES ('$department', $amount, 0) 
            ON DUPLICATE KEY UPDATE budget_amount = $amount";
    $conn2->query($sql);

    // Insert record into budget_transactions table
    $sql = "INSERT INTO budget_transactions (date, transaction_type, description, amount, department) 
            VALUES ('$date', '$transactionType', '$description', $amount, '$department')";
    $conn2->query($sql);

    // Redirect back to budgets.php
    header("Location: budgets.php");
    exit();
}
?>
