<?php
include '../../../../database/db_connect.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filter_educ = isset($_GET['filter_educ']) ? trim($_GET['filter_educ']) : '';

$sql = "SELECT s_id, id_num, suffix, lname, fname, mname, sex, bod, address, mobile_num, email, 
        educ_level, year_level, section, program, previous_school, status,
        (SELECT COUNT(*) FROM case_records WHERE student_id = students.s_id) AS case_count
        FROM students
        WHERE status = 'Active'";

if ($filter_educ !== '') {
    $sql .= " AND educ_level = ?";
}
if ($search !== '') {
    $sql .= " AND (id_num LIKE ? OR lname LIKE ? OR fname LIKE ?)";
}

$stmt = $conn->prepare($sql);

if ($filter_educ !== '' && $search !== '') {
    $like = "%$search%";
    $stmt->bind_param("ssss", $filter_educ, $like, $like, $like);
} elseif ($filter_educ !== '') {
    $stmt->bind_param("s", $filter_educ);
} elseif ($search !== '') {
    $like = "%$search%";
    $stmt->bind_param("sss", $like, $like, $like);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $caseCount = (int)$row['case_count'];
        if ($caseCount === 0) {
            $statusClass = 'green';
        } elseif ($caseCount <= 2) {
            $statusClass = 'orange';
        } else {
            $statusClass = 'red';
        }

        $bod = $row['bod'];
        $birthdate = new DateTime($bod);
        $today = new DateTime();
        $age = $today->diff($birthdate)->y;

        $suffix = ($row['suffix'] !== 'N/A') ? $row['suffix'] : '';
        $mname = trim($row['mname']);
        $mname = ($mname !== '') ? strtoupper(substr($mname, 0, 1)) . '.' : '';
        $name = trim($row['lname'] . ", " . $row['fname'] . " " . $mname . " " . $suffix);

        echo "<tr>
            <td><span class='status-circle $statusClass' style='background: $statusClass !important;'></span></td>
            <td>".htmlspecialchars($row['id_num'])."</td>
            <td>".htmlspecialchars($name)."</td>
            <td>".$age."</td>
            <td>".htmlspecialchars($row['educ_level'])."</td>
            <td>".(!empty($row['section']) ? htmlspecialchars($row['section']) : htmlspecialchars($row['program']))."</td>
            <td>
                <button class='btn btn-view' onclick='viewStudent(".$row['s_id'].")'>View</button>
                <button class='btn btn-edit' onclick='openEditModal(".$row['s_id'].")'>Edit</button>
                <button class='btn btn-delete' onclick='openDeleteConfirmationModal(".$row['s_id'].")'>Delete</button>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='7'>No students found</td></tr>";
}
?>
