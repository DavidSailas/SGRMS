<?php
session_start();
include '../../../database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); 

    // Prepare the query to join users and students
    $stmt = $conn->prepare("
        SELECT users.*, students.fname 
        FROM users 
        LEFT JOIN students ON users.student_id = students.s_id 
        WHERE users.username = ?
    ");
    if (!$stmt) {
        $_SESSION['error_username'] = "Database error: " . $conn->error;
        header("Location: ../../../index.php");
        exit();
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the user is found
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Compare the hashed password
        if (password_verify($password, $user['password'])) { 
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['fname'] = $user['fname']; 

            // Redirect based on user role
            switch ($user['role']) {
                case 'Head Guidance':
                    header("Location: ../../../resources/view/Head/dashboard.php");
                    break;
                case 'Guidance Counselor':
                    header("Location:  ../../../resources/view/Counselor/dashboard.php");
                    break;
                case 'Parent':
                    header("Location:  ../../../resources/view/Parent/dashboard.php");
                    break;
                case 'Student':
                    header("Location:  ../../../resources/view/Student/dashboard.php");
                    break;
                default:
                    header("Location: index.php");
            }
            exit();
        } else {
            // Wrong password: set error for password field and preserve the username
            $_SESSION['error_password'] = "Wrong password!";
            $_SESSION['old_username'] = $username;
            header("Location: index.php");
            exit();
        }
    } else {
        // User not found: set error for username field
        $_SESSION['error_username'] = "User  not found!";
        header("Location: index.php");
        exit();
    }
}
?>