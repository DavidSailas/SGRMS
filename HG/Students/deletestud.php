<?php
include '../../Database/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Get s_id from the URL query string
    $studentId = isset($_GET['s_id']) ? intval($_GET['s_id']) : null;

    $response = ["debug_s_id" => $studentId];

    if ($studentId) {
        $sql = "DELETE FROM students WHERE s_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $studentId);

            if ($stmt->execute()) {
                $response["success"] = true;
            } else {
                $response["success"] = false;
                $response["error"] = $stmt->error;
            }

            $stmt->close();
        } else {
            $response["success"] = false;
            $response["error"] = "Failed to prepare statement.";
        }
    } else {
        $response["success"] = false;
        $response["error"] = "Invalid student ID.";
    }

    echo json_encode($response);
}

$conn->close();
?>
