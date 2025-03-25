<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (isset($_GET['s_id'])) {
    $s_id = $_GET['s_id'];
    $sql = "SELECT * FROM students WHERE s_id = '$s_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $student = $result->fetch_assoc();

        // Calculate age
        $bod = new DateTime($student['bod']);
        $today = new DateTime();
        $age = $today->diff($bod)->y;

        // Prepare student data for display
        $studentData = [
            's_image' => !empty($student['s_image']) ? htmlspecialchars($student['s_image']) : '',
            'id_num' => htmlspecialchars($student['id_num']),
            'name' => htmlspecialchars($student['prefix'] . " " . $student['lname'] . ", " . $student['fname'] . " " . $student['mname']),
            'age' => htmlspecialchars($age),
            'dob' => htmlspecialchars($student['bod']),
            'sex' => htmlspecialchars($student['gender']),
            'address' => htmlspecialchars($student['address']),
            'mobile_num' => htmlspecialchars($student['mobile_num']),
            'email' => htmlspecialchars($student['email']),
            'educ_level' => htmlspecialchars($student['educ_level']),
            'year_level' => htmlspecialchars($student['year_level']),
            'section_program' => htmlspecialchars($student['educ_level'] === 'College' ? $student['program'] : $student['section']),
        ];

        echo json_encode($studentData);
    } else {
        echo json_encode(['error' => 'Student not found.']);
    }
} else {
    echo json_encode(['error' => 'No student ID provided.']);
}

$conn->close();
?>