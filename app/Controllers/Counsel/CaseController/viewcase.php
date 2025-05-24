<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../../../../database/db_connect.php';
header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $case_id = $_GET['id'];
    $sql = "SELECT cr.*, s.lname, s.fname, s.educ_level AS academic_level, s.section, s.program
            FROM case_records cr
            JOIN students s ON cr.student_id = s.s_id
            WHERE cr.case_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $case_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        echo json_encode(['error' => $conn->error]);
        $stmt->close();
        $conn->close();
        exit;
    }

    $case = $result->fetch_assoc();
    $stmt->close();

    if (!$case) {
        echo json_encode(['error' => 'No case found or student record missing.']);
        $conn->close();
        exit;
    }

    $case['student_name'] = $case['lname'] . ', ' . $case['fname'];
    echo json_encode($case);
} else {
    echo json_encode(['error' => 'No case ID provided.']);
}
$conn->close();
?>
