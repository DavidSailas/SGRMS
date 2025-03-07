<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); 

    // Prepare the query to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    if(!$stmt){
        $_SESSION['error_username'] = "Database error: " . $conn->error;
        header("Location: index.php");
        exit();
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the user is found
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Compare the hashed password (note: md5 is not secure for production)
        if (md5($password) === $user['password']) { 
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on user role (use absolute paths if needed)
            switch ($user['role']) {
                case 'Super Admin':
                    header("Location: /SGRMS/SuperAdmin/superadmin.php");
                    break;
                case 'Admin':
                    header("Location: /SGRMS/admin.php");
                    break;
                case 'Super User':
                    header("Location: /SGRMS/superuser.php");
                    break;
                case 'User':
                    header("Location: /SGRMS/user.php");
                    break;
                default:
                    header("Location: /SGRMS/index.php");
            }
            exit();
        } else {
            // Wrong password: set error for password field and preserve the username
            $_SESSION['error_password'] = "Wrong password!";
            $_SESSION['old_username'] = $username;
            header("Location: /SGRMS/Login/index.php");
            exit();
        }
    } else {
        // User not found: set error for username field
        $_SESSION['error_username'] = "User not found!";
        header("Location: /SGRMS/Login/index.php");
        exit();
    }
}
?>
