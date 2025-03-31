<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lname = isset($_POST['lname']) ? trim($_POST['lname']) : '';
    $fname = isset($_POST['fname']) ? trim($_POST['fname']) : '';
    $mname = isset($_POST['mname']) ? trim($_POST['mname']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $contact_num = isset($_POST['contact_num']) ? trim($_POST['contact_num']) : '';
    $c_level = isset($_POST['c_level']) ? trim($_POST['c_level']) : '';
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($lname) || empty($fname) || empty($email) || empty($contact_num) || empty($c_level) || empty($username) || empty($password)) {
        die("All fields are required.");
    }

    // Insert into users table
    $sqlUser  = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmtUser  = $conn->prepare($sqlUser );
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security
    $stmtUser ->bind_param("ss", $username, $hashedPassword);

    if ($stmtUser ->execute()) {
        $userId = $stmtUser ->insert_id; // Get the last inserted user ID

        // Insert into counselors table
        $status = 'Pending'; 
        $role = 'Guidance Counselor'; 
        $sqlCounselor = "INSERT INTO counselors (lname, fname, mname, email, contact_num, c_level, u_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtCounselor = $conn->prepare($sqlCounselor);
        $stmtCounselor->bind_param("ssssssi", $lname, $fname, $mname, $email, $contact_num, $c_level, $userId);

        if ($stmtCounselor->execute()) {
            header("Location: counsel.php");
            exit();
        } else {
            echo "Error: " . $stmtCounselor->error;
        }

        $stmtCounselor->close();
    } else {
        echo "Error: " . $stmtUser ->error;
    }

    $stmtUser ->close();
}

$conn->close();
?>