<?php
session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    if ($action === "login") {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $name, $hashed_password, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $name;
                $_SESSION['role'] = $role;//employee, employer, admin
                $_SESSION['user_logged_in'] = true;
                echo "<script>alert('Login Successful! ".$name."'); window.location.href = '../Frontend/index.php';</script>";
                exit();

            } else {
                echo "<script>alert('Wrong password, please try again'); window.location.href = '../Frontend/login.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Email does not exist, please create a account'); window.location.href = '../Frontend/login.php';</script>";
            exit();
        }

        $stmt->close();
    } elseif ($action === "signup") {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        $role = $_POST['role'];

        $company_name = $location = $industry = $website = null;
        if ($role === "employer") {
            $company_name = trim($_POST['company-name']);
            $location = trim($_POST['location']);
            $industry = trim($_POST['industry']);
            $website = trim($_POST['website']);
        }

        $profile_image = null; 
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
            $profile_image = file_get_contents($_FILES['profile_image']['tmp_name']); 
        }
        
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            die("This email is already registered. Try logging in.");
        }
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, company_name, location, industry, website, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"); 
        $stmt->bind_param("sssssssss", $name, $email, $password, $role, $company_name, $location, $industry, $website, $profile_image);

        if ($stmt->execute()) {
            echo "<script>alert('Sign up successful, you can sign in now.'); window.location.href = '../Frontend/login.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
