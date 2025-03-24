<?php
session_start();
require_once "../PHP/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $image = null;
    $uploadError = null;


    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($_FILES['profile_image']['tmp_name']);
        if (strpos($mime, 'image/') === 0) {
            $image = file_get_contents($_FILES['profile_image']['tmp_name']);
        } else {
            $uploadError = "Invalid file type. Please upload an image.";
        
        }
    } elseif (isset($_FILES['profile_image'])) {
        $uploadError = "File upload error: " . $_FILES['profile_image']['error'];}

    if ($uploadError) {
        echo "<script>alert('$uploadError'); window.history.back();</script>";
        exit();
    }

    if ($image !== null) {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, profile_image = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $image, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $email, $user_id);
    }

    if ($stmt->execute()) {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        echo "<script>alert('Profile updated successfully!'); window.location.href = '../Frontend/profile-seeker.php';</script>";
    } else {
        echo "<script>alert('Error updating profile.'); window.history.back();</script>";
    }

    $stmt->close();
}
?>