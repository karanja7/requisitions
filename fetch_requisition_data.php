<!--handle the in-stock products etc -->
<?php
// Connect to the database and fetch data
$servername = "localhost";
$username = "root";
$password = "Gathoni1.";
$dbname = "requisition_management";

$conn2 = new mysqli($servername, $username, $password, $dbname);

if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
}

$sql = "SELECT product_name, remaining_quantity, total_quantity FROM products";
$result = $conn2->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn2->close();

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($data);
