<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['case_ids'])) {
    include '../../../../database/db_connect.php';

    $caseIds = $_POST['case_ids'];
    $ids = implode(',', array_map('intval', $caseIds));

    $sql = "SELECT cr.case_id, s.educ_level AS academic_level, cr.case_type, cr.status 
            FROM case_records cr
            JOIN students s ON cr.student_id = s.s_id
            WHERE cr.case_id IN ($ids)";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="cases_export.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Case ID', 'Academic Level', 'Case Type', 'Status']);

        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }

        fclose($output);
    } else {
        echo "No cases found.";
    }

    $conn->close();
    exit;
}
?>