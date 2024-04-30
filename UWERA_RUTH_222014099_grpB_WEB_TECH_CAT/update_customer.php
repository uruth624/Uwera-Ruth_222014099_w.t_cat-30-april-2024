<?php
include('db_connection.php');

// Check if Customer ID is set
if (isset($_REQUEST['customer_id'])) {
  $customer_id = $_REQUEST['customer_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM customers WHERE customer_id=?");
  $stmt->bind_param("i", $customer_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $address = $row['address'];
  } else {
    echo "Customer not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Customer Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update customer information form -->
        <h2><u>Update Customer Information</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?php echo isset($first_name) ? $first_name : ''; ?>">
            <br><br>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?php echo isset($last_name) ? $last_name : ''; ?>">
            <br><br>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
            <br><br>

            <label for="phone">Phone:</label>
            <input type="text" name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>">
            <br><br>

            <label for="address">Address:</label>
            <input type="text" name="address" value="<?php echo isset($address) ? $address : ''; ?>">
            <br><br>

            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];

  // Update the customer in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE customers SET first_name=?, last_name=?, email=?, phone=?, address=? WHERE customer_id=?");
  $stmt->bind_param("sssssi", $first_name, $last_name, $email, $phone, $address, $customer_id);
  $stmt->execute();

  // Redirect to appropriate page after update
  header('Location: customer.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
