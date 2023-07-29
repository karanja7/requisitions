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
function fetchRemainingQuantities()
{
    global $conn2; // Make the $conn2 variable accessible inside the function
    $query = "SELECT product_name,  total_quantity, remaining_quantity FROM products";
    $result = $conn2->query($query);

    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

$data = fetchRemainingQuantities();

// Close the database connection
$conn2->close();

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>