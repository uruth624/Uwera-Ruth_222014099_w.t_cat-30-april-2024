<?php
include('db_connection.php');

// Check if Shipping ID is set
if (isset($_REQUEST['shipping_id'])) {
  $shipping_id = $_REQUEST['shipping_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM shipping_information WHERE shipping_id=?");
  $stmt->bind_param("i", $shipping_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $shipping_id = $row['shipping_id'];
    $order_id = $row['order_id'];
    $shipping_address = $row['shipping_address'];
    $shipping_date = $row['shipping_date'];
  } else {
    echo "Shipping information not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Shipping Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update shipping information form -->
        <h2><u>Update Shipping Information</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="order_id">Order ID:</label>
            <input type="number" name="order_id" value="<?php echo isset($order_id) ? $order_id : ''; ?>">
            <br><br>

            <label for="shipping_address">Shipping Address:</label>
            <input type="text" name="shipping_address" value="<?php echo isset($shipping_address) ? $shipping_address : ''; ?>">
            <br><br>

            <label for="shipping_date">Shipping Date:</label>
            <input type="date" name="shipping_date" value="<?php echo isset($shipping_date) ? $shipping_date : ''; ?>">
            <br><br>

            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $order_id = $_POST['order_id'];
  $shipping_address = $_POST['shipping_address'];
  $shipping_date = $_POST['shipping_date'];

  // Update the shipping information in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE shipping_information SET order_id=?, shipping_address=?, shipping_date=? WHERE shipping_id=?");
  $stmt->bind_param("issi", $order_id, $shipping_address, $shipping_date, $shipping_id);
  $stmt->execute();

  // Redirect to appropriate page after update
  header('Location: shipping_information.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
