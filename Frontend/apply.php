<?php
session_start();
require '../PHP/db_connect.php';

if (!isset($_SESSION['user_logged_in']) || $_SESSION['role'] !== 'job-seeker') {
    echo "<script>alert('You must be signed in as a job-seeker!'); 
    window.history.back();</script>";
    exit;
}

$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cover_letter = $_POST['cover_letter'];

    $stmt = $conn->prepare("INSERT INTO applications (job_id, user_id, cover_letter) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $job_id, $user_id, $cover_letter);
    
    if ($stmt->execute()) {
        echo "<script>
        alert('Application submitted successfully!');
        window.location.href = '../Frontend/index.php';
    </script>";
    exit;
    } else {
        echo "Error submitting application.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply</title>
    <link rel="stylesheet" href="css/apply.css">
    <link rel="stylesheet" href="css/common.css">
</head>

<body>
<form method="POST">
    <textarea name="cover_letter" placeholder="Write your cover letter here"></textarea>
    <button type="submit">Submit Application</button>
</form>
</div>

<script src="js/common.js"></script>

</body>

</html>