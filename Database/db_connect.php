<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "sgrmsdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Store connection in session if needed
$_SESSION['conn'] = $conn;
?>
