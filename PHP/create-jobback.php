<?php
session_start();
require '../PHP/db_connect.php';
$user_id = $_SESSION['user_id'];


$stmt = $conn->prepare("SELECT company_name, location FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($company_name, $location);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_job'])) {
    $job_title = trim($_POST['job_title']);
    $job_description = trim($_POST['job_description']);
    $salary = $_POST['salary'];


    $stmt = $conn->prepare("INSERT INTO jobs (user_id, title, company, location, job_description, salary) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssi", $user_id, $job_title, $company_name, $location, $job_description, $salary);


    if ($stmt->execute()) {
        echo "<script>alert('Job created successfully.'); window.location.href = '../Frontend/index.php';</script>";
    } else {
        echo "<script>alert('Error creating job: " . $conn->error . "');</script>";
    }

    $stmt->close();
}
?>