<?php
// Handle sign-out button click
if (isset($_POST['sign-out-btn'])) {
    // Destroy the session to log the user out
    session_destroy();
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

session_start();
include("connection.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartREQ | FAQs</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="home.css">
    <script src="loginscript.js"></script>
</head>
<body>
    <div class="header">
        <a href="home.php"><img src="images/smart REQ logo.png" alt="SmartREQ " class="logo"></a>
        <a href="home.php" ><ion-icon name="home-sharp"></ion-icon></a>
        <nav> 
            <a href="#" class="direct"></a>    
            <a href="#" class="direct"></a>   
            <a href="#" class="direct"></a>   

        </nav>
        
    </div>
    
    <div class="sidebar">
        <div class="user-info">
            <?php
            if (isset($_SESSION['username'])) {
                echo "You are logged in as: " .$_SESSION['username'];
            }
            ?>
        </div>
        <ul class="menu">
            <li>
                <a href="budgets.php"><ion-icon name="podium"></ion-icon> Budgets</a>
                <a href="requisitions.php"><ion-icon name="newspaper"></ion-icon></ion-icon> Requisitions</a>  
                <a href="myprofile.php"><ion-icon name="person-circle-sharp"></ion-icon> Profile</a>
                <a href="F.A.Qs.php"><ion-icon name="help-circle"></ion-icon> F.A.Qs</a>
                <a href="reports.php"><ion-icon name="settings"></ion-icon>Reports</a>
            </li>
        </ul>
        <form method="post">
            <button type="submit" id="sign-out-btn" name="sign-out-btn"> <ion-icon name="log-out"></ion-icon> Sign Out</button>
        </form>
    </div>
    
    <div class="main-content">
        <h1>F.A.Qs </h1>
        <div class="no-data-container">
            <p>No data for now</p>
            <img src="images/empty-box.png" alt="Empty Box">
            
        </div>

        <?php

class ProductChart
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "Gathoni1.";
    private $dbname = "requisition_management";
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function fetchProductData()
    {
        $sql = "SELECT product_name, total_quantity, remaining_quantity, reorder_level FROM products";
        $result = $this->conn->query($sql);

        $data = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function generateChart()
    {
        $productData = $this->fetchProductData();

        echo '<h2>Remaining Stock</h2>';
        echo '<div class="chart-container">';
        echo '<canvas id="productChart"></canvas>';
        echo '</div>';

        echo '<script>';
        echo 'document.addEventListener("DOMContentLoaded", function () {';
        echo 'fetch("fetch_product_data.php") // Replace with your PHP script to fetch data from the database';
        echo '.then(response => response.json())';
        echo '.then(data => renderChart(data));';
        echo '});';

        echo 'function renderChart(data) {';
        echo 'const labels = data.map(item => item.product_name);';
        echo 'const remainingQuantities = data.map(item => item.remaining_quantity);';
        echo 'const totalQuantities = data.map(item => item.total_quantity);';
        echo 'const reorderQuantities = data.map(item => item.reorder_quantity);';

        echo 'const ctx = document.getElementById("productChart").getContext("2d");';
        echo 'const myChart = new Chart(ctx, {';
        echo 'type: "bar",';
        echo 'data: {';
        echo 'labels: labels,';
        echo 'datasets: [';
        echo '{';
        echo 'label: "Total Quantity",';
        echo 'data: totalQuantities,';
        echo 'backgroundColor: "rgba(75, 192, 192, 0.6)",';
        echo 'borderColor: "rgba(75, 192, 192, 1)",';
        echo 'borderWidth: 1';
        echo '},';
        echo '{';
        echo 'label: "Remaining Quantity",';
        echo 'data: remainingQuantities,';
        echo 'backgroundColor: "rgba(255, 99, 132, 0.6)",';
        echo 'borderColor: "rgba(255, 99, 132, 1)",';
        echo 'borderWidth: 1';
        echo '},';
        echo '{';
        echo 'label: "Reorder Quantity",';
        echo 'data: reorderQuantities,';
        echo 'backgroundColor: "rgba(54, 162, 235, 0.6)",';
        echo 'borderColor: "rgba(54, 162, 235, 1)",';
        echo 'borderWidth: 1';
        echo '},';
        echo ']';
        echo '},';
        echo 'options: {';
        echo 'scales: {';
        echo 'y: {';
        echo 'beginAtZero: true,';
        echo 'grid: {';
        echo 'display: true,';
        echo '}';
        echo '},';
        echo 'x: {';
        echo 'grid: {';
        echo 'display: false,';
        echo '}';
        echo '},';
        echo '},';
        echo 'plugins: {';
        echo 'legend: {';
        echo 'display: true,';
        echo 'position: "top",';
        echo 'labels: {';
        echo 'font: {';
        echo 'size: 14';
        echo '}';
        echo '},';
        echo '},';
        echo 'title: {';
        echo 'display: false';
        echo '},';
        echo '},';
        echo '}';
        echo '});';
        echo '}';
        echo '</script>';
    }

    public function checkAndReorderProducts()
    {
        $productData = $this->fetchProductData();

        foreach ($productData as $product) {
            $totalQuantity = $product['total_quantity'];
            $remainingQuantity = $product['remaining_quantity'];
            $reorderQuantity = $product['reorder_level'];

            // Calculate 15% of the total quantity
            $threshold = 0.15 * $totalQuantity;

            if ($remainingQuantity <= $threshold) {
                // Calculate the quantity needed to stock up to 90%
                $quantityToOrder = 0.9 * $totalQuantity - $remainingQuantity;

                // Perform the reorder process here
                // For demonstration purposes, we will just print a message
                echo "Reordering " . $product['product_name'] . " - Quantity to order: " . $quantityToOrder . "\n";
                // You can also include code to place an order with the supplier for the required quantity
            }
        }
    }

    public function __destruct()
    {
        $this->conn->close();
    }
}

// Example usage
$productChart = new ProductChart();
$productChart->generateChart();
$productChart->checkAndReorderProducts();
?>

    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>