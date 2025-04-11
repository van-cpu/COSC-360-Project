<?php
 $servername = "localhost";
 $port = "3306"; 
 $username = "narora08"; 
 $password = "narora08"; 
 $database = "narora08";
 
 
 $conn = new mysqli($servername, $username, $password, $database, $port);
 
 
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
 ?>