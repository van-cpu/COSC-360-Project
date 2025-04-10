<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Profile Management</title>
    <link rel="stylesheet" href="./css/profile-employer.css">
    <link rel="stylesheet" href="css/common.css">
</head>
<body>
<?php
        require_once "../PHP/db_connect.php";
        session_start();
        $employer_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true){
        if($_SESSION['user_id'] == $employer_id){header("Location: profile-seeker.php");}
        }else{
            echo '<a href="login.php" id="loginLink">Login</a>';      
        }

        $stmt = $conn->prepare("SELECT name,email,company_name,location,industry,website,profile_clicks FROM users WHERE id = ?");
        $stmt->bind_param("i", $employer_id);
        $stmt->execute();
        $stmt->bind_result($name,$email,$company,$location,$industry,$website,$profile_clicks);
        $stmt->fetch();
        $stmt->close();

        if(!isset($_SESSION['user_clicked' .$employer_id])){//so it only goes up if they are not the employer
            $_SESSION['user_clicked'.$employer_id] = true;
            $profile_clicks +=1;
        
            $stmt = $conn->prepare("UPDATE users SET profile_clicks = ? WHERE id = ?");
            $stmt->bind_param("ii", $profile_clicks, $employer_id);
            $stmt->execute();
            $stmt->close();
        }        
        ?>
    <div class="container">
        <h1><?php echo $name?>'s Profile</h1>
        
        <!-- Company Info Card -->
        <div class="card">
            <h2>Company Info</h2>
            <h3>Email contact:  <?php echo $email?></h3>
            <h3>Comapny Name: <?php echo $company?></h3>
            <h3>Location: <?php echo $location?> </h3>
            <h3>Industry: <?php echo $industry?></h3>
            <h3>Website: <?php echo $website?></h3>
            <h3>Profile Clicks: <?php echo $profile_clicks?></h3>
            
        </div>

      <?php 
              $stmt = $conn->prepare("SELECT id, title, company, location, salary, posted_at FROM jobs WHERE user_id = ?");
              $stmt->bind_param("i", $employer_id);

              $stmt->execute();
              $result = $stmt->get_result();
              $stmt->close();
      
      ?>
    <div>
            <h3>Job Postings</h3>
            <div id="job-postings-list">
                <ol>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li class="card" onclick="window.location.href='job-details.php?id=<?php echo $row['id']; ?>'">
                            Title: <?php echo htmlspecialchars($row['title']); ?><br>
                            Company: <?php echo htmlspecialchars($row['company']); ?><br>
                            Location: <?php echo htmlspecialchars($row['location']); ?><br>
                            Salary: <?php echo htmlspecialchars($row['salary']); ?><br>
                            Posted At: <?php echo htmlspecialchars($row['posted_at']); ?>
                            <h3> Apply </h3>
                        </li>
                    <?php endwhile; ?>
                </ol>
            </div>
    </div>


    </div>

    <script src="./js/profile-employer.js"></script>
    <script src="js/common.js"></script>
</body>
</html>