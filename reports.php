<?php
session_start();
include("connection.php");
require('fpdf186/fpdf.php'); // Include the FPDF library

// Handle sign-out button click
if (isset($_POST['sign-out-btn'])) {
    // Destroy the session to log the user out
    session_destroy();
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Function to generate and download the PDF report for budgets

function generateBudgetsReport($conn2) {
    // Fetch budget details from the database
    $sql = "SELECT * FROM budgets";
    $result = $conn2->query($sql);

    if ($result->num_rows > 0) {
        // Create the PDF document
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Budgets Report');

        // Add content (budget details) to the PDF
        while ($row = $result->fetch_assoc()) {
            $pdf->Ln();
            $pdf->Cell(40, 10, 'Budget Name: ' . $row['department']);
            $pdf->Cell(40, 10, 'Amount: ' . $row['amount']);
            // Add more fields from the budget table as needed
        }

        // Output the PDF document to the user's browser for download
        $pdf->Output();
    } else {
        echo "No budgets found.";
    }
}

// Function to generate and download the PDF report for requisitions
function generateRequisitionsReport($conn2) {
    // Fetch requisitions details from the database
    $sql = "SELECT * FROM requisitions";
    $result = $conn2->query($sql);

    if ($result->num_rows > 0) {
        // Create the PDF document
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Requisitions Report');

        // Add content (requisitions details) to the PDF
        while ($row = $result->fetch_assoc()) {
            $pdf->Ln();
            $pdf->Cell(40, 10, 'Requisition Number: ' . $row['requisition_number']);
            $pdf->Cell(40, 10, 'Requester Name: ' . $row['requester_name']);
            $pdf->Cell(40, 10, 'Product Details: ' . $row['product_details']);
            // Add more fields from the requisitions table as needed
        }

        // Output the PDF document to the user's browser for download
        $pdf->Output();
    } else {
        echo "No requisitions found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['generate-budgets-report-btn'])) {
        generateBudgetsReport($conn2);
    } elseif (isset($_POST['generate-requisitions-report-btn'])) {
        generateRequisitionsReport($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REQUISMART | Reports</title>
    <link rel="stylesheet" type="text/css" href="home.css">
    <script src="loginscript.js"></script>
</head>
<body>
    <div class="header">
        <a href="home.php"><img src="images/SOLNs.png" alt="REQUISMART " class="logo"></a>
        <a href="home.php" ><ion-icon name="home-sharp"></ion-icon></a>
        <nav>    

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
        <h1>Reports </h1>
        <!--main content -->
        <div>
            <h2>Generate Budgets Report</h2>
            <form method="post">
                <button type="submit" name="generate-budgets-report-btn">Download Budgets Report</button>
            </form>
        </div>
        <div>
            <h2>Generate Requisitions Report</h2>
            <form method="post">
                <button type="submit" name="generate-requisitions-report">Download Requisitions Report</button>
            </form>
        </div>
        
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

