<?php
require '../PHP/db_connect.php';
session_start();

$user_id = $_SESSION['userid_curjob'];

$stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($profile_image);
$stmt->fetch();
$stmt->close();
$conn->close();

if (!empty($profile_image)) {
    header("Content-Type: image/jpeg");
    echo $profile_image;
} else {
    header("Content-Type: image/png");
    readfile("../Frontend/photos/defaultimage.png");
}
?>
