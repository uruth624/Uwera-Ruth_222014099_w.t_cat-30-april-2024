<?php
include('db_connection.php');

// Check if payment id is set
if (isset($_REQUEST['payment_id'])) {
  $payid = $_REQUEST['payment_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM payment_information WHERE payment_id=?");
  $stmt->bind_param("i", $payid);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $a = $row['payment_id'];
    $b = $row['order_id'];
    $c = $row['total_amount'];
    $d = $row['transaction_date'];
  } else {
    echo "payment not found.";
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
        <!-- Update payment_information form -->
        <h2><u>Update Form of payment_information</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="order_id">order id:</label>
            <input type="number" name="order_id" value="<?php echo isset($b) ? $b : ''; ?>">
            <br><br>

            <label for="total_amount">total amount:</label>
            <input type="number" name="total_amount" value="<?php echo isset($c) ? $c : ''; ?>">
            <br><br>

            <label for="transaction_date">transaction date:</label>
            <input type="date" name="transaction_date" value="<?php echo isset($d) ? $d : ''; ?>">
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
  $total_amount = $_POST['total_amount'];
  $transaction_date = $_POST['transaction_date'];

  // Update the payment_information in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE payment_information SET order_id=?, total_amount=?, transaction_date=? WHERE payment_id=?");
  $stmt->bind_param("iddi", $order_id, $total_amount, $transaction_date, $payid);
  $stmt->execute();

  // Redirect to payment_information.php
  header('Location: payment_information.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
