<?php
include '../../../../database/db_connect.php';

if (!isset($_GET['id'])) {
    die("Missing student ID");
}

$student_id = $_GET['id'];

// Get student details
$stmt = $conn->prepare("SELECT * FROM students WHERE s_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo '<div class="modal-student-details">';
    echo '<img src="' . htmlspecialchars($row['s_image']) . '" alt="Student Image" style="max-width:100px;"><br>';
    echo '<strong>ID Number:</strong> ' . htmlspecialchars($row['id_num']) . '<br>';
    echo '<strong>Full Name:</strong> ' . htmlspecialchars($row['suffix'] . ' ' . $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']) . '<br>';
    echo '<strong>Gender:</strong> ' . htmlspecialchars($row['sex']) . '<br>';
    echo '<strong>Birthdate:</strong> ' . htmlspecialchars($row['bod']) . '<br>';
    echo '<strong>Address:</strong> ' . htmlspecialchars($row['address']) . '<br>';
    echo '<strong>Mobile Number:</strong> ' . htmlspecialchars($row['mobile_num']) . '<br>';
    echo '<strong>Email:</strong> ' . htmlspecialchars($row['email']) . '<br>';
    echo '<strong>Educational Level:</strong> ' . htmlspecialchars($row['educ_level']) . '<br>';
    echo '<strong>Year Level:</strong> ' . htmlspecialchars($row['year_level']) . '<br>';
    echo '<strong>Section:</strong> ' . htmlspecialchars($row['section']) . '<br>';
    echo '<strong>Program:</strong> ' . htmlspecialchars($row['program']) . '<br>';
    echo '<strong>Previous School:</strong> ' . htmlspecialchars($row['previous_school']) . '<br>';
    echo '<strong>Status:</strong> ' . htmlspecialchars($row['status']) . '<br>';
    echo '</div>';

    // Get case history
    $stmt_cases = $conn->prepare("SELECT * FROM case_records WHERE student_id = ?");
    $stmt_cases->bind_param("i", $student_id);
    $stmt_cases->execute();
    $case_results = $stmt_cases->get_result();

    echo '<div class="modal-case-history">';
    echo '<h4>Case History</h4>';

    if ($case_results->num_rows > 0) {
        while ($case = $case_results->fetch_assoc()) {
            echo '<div class="case-entry" style="margin-bottom: 1rem;">';
            echo '<strong>Case Type:</strong> ' . htmlspecialchars($case['case_type']) . '<br>';
            echo '<strong>Description:</strong> ' . htmlspecialchars($case['description']) . '<br>';
            echo '<strong>Reported By:</strong> ' . htmlspecialchars($case['reported_by']) . '<br>';
            echo '<strong>Filed Date:</strong> ' . htmlspecialchars($case['filed_date']) . '<br>';
            echo '<strong>Status:</strong> ' . htmlspecialchars($case['status']) . '<br>';
            echo '<hr>';
            echo '</div>';
        }
    } else {
        echo '<p>No case history available.</p>';
    }

    echo '</div>';
} else {
    echo "Student not found.";
}

$stmt->close();
$conn->close();
?>
