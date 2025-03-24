<?php
$servername = "localhost";
$port = "3306"; 
$username = "root"; 
$password = ""; 
$database = "project";


$conn = new mysqli($servername, $username, $password, $database, $port);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
