<?php
$servername = "localhost";
$username = "root";
$password = "Gathoni1.";
$dbname = "login_db";

$conn1 = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn1->connect_error) {
    die("Connection failed: " . $conn1->connect_error);
}
?>
<?php
$servername = "localhost";
$username = "root";
$password = "Gathoni1.";    
$dbname = "requisition_management";

$conn2 = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
}
?>

