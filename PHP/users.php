<?php
session_start();

// Database configuration
$db_host = 'localhost';
$db_name = 'vegetableshop';
$db_username = 'root';
$db_password = '';

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch users from the database
    $stmt = $conn->prepare("SELECT username, password, datetime FROM users ORDER BY datetime DESC");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <link rel="stylesheet" href="../CSS/veggies.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <h1>Registered Users</h1>
        <?php if (!empty($users)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Created At</th>
                    <th>Show</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $index => $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td>
                        <input type="password" id="password<?= $index ?>" value="<?= htmlspecialchars($user['password']) ?>" readonly>
                    </td>
                    <td><?= htmlspecialchars($user['datetime']) ?></td>
                    <td>
                        <button onclick="togglePassword(<?= $index ?>)">Show</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p>No users found.</p>
        <?php endif; ?>
        <br>
        <a href="../Pages/menu.html"><button>Back to Menu</button></a>
    </div>

    <script>
        function togglePassword(index) {
            let passField = document.getElementById("password" + index);
            passField.type = (passField.type === "password") ? "text" : "password";
        }
    </script>
</body>
</html>
