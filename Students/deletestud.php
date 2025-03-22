<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (isset($_GET['s_id'])) {
    $id = intval($_GET['s_id']);

    $sql = "DELETE FROM students WHERE s_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Success message (optional)
        echo "Student record deleted successfully.";
    } else {
        // Error handling (optional)
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

// Redirect back to the student list page after deletion
header("Location: students.php");
exit();
?>