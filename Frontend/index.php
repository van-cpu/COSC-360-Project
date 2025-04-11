<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/common.css">
</head>
<body>
   <a name="top"></a>
   <div class="main">
    <div class="welcome">
        <?php
        session_start();
        require '../PHP/db_connect.php';
        if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true){
        echo '<a href="logout.php" id="logoutLink">Logout</a>';
        echo "<h1> Welcome ".$_SESSION['name']."</h1>"; 
        if ($_SESSION['role'] === 'employer') {
            echo '<a href="create-job.php" id="createJob">Create Job</a>';
              
        }else if ($_SESSION['role'] === 'admin') {
           // echo '<a href="admin.php" id="adminPanel">Admin Panel</a>';
              
        }
        }else{
            echo '<a href="login.php" id="loginLink">Login</a>';      
            echo  "<h1> Welcome </h1>";
        }
        
        ?>

        <p> Search for jobs, employers and post your job listings!</p>
    </div>
 
    <div class="card">
    <h1> Popular Jobs </h1>
    <?php
    $result = $conn->query("SELECT id, title, job_description FROM jobs ORDER BY click_count DESC LIMIT 4");
        if ($result->num_rows > 0) {
            $counter =0;
            while ($row = $result->fetch_assoc()) {
                if ($counter < 4) {
                    $counter += 1;
                echo '<div class="jobcard" onclick="window.location.href=\'job-details.php?id=' . $row['id'] . '\'">';
                echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
                echo '<p>' . htmlspecialchars($row['job_description']) . '</p>';
                echo '<button> See More </button>';
                echo '</div>';
            }}
        } else {
            echo '<p>No job listings available.</p>';
        }
        ?>
    </div>

    <div class="card">
    <h1> Popular Employers </h1>
    <?php
    $result = $conn->query("SELECT id, name, company_name, profile_clicks FROM users WHERE role = 'employer' ORDER BY profile_clicks DESC LIMIT 4");
        if ($result->num_rows > 0) {
            $counter =0;
            while ($row = $result->fetch_assoc()) {
                if ($counter < 4) {
                    $counter += 1;
                    echo '<div class="employercard" onclick="window.location.href=\'profile-employer.php?id=' . $row['id'] . '\'">';
                    echo '<h2>' . htmlspecialchars($row['name']) . ' - ' . htmlspecialchars($row['company_name']) . '</h2>';
                    echo '<p>Profile Clicks: ' . htmlspecialchars($row['profile_clicks']) . '</p>';
                    echo '<button>View Profile</button>';
                    echo '</div>';
            }}
        } else {
            echo '<p>No job listings available.</p>';
        }
        ?>
    </div>




    <div id="bottomnav">
        <a href="#top">Back to Top</a>
    </div>
</div>

    <script src="js/common.js"></script>
    <script src="js/index.js"></script>
</body>
</html>
