<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/common.css">
</head>

<body>
    <?php
        session_start();
        require "../PHP/db_connect.php";
        if(!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in'] === true){
            echo '<a href="login.php" id="loginLink">Login</a>';
        }elseif(!$_SESSION['role'] === "admin"){
            echo '<a href="login.php" id="loginLink">Login</a>';
        }
        ?>
    <div id="innerHTML">
        <h1>Admin Panel</h1>

        <div class="dashboard">
            <h2>Dashboard</h2>
            <?php 
            
        $stmt = $conn->prepare("SELECT COUNT(users.id) FROM users WHERE users.status = 'active' GROUP BY users.status ");
        $stmt->execute();
        $stmt->bind_result($activeUsersCount);
        $stmt->fetch();
        $stmt->close();
        if($activeUsersCount == null){$activeUsersCount =0;}

        $stmt = $conn->prepare("SELECT COUNT(jobs.id) FROM jobs");
        $stmt->execute();
        $stmt->bind_result($jobsCount);
        $stmt->fetch();
        $stmt->close();
        if($activeUsersCount == null){$activeUsersCount =0;}
            ?>
            <h3 id="curSiteList">Current Site Listings: <?php echo $jobsCount?></h3>
            <h3 id="curSiteUser">Current Site Users: <?php echo $activeUsersCount?></h3>
        </div>

        <div class="dashboard">
            <h2>Search For Users: </h2>
            <div id="searchBar">
                <input type="text" id="searchInput" placeholder="Search Users by Name or Email...">
            </div>
            <div id="userListContainer">
                <?php
                    

                    $sql = "SELECT id, name, email, status FROM users";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='user' data-username='" . strtolower($row["name"]) . "' data-email='" . strtolower($row["email"]) . "'> 
                        <p>UserID: " . $row["id"] . " - Username: " . $row["name"] . " - Email: " . $row["email"] . "</p>
                        <form action='../PHP/update_user.php' method='POST' style='display: inline;'>
                            <input type='hidden' name='user_id' value='" . $row["id"] . "'>
                            <button type='submit' name='action' value='enable'>Enable</button>
                        </form>
                        <form action='../PHP/update_user.php' method='POST' style='display: inline;'>
                            <input type='hidden' name='user_id' value='" . $row["id"] . "'>
                            <button type='submit' name='action' value='disable'>Disable</button>
                        </form>
                        <p>" . strtolower($row["status"]) . "</p>
                      </div>";
                 }
                ?>
            </div>
        </div>
<!--
        <div id="viewReportedIssue" style="display: none;">
            <h2>View Issue</h2>
            <div id="innerText" class="textDiv">
                <h2>Job Details</h2>
                <br>
                <p id="jobLocation">Job Location (Remote/In-Person, City)</p>
                <p id="salaryRange">Salary Range (if provided)</p>
                <p id="employementType">Employment Type (Full-time, Part-time, Contract, Internship)</p>
                <p id="jobDescription">Job Description (Detailed overview of responsibilities)</p>
                <p id="reqQual">Requirements & Qualifications (Experience, skills, certifications)</p>
                <p id="Bene">Benefits (401k, health insurance, PTO, etc.)</p>
            </div>
            <br>
            <div class="textDiv">
                <p id="jobDate">Job listed on: February 26 2025</p>
                <p id="deadline">Deadline: June 6 2025</p>
            </div>
            <div id="buttonHolder">

                <button id="delList" class="repBut">Delete Listing</button>
                <button id="reqEdit" class="repBut">Request Edits</button>
                <button id="close" class="repBut">Close</button>
            </div>
        </div>
        <div class="dashboard">
            <h1>Reports Dashboard</h1>
            <h3>Reported Issues</h3>
            <h4 id="curSiteIssues">Current reported issues: <span id="issueCount">2</span></h4>

            <div id="filterOptions">
                <label><input type="checkbox" class="filterCheckbox" value="spam" checked> Spam</label>
                <label><input type="checkbox" class="filterCheckbox" value="misleading" checked> Misleading</label>
                <label><input type="checkbox" class="filterCheckbox" value="offensive" checked> Offensive</label>
                <label><input type="checkbox" class="filterCheckbox" value="other" checked> Other</label>
            </div>

            <ul id="reportedIssues">
                <li data-category="spam">Job #123 - Reported for Spam <a class="viewProb">view</a></li>
                <li data-category="misleading">Job #124 - Misleading Information <a class="viewProb">view</a></li>
                <li data-category="offensive">Job #125 - Offensive Content <a class="viewProb">view</a></li>
                <li data-category="other">Job #126 - Other Issue <a class="viewProb">view</a></li>
                <li data-category="other">Job #22 - Other Issue 2 <a class="viewProb">view</a></li>
            </ul>

            <h3>Reported Users</h3>
            <div id="filterOptionsUsers">
                <label><input type="checkbox" class="filterCheckbox1" value="spam" checked> Spam</label>
                <label><input type="checkbox" class="filterCheckbox1" value="misleading" checked> Misleading</label>
                <label><input type="checkbox" class="filterCheckbox1" value="offensive" checked> Offensive</label>
                <label><input type="checkbox" class="filterCheckbox1" value="other" checked> Other</label>
            </div>
            
            <ul id="userList">
                <li data-category="spam">User #123 - Reported for Spam <a class="viewProb">view</a></li>
                <li data-category="misleading">User #124 - Misleading Information <a class="viewProb">view</a></li>
                <li data-category="offensive">User #125 - Offensive Content <a class="viewProb">view</a></li>
                <li data-category="other">User #126 - Other Issue <a class="viewProb">view</a></li>
                <li data-category="other">User #22 - Other Issue 2 <a class="viewProb">view</a></li>
            </ul>
        </div>
    </div>
                -->
    <script src="js/common.js"></script>
    <script src="js/admin.js"></script>