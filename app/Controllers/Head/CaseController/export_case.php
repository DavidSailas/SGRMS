<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
include '../../../../database/db_connect.php';

use Dompdf\Dompdf;

if (isset($_GET['id'])) {
    $case_id = $_GET['id'];
    $sql = "SELECT * FROM case_records WHERE case_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $case_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $case = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    if ($case) {
        // Optional: replace with base64-encoded logo if needed
        $school_logo = 'https://via.placeholder.com/100'; // You can use base64 or a local image path here

        $html = '
        <html>
        <head>
            <style>
                body {
                    font-family: "Arial", sans-serif;
                    font-size: 12px;
                    color: #333;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    padding: 30px;
                }
                .header {
                    text-align: center;
                    border-bottom: 2px solid #000;
                    padding-bottom: 10px;
                    margin-bottom: 20px;
                }
                .header img {
                    width: 80px;
                    margin-bottom: 10px;
                }
                .header h1 {
                    margin: 0;
                    font-size: 18px;
                    text-transform: uppercase;
                }
                .header p {
                    margin: 2px 0;
                    font-size: 14px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 10px;
                }
                table td {
                    padding: 8px 10px;
                    vertical-align: top;
                    border: 1px solid #999;
                }
                table tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                .label {
                    font-weight: bold;
                    background-color: #eee;
                    width: 30%;
                }
                .description {
                    white-space: pre-wrap;
                }
                .footer {
                    text-align: center;
                    font-size: 10px;
                    margin-top: 30px;
                    color: #777;
                    border-top: 1px solid #ccc;
                    padding-top: 10px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <img src="' . $school_logo . '" alt="School Logo">
                    <h1>St. Cecilia’s College Cebu Inc.</h1>
                    <p>School Guidance Records Management System</p>
                    <p><strong>Case Report</strong></p>
                </div>

                <table>
                    <tr>
                        <td class="label">Case Type</td>
                        <td>' . htmlspecialchars($case['case_type']) . '</td>
                    </tr>
                    <tr>
                        <td class="label">Student Name</td>
                        <td>' . htmlspecialchars($case['student_name']) . '</td>
                    </tr>
                    <tr>
                        <td class="label">Academic Level</td>
                        <td>' . htmlspecialchars($case['academic_level']) . '</td>
                    </tr>
                    <tr>
                        <td class="label">Course Section</td>
                        <td>' . htmlspecialchars($case['course_section']) . '</td>
                    </tr>
                    <tr>
                        <td class="label">Description</td>
                        <td class="description">' . nl2br(htmlspecialchars($case['description'])) . '</td>
                    </tr>
                    <tr>
                        <td class="label">Reported By</td>
                        <td>' . htmlspecialchars($case['reported_by']) . '</td>
                    </tr>
                    <tr>
                        <td class="label">Filed Date</td>
                        <td>' . date('F j, Y', strtotime($case['filed_date'])) . '</td>
                    </tr>
                    <tr>
                        <td class="label">Filed Time</td>
                        <td>' . date('g:i A', strtotime($case['filed_time'])) . '</td>
                    </tr>
                    <tr>
                        <td class="label">Status</td>
                        <td>' . htmlspecialchars($case['status']) . '</td>
                    </tr>
                </table>

                <div class="footer">
                    Document generated on ' . date("F j, Y, g:i A") . '
                </div>
            </div>
        </body>
        </html>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Case_Report_{$case_id}.pdf", array("Attachment" => false)); // Change to true to download
        exit;
    } else {
        echo "Case not found.";
    }
} else {
    echo "Invalid request.";
}
