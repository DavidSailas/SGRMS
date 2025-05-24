<?php
include '../../../../database/db_connect.php';

$search = $_POST['search'] ?? '';

$sql = "SELECT s_id, id_num, suffix, lname, fname, mname, sex, bod, address, mobile_num, email, 
        educ_level, year_level, section, program, previous_school, status,
        (SELECT COUNT(*) FROM case_records WHERE student_id = students.s_id) AS case_count
        FROM students
        WHERE id_num LIKE ? OR lname LIKE ? OR fname LIKE ?
        ORDER BY lname ASC";

$stmt = $conn->prepare($sql);
$searchTerm = "%$search%";
$stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$output = '';
while ($row = $result->fetch_assoc()) {
    $caseCount = (int)$row['case_count'];
    $statusClass = ($caseCount === 0) ? 'green' : (($caseCount <= 2) ? 'orange' : 'red');

    $birthdate = new DateTime($row['bod']);
    $today = new DateTime();
    $age = $today->diff($birthdate)->y;

    $suffix = ($row['suffix'] !== 'N/A') ? $row['suffix'] : '';
    $mname = trim($row['mname']);
    $mname = ($mname !== '') ? strtoupper(substr($mname, 0, 1)) . '.' : '';
    $name = trim($row['lname'] . ", " . $row['fname'] . " " . $mname . " " . $suffix);

    $output .= "<tr data-status='" . htmlspecialchars(strtolower($row['status'])) . "'>
        <td><span class='status-circle $statusClass' style='background: $statusClass !important;'></span></td>
        <td>".htmlspecialchars($row['id_num'])."</td>
        <td>".htmlspecialchars($name)."</td>
        <td>".$age."</td>
        <td>".htmlspecialchars($row['educ_level'])."</td>
        <td>".(!empty($row['section']) ? htmlspecialchars($row['section']) : htmlspecialchars($row['program']))."</td>
        <td style='display:none;' class='status-text'>".htmlspecialchars(strtolower($row['status']))."</td>
        <td>
            <button class='btn btn-view' onclick='viewStudent(".$row['s_id'].")'>View</button>
            <button class='btn btn-edit' onclick='openEditModal(".$row['s_id'].")'>Edit</button>
            <button class='btn btn-delete' onclick='openDeleteConfirmationModal(".$row['s_id'].")'>Delete</button>
        </td>
    </tr>";
}

echo $output ?: "<tr><td colspan='7'>No students found</td></tr>";
?>
