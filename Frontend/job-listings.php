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

    <div class="filters">
    <?php
// Fetch distinct locations and industries
$locations = [];
$industries = [];

$locationResult = $conn->query("SELECT DISTINCT location FROM jobs WHERE location IS NOT NULL AND location != ''");
while ($row = $locationResult->fetch_assoc()) {
    $locations[] = $row['location'];
}

$industryResult = $conn->query("SELECT DISTINCT industry FROM jobs WHERE industry IS NOT NULL AND industry != ''");
while ($row = $industryResult->fetch_assoc()) {
    $industries[] = $row['industry'];
}
?>

<label for="filter-location">Location:</label>
<select id="filter-location">
    <option value="">All Locations</option>
    <?php foreach ($locations as $loc): ?>
        <option value="<?= htmlspecialchars($loc) ?>"><?= htmlspecialchars($loc) ?></option>
    <?php endforeach; ?>
</select>

<label for="filter-industry">Industry:</label>
<select id="filter-industry">
    <option value="">All Industries</option>
    <?php foreach ($industries as $ind): ?>
        <option value="<?= htmlspecialchars($ind) ?>"><?= htmlspecialchars($ind) ?></option>
    <?php endforeach; ?>
</select>

    <label for="sort-by">Sort By:</label>
    <select id="sort-by">
        <option value="date">Newest First</option>
        <option value="title">Title (A-Z)</option>
    </select>
</div>


    <!-- This will be dynamically filled -->
    <div class="card" id="jobResults"></div>
    <div id="pagination" class="pagination-controls"></div>

</div>

<script src="js/common.js"></script>
<script src="js/job-listings.js"></script>
</body>
</html>
