<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

$sql = "SELECT * FROM counselors";
$conditions = [];
$params = [];
$types = "";

// Process the search term
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = $_GET['search'];
    // Search by name or email
    $conditions[] = "(lname LIKE ? OR fname LIKE ? OR email LIKE ?)";
    $params[] = "%$searchTerm%"; // For lname
    $params[] = "%$searchTerm%"; // For fname
    $params[] = "%$searchTerm%"; // For email
    $types .= "sss"; // Three string parameters
}

// Process the educational level filter
if (isset($_GET['filter_educ']) && !empty($_GET['filter_educ'])) {
    $conditions[] = "c_level = ?";
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
            <td>".htmlspecialchars($row['contact_num'])."</td>
            <td>".htmlspecialchars($row['c_level'])."</td>
            <td class='actions'>
                <a href='editadmin.php?c_id=".$row['c_id']."' class='btn btn-edit'>Edit</a>
                <a href='deleteadmin.php?c_id=".$row['c_id']."' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this counselor?\")'>Delete</a>
            </td>
        </tr>";
    }
} else {
    $output .= "<tr><td colspan='5'>No counselors found</td></tr>";
}

echo $output;
?>