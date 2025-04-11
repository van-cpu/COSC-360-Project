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

    // Comment submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'add_comment') {
            if (!empty($_POST['comment_text']) && isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $user_name = $_SESSION['name'];
                $comment_text = trim($_POST['comment_text']);

                $stmt = $conn->prepare("INSERT INTO comments (employer_id, user_id, user_name, comment_text) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiss", $employer_id, $user_id, $user_name, $comment_text);
                $stmt->execute();
                $stmt->close();

                header("Location: profile-employer.php?id=$employer_id");
                exit();
            }
        }

        if (isset($_POST['action']) && $_POST['action'] === 'delete_comment') {
            $comment_id = intval($_POST['comment_id']);
            $user_id = $_SESSION['user_id'];
            $is_admin = isset($_SESSION['is_admin']) ? $_SESSION['is_admin'] : 0;

            $stmt = $conn->prepare("DELETE FROM comments WHERE id = ? AND (user_id = ? OR ? = 1)");
            $stmt->bind_param("iii", $comment_id, $user_id, $is_admin);
            $stmt->execute();
            $stmt->close();

            header("Location: profile-employer.php?id=$employer_id");
            exit();
        }
    }

    // Redirect logged-in employer to their own editable page
    if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
        if ($_SESSION['user_id'] == $employer_id) {
            header("Location: profile-seeker.php");
            exit();
        }
    } else {
        echo '<a href="login.php" id="loginLink">Login</a>';
    }

    // Fetch employer info
    $stmt = $conn->prepare("SELECT name,email,company_name,location,industry,website,profile_clicks FROM users WHERE id = ?");
    $stmt->bind_param("i", $employer_id);
    $stmt->execute();
    $stmt->bind_result($name,$email,$company,$location,$industry,$website,$profile_clicks);
    $stmt->fetch();
    $stmt->close();

    // Increment profile clicks (only once per session)
    if (!isset($_SESSION['user_clicked' . $employer_id])) {
        $_SESSION['user_clicked' . $employer_id] = true;
        $profile_clicks += 1;

        $stmt = $conn->prepare("UPDATE users SET profile_clicks = ? WHERE id = ?");
        $stmt->bind_param("ii", $profile_clicks, $employer_id);
        $stmt->execute();
        $stmt->close();
    }
?>
<div class="container">
    <h1><?php echo htmlspecialchars($name) ?>'s Profile</h1>

    <!-- Company Info Card -->
    <div class="card">
        <h2>Company Info</h2>
        <p><strong>Email contact: <?php echo htmlspecialchars($email) ?></strong></p><br>
        <p><strong>Company Name: <?php echo htmlspecialchars($company) ?></strong></p><br>
        <p><strong>Location: <?php echo htmlspecialchars($location) ?></strong></p><br>
        <p><strong>Industry: <?php echo htmlspecialchars($industry) ?></strong></p><br>
        <p><strong>Website: <?php echo htmlspecialchars($website) ?></strong></p><br>
        <p><strong>Profile Clicks: <?php echo htmlspecialchars($profile_clicks) ?></strong></p>
    </div>

    <!-- Job Postings -->
    <?php 
        $stmt = $conn->prepare("SELECT id, title, company, location, salary, posted_at FROM jobs WHERE user_id = ?");
        $stmt->bind_param("i", $employer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    ?>
    <div class="card">
        <h2>Job Postings</h2>
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

    <!-- Comments Section -->
    <div class="card">
        <h2>Comments</h2>
            <form action="" method="POST">
                <input type="text" name="comment_text" placeholder="Write a comment..." required style="text-align: start; width:100%; height:40px;">
                <input type="hidden" name="action" value="add_comment">
                <button type="submit">Post Comment</button>
            </form>
        <?php
            $stmt = $conn->prepare("SELECT id, user_name, comment_text, created_at, user_id FROM comments WHERE employer_id = ? ORDER BY created_at DESC");
            $stmt->bind_param("i", $employer_id);
            $stmt->execute();
            $comments = $stmt->get_result();

            while ($comment = $comments->fetch_assoc()):
        ?>
            <div class="comment">
                <br>
                <p><strong><?php echo htmlspecialchars($comment['user_name']); ?></strong> said:</p>
                <p style="word-break: break-word; overflow-wrap: break-word; white-space: pre-wrap;"><?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></p>
                <p><small><?php echo $comment['created_at']; ?></small></p>

                <?php
                    if (isset($_SESSION['user_id']) &&  ($_SESSION['user_id'] == $comment['user_id'] || (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1))): ?>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="delete_comment">
                        <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                        <button type="submit" onclick="return confirm('Delete this comment?')">Delete</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
        <?php $stmt->close(); ?>
    </div>
</div>

<script src="./js/profile-employer.js"></script>
<script src="js/common.js"></script>
</body>
</html>
