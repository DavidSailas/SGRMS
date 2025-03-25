<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (isset($_GET['t_id'])) {
    $t_id = $_GET['t_id'];
    $sql = "SELECT * FROM teachers WHERE t_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $t_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $teacher = $result->fetch_assoc();
        echo json_encode($teacher); 
    } else {
        echo json_encode(['error' => 'Teacher not found']);
    }
} else {
    echo json_encode(['error' => 'No teacher ID provided']);
}

$conn->close();
?>