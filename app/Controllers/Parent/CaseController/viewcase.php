<?php
include '../../../../database/db_connect.php';

if (isset($_GET['case_id'])) {
    $case_id = $_GET['case_id'];

    $sql = "SELECT cr.*, s.lname, s.fname FROM case_records cr
            JOIN students s ON cr.student_id = s.s_id
            WHERE cr.case_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $case_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $case = $result->fetch_assoc();
            echo "<div><strong>Case Type:</strong> " . htmlspecialchars($case['case_type']) . "</div>";
            echo "<div><strong>Status:</strong> " . htmlspecialchars($case['status']) . "</div>";
            echo "<div><strong>Referral Date:</strong> " . htmlspecialchars($case['referral_date']) . "</div>";
            echo "<div><strong>Student:</strong> " . htmlspecialchars($case['lname']) . ", " . htmlspecialchars($case['fname']) . "</div>";
            echo "<div><strong>Description:</strong><br><span style='color:#222;'>" . nl2br(htmlspecialchars($case['description'])) . "</span></div>";
        } else {
            echo "Case not found.";
        }

        $stmt->close();
    } else {
        echo "Query error.";
    }
} else {
    echo "No case ID provided.";
}
?>
