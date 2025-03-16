<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $_SESSION['input_username'] = $username; // Store username to re-fill form if login fails

    // Validate input
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Both fields are required!";
        header("Location: login.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            switch ($user['role']) {
                case 'Super Admin':
                    header("Location: superadmin.php");
                    break;
                case 'Admin':
                    header("Location: admin_dashboard.php");
                    break;
                case 'Super User':
                    header("Location: superuser_dashboard.php");
                    break;
                case 'User':
                    header("Location: user_dashboard.php");
                    break;
                default:
                    header("Location: login.php");
            }
            unset($_SESSION['input_username']); // Clear username session after successful login
            exit();
        } else {
            $_SESSION['error'] = "Incorrect password!";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "User not found!";
        header("Location: login.php");
        exit();
    }
}
?>
