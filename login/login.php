<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if both username and password are provided
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        // You can perform authentication here, for example, checking against a database
        // Sample code for authentication:
        // if ($username === "admin" && $password === "admin123") {
        //     // Authentication successful, redirect to a dashboard or home page
        //     header("Location: dashboard.php");
        //     exit;
        // } else {
        //     // Authentication failed, display an error message
        //     $error_message = "Invalid username or password";
        // }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="styles.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <div class="wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <h3>Engineering Inventory Management System</h3>
      <div class="input-box">
        <input type="text" name="username" placeholder="Username" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
        <i class='bx bxs-lock-alt'></i>
      </div>
      <div class="remember-forgot">
        <label><input type="checkbox" name="remember">Remember Me</label>
        <a href="#">Forgot Password</a>
      </div>
      <button type="submit" class="btn" name="login">Login</button>
      <div class="register-link">
        <p>Don't have an account? <a href="#">Register</a></p>
      </div>
      <?php if(isset($error_message)) { ?>
        <div class="error-message"><?php echo $error_message; ?></div>
      <?php } ?>
    </form>
  </div>
</body>
</html>