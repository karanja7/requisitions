<?php
// Include your database connection
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
  


// Handle user registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Perform user registration and database insertion here
    
    // For demonstration purposes, let's just display a success message
    $registrationMessage = "User $username registered successfully!";
}

// Handle requisition approval/denial
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
    $requisitionId = $_POST['requisition_number'];
    $approvalStatus = $_POST['approval_status'];
    
    // Update the requisition approval status in the database
    
    // For demonstration purposes, let's just display a success message
    $approvalMessage = "Requisition $requisitionId $approvalStatus!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="home.css">
   <style> /* Reset some default styles */
body, h1, h2, p, table {
    margin: 0;
    padding: 10px;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    color: #333;
}

h1 {
    font-size: 24px;
    margin: 20px;
}

h2 {
    font-size: 20px;
    margin: 10px 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px;
}

th, td {
    padding: 5px;
    border-bottom: 1px solid #ccc;
}

th {
    background-color: #f0f0f0;
    text-align: left;
    font-weight: bold;
}

/* User Registration Panel */
form {
    background-color: #fff;
    padding: 20px;
    margin: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 10px;
}

button {
    background-color: #3498db;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

/* Requisition Approval Panel */
table {
    margin-top: 0;
}

td:last-child {
    display: flex;
    gap: 10px;
}

button[name="approve"], button[name="deny"] {
    background-color: #27ae60;
}

button[name="deny"] {
    background-color: #e74c3c;
}

/* Logout Link */
a {
    display: block;
    margin: 20px;
    text-align: center;
    color: #3498db;
    text-decoration: none;
    font-weight: bold;
}
</style>
</head>
<body>
     <?php
        if (isset($_SESSION['username'])) {
            echo "welcome admin: " . $_SESSION['username'];
        }
        ?>

    <!-- User Registration Panel -->
    <h2>User Registration</h2>
    <?php if (isset($registrationMessage)): ?>
        <p><?php echo $registrationMessage; ?></p>
    <?php endif; ?>
    <form action="register.php" method="post">
        <label for="Username">Username :</label>
        <input type="text" name="Username" placeholder="Input user Email" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Insert Email" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Assign Password" required><br>
        <button type="submit" name="register">Register User</button>
    </form>

    <!-- Requisition Approval Panel -->
    <h2>Requisition Approval</h2>
    <?php if (isset($approvalMessage)): ?>
        <p><?php echo $approvalMessage; ?></p>
    <?php endif; ?>
    <table>
        <tr>
            <th>Requisition ID</th>
            <th>Requester</th>
            <th>Product Details</th>
            <th>Quantity</th>
            <th>Actions</th>
        </tr>
        <?php
        // Fetch pending requisitions from the database
        $sql = "SELECT * FROM requisitions WHERE approval_status = 'Pending'";
        $result = $conn2->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['requisition_number']}</td>";
            echo "<td>{$row['requester_name']}</td>";
            echo "<td>{$row['product_details']}</td>";
            echo "<td>{$row['quantity']}</td>";
            echo "<td>
                    <form method='post'>
                        <input type='hidden' name='requisition_number' value='{$row['requisition_number']}'>
                        <input type='hidden' name='approval_status' value='Approved'>
                        <button type='submit' name='approve'>Approve</button>
                    </form>
                    <form method='post'>
                        <input type='hidden' name='requisition_number' value='{$row['requisition_number']}'>
                        <input type='hidden' name='approval_status' value='Denied'>
                        <button type='submit' name='approve'>Deny</button>
                    </form>
                </td>";
            echo "</tr>";
        }
        ?>
    </table>

    <a href="login.php">Logout</a>
</body>
</html>
