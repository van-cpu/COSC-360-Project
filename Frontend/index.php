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
        if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true){
        
        echo "<h1> Welcome ".$_SESSION['name']."</h1>"; 
        if ($_SESSION['role'] === 'employer') {
            echo '<a href="create-job.php" id="createJob">Create Job</a>';
        }
        }else{
            echo '<a href="login.php" id="loginLink">Login</a>';      
            echo  "<h1> Welcome </h1>";
        }
        
        ?>

        <p> Description of job website</p>
    </div>
   

    <div class="card">
        <h1> Popular Jobs </h1>
        <div class="jobcard" onclick="jobClicked('job1')"> 
            <h2> Job Listing 1 </h1>
            <p> Description </p>
            <button> See More </button>
        </div>
        <div class="jobcard" onclick="jobClicked('job1')">
            <h2> Job Listing 2 </h1>
            <p> Description </p>
            <button> See More </button>
        </div>
        <div class="jobcard" onclick="jobClicked('job1')">
            <h2> Job Listing 3 </h1>
            <p> Description </p>
            <button> See More </button>
        </div>
        <div class="jobcard" onclick="jobClicked('job1')">
            <h2> Job Listing 4 </h1>
            <p> Description </p>
            <button> See More </button>
        </div>
    </div>

    <div class="card">
        <div class="jobtypes">
            <p><b> Trending Job Types:</b><a href="job-listings.html"> Freelance </a>
                <a href="job-listings.html"> Full Time </a>
                <a href="job-listings.html"> Remote </a>
                <a href="job-listings.html"> Part Time </a>
                <a href="job-listings.html"> Manager </a> 
                <a href="job-listings.html"> No Experience </a>
                <a href="job-listings.html"> Retail </a><p>
        </div>
    </div>

    <div class="card">
        <h1> Popular Employers </h1>
        <div class="employercard" onclick="employerClicked('job1')">
            <h2> Employer  1 </h1> 
        </div>
        <div class="employercard" onclick="employerClicked('job1')">
            <h2> Employer  2 </h1> 
        </div>
        <div class="employercard" onclick="employerClicked('job1')">
            <h2> Employer  3 </h1> 
        </div>
        <div class="employercard" onclick="employerClicked('job1')">
            <h2> Employer  4 </h1> 
        </div>
    </div>

    <div class="card">
        <h1> Extra Resources </h1>
    </div>

    <div id="bottomnav">
        <a href="#top">Back to Top</a>
    </div>
</div>

    <script src="js/common.js"></script>
    <script src="js/index.js"></script>
</body>
</html>
