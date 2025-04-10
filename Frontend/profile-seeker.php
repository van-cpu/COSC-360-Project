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
          <?PHP        if ($_SESSION['role'] === 'employer') {//is an employer
            echo " <h2> Current job postings </h2>";

        }else{// is an employee
            echo '<h1>Current applications: </h1>';
            $stmt = $conn->prepare("SELECT jobs.id, jobs.title, jobs.company, jobs.location, jobs.job_description FROM applications JOIN jobs ON jobs.id = applications.job_id WHERE applications.user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                        echo '<br><div onclick="window.location.href=\'job-details.php?id=' . $row['id']  . '\'">';                        
                        echo '<div class="card">';
                        echo '<h2> Job title: ' . htmlspecialchars($row['title']) ;
                        echo '<br> <h3> Company: ' . htmlspecialchars($row['company']) ;
                        echo '<br> <h3> Location: ' . htmlspecialchars($row['location']) ;
                        echo '<br> <h3> Job Description: ' . htmlspecialchars($row['job_description']) ;
                        echo '</div>';
                    }
            } else {
                echo '<p>No job listings available.</p>';
            }

        }
        
        ?>


    <script src="./js/profile-seeker.js"></script>
    <script src="js/common.js"></script>
</body>
</html>