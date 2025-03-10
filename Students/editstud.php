<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (isset($_GET['s_id'])) {
    // Get the student ID from the GET request
    $s_id = $_GET['s_id'];

    // Prepare SQL query to fetch student data
    $sql = "SELECT s_id, lname, fname, mname, bod, gender, address, mobile_num, email, educ_level, year_level, section FROM students WHERE s_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $s_id); // Bind the student ID as an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the data as an associative array
        $student = $result->fetch_assoc();
        // Return the student data as JSON
        echo json_encode($student);
    } else {
        // Return an error message if the student was not found
        echo json_encode(['error' => 'Student not found']);
    }

    $stmt->close();
    $conn->close();
} else {
    // If the student ID is not provided, redirect to the student list page
    header("Location: students.php");
    exit();
}
?>
