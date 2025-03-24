<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <link rel="stylesheet" href="css/job-details.css">
    <link rel="stylesheet" href="css/common.css">
</head>

<body>

<?php
        session_start();
        require '../PHP/db_connect.php';
        if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true){
        
        if ($_SESSION['role'] === 'employer') {
            echo '<a href="create-job.php" id="createJob">Create Job</a>';
            echo '<a href="logout.php" id="logoutLink">Logout</a>';  
        }
        }else{
            echo '<a href="login.php" id="loginLink">Login</a>';      
        }
        
        ?>
<?php>

<?php

require '../PHP/db_connect.php';


$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


$stmt = $conn->prepare("SELECT title, company, location, salary, job_description, requirements, benefits, posted_at, user_id FROM jobs WHERE id = ?");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$stmt->bind_result($job_title, $company_name, $job_location, $salary, $job_description, $requirements, $benefits, $posted_at, $user_id);
$stmt->fetch();
$stmt->close();


$is_logged_in = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
$is_employer = $is_logged_in && $_SESSION['role'] === 'employer' && $_SESSION['user_id'] == $user_id;

if (!$is_logged_in) {
    echo '<a href="login.php" id="loginLink">Login</a>';
}
?>
    <div id="innerHTML">
        <div id="iconCont">
            <img src="../Frontend/photos/bookmark.png" alt="bookmark" id="bookmark">
            <img src="../Frontend/photos/report.png" alt="report post" id="report">
        </div>
   
        <form id="reportForm" style="display: none;">
            <h2>Report Listing</h2>
            <label class="option"><input type="checkbox" name="reportReason" value="spam"> Spam</label><br>
            <label class="option"><input type="checkbox" name="reportReason" value="misleading"> Misleading Information</label><br>
            <label class="option"><input type="checkbox" name="reportReason" value="offensive"> Offensive Content</label><br>
            <label class="option"><input type="checkbox" name="reportReason" value="other"> Other</label><br>
            <button type="submit" id="submitButton">Submit</button>
        </form>
     
        <img src="../Frontend/photos/defaultimage.png" alt="Default Logo" id="companyLogo">
        <h2 id="companyName"><?php echo htmlspecialchars($company_name); ?></h2>
        <h1 id="jobTitle"><?php echo htmlspecialchars($job_title); ?></h1>

        <div id="innerText" class="textDiv">
            <h2>Job Details</h2>
            <br>
            <p id="jobLocation"><?php echo htmlspecialchars($job_location); ?></p>
            <p id="salaryRange"><?php echo htmlspecialchars($salary); ?></p>
            <p id="jobDescription"><?php echo htmlspecialchars($job_description); ?></p>
            <p id="reqQual"><?php echo htmlspecialchars($requirements); ?></p>
            <p id="Bene"><?php echo htmlspecialchars($benefits); ?></p>
        </div>
        <div class="textDiv">
            <p id="jobDate">Job listed on: <?php echo htmlspecialchars($posted_at); ?></p>
            <p id="deadline">Deadline: </p>
        </div>
        <button id="applyButton" onclick="window.location.href = 'apply.php?id=<?php echo $job_id; ?>'">Apply</button>
        
        <?php if ($is_employer): ?>
            <button id="editButton" onclick="window.location.href='edit-job.php?id=<?php echo $job_id; ?>'">Edit Job</button>
        <?php endif; ?>
    </div>

    <script src="js/common.js"></script>
    <script src="js/job-details.js"></script>
</body>

</html>
