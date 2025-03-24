<?php
require "../PHP/db_connect.php";  // Ensure this file connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["user_id"]) && isset($_POST["action"])) {
        $userId = intval($_POST["user_id"]);
        $action = $_POST["action"];

        if ($action == "enable") {
            $sql = "UPDATE users SET status = 'enabled' WHERE id = ?";
        } elseif ($action == "disable") {
            $sql = "DELETE FROM users WHERE id = ?";
        }

        if (isset($sql)) {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            if ($stmt->execute()) {
                echo "User updated successfully!";
            } else {
                echo "Error updating user.";
            }
            $stmt->close();
        }
    }
}

header("Location: admin.php"); // Redirect back to admin panel
exit();
?>