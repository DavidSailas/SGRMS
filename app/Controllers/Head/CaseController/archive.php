<?php
include '../../../../database/db_connect.php';

if (isset($_GET['id'])) {
    $case_id = intval($_GET['id']); // Ensure ID is an integer

    // Update status to 'archived'
    $sql = "UPDATE case_records SET status = 'Archived' WHERE case_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $case_id);

    if ($stmt->execute()) {
        header("Location: ../../../../resources/view/Head/case.php?new_case=added");
        exit();
    } else {
        echo "Error archiving case: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
