<?php
// Include the database connection file
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

// Check if the teacher ID (t_id) is provided in the request
if (isset($_GET['t_id'])) {
    $t_id = $_GET['t_id'];

    // Prepare the SQL query to fetch teacher data
    $sql = "SELECT 
                teachers.t_id, 
                teachers.lname, 
                teachers.fname, 
                teachers.mname, 
                teachers.email, 
                teachers.phone, 
                teachers.teach_level, 
                teachers.year_level, 
                teachers.section, 
                teachers.program, 
                users.username 
            FROM teachers 
            JOIN users ON teachers.u_id = users.u_id 
            WHERE teachers.t_id = ?";

    // Prepare and execute the statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $t_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the teacher exists
        if ($result->num_rows > 0) {
            // Fetch the teacher data as an associative array
            $teacher = $result->fetch_assoc();

            // Return the data as JSON
            echo json_encode($teacher);
        } else {
            // Return an error if the teacher is not found
            echo json_encode(['error' => 'Teacher not found']);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Database query failed']);
    }
} else {
    // Return an error if no teacher ID is provided
    echo json_encode(['error' => 'No teacher ID provided']);
}

// Close the database connection
$conn->close();
?>
