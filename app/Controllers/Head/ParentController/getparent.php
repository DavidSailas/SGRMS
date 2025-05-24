<?php
include '../../../../database/db_connect.php';

$id = intval($_GET['id'] ?? 0);  // Securely get the parent ID
$response = [];

if ($id > 0) {
    // Get parent information
    $parentSql = "SELECT * FROM parents WHERE p_id = ?";
    $stmt = $conn->prepare($parentSql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $parentResult = $stmt->get_result();

    if ($parent = $parentResult->fetch_assoc()) {
        $response['name'] = $parent['guardian_name'];
        $response['relationship'] = $parent['relationship'];
        $response['contact'] = $parent['contact_num'];
        $response['email'] = $parent['email'];

        // Get associated account info
        $userSql = "SELECT username, status FROM users WHERE parent_id = ? AND role = 'Parent' LIMIT 1";
        $userStmt = $conn->prepare($userSql);
        $userStmt->bind_param("i", $id);
        $userStmt->execute();
        $userResult = $userStmt->get_result();
        if ($user = $userResult->fetch_assoc()) {
            $response['username'] = $user['username'];
            $response['account_status'] = $user['status'] === 'Active'
                ? "<span class='badge badge-green'>Has Account</span>"
                : "<span class='badge badge-orange'>Inactive Account</span>";
        } else {
            $response['username'] = 'N/A';
            $response['account_status'] = "<span class='badge badge-gray'>No Account</span>";
        }

        // Collect children names
        $children = [];
        $childSql = "SELECT lname, fname, mname, suffix FROM students WHERE parent_id = ?";
        $childStmt = $conn->prepare($childSql);
        $childStmt->bind_param("i", $id);
        $childStmt->execute();
        $childResult = $childStmt->get_result();
        while ($child = $childResult->fetch_assoc()) {
            $fullName = $child['fname'] . ' ' . $child['mname'] . ' ' . $child['lname'] . ' ' . $child['suffix'];
            $children[] = trim($fullName);
        }
        $response['children'] = $children;
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
