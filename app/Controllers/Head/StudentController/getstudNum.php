<?php
include '../../../../database/db_connect.php';

// Query to get the last student ID number
$sql = "SELECT id_num FROM students ORDER BY s_id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $lastIdNum = $result->fetch_assoc()['id_num'];

    // Extract the last 8 digits of the ID number
    preg_match('/(\d{8})$/', $lastIdNum, $matches);
    $lastNumber = isset($matches[1]) ? intval($matches[1]) : 0;

    // Generate next ID number
    $nextNumber = str_pad($lastNumber + 1, 8, '0', STR_PAD_LEFT);
} else {
    // If no students exist, start with 00000001
    $nextNumber = '00000001';
}

// Generate the full ID
$currentYear = date('y'); // Get the last two digits of the current year
$fullId = "SCC-$currentYear-$nextNumber";

echo $fullId;

$conn->close();
?>
