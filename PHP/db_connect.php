<?php
$hostname = "localhost";
$port = "3306"; 

$username = "narora08"; 
$password = "narora08"; 
$database = "narora08";


try{
    $conn = mysqli_connect($hostname,$username,$password,$database);
}
catch(Exception $e){
    die("Connection Failed ". $e->getMessage());
}
?>
