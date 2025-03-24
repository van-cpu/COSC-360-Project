<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link rel="stylesheet" href="css/job-listings.css">
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

    $isSignedIn = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
    if (!$isSignedIn) {
        echo '<a href="login.php" id="loginLink">Login</a>';
    }
?>
<!-- Inject PHP session info into JS -->
<script>
    let isSignedIn = <?php echo $isSignedIn ? 'true' : 'false'; ?>;
</script>

<div class="main">
    <div class="search">
        <h1> Search Job Listing Board </h1>
        <img src="photos/search-2911.png">
        <input type="text" id="searchInput" placeholder="Job Title...">
    </div>

    <div class="catagories">
        <button onclick="tagSelect('fulltime')" id="fulltime"> Full Time </button>
        <button onclick="tagSelect('parttime')" id="parttime"> Part Time </button>
        <button onclick="tagSelect('freelance')" id="freelance"> Freelance </button>
        <button onclick="tagSelect('remote')" id="remote"> Remote </button>
        <button onclick="tagSelect('manager')" id="manager"> Manager </button>
        <button onclick="tagSelect('retail')" id="retail"> Retail </button>
        <button onclick="tagSelect('noexperience')" id="noexperience"> No Experience </button>
    </div>

    <!-- This will be dynamically filled -->
    <div class="card" id="jobResults"></div>
    <div id="pagination" class="pagination-controls"></div>

</div>

<script src="js/common.js"></script>
<script src="js/job-listings.js"></script>
</body>
</html>
