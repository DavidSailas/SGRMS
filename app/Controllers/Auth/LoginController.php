<?php
session_start();
include '../../../database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); 

    // Prepare the query to join users and students
    $stmt = $conn->prepare("
        SELECT users.*, students.fname AS student_fname, parents.guardian_name AS parent_name 
        FROM users 
        LEFT JOIN students ON users.student_id = students.s_id 
        LEFT JOIN parents ON users.parent_id = parents.p_id 
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
            $_SESSION['parent_id'] = $user['parent_id'];
            $_SESSION['parent_name'] = $user['parent_name']; 


            // Redirect based on user role
            switch ($user['role']) {
                case 'Head Guidance':
                    header("Location: ../../../resources/view/Head/dashboard.php");
                    break;
                case 'Guidance Counselor':
                    $counselorStmt = $conn->prepare("SELECT c_id FROM counselors WHERE c_id = ?");
                    $counselorStmt->bind_param("i", $user['counselor_id']);
                    $counselorStmt->execute();
                    $counselorResult = $counselorStmt->get_result();

                    if ($counselorResult->num_rows > 0) {
                        $counselor = $counselorResult->fetch_assoc();
                        $_SESSION['counselor_id'] = $counselor['c_id'];  
                        header("Location: ../../../resources/view/Counsel/dashboard.php");
                    } else {
                        $_SESSION['error_username'] = "Counselor data not found!";
                        header("Location: ../../../index.php");
                    }
                    break;
                case 'Parent':
                    header("Location:  ../../../resources/view/Parent/dashboard.php");
                    break;
                case 'Student':
                    header("Location:  ../../../resources/view/Student/dashboard.php");
                    break;
                default:
                    header("Location: ../../../index.php");
            }
            exit();
        } else {
            // Wrong password: set error for password field and preserve the username
            $_SESSION['error_password'] = "Wrong password!";
            $_SESSION['old_username'] = $username;
            header("Location: ../../../index.php");
            exit();
        }
    } else {
        // User not found: set error for username field
        $_SESSION['error_username'] = "User  not found!";
        header("Location: ../../../index.php");
        exit();
    }
} else {
    header("Location: ../../../index.php");
    exit();
}
?>