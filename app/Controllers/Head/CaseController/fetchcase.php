<?php
include '../../../../database/db_connect.php';

if (isset($_GET['case_id'])) {
    $case_id = intval($_GET['case_id']);

    $sql = "SELECT * FROM case_records WHERE case_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $case_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $case = $result->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode($case);
    } else {
        echo json_encode(null);
    }
    $stmt->close();
} else {
    echo json_encode(null);
}
$conn->close();
?>
