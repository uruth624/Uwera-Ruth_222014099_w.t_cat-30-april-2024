<?php
include('db_connection.php');

// Check if order id is set
if (isset($_REQUEST['order_id'])) {
  $order_id = $_REQUEST['order_id'];


  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM orders WHERE order_id=?");
  $stmt->bind_param("i", $order_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $b = $row['customer_id'];
    $c = $row['order_date'];
    
  } else {
    echo "orders not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update order Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update orders information form -->
        <h2><u>Update orders Information</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="customer_id">customer id:</label>
            <input type="number" name="customer_id" value="<?php echo isset($b) ? $b : ''; ?>">
            <br><br>

            <label for="order_date">order date:</label>
            <input type="date" name="order_date" value="<?php echo isset($c) ? $c : ''; ?>">
            <br><br>

            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $customer_id = $_POST['customer_id'];
  $order_date = $_POST['order_date'];

  // Update the orders in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE orders SET  customer_id=?, order_date=? WHERE order_id=?");
  $stmt->bind_param("isi", $customer_id, $order_date, $order_id);
  $stmt->execute();

  // Redirect to appropriate page after update
  header('Location: orders.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
