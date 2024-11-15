<?php
$servername = "localhost";  // Usually "localhost"
$username = "root";         // Default username for MySQL
$password = "";             // Default password for MySQL (leave blank if no password is set)
$dbname = "school_system";  // The name of the database you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
