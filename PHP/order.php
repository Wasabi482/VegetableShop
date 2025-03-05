<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vegetable Order Summary</title>
  <link rel="stylesheet" href="../CSS/veggies.css?v=<?php echo time(); ?>">
  
</head>
<body>
    
<div class="navbar">
    <h1> Vegetable Shop</h1>
 </div>


<div class="container">
<?php


function calculateOrder($product_prices,$size_prices,$extras_prices,$product_type,$size,$extras){

    $total_price = $product_prices[$product_type] * $size_prices[$size];

  foreach ($extras as $extra) {
      $total_price += $extras_prices[$extra];
  }
  return $total_price;
}

/**
 * Displays the details of the vegetable order.
 * @param array $product_prices the array containing the prices of different coffee types
 * @param array $size_prices the array containing the prices of different sizes
 * @param array $extras_prices the array contating the prices of different extras
 * @param string $product_type the type of vegetable ordered
 * @param string $size or weight of the vegetable
 * @param array $extras the selected extras for the vegetable
 * @param float $total_price the total price of the order
 
 *  **/
function displayOrder($total_price, $product_prices, $product_type, $size_prices,$size,$extras,$extras_prices){


    //Display the customer's name
  echo "<div class='order'>";
  echo "Name:" ." ". htmlspecialchars($_POST["name"]) . "<br>";

  //Display the type of vegetable ordered along with its price
  echo "Vegatable Type:" ." ". htmlspecialchars($_POST["choices"]) . " (₱" . number_format($product_prices[$product_type], 2) . ")
  <br>";

  //Display the type of vegetable ordered along with its price
  echo "Size:" ." ". htmlspecialchars($_POST["size"]) . //" (₱" . number_format($size_prices[$size], 2) . ")
  "<br>";

  //Check if any extras were selected and display them along with their total price
  if (!empty($extras)) {
      echo "Extras:" ." ". implode(", ", $extras) . " (₱" . number_format(array_sum(array_intersect_key($extras_prices, array_flip($extras))), 2) . ")<br>";
  }

  //Display the total price of the order
  echo "Total Price:₱" ." ". number_format($total_price, 2) . "<br>";

  //Display any special instructions provided by the customer
  echo "Special Instructions<br>" . htmlspecialchars($_POST["instructions"]) . "<br>";
}

/**
 * Display an image and additional information about the order.
 * 
 * @param string $product_type the type of vegetable ordered
 */
function displayImageAndInfo($product_type){

    switch($product_type) {
        case "potato":
            $result ="<img src='https://www.gardenia.net/wp-content/uploads/2023/05/solanum-tuberosum.webp' class='result'>The potato is a starchy food, a tuber of the plant Solanum tuberosum and is a root vegetable native to the Americas. The plant is a perennial in the nightshade family Solanaceae. Wild potato species can be found from the southern United States to southern Chile.";
            break;
        case "carrot":
            $result ="<img src='https://www.economist.com/cdn-cgi/image/width=1424,quality=80,format=auto/sites/default/files/20180929_BLP506.jpg' class='result'>The carrot is a root vegetable, typically orange in color, though heirloom variants including purple, black, red, white, and yellow cultivars exist, all of which are domesticated forms of the wild carrot, Daucus carota, native to Europe and Southwestern Asia. ";
            break;
        case "tomato":
            $result ="<img src='https://images-prod.healthline.com/hlcmsresource/images/AN_images/tomatoes-1296x728-feature.jpg' class='result'>The tomato is the edible berry of the plant Solanum lycopersicum, commonly known as the tomato plant. The species originated in western South America, Mexico, and Central America. The Nahuatl word tomatl gave rise to the Spanish word tomate, from which the English word tomato derived.";
            break;
        case "cabbage":
            $result ="<img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSkEeqh9Pgh8x6s03XcAylTlfq0r6SsxWgoviVOR73X7SrIA6BMbDJHG4QAOfj44_JIt90&usqp=CAU' class='result'>Cabbage, comprising several cultivars of Brassica oleracea, is a leafy green, red, or white biennial plant grown as an annual vegetable crop for its dense-leaved heads.";
            break;
        case "celery":
            $result ="<img src='https://img.taste.com.au/dOryg-6K/taste/2007/07/celery-181887-1.jpg' class='result'>Celery is a marshland plant in the family Apiaceae that has been cultivated as a vegetable since antiquity. Celery has a long fibrous stalk tapering into leaves. Depending on location and cultivar, either its stalks, leaves or hypocotyl are eaten and used in cooking. Celery seed powder is used as a spice.";
            break;
    }

    echo $result;
}

/**
 * Generates the content for the receipt based on the provided parameters.
 * 
 * @param string $name the name of the customer
 * @param string $product_type the type of vegetable ordered
 * @param array $product_prices array containing the prices of different vegetable ordered
 * @param string  $size the size of the vegetable ordered
 * @param array $size_prices array containing the prices of different coffee sizes
 * @param array $extras_prices array containing the prices of different extras
 * @param array $extras array containing the selected extras
 * @param float $total_price the total price of the order
 * @param string $instructions any special instructions provided
 * @return string the content of the script
 */

function generateReceiptContent($name, $productType, $product_prices, $size, $size_prices, $extras, $extras_prices, $total_price, $instructions){
    
    //Initialize the receipt content with title and separator
    $receiptContent ="Order Summary\n";
    $receiptContent .="-----------------\n";
    //Add customer name to the receipt content
    $receiptContent .="Name:".$name. "\n";
    //Add product type with its price to the receipt content
    $receiptContent .="Product Type:".$productType."(₱".number_format($product_prices[$productType], 2).")\n";
    //Add size with its price to the receipt content
    $receiptContent.="Size:".$size.//"(₱".number_format($size_prices[$size], 2).")
    "\n";

    //Check if any extras were selected and add them to the receipt content
    if(!empty($extras))
    {
        $receiptContent .="Extras: " . implode(",", $extras)."(₱" . number_format(array_sum(array_intersect_key($extras_prices, array_flip($extras))), 2). ")\n";
    }
    //Add the total price to the receipt content
    $receiptContent.="Total Price: ₱". number_format($total_price, 2)."\n";
    //Add any special instructions to the receipt content
        $receiptContent.="Special Instructions: ".$instructions. "\n";
        // Add a thank you message to the receipt content
        $receiptContent .="\n";
        $receiptContent .="Thank you for your order!";
        //Return the complete receipt content
        return $receiptContent;
}

/**
 * Saves the receipt content to a text fie.
 * 
 * @param string $receiptContent the content of the receipt to be saved
 */
function saveReceiptToFile($receiptContent){
    //Open file for writing. If the file does not exist, it will be created.
    //If the file cannot be opened, display an error message and terminate the script.
    $file=fopen("Order.txt", "w+") or die("Unable to open file!");

    //write the receipt content to the file.
    fwrite($file,$receiptContent);
    //Close the file after writing is complete.
   fclose($file);
   //Display a success message indicating that the receipt was created.
    echo "Receipt created successfully as Order.txt!";
}

function insertOrderToDatabase($name,$productType, $size,$total_price,$instructions, $extras){
    include "../Database/database.php";

    try{
        //Open the database connection
        $conn=new PDO("mysql:host=$db_host;dbname=$db_name",$db_username,$db_password);
        //Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //Prepares an SQL statement for execution
        $stmt = $conn->prepare("INSERT INTO orders (id,name, productType, size, totalPrice, instructions, extras) VALUES (:id, :name, :product_type,:size,:total_price,:instructions,:extras)");
        //Convert the array into a single string

        $extras_string= implode(", ", $extras);

        //Bind the value of the variable to the parameter
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':product_type',$productType);
        $stmt->bindParam(':size',$size);
        $stmt->bindParam(':total_price',$total_price);
        $stmt->bindParam(':instructions',$instructions);
        $stmt->bindParam(':extras',$extras_string);

        //Executes the prepared statement
        $stmt->execute();
        echo" <br/> ";
        echo"<script> 
        setTimeout(function(){
            alert('Order details inserted into the database successfully!');
        },100);
        </script>";

    }catch (PDOException $e){
        echo"Error:". $e->getMessage();
    }
}
    //Close the database connection
    $conn=null;

/**
 * Displays the order summary, including customer details, product order details, images, and passwords if applicable. 
 * Generates a receipt and saves it to a text file.
 */
//Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Display the order summary section
    echo "<div class='summary'>";
    echo "<h2>📝 Order Summary</h2>";
    //Define the prices for different product types, sizes, and extras
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
    //Sanitize the input values
    $name = htmlspecialchars($_POST["name"]);
    $productType=htmlspecialchars($_POST["choices"]);
    $size=htmlspecialchars($_POST["size"]);
    $instructions=htmlspecialchars($_POST["instructions"]);
    //Extract the user input details
    $product_type = $_POST["choices"];
    $size = $_POST["size"];
    $extras = isset($_POST["extras"]) ? $_POST["extras"] : [];
    //Calculate the total price
    $total_price = calculateOrder($product_prices,$size_prices,$extras_prices,$product_type,$size,$extras);
    //Display the detailed order information
    displayOrder($total_price, $product_prices, $product_type, $size_prices,$size,$extras,$extras_prices);
    //Display image and description based on the total price
    displayImageAndInfo($product_type);
    echo "</div><br/><br/>";
    //Generate the receipt content based on the order details
    echo "<div class='receipt'>";
    $receiptContent = generateReceiptContent($name, $productType, $product_prices, $size, $size_prices, $extras, $extras_prices, $total_price, $instructions);
    //save the receipt content to a text file
    saveReceiptToFile($receiptContent);
    echo "<br/>";
    //Insert order details into the database
    insertOrderToDatabase($name,$productType,$size,$total_price,$instructions,$extras);
    echo "</div>";
}
?>
</div>

<br/>
<form action="../Pages/insert.html">
    <button type="submit">Back</button>
</form>

</body>
</html>
