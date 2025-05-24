<?php
include '../../../../database/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Get s_id from the URL query string
    $studentId = isset($_GET['s_id']) ? intval($_GET['s_id']) : null;

    $response = ["debug_s_id" => $studentId];

    if ($studentId) {

        $sql = "UPDATE students SET status = 'Inactive' WHERE s_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $studentId);

            if ($stmt->execute()) {
                // 2. Get user_id of the student from users table
                $userId = null;
                $userStmt = $conn->prepare("SELECT u_id FROM users WHERE student_id = ?");
                $userStmt->bind_param("i", $studentId);
                $userStmt->execute();
                $userStmt->bind_result($userId);
                $userStmt->fetch();
                $userStmt->close();

                if ($userId) {
                    $updateUser = $conn->prepare("UPDATE users SET status = 'Pending' WHERE u_id = ?");
                    $updateUser->bind_param("i", $userId);
                    $updateUser->execute();
                    $updateUser->close();
                }

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
