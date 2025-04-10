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
         echo '<a href="logout.php" id="logoutLink">Logout</a>';  
        if ($_SESSION['role'] === 'employer') {
            echo '<a href="create-job.php" id="createJob">Create Job</a>';
           
        }
        }else{
            echo '<a href="login.php" id="loginLink">Login</a>';      
        }
        
        ?>


<?php



$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


$stmt = $conn->prepare("SELECT title, company, location, salary, job_description, requirements, benefits, posted_at, user_id, click_count FROM jobs WHERE id = ?");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$stmt->bind_result($job_title, $company_name, $job_location, $salary, $job_description, $requirements, $benefits, $posted_at, $user_id, $click_count);
$stmt->fetch();
$stmt->close();
$_SESSION['userid_curjob'] = $user_id;

$is_logged_in = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
$is_employer = $is_logged_in && $_SESSION['role'] === 'employer' && $_SESSION['user_id'] == $user_id;

if (!$is_logged_in) {
    echo '<a href="login.php" id="loginLink">Login</a>';
}
if(!$is_employer && !isset($_SESSION['user_clicked' .$user_id.$job_id])){//so it only goes up if they are not the employer
    $_SESSION['user_clicked'.$user_id.$job_id] = true;
    $click_count +=1;

    $stmt = $conn->prepare("UPDATE jobs SET click_count = ? WHERE id = ?");
    $stmt->bind_param("ii", $click_count, $job_id);
    $stmt->execute();
    $stmt->close();
}

$stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($profile_image);
$stmt->fetch();
$stmt->close();



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
        <img src="../PHP/getJobImage.php" alt="Profile Image" class="clickable-hover" id="companyLogo" onclick="window.location.href='profile-employer.php?id=<?php echo $user_id; ?>'">
        <h2 id="companyName"><?php echo htmlspecialchars($company_name); ?></h2>
        <h1 id="jobTitle"><?php echo htmlspecialchars($job_title); ?></h1>
        <h2 style="color: white;"> Clicks since Posting: <?php echo $click_count ?></h2>
        <div id="innerText" class="textDiv">
            <h2>Job Details</h2>
            <br>
            <p id="jobLocation"><?php echo 'Location: '.htmlspecialchars($job_location); ?></p>
            <p id="salaryRange"><?php echo 'Salary: '.htmlspecialchars($salary); ?></p>
            <p id="jobDescription"><?php echo 'Job Description: '. htmlspecialchars($job_description); ?></p>
            <p id="reqQual"><?php echo 'Requirements: '.htmlspecialchars($requirements); ?></p>
            <p id="Bene"><?php echo 'Benifits: '.htmlspecialchars($benefits); ?></p>
        </div>
        <div class="textDiv">
            <p id="jobDate">Job listed on: <?php echo htmlspecialchars($posted_at); ?></p>
            <p id="deadline">Deadline: </p>
        </div>
        <button id="applyButton" onclick="window.location.href = 'apply.php?id=<?php echo $job_id; ?>'">Apply</button>
        
        <?php if ($is_employer): ?>
            <button id="editButton" onclick="window.location.href='edit-job.php?id=<?php echo $job_id; ?>'">Edit Job</button>
        <?php endif; ?>
        <?php 
        if ($is_employer) {echo "<div id='subApp'>";
            echo "<h2>Submitted Applications: </h2>";
        
            $app_stmt = $conn->prepare("SELECT users.name, users.location, users.email, applications.cover_letter, applications.applied_at FROM applications JOIN users ON applications.user_id = users.id WHERE applications.job_id = ?");
            $app_stmt->bind_param("i", $job_id);
            $app_stmt->execute();
            $app_stmt->bind_result($applicant_name, $applicant_location, $applicant_email, $cover_letter, $applied_at);
        
            while ($app_stmt->fetch()) {
                echo "<br><br><div class='application'>";
                echo "<p><strong>Applicant:</strong> " . htmlspecialchars($applicant_name) . "</p>";
                echo "<p><strong>Cover Letter:</strong> " . nl2br(htmlspecialchars($cover_letter)) . "</p>";
                echo "<p><strong>Email:</strong> " . nl2br(htmlspecialchars($applicant_email)) . "</p>";
                echo "<p><strong>Applied on:</strong> " . htmlspecialchars($applied_at) . "</p>";
                echo "</div>";
            }
        echo "</div>";
            $app_stmt->close();
        }
        
        ?>
    </div>

    <script src="js/common.js"></script>
    <script src="js/job-details.js"></script>
</body>

</html>
