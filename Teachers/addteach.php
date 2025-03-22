<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $section = isset($_POST['section']) && !empty($_POST['section']) ? $_POST['section'] : 'Not Assigned';
    $teach_level = $_POST['teach_level'];

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO teachers (lname, fname, mname, email, phone, section, teach_level) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $lname, $fname, $mname, $email, $phone, $section, $teach_level);
    
    if ($stmt->execute()) {
        // Redirect back to the teacher list page after successful insertion
        header("Location: teacher.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>