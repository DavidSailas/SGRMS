<?php
include '../../../../database/db_connect.php';

header('Content-Type: application/json');

if (!isset($_GET['c_id']) || !filter_var($_GET['c_id'], FILTER_VALIDATE_INT)) {
    echo json_encode(['error' => 'Invalid counselor ID.']);
    exit;
}

$c_id = intval($_GET['c_id']);
$sql = "SELECT c.*, u.username FROM counselors c JOIN users u ON u.counselor_id = c.c_id WHERE c.c_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("i", $c_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'Counselor not found.']);
    exit;
}

$row = $result->fetch_assoc();
$stmt->close();
$conn->close();

echo json_encode($row);
?>
