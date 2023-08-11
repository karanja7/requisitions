<?php
require_once 'connection.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user data from the login form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists in the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn1->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables and redirect to the homepage
            $_SESSION['username'] = $user['username'];
            $_SESSION['unique_code'] = $user['unique_code'];
            header("Location: home.php");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }
    $stmt = $conn1->prepare("select * from users where email = ? AND password = ?");
    $stmt->bind_param("ss", $admission, $passworda);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if($stmt_result->num_rows > 0) {
      $data = $stmt_result->fetch_assoc();
      if($data['role'] == "admin") {
        echo '
    <script>
    alert("login successful");
    header("Location: admin_page.php");
    </script>
    ';
      }else {
        echo '
    <script>
    alert("login successful");
    header("Location: home.php");
    </script>
    ';
      }
    }else {
      echo '
      <script>
      alert("Invalid admission or password");
      header("Location: login.php");
      </script>
      ';
    }
  }

?>
