<?php
$servername = "localhost";  // Typically "localhost", but could be an IP address or domain.
$username = "root";         // Your database username.
$password = "";             // Your database password.
$dbname = "keluarmasuk";    // The name of the database you're working with.

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
