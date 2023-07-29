<?php
// Retrieve the requisition number from the query parameter
$requisitionNumber = $_GET['requisition_number'];

// Check if requisition number is provided
if (empty($requisitionNumber)) {
    header("Location: requisition_list.php?error=Requisition number not specified.");
    exit;
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "Gathoni1.";
$dbname = "requisition_management";

// Create a database connection
$conn2 = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
}

// Retrieve the requisition details from the database based on the requisition number
$sql = "SELECT * FROM requisitions WHERE requisition_number = '$requisitionNumber'";
$result = $conn2->query($sql);

if ($result->num_rows > 0) {
    // Fetch the requisition details
    $requisition = $result->fetch_assoc();
} else {
    echo "Requisition not found.";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $requesterName = $_POST['requesterName'];
    $productDetails = $_POST['productDetails'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $deliveryDate = $_POST['deliveryDate'];
    $department = $_POST['department'];
    $additionalInfo = $_POST['additionalInfo'];

    // Update the requisition details in the database
    $sql = "UPDATE requisitions SET requester_name = ?, product_details = ?, quantity = ?, price = ?, delivery_date = ?, department = ?, additional_info = ? WHERE requisition_number = ?";
    $stmt = $conn2->prepare($sql);
    $stmt->bind_param("ssidsiss", $requesterName, $productDetails, $quantity, $price, $deliveryDate, $department, $additionalInfo, $requisitionNumber);

    if ($stmt->execute()) {
        echo "Requisition updated successfully.";
    } else {
        echo "Error updating requisition: " . $stmt->error;
    }

    $stmt->close();
}

$conn2->close();
?>

<!-- HTML and form for editing the requisition details -->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Requisition</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="home.css">
</head>
<body>
    <div class="reqpageheader">
        <a href="home.php"><img src="images/smart REQ logo.png" alt="SmartREQ " class="logo"></a>
        <a href="home.php" ><ion-icon name="home-sharp"></ion-icon></a>
        <nav>  

        </nav>
    </div>

    <h1>Edit Requisition</h1>
    <form id="edit-requisition" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="requisition_number" value="<?php echo htmlspecialchars($requisition['requisition_number']); ?>">

        <div>
            <label for="requester-name" class="req-label">Requester Name:</label>
            <input type="text" id="requester-name" name="requesterName" class="req-input" value="<?php echo htmlspecialchars($requisition['requester_name']); ?>" required>
        </div>
        <div>
            <label for="product-details" class="req-label">Product Details:</label>
            <input type="text" id="product-details" name="productDetails" class="req-input" value="<?php echo htmlspecialchars($requisition['product_details']); ?>" required>
        </div>
        <div>
            <label for="quantity" class="req-label">Quantity:</label>
            <input type="number" id="quantity" name="quantity" class="req-input" value="<?php echo htmlspecialchars($requisition['quantity']); ?>" required>
        </div>
        <div>
            <label for="price" class="req-label">Price:</label>
            <input type="number" id="price" name="price" class="req-input" value="<?php echo htmlspecialchars($requisition['price']); ?>" required>
        </div>
        <div>
            <label for="delivery-date" class="req-label">Delivery Date:</label>
            <input type="date" id="delivery-date" name="deliveryDate" class="req-input" value="<?php echo htmlspecialchars($requisition['delivery_date']); ?>" required>
        </div>
        <div>
            <label for="department" class="req-label">Department:</label>
            <input type="text" id="department" name="department" class="req-input" value="<?php echo htmlspecialchars($requisition['department']); ?>" required>
        </div>
        <div> 
            <label for="additional-info" class="req-label">Additional Information:</label>
            <textarea id="additional-info" name="additionalInfo"><?php echo htmlspecialchars($requisition['additional_info']); ?></textarea>
        </div>
        <button type="submit">Update</button>
    </form>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

