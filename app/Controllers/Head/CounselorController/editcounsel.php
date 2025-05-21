<?php
include '../../../../database/db_connect.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data
    $c_id = intval($_POST['c_id']);
    $lname = trim($_POST['lname']);
    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $email = trim($_POST['email']);
    $contact_num = trim($_POST['contact_num']);
    $c_level = $_POST['c_level'];

    // Validate Required Fields
    if (empty($lname) || empty($fname) || empty($email) || empty($contact_num) || empty($c_level)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Update counselor record
    $sql = "UPDATE counselors SET lname=?, fname=?, mname=?, email=?, contact_num=?, c_level=? WHERE c_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $lname, $fname, $mname, $email, $contact_num, $c_level, $c_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Counselor updated successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}

// If not POST, return error
echo json_encode(['success' => false, 'message' => 'Invalid request.']);
?>