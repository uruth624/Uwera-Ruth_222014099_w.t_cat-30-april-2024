<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>payment information Page</title>
  <style>
    /* Normal link */
    a {
      padding: 10px;
      color: white;
      background-color: yellow;
      text-decoration: none;
      margin-right: 15px;
    }

    /* Visited link */
    a:visited {
      color: purple;
    }
    /* Unvisited link */
    a:link {
      color: brown; /* Changed to lowercase */
    }
    /* Hover effect */
    a:hover {
      background-color: white;
    }

    /* Active link */
    a:active {
      background-color: red;
    }

    /* Extend margin left for search button */
    button.btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }
    /* Extend margin left for search button */
    input.form-control {
      margin-left: 1200px; /* Adjust this value as needed */

      padding: 8px;
     
    }
  </style>
  <!-- JavaScript validation and content load for insert data-->
        <script>
            function confirmInsert() {
                return confirm('Are you sure you want to insert this record?');
            }
        </script>
        
  </head>

  <header>

<body bgcolor="yellow">
  <form class="d-flex" role="search" action="search.php">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  <ul style="list-style-type: none; padding: 0;">
    <li style="display: inline; margin-right: 10px;">
    <img src="./image/logo.jpeg" width="90" height="60" alt="Logo">
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./home.html">HOME</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./products.php">PRODUCT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./shipping_information.php">SHIPPING INFORMATION</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./payment_information.php">PAYMENT INFORMATION</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./customer.php">CUSTOMER</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./orders.php">ORDERS</a>
  </li>
   
  
    <li class="dropdown" style="display: inline; margin-right: 10px;">
      <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none; margin-right: 15px;">Settings</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
        <a href="login.html">Login</a>
        <a href="register.html">Register</a>
        <a href="logout.php">Logout</a>
      </div>
    </li><br><br>
    
    
    
  </ul>

</header>
<section>
    <h1><u>payment information Form </u></h1>



<form method="post" onsubmit="return confirmInsert();">
    <label for="order_id">Order ID:</label>
    <input type="number" id="order_id" name="order_id" required><br><br>

    <label for="total_amount">Total Amount:</label>
    <input type="number" step="0.01" id="total_amount" name="total_amount" required><br><br>

    <label for="transaction_date">Transaction Date:</label>
    <input type="date" id="transaction_date" name="transaction_date" required><br><br>

    <input type="submit" name="add" value="Insert">
</form>

<?php
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO payment_information(order_id, total_amount, transaction_date) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $order_id, $total_amount, $transaction_date);
    // Set parameters and execute
    $order_id = $_POST['order_id'];
    $total_amount = $_POST['total_amount'];
    $transaction_date = $_POST['transaction_date'];
   
    if ($stmt->execute() == TRUE) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$connection->close();
?>

<?php
include('db_connection.php');

// SQL query to fetch data from the payment_information table
$sql = "SELECT * FROM payment_information";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of Payments</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <center><h2>Table of Payments</h2></center>
    <table border="3">
        <tr>
            <th>Payment ID</th>
            <th>Order ID</th>
            <th>Total Amount</th>
            <th>Transaction Date</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
<?php
include('db_connection.php');

// Prepare SQL query to retrieve all payments
$sql = "SELECT * FROM payment_information";
$result = $connection->query($sql);

// Check if there are any payments
if ($result->num_rows > 0) {
    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        $payment_id = $row['payment_id']; // Fetch the Payment ID
        echo "<tr>
            <td>" . $row['payment_id'] . "</td>
            <td>" . $row['order_id'] . "</td>
            <td>" . $row['total_amount'] . "</td>
            <td>" . $row['transaction_date'] . "</td>
            <td><a style='padding:4px' href='delete_payment_information.php?payment_id=$payment_id'>Delete</a></td> 
            <td><a style='padding:4px' href='update_payment_information.php?payment_id=$payment_id'>Update</a></td> 
        </tr>";
    }

} else {
    echo "<tr><td colspan='6'>No data found</td></tr>";
}
// Close the database connection
$connection->close();
?>
    </table>

</body>

</section>
 
<footer>
  <center> 
    <b><h2>UR CBE BIT &copy, 2024 &reg, Designer by:UWERA RUTH</h2></b>
  </center>
</footer>
  
</body>
</html>
