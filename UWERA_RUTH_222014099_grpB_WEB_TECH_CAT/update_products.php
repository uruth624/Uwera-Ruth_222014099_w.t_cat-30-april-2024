<?php
include('db_connection.php');

// Check if Product_Id is set
if (isset($_REQUEST['product_id'])) {
  $pid = $_REQUEST['product_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM products WHERE product_id=?");
  $stmt->bind_param("i", $pid);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['product_id'];
    $b = $row['product_name'];
    $c = $row['price'];
    $d = $row['stock_quantity'];
  } else {
    echo "Product not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update products</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update products form -->
        <h2><u>Update Form of products</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="product_name">Product name:</label>
            <input type="text" name="product_name" value="<?php echo isset($b) ? $b : ''; ?>">
            <br><br>

            <label for="price">Price:</label>
            <input type="number" name="price" value="<?php echo isset($c) ? $c : ''; ?>">
            <br><br>

            <label for="stock_quantity">Stock Quantity:</label>
            <input type="number" name="stock_quantity" value="<?php echo isset($d) ? $d : ''; ?>">
            <br><br>
            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $product_name = $_POST['product_name'];
  $price = $_POST['price'];
  $stock_quantity = $_POST['stock_quantity'];

  // Update the product in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE products SET product_name=?, price=?, stock_quantity=? WHERE product_id=?");
  $stmt->bind_param("sdii", $product_name, $price, $stock_quantity, $pid);
  $stmt->execute();

  // Redirect to product.php
  header('Location: products.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
