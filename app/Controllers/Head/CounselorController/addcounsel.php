<?php
include '../../../../database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lname = isset($_POST['lname']) ? trim($_POST['lname']) : '';
    $fname = isset($_POST['fname']) ? trim($_POST['fname']) : '';
    $mname = isset($_POST['mname']) ? trim($_POST['mname']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $contact_num = isset($_POST['contact_num']) ? trim($_POST['contact_num']) : '';
    $c_level = isset($_POST['c_level']) ? trim($_POST['c_level']) : '';
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $c_image = ''; // Set this if you have image upload

    if (empty($lname) || empty($fname) || empty($email) || empty($contact_num) || empty($c_level) || empty($username) || empty($password)) {
        die("All fields are required.");
    }

    // 1. Insert into counselors table
    $sqlCounselor = "INSERT INTO counselors (lname, fname, mname, contact_num, email, c_level, c_image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtCounselor = $conn->prepare($sqlCounselor);
    $stmtCounselor->bind_param("sssssss", $lname, $fname, $mname, $contact_num, $email, $c_level, $c_image);

    if ($stmtCounselor->execute()) {
        $counselor_id = $conn->insert_id;
        $stmtCounselor->close();

        // 2. Insert into users table with status, role, and counselor_id
        $student_id = null;
        $parent_id = null;
        $sqlUser  = "INSERT INTO users (username, password, status, role, student_id, parent_id, counselor_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtUser  = $conn->prepare($sqlUser);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = 'Guidance Counselor';
        $status = 'Active';
        $stmtUser->bind_param("ssssiii", $username, $hashedPassword, $status, $role, $student_id, $parent_id, $counselor_id);

        if ($stmtUser->execute()) {
            header("Location: ../../../../resources/view/Head/counsel.php");
            exit();
        } else {
            echo "Error: " . $stmtUser->error;
        }
        $stmtUser->close();
    } else {
        echo "Error: " . $stmtCounselor->error;
    }
}

$conn->close();
?>