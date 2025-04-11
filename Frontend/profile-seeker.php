<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Profile Management</title>
    <link rel="stylesheet" href="./css/profile-seeker.css">
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
    else if ($_SESSION['role'] === 'admin') {
        header("Location: admin.php");
        exit();    
        }
    }else{
        header("Location: login.php");
        exit();   
    }  
?>

<div class="container">
    <h1>Profile Management</h1>
    <?php 

    require_once "../PHP/db_connect.php";

    $user_id = $_SESSION['user_id']; 
    $user_name = $_SESSION['name']; 
    $user_email = $_SESSION['email']; 


    $stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($profile_image);
    $stmt->fetch();
    $stmt->close();

    ?>
    <!-- Personal Info Card -->
    <div class="card">
        <h2>Personal Info</h2>
        <form id="personal-info-form" action="../PHP/profile-seekerLog.php" method="POST" onsubmit="return validatePersonalInfo()" enctype="multipart/form-data">
            <img src="../PHP/getImage.php" alt="Profile Image" class="profile-image"id="profile-image">
            <div class="form-group">
            <label for="profile-image">Change profile Image</label>
            <input type="file" name="profile_image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value=<?php echo $user_name ?> placeholder="wad" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value=<?php echo $user_email ?> required>
            </div>
            
            <button type="submit">Update Profile</button>
        </form>
    </div>

    <?php if ($_SESSION['role'] === 'employer'){?>
    <br>
    <h1>Company Management</h1>
    <!-- Company Info Card -->
    <div class="card">
        <h2>Company Info</h2>
        <form id="company-info-form" onsubmit="return validateCompanyInfo()">
            <div class="form-group">
                <label for="company-name">Company Name</label>
                <input type="text" id="company-name" name="company-name" value="Company Name Here" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" value="City, State" required>
            </div>
            <div class="form-group">
                <label for="industry">Industry</label>
                <select id="industry" name="industry" required>
                    <option value="technology">Technology</option>
                    <option value="healthcare">Healthcare</option>
                    <option value="finance">Finance</option>
                    <option value="education">Education</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="website">Website (Optional)</label>
                <input type="url" id="website" name="website" value="https://www.company.com">
            </div>
            <button type="submit">Update Company Info</button>
        </form>
    </div>

    <?php
    echo '<h1>Current Applicants: </h1>';

    $stmt = $conn->prepare("SELECT users.name, users.email, applications.cover_letter, applications.resume, applications.applied_at, jobs.id, jobs.title, jobs.company, jobs.location 
    FROM applications 
    JOIN jobs ON jobs.id = applications.job_id 
    JOIN users ON users.id = applications.user_id 
    WHERE jobs.user_id = ?");

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card">';
            echo '<br><h2>Applicant: ' . htmlspecialchars($row['name']) . '</h2>';
            echo '<br><p>Email: ' . htmlspecialchars($row['email']) . '</p>';
            echo '<br><p>Applied for: <strong>' . htmlspecialchars($row['title']) . '</strong> at ' . htmlspecialchars($row['company']) . '</p>';
            echo '<br><p>Location: ' . htmlspecialchars($row['location']) . '</p>';
            echo '<br><p>Applied on: ' . htmlspecialchars($row['applied_at']) . '</p>';
            echo '<br><p>Text: ' . htmlspecialchars($row['cover_letter']) . '</p>';

            echo '</div>';
        }
    } else {
        echo '<p>No applicants yet.</p>';
    }
    ?>  

    
    <?php } else {

    echo '<h1>Current applications: </h1>';
    $stmt = $conn->prepare("SELECT jobs.id, jobs.title, jobs.company, jobs.location, jobs.job_description 
    FROM applications JOIN jobs ON jobs.id = applications.job_id 
    WHERE applications.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

                echo '<div class="card" onclick="window.location.href=\'job-details.php?id=' . $row['id']  . '\'">';                        
                echo '<p><strong> Job title: ' . htmlspecialchars($row['title'])  . '</strong></p>';
                echo '<br><p><strong> Company: ' . htmlspecialchars($row['company']) . '</strong></p>';
                echo '<br><p><strong> Location: ' . htmlspecialchars($row['location']). '</strong></p>' ;
                echo '<br><p><strong> Job Description: ' . htmlspecialchars($row['job_description']). '</strong></p>' ;
                echo '</div>';
            }
    } else {
        echo '<p>No job listings available.</p>';
    }
?>

<?php };?>
</div>

<script src="./js/profile-seeker.js"></script>
<script src="./js/profile-employer.js"></script>
<script src="js/common.js"></script>
</body>
</html>