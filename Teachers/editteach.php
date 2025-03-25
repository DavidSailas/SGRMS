<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php'; 

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the teacher ID is provided and valid
$t_id = filter_input(INPUT_GET, 't_id', FILTER_VALIDATE_INT);
if (!$t_id) {
    echo "Invalid teacher ID.";
    exit();
}

// Fetch the current details of the teacher and the associated user
$sql = "SELECT teachers.*, users.username 
        FROM teachers 
        JOIN users ON teachers.u_id = users.u_id 
        WHERE teachers.t_id = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $t_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $teacher = $result->fetch_assoc();
} else {
    echo "Teacher not found.";
    exit();
}

// Handle form submission for updating teacher details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $required_fields = ['lname', 'fname', 'mname', 'email', 'phone', 'teach_level', 'year_level', 'section', 'program'];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            echo "Error: Missing required field - " . $field;
            exit();
        }
    }

    $lname = trim($_POST['lname']);
    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = preg_replace('/[^0-9]/', '', $_POST['phone']);
    $teach_level = $_POST['teach_level'];
    $year_level = $_POST['year_level'];
    $section = $_POST['section'];
    $program = $_POST['program'];

    if (!$email) {
        echo "Invalid email format.";
        exit();
    }

    $update_sql = "UPDATE teachers SET lname=?, fname=?, mname=?, email=?, phone=?, teach_level=?, year_level=?, section=?, program=? WHERE t_id=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssssssssi", $lname, $fname, $mname, $email, $phone, $teach_level, $year_level, $section, $program, $t_id);

    if ($update_stmt->execute()) {
        header("Location: teacher_list.php?message=updated");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $update_stmt->close();
}

$stmt->close();
$conn->close();
?>
