<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $section = $_POST['section'];
    $program = $_POST['program'];
    $teach_level = $_POST['teach_level'];
    $year_level = $_POST['year_level'];
    
    // New user account details
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $status = 'Pending'; // Set status to Pending
    $role = 'Teacher';

    // Prepare and execute the SQL statement for users
    $sqlUser   = "INSERT INTO users (username, password, status, role) VALUES (?, ?, ?, ?)";
    $stmtUser   = $conn->prepare($sqlUser );
    $stmtUser ->bind_param("ssss", $username, $password, $status, $role);
    
    if ($stmtUser ->execute()) {
        // Get the last inserted user ID
        $u_id = $stmtUser ->insert_id;

        // Prepare and execute the SQL statement for teachers
        $sql = "INSERT INTO teachers (u_id, lname, fname, mname, email, phone, teach_level, year_level, section, program) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssssss", $u_id, $lname, $fname, $mname, $email, $phone, $teach_level, $year_level, $section, $program);
        
        if ($stmt->execute()) {
            // Redirect back to the teacher list page after successful insertion
            header("Location: teacher.php");
            exit();
        } else {
            echo "Error inserting teacher: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error creating user account: " . $stmtUser ->error;
    }

    $stmtUser ->close();
}

$conn->close();
?>