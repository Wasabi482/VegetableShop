<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Vegetable Market</title>
    <link rel="stylesheet" href="../CSS/veggies.css?v=<?php echo time(); ?>">
</head>
<body>
  <div class="container">
  <?php
session_start();
include "../Database/database.php"; // Include database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);

  try {
      $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
      $stmt->bindParam(':username', $username);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
          echo "DEBUG: Entered Password: " . $password . "<br>";
          echo "DEBUG: Stored Hashed Password: " . $user['password'] . "<br>";

          if (password_verify($password, $user['password'])) {
              $_SESSION['username'] = $username;
              header("Location: ../Pages/menu.html");
              exit();
          } else {
              echo "DEBUG: Password verification failed.";
          }
      } else {
          echo "DEBUG: Username does not exist!";
      }
  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}

?>

<!-- Simple back button to return to login page -->
    <form action="../Pages/login.html">
      <button type="submit">Back</button>
    </form>
  </div>
</body>
</html>