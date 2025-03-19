<?php
session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action === "login") {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $hashed_password, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $role;
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Wrong password.";
            }
        } else {
            echo "This email does not exist. Please sign up.";
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

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            die("This email is already registered. Try logging in.");
        }
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, company_name, location, industry, website) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $name, $email, $password, $role, $company_name, $location, $industry, $website);

        if ($stmt->execute()) {
            echo "Signup successful! You can now login.";
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
