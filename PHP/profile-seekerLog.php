<?php
session_start();
require_once "../PHP/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);




    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $user_id);


    if ($stmt->execute()) {
        
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $name;
        echo "<script>alert('Profile updated successfully!'); window.location.href = '../Frontend/profile-seeker.php';</script>";
    } else {

    }

    $stmt->close();
}
?>
