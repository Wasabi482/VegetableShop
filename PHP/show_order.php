<link rel="stylesheet" href="../CSS/veggies.css?v=<?php echo time(); ?>">
<?php 
include "../Database/database.php";

try {
  //Open the database connection
  $conn=new PDO("mysql:host=$db_host;dbname=$db_name", $db_username,$db_password);

  //Set the PDO error mode to exception useful for error handling and allows you to catch and handle any errors that occur during the execution of the database operations.

  $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  //Prepares an SQL statement for execution
  $stmt = $conn->prepare('SELECT * FROM orders');

  //Executes the prepared statement
  $stmt->execute();

  //Fetch all the orders
  $results=$stmt->fetchAll();

  //Display each order as a table row
  echo"<table>";
  echo "<tr>";
    echo "<th> OrderID </th>";
    echo "<th>Name</th>";
    echo "<th>Product</th>";
    echo "<th>Size</th>";
    echo "<th>Total Price</th>";
    echo "<th>Instruction</th>";
    echo "<th>Extras</th>";
    echo "</tr>";
  foreach($results as $result) {
    echo '<tr>';
    echo "<td>" . $result['id']."</td>";
    echo "<td>" . $result['name'] . "</td>";
    echo "<td>" . $result['productType'] . "</td>";
    echo "<td>" . $result['size'] . "</td>";
    echo "<td>₱" . number_format($result['totalPrice'], 2) . "</td>";
    echo "<td>" . $result['instructions'] . "</td>";
    echo "<td>" . $result['extras'] . "</td>";
    echo "</tr>";
}
}catch (PDOException $e){
  echo "Error:".$e->getMessage();

  echo"</table>";
}
//Close the database connection
$conn=null;
?>