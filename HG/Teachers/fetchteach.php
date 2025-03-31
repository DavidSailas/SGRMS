<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

$t_id = filter_input(INPUT_GET, 't_id', FILTER_VALIDATE_INT);
if (!$t_id) {
    echo json_encode(['error' => 'Invalid teacher ID']);
    exit();
}

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
    echo json_encode($teacher);
} else {
    echo json_encode(['error' => 'Teacher not found']);
}

$stmt->close();
$conn->close();
?>