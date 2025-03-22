<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (isset($_GET['s_id'])) {
    $s_id = $_GET['s_id'];
    $sql = "SELECT * FROM students WHERE s_id = '$s_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $student = $result->fetch_assoc();
        echo json_encode($student); 
    } else {
        echo json_encode(['error' => 'Student not found']);
    }
} else {
    echo json_encode(['error' => 'No student ID provided']);
}

$conn->close();
?>