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
        include "../Database/database.php";

        function calculateOrder($product_prices,$size_prices,$extras_prices,$product_type,$size,$extras){

          $total_price = $product_prices[$product_type] * $size_prices[$size];
      
        foreach ($extras as $extra) {
            $total_price += $extras_prices[$extra];
        }
        return $total_price;
      }
        // Define arrays for coffee prices, size prices, and extras prices
        $product_prices = [
          "potato" => 110,
          "carrot" => 131.65,
          "tomato" => 45,
          "cabbage" => 146.270,
          "celery" => 389.54,
      ];
  
      $size_prices = [
          "1/4kg" => .2,
          "1/2kg" => .5,
          "1kg" => 1,
      ];
  
      $extras_prices = [
          "plastic" => 5.75,
          "paper" => 10.50,
      ];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $orderID = $_POST["order_id"];

            try {
                // Open the database connection
                $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
                
                // Set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Prepare and execute the update query
                $stmt = $conn->prepare("SELECT * FROM orders WHERE id = :orderID");
                $stmt->bindParam(':orderID', $orderID);
                $stmt->execute();

                // Fetch the orders
                $result = $stmt->fetch();

                if ($result) {
                    // Retrieve existing values
                    $name = isset($_POST["name"]) && $_POST["name"] !== "" ? $_POST["name"] : $result['name'];
                    $productType = isset($_POST["choices"]) && $_POST["choices"] !== "" ? $_POST["choices"] : $result['product_type'];
                    $size = isset($_POST["size"]) && $_POST["size"] !== "" ? $_POST["size"] : $result['size'];
                    $extras = isset($_POST["extras"]) && is_array($_POST["extras"]) ? $_POST["extras"] : explode(", ", $result['extras']);
                    $instructions = isset($_POST["instructions"])  && $_POST["instructions"] !== "" ? $_POST["instructions"] : $result['instructions'];

                    // Calculate the total price
                    $total_price = calculateOrder($product_prices,$size_prices,$extras_prices,$productType,$size,$extras);

                    // Update the order details
                    $updateStmt = $conn->prepare("UPDATE orders SET name=:name, productType=:productType, size=:size, extras=:extras, totalPrice=:total_price, instructions=:instructions WHERE id=:orderID");
                    $updateStmt->execute(array(
                        ':name' => $name,
                        ':productType' => $productType,
                        ':size' => $size,
                        ':extras' => implode(", ", $extras),
                        ':total_price' => $total_price,
                        ':instructions' => $instructions,
                        ':orderID' => $orderID
                    ));

                    echo "Order details updated successfully!";
                    echo"<script> 
        setTimeout(function(){
            alert('Order details updated successfully!');
        },100);
        </script>";
                } else {
                    echo "Order not found. Please check the Order ID and try again.";
                    echo"<script> 
        setTimeout(function(){
            alert('Order not found!');
        },100);
        </script>";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            // Close the database connection
            $conn = null;
        }

        
        ?>

        <br />
        <form action="../Pages/update.html">
            <button type="submit">Back</button>
        </form>
    </div>
</body>

</html>