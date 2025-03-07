<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

$sql = "SELECT s_id, lname, fname, mname, bod, educ_level, section FROM students";
$conditions = [];
$params = [];
$types = "";

// Process the search term
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = $_GET['search'];
    if (is_numeric($searchTerm)) {
        // Search by s_id or names if numeric
        $conditions[] = "(s_id = ? OR lname LIKE ? OR fname LIKE ? OR mname LIKE ?)";
        $params[] = intval($searchTerm);
        $params[] = "%$searchTerm%";
        $params[] = "%$searchTerm%";
        $params[] = "%$searchTerm%";
        $types .= "isss";
    } else {
        // Otherwise, search by name fields
        $conditions[] = "(lname LIKE ? OR fname LIKE ? OR mname LIKE ?)";
        $params[] = "%$searchTerm%";
        $params[] = "%$searchTerm%";
        $params[] = "%$searchTerm%";
        $types .= "sss";
    }
}

// Process the educational level filter
if (isset($_GET['filter_educ']) && !empty($_GET['filter_educ'])) {
    $conditions[] = "educ_level = ?";
    $params[] = $_GET['filter_educ'];
    $types .= "s";
}

// Build the final SQL query if conditions exist
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    $result = $conn->query($sql);
}

$output = "";
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bod = $row['bod'];
        $birthdate = new DateTime($bod);
        $today = new DateTime();
        $age = $today->diff($birthdate)->y;
        
        $output .= "<tr>
            <td><span class='status-circle green'></span></td>
            <td>".$row['lname'].", ".$row['fname']." ".$row['mname']."</td>
            <td>".$age."</td>
            <td>".$row['educ_level']."</td>
            <td>".$row['section']."</td>
            <td>
                <a href='viewstud.php?s_id=".$row['s_id']."' class='btn btn-view'>View</a>
                <a href='editstud.php?s_id=".$row['s_id']."' class='btn btn-edit'>Edit</a>
                <a href='deletestud.php?s_id=".$row['s_id']."' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>
            </td>
        </tr>";
    }
} else {
    $output .= "<tr><td colspan='6'>No students found</td></tr>";
}

echo $output;
?>
