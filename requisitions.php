<?php
include("connection.php");

session_start();

// Handle sign-out button click
if (isset($_POST['sign-out-btn'])) {
    // Destroy the session to log the user out
    session_destroy();
    // Redirect to the login page
    header("Location: login.php");
    exit();
}
  
// Initialize the success and error message variables
$successMessage = "";
$errorMessage = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate and sanitize form data
  $requesterName = $_POST['requesterName'];
  $productDetails = $_POST['productDetails'];
  $quantity = $_POST['quantity'];
  $supplier = $_POST['supplier'];
  $price = $_POST['price'];
  $deliveryDate = $_POST['deliveryDate'];
  $department = $_POST['department'];
  $additionalInfo = $_POST['additionalInfo'];
  //$requisitionNumber = generateRequisitionNumber();

  // Prepare the SQL statement with placeholders
  $stmt = $conn2->prepare("INSERT INTO requisitions (requester_name, product_details, quantity, supplier, price, delivery_date, department, additional_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind the values to the prepared statement
    $stmt->bind_param("ssssdsss", $requesterName, $productDetails, $quantity, $supplier, $price, $deliveryDate, $department, $additionalInfo);


  // Execute the prepared statement
  if ($stmt->execute()) {
    $successMessage = "Requisition submitted successfully!";
    // Retrieve the approval status for the specific requisition
    $requisitionNumber = $conn2->insert_id;
    $approvalStatus = getApprovalStatus($requisitionNumber);


      // Redirect to the requisition_list.php page
      header("Location: requisition_list.php");
      exit();
  } else {
    $errorMessage = "Error submitting requisition. Please try again.";
      echo "Error: " . $stmt->error;
  }
//close statement and database connection
  $stmt->close();
}

// Function to get the approval status for a given requisition number
function getApprovalStatus($requisitionNumber) {
  global $conn2;
  $sql = "SELECT approval_status FROM requisitions WHERE requisition_number = ?";
  $stmt = $conn2->prepare($sql);
  $stmt->bind_param("s", $requisitionNumber);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row['approval_status'];
  } else {
      return "Not Found"; // Open to changes
  }
}

$sql = "SELECT product_name, total_quantity, remaining_quantity FROM products";
$result = $conn2->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Generate a unique requisition number for each requisition
function generateRequisitionNumber() {
  // use combination of timestamp and a random number
  $requisitionNumber = "PO" . time() . rand(100, 999);
  return $requisitionNumber;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartREQ | Requisitions</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="home.css">
    <script src="loginscript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
</head>
<body>
  
    <div class="header">
        <a href="home.php"><img src="images/smart REQ logo.png" alt="SmartREQ " class="logo"></a>
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
<!--  main content   -->
    <div class="main-content">
        <div class="directory">
          <h1>REQUISITIONS</h1>
          <h3><a href="requisition_details.php" class="direct">view my requisition status</a></h3>
      </div>
       
        <!-- Requisitions content-->

<section>
  <h2>Remaining Stock</h2>
  <div class="chart-container">
    <canvas id="productChart"></canvas>
  </div>
  <script>
        // Extract data for chart labels and values
        const labels = <?php echo json_encode(array_column($data, 'product_name')); ?>;
        const totalQuantities = <?php echo json_encode(array_column($data, 'total_quantity')); ?>;
        const remainingQuantities = <?php echo json_encode(array_column($data, 'remaining_quantity')); ?>;
        
        // Check if any item's remaining quantity is below 15% of the total quantity
        const threshold = 0.15;
        const reorderQuantities = totalQuantities.map((total, index) => {
            if (remainingQuantities[index] < total * threshold) {
                return total * 0.9; // Reorder 90% of the total quantity
            } else {
                return null;
            }
        });

        // Chart configuration
        const ctx = document.getElementById('productChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Total Quantity',
                        data: totalQuantities,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Remaining Quantity',
                        data: remainingQuantities,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Reorder Quantity',
                        data: reorderQuantities,
                        backgroundColor: 'rgba(255, 206, 86, 0.6)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    title: {
                        display: false
                    }
                }
            }
        });
    </script>


</section>

  <section>
  <?php if (!empty($successMessage)): ?>
        <p style="color: green;">
            <?= $successMessage ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($errorMessage)): ?>
        <p style="color: red;">
            <?= $errorMessage ?>
        </p>
    <?php endif; ?>
        <form id="requisition-form"method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h2>Create Requisition</h2>
            <div>
                <label for="requester-name" class="req-label">Requester's Name:</label>
                <input type="text" id="requester-name" name="requesterName" class="req-input" placeholder="Your name" required>
            </div>
            <div class="">
                <label for="product-details" class="req-label">Product Details:</label>
                <input type="text" id="product-details" name="productDetails" class="req-input" placeholder="product name/identity" required>
            </div>
            <div>
                <label for="quantity" class="req-label">Quantity:</label>
                <input type="number" id="quantity" name="quantity" class="req-input" placeholder="Items/pieces" required>
            </div>
            <div>
                <label for="supplier" class="req-label">supplier:</label>
                <select type="number" id="supplier" name="supplier" class="req-input" required>
                    <option value="#"selected="selected">Choose supplier</option>
                    <option value="karani">karani suppliers</option>
                    <option value="KCL">KCL suppliers</option>
                    <option value="bidco">bidco suppliers</option>
                  </select> 
            </div>
            <div>
                <label for="price" class="req-label">Price:</label>
                <input type="number" id="price" name="price" class="req-input" placeholder="Ksh per item/piece" required>
            </div>
            <div>
                <label for="delivery-date" class="req-label">Delivery Date:</label>
                <input type="date" id="delivery-date" name="deliveryDate" class="req-input" required>
            </div>
            <div>
                <label for="department" class="req-label" >Department:</label>
                <select name="department" id="department"class="req-input" placeholder="department name" required>
                  <option value="">Select Department</option>
                  <option value="Production">production</option>
                  <option value="IT & TECH">IT & TECH</option>
            </div>
            <div>
                <label for="additional-info" class="req-label" >Additional Information:</label>
                <textarea id="additional-info" name="additionalInfo" class="req-input" placeholder="any specific details or concern of the item" required></textarea>
            </div>
            <button type="submit">Submit</button>
  </form>
  </section>
</div>

<!-- JavaScript to fetch data and render the chart -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    fetch('fetch_requisition_data.php') // Replace with your PHP script to fetch data from the database
      .then(response => response.json())
      .then(data => renderChart(data));
  });

  function renderChart(data) {
    // Extract data for chart labels and values
    const labels = data.map(item => item.product_name);
    const remainingQuantities = data.map(item => item.remaining_quantity);
    const totalQuantities = data.map(item => item.total_quantity);

    // Chart configuration
    const ctx = document.getElementById('remainingChart').getContext('2d');
    const myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Remaining Quantity',
            data: remainingQuantities,
            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Change the color and opacity of the bars
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          },
          {
            label: 'Total Quantity',
            data: totalQuantities,
            backgroundColor: 'rgba(255, 99, 132, 0.6)', // Change the color and opacity of the bars
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
          }
        ]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              display: true, // Show grid lines on the y-axis
            }
          },
          x: {
            grid: {
              display: false, // Hide grid lines on the x-axis
            }
          }
        },
        plugins: {
          legend: {
            display: true, // Show the legend
            position: 'top', // Position the legend at the top
            labels: {
              font: {
                size: 14 // Increase the font size of the legend labels
              }
            }
          },
          title: {
            display: false // Hide the chart title
          }
        }
      }
    });
  }
</script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>