<?php
// Check if the 'query' GET parameter is set
if (isset($_GET['query']) && !empty($_GET['query'])) {

 include('db_connection.php');

    // Sanitize input to prevent SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);

    // Queries for different tables
    $queries = [
        'products' => "SELECT product_id FROM products WHERE product_id LIKE '%$searchTerm%'",
        'customers' => "SELECT first_name FROM customers WHERE first_name LIKE '%$searchTerm%'",
        'shipping_information' => "SELECT shipping_id FROM shipping_information WHERE shipping_id LIKE '%$searchTerm%'",
        'payment_information' => "SELECT  payment_id FROM payment_information WHERE payment_id LIKE '%$searchTerm%'",
        'orders' => "SELECT order_id FROM orders WHERE order_id LIKE '%$searchTerm%'",
    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $connection->query($sql);
        echo "<h3>Table of $table:</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row[array_keys($row)[0]] . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>
