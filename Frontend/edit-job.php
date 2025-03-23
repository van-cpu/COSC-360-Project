<?php
session_start();
require '../PHP/db_connect.php';

if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    echo "<script>alert('Please log in first.'); window.location.href = 'login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


$stmt = $conn->prepare("SELECT title, company, location, salary, job_description, requirements, benefits, user_id FROM jobs WHERE id = ?");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$stmt->bind_result($job_title, $company_name, $job_location, $salary, $job_description, $requirements, $benefits, $job_creator_id);
$stmt->fetch();
$stmt->close();


if ($user_id != $job_creator_id) {
    echo "<script>alert('You do not have permission to edit this job.'); window.location.href = 'index.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $job_title = trim($_POST['job_title']);
    $job_location = trim($_POST['location']);
    $salary = trim($_POST['salary']);
    $job_description = trim($_POST['job_description']);
    $requirements = trim($_POST['requirements']);
    $benefits = trim($_POST['benefits']);

    $stmt = $conn->prepare("UPDATE jobs SET title=?, location=?, salary=?, job_description=?, requirements=?, benefits=? WHERE id=?");
    $stmt->bind_param("ssisssi", $job_title, $job_location, $salary, $job_description, $requirements, $benefits, $job_id);

    if ($stmt->execute()) {
        echo "<script>alert('Job updated successfully.'); window.location.href = 'job-details.php?id=$job_id';</script>";
    } else {
        echo "<script>alert('Error updating job: " . $conn->error . "');</script>";
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>

    <link rel="stylesheet" href="css/edit-job.css">
    <link rel="stylesheet" href="css/common.css">
</head>
<body>
    <div id="innerPart">
    <h2>Edit Job Posting</h2>
    <form method="POST">
        <label for="job_title">Job Title:</label>
        <input type="text" id="job_title" name="job_title" value="<?php echo htmlspecialchars($job_title); ?>" required>
        <br><br>
        
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($job_location); ?>" required>
        <br><br>
        
        <label for="salary">Salary:</label>
        <input type="number" id="salary" name="salary" value="<?php echo htmlspecialchars($salary); ?>" required>
        <br><br>
        
        <label for="job_description">Job Description:</label>
        <textarea id="job_description" name="job_description" rows="4" required><?php echo htmlspecialchars($job_description); ?></textarea>
        <br><br>
        
        <label for="requirements">Requirements:</label>
        <textarea id="requirements" name="requirements" rows="4" required><?php echo htmlspecialchars($requirements); ?></textarea>
        <br><br>
        
        <label for="benefits">Benefits:</label>
        <textarea id="benefits" name="benefits" rows="4" required><?php echo htmlspecialchars($benefits); ?></textarea>
        <br><br>
        
        <button type="submit">Save Changes</button>
    </form>
</div>
</body>
</html>
