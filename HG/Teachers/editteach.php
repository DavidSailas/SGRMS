<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

// Debug: Check if t_id is received via POST or GET
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $t_id = filter_input(INPUT_POST, 't_id', FILTER_VALIDATE_INT);
    if (!$t_id) {
        echo "Invalid teacher ID (POST).";
        exit();
    }
} else {
    $t_id = filter_input(INPUT_GET, 't_id', FILTER_VALIDATE_INT);
    if (!$t_id) {
        echo "Invalid teacher ID (GET).";
        exit();
    }
}

// Debug: Print the t_id
echo "Teacher ID: " . $t_id . "<br>";

// Fetch the current details of the teacher and the associated user
$sql = "SELECT teachers.*, users.username, users.u_id 
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
    // Debug: Print submitted form data
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Make program and section optional
    $required_fields = ['lname', 'fname', 'mname', 'email', 'phone', 'teach_level', 'year_level', 'username', 'password'];

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
    $section = isset($_POST['section']) ? $_POST['section'] : null; // Make section optional
    $program = isset($_POST['program']) ? $_POST['program'] : null; // Make program optional
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    if (!$email) {
        echo "Invalid email format.";
        exit();
    }

    // Start a transaction to ensure both updates succeed or fail together
    $conn->begin_transaction();

    try {
        // Update the teachers table
        $update_teacher_sql = "UPDATE teachers SET lname=?, fname=?, mname=?, email=?, phone=?, teach_level=?, year_level=?, section=?, program=? WHERE t_id=?";
        $update_teacher_stmt = $conn->prepare($update_teacher_sql);
        $update_teacher_stmt->bind_param("sssssssssi", $lname, $fname, $mname, $email, $phone, $teach_level, $year_level, $section, $program, $t_id);

        if (!$update_teacher_stmt->execute()) {
            throw new Exception("Error updating teacher record: " . $update_teacher_stmt->error);
        }

        // Update the users table
        $update_user_sql = "UPDATE users SET username=?, password=? WHERE u_id=?";
        $update_user_stmt = $conn->prepare($update_user_sql);
        $update_user_stmt->bind_param("ssi", $username, $password, $teacher['u_id']);

        if (!$update_user_stmt->execute()) {
            throw new Exception("Error updating user record: " . $update_user_stmt->error);
        }

        // Commit the transaction if both updates succeed
        $conn->commit();

        // Redirect to the teacher list page with a success message
        header("Location: teacher.php?");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction if any update fails
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $update_teacher_stmt->close();
    $update_user_stmt->close();
}

$stmt->close();
$conn->close();
?>