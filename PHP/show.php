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
    <h1>Vegetable Shop Orders</h1>
    <table>
      <?php include 'show_order.php';?>
    </table>

    <br/>

    <form action="../Pages/menu.html">
      <button type="submit">Back to Main Menu</button>
    </form>
  </div>
</body>
</html>