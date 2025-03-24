<?php
session_start();
require '../PHP/db_connect.php';


if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    echo "<script>alert('Please log in first.'); window.location.href = 'login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];


$stmt = $conn->prepare("SELECT company_name, location FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($company_name, $location);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Job</title>
    <link rel="stylesheet" href="CSS/create-job.css"> 
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/common.css">
</head>
<body>
    <h2>Create Job Posting</h2>
    
    <form action="../PHP/create-jobback.php" method="POST">
        <div id="formHolder"> 
        <label for="job_title">Job Title:</label>
        <input type="text" id="job_title" name="job_title" required>
        <br><br>

        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" value="<?php echo htmlspecialchars($company_name); ?>" readonly>
        <br><br>

        <label for="location">Job Location:</label>
        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($location); ?>">
        <br><br>

        <label for="job_description">Job Description:</label>
        <textarea id="job_description" name="job_description" rows="4" required></textarea>
        <br><br>

        <label for="benefits">Benefits:</label>
        <textarea id="benefits" name="benefits" rows="4" required></textarea>
        <br><br>

        <label for="requirements">Requirements:</label>
        <textarea id="requirements" name="requirements" rows="4" required></textarea>
        <br><br>


        <label for="salary">Salary:</label>
        <input type="number" id="salary" name="salary" min="0" step="500" required>
        <br><br>

        <button type="submit" name="create_job" id="create_job">Create Job</button>
    </div>
    </form>

  

<script src="js/common.js"></script>
</body>
</html>
