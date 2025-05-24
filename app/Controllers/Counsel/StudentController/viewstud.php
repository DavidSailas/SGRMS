<?php
include '../../../../database/db_connect.php';

if (isset($_GET['s_id'])) {
    $s_id = $_GET['s_id'];
    $sql = "SELECT s.*, p.guardian_name, p.relationship, p.contact_num AS guardian_contact, p.email AS guardian_email
            FROM students s
            LEFT JOIN parents p ON s.parent_id = p.p_id
            WHERE s.s_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $s_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $student = $result->fetch_assoc();

        // Calculate age
        $bod = new DateTime($student['bod']);
        $today = new DateTime();
        $age = $today->diff($bod)->y;

        // Format suffix: hide if N/A
        $suffix = ($student['suffix'] !== 'N/A') ? $student['suffix'] : '';

        // Format middle name: show as first letter with dot if not empty
        $mname = trim($student['mname']);
        $mname = ($mname !== '') ? strtoupper(substr($mname, 0, 1)) . '.' : '';

        // Build the name string
        $name = trim($suffix . " " . $student['lname'] . ", " . $student['fname'] . " " . $mname);

        // Prepare student data for display
        $studentData = [
            's_image' => !empty($student['s_image']) ? htmlspecialchars($student['s_image']) : '',
            'id_num' => htmlspecialchars($student['id_num']),
            'name' => htmlspecialchars($name),
            'age' => htmlspecialchars($age),
            'dob' => htmlspecialchars($student['bod']),
            'sex' => htmlspecialchars($student['sex']),
            'address' => htmlspecialchars($student['address']),
            'mobile_num' => htmlspecialchars($student['mobile_num']),
            'email' => htmlspecialchars($student['email']),
            'educ_level' => htmlspecialchars($student['educ_level']),
            'year_level' => htmlspecialchars($student['year_level']),
            'section_program' => htmlspecialchars($student['educ_level'] === 'College' ? $student['program'] : $student['section']),
            'previous_school' => htmlspecialchars($student['previous_school']),
            // Guardian info
            'guardian_name' => htmlspecialchars($student['guardian_name'] ?? ''),
            'relationship' => htmlspecialchars($student['relationship'] ?? ''),
            'guardian_contact' => htmlspecialchars($student['guardian_contact'] ?? ''),
            'guardian_email' => htmlspecialchars($student['guardian_email'] ?? ''),
        ];

        // Fetch case records 
        $caseSql = "SELECT case_type, description, filed_date FROM case_records WHERE student_id = ?";
        $caseStmt = $conn->prepare($caseSql);
        $caseStmt->bind_param("i", $s_id);
        $caseStmt->execute();
        $caseResult = $caseStmt->get_result();

        $caseRecords = [];
        if ($caseResult && $caseResult->num_rows > 0) {
            while ($row = $caseResult->fetch_assoc()) {
                $caseRecords[] = [
                    'title' => htmlspecialchars($row['case_type']),
                    'description' => htmlspecialchars($row['description']),
                    'date' => htmlspecialchars($row['filed_date']),
                ];
            }
        }


        $studentData['case_records'] = $caseRecords;



        echo json_encode($studentData);
    } else {
        echo json_encode(['error' => 'Student not found.']);
    }
} else {
    echo json_encode(['error' => 'No student ID provided.']);
}

$conn->close();
?>