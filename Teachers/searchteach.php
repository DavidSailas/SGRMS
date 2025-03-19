<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

$sql = "SELECT t_id, lname, fname, mname, email, phone, section, teach_level FROM teachers";
$conditions = [];
$params = [];
$types = "";

// Process the search term
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = $_GET['search'];
    // Search by t_id or names
    $conditions[] = "(t_id LIKE ? OR lname LIKE ? OR fname LIKE ? OR mname LIKE ?)";
    $params[] = "%$searchTerm%"; // For t_id
    $params[] = "%$searchTerm%"; // For lname
    $params[] = "%$searchTerm%"; // For fname
    $params[] = "%$searchTerm%"; // For mname
    $types .= "ssss"; // Four string parameters
}

// Process the educational level filter
if (isset($_GET['filter_educ']) && !empty($_GET['filter_educ'])) {
    $conditions[] = "teach_level = ?";
    $params[] = $_GET['filter_educ'];
    $types .= "s"; // One additional string parameter
}

// Build the final SQL query if conditions exist
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$output = "";
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>
            <td>".htmlspecialchars($row['lname']).", ".htmlspecialchars($row['fname'])." ".htmlspecialchars($row['mname'])."</td>
            <td>".htmlspecialchars($row['email'])."</td>
            <td>".htmlspecialchars($row['phone'])."</td>
            <td>".htmlspecialchars($row['teach_level'])."</td>
            <td class='actions'>
                <a href='viewteach.php?t_id=".$row['t_id']."' class='btn btn-view'>View</a>
                <a href='editteach.php?t_id=".$row['t_id']."' class='btn btn-edit'>Edit</a>
                <a href='deleteteach.php?t_id=".$row['t_id']."' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this teacher?\")'>Delete</a>
            </td>
        </tr>";
    }
} else {
    $output .= "<tr><td colspan='5'>No teachers found</td></tr>";
}

echo $output;
?>