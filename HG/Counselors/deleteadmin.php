<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

// Check if the counselor ID is set in the URL
if (isset($_GET['c_id'])) {
    $id = intval($_GET['c_id']); // Get the counselor ID and convert it to an integer

    // Prepare the SQL statement to delete the counselor
    $sql = "DELETE FROM counselors WHERE c_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Bind the ID parameter

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Success message (optional)
        echo "Counselor record deleted successfully.";
    } else {
        // Error handling (optional)
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();

// Redirect back to the counselor management page after deletion
header("Location: counsel.php");
exit();
?>
