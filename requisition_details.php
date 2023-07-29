<?php
session_start();
include("connection.php");

// Retrieve the requisition number from the query parameter
$requisitionNumber = $_GET['requisition_number'];

// Retrieve the requisition details from the database based on the requisition number
$sql = "SELECT * FROM requisitions WHERE requisition_number = '$requisitionNumber'";
$result = $conn2->query($sql);

if ($result->num_rows > 0) {
    // Fetch the requisition details
    $requisition = $result->fetch_assoc();

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the "Approve" button is clicked
        if (isset($_POST['approve-btn'])) {
            // Update the approval status to "Approved" in the database
            $approvalStatus = "Approved";
            $sql = "UPDATE requisitions SET approval_status = '$approvalStatus' WHERE requisition_number = '$requisitionNumber'";
            $conn2->query($sql);
        }

        // Check if the "Deny" button is clicked
        elseif (isset($_POST['deny-btn'])) {
            // Update the approval status to "Denied" in the database
            $approvalStatus = "Denied";
            $sql = "UPDATE requisitions SET approval_status = '$approvalStatus' WHERE requisition_number = '$requisitionNumber'";
            $conn2->query($sql);
        }

        // Redirect back to the requisition_details.php page to reflect the updated status
        header("Location: requisition_details.php?requisition_number=$requisitionNumber");
        exit();
    }

} else {
    echo "No Requisition Details found.";
}
// ... Your existing code for approving the requisition ...

// After approving the requisition, update the budgets table
$updateBudgetSql = "UPDATE budgets SET spending_to_date = spending_to_date + ?, remaining_balance = remaining_balance - ? WHERE department = ?";
$updateBudgetStmt = $conn2->prepare($updateBudgetSql);
$updateBudgetStmt->bind_param("dds", $amount, $amount, $department);

// Set the department and amount based on the approved requisition details
$department = $requisition['department'];
//$amount = $requisition['amount'];

$updateBudgetStmt->execute();
$updateBudgetStmt->close();

// Close the database connection
$conn2->close();
?>

<!-- HTML and CSS for displaying the requisition details and the buttons -->
<!DOCTYPE html>
<html>
<head>
    <title>Requisition Details</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>
    <h1>Requisition Details</h1>
    <?php if (isset($requisition)): ?>
        <p><strong>Requisition Number:</strong> <?php echo $requisition['requisition_number']; ?></p>
        <p><strong>Requester Name:</strong> <?php echo $requisition['requester_name']; ?></p>
        <p><strong>Product Details:</strong> <?php echo $requisition['product_details']; ?></p>
        <p><strong>Quantity:</strong> <?php echo $requisition['quantity']; ?></p>
        <p><strong>Price:</strong> <?php echo $requisition['price']; ?></p>
        <p><strong>Delivery Date:</strong> <?php echo $requisition['delivery_date']; ?></p>
        <p><strong>Department:</strong> <?php echo $requisition['department']; ?></p>
        <p><strong>Additional Info:</strong> <?php echo $requisition['additional_info']; ?></p>
        <p><strong>Approval Status:</strong> <?php echo $requisition['approval_status']; ?></p>

        <!-- Add buttons for Approve and Deny -->
        <form method="post">
            <input type="hidden" name="requisition_number" value="<?php echo $requisition['requisition_number']; ?>">
            <button type="submit" name="approve-btn">Approve</button>
            <button type="submit" name="deny-btn">Deny</button>
        </form>
    <?php endif; ?>
</body>
</html>

