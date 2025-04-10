<?php
$hostname = "localhost";
$port = "3306"; 

$username = "root"; 
$password = ""; 
$database = "project";


try{
    $conn = mysqli_connect($hostname,$username,$password,$database);
}
catch(Exception $e){
    die("Connection Failed ". $e->getMessage());
}
?>
