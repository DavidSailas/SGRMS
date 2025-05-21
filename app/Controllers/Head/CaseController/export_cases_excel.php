<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

// Ensure the case ID is passed
if (isset($_GET['id'])) {
    $case_id = $_GET['id'];

    // Database connection
include '../../../../database/db_connect.php';

    // Fetch case data based on case ID
    $sql = "SELECT cr.*, s.lname, s.fname, s.educ_level, s.section, s.program
            FROM case_records cr
            JOIN students s ON cr.student_id = s.s_id
            WHERE cr.case_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $case_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $case = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    if ($case) {
        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header for the columns
        $sheet->setCellValue('A1', 'Case ID')
              ->setCellValue('B1', 'Student Name')
              ->setCellValue('C1', 'Academic Level')
              ->setCellValue('D1', 'Course Section')
              ->setCellValue('E1', 'Case Type')
              ->setCellValue('F1', 'Description')
              ->setCellValue('G1', 'Reported By')
              ->setCellValue('H1', 'Filed Date')
              ->setCellValue('I1', 'Filed Time')
              ->setCellValue('J1', 'Status');

        // Insert the data into the rows
        $sheet->setCellValue('A2', $case['case_id'])
              ->setCellValue('B2', $case['student_name'])
              ->setCellValue('C2', $case['academic_level'])
              ->setCellValue('D2', $case['course_section'])
              ->setCellValue('E2', $case['case_type'])
              ->setCellValue('F2', $case['description'])
              ->setCellValue('G2', $case['reported_by'])
              ->setCellValue('H2', $case['filed_date'])
              ->setCellValue('I2', $case['filed_time'])
              ->setCellValue('J2', $case['status']);

        // Set the Excel file name
        $fileName = "Case_{$case_id}.xlsx";

        // Write the file to the browser for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    } else {
        echo "Case not found.";
    }
}
?>
