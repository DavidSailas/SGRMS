<?php
include '../../../../database/db_connect.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$response = ['success' => false];

if (isset($data['parent_id'])) {
    $parent_id = $conn->real_escape_string($data['parent_id']);

    // Soft delete: mark parent as archived instead of deleting
    $sql = "UPDATE parents SET status = 'archived' WHERE p_id = '$parent_id'";

    if ($conn->query($sql)) {
        $response['success'] = true;
    } else {
        $response['error'] = "Query failed: " . $conn->error;
    }
}

echo json_encode($response);
?>