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

    <div class="container">
        <h1>Profile Management</h1>
        <?php 
        session_start();
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

        $profileImageSrc = $profile_image ? 'data:image/jpeg;base64,' . base64_encode($profile_image) : '../Frontend/photos/defaultimage.png';

        ?>
        <!-- Personal Info Card -->
        <div class="card">
            <h2>Personal Info</h2>
            
            <form id="personal-info-form" action="../PHP/profile-seekerLog.php" method="POST" onsubmit="return validatePersonalInfo()">
                <img src="<?php echo $profileImageSrc; ?>" alt="Profile Image" class="profile-image">
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

        <!-- Job Preferences Card -->
        <div class="card">
            <h2>Job Preferences</h2>
            <button onclick="addJobPreference()">+</button>
            <p>What kind of job preferences do you have?</p>
            <div id="job-preferences-list"></div>
        </div>

        <!-- Experience Card -->
        <div class="card">
            <h2>Experience</h2>
            <button onclick="showExperienceForm()">+</button>
            <p>What kind of experience do you have?</p>
            <div id="experience-list"></div>
        </div>

        <!-- Skills Card -->
        <div class="card">
            <h2>Skills</h2>
            <button onclick="addSkill()">+</button>
            <p>What kind of skills do you have?</p>
            <div id="skills-list"></div>
        </div>

        <!-- Education Card -->
        <div class="card">
            <h2>Education</h2>
            <button onclick="showEducationForm()">+</button>
            <p>What education do you have?</p>
            <div id="education-list"></div>
        </div>
    </div>

    <script src="./js/profile-seeker.js"></script>
    <script src="js/common.js"></script>
</body>
</html>