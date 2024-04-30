<?php
// Connection details
$host = "localhost";
$user = "uwera";
$pass = "ruth";
$database = "online_coat_and_paint_selling_system";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>