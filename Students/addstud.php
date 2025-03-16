<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lname = isset($_POST['lname']) ? trim($_POST['lname']) : '';
    $fname = isset($_POST['fname']) ? trim($_POST['fname']) : '';
    $mname = isset($_POST['mname']) ? trim($_POST['mname']) : '';
    $bod = isset($_POST['bod']) ? $_POST['bod'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $mobile_num = isset($_POST['mobile_num']) ? trim($_POST['mobile_num']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $educ_level = isset($_POST['educ_level']) ? $_POST['educ_level'] : '';
    $year_level = isset($_POST['year_level']) ? $_POST['year_level'] : '';
    $section = isset($_POST['section']) ? trim($_POST['section']) : '';

    if (empty($lname) || empty($fname) || empty($bod) || empty($gender) || empty($address) ||
        empty($mobile_num) || empty($email) || empty($educ_level) || empty($year_level) || empty($section)) {
        echo "All fields are required.";
        exit;
    }

    $sql = "INSERT INTO students (lname, fname, mname, bod, gender, address, mobile_num, email, educ_level, year_level, section) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss", $lname, $fname, $mname, $bod, $gender, $address, $mobile_num, $email, $educ_level, $year_level, $section);

    if ($stmt->execute()) {
        echo "Student added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
