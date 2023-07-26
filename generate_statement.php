<?php
require('fpdf/fpdf.php');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "Gathoni1.";
$dbname = "requisition_management";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create PDF object
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Transaction Statement', 0, 1, 'C');

// Retrieve transaction data from the database
$transactionSql = "SELECT * FROM transactions";
$transactionResult = $conn->query($transactionSql);

if ($transactionResult->num_rows > 0) {
    while ($transaction = $transactionResult->fetch_assoc()) {
        // Output transaction details in the PDF
        $pdf->Cell(40, 10, $transaction['date'], 1);
        $pdf->Cell(40, 10, $transaction['transaction_type'], 1);
        $pdf->Cell(60, 10, $transaction['description'], 1);
        $pdf->Cell(30, 10, '$' . $transaction['amount'], 1);
        $pdf->Cell(40, 10, $transaction['department'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No transactions found.', 1, 1, 'C');
}

// Output the PDF
$pdf->Output();

// Close the database connection
$conn->close();
?>
