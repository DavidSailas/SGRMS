<?php
include '../../../../database/db_connect.php';
$result = $conn->query("SELECT COUNT(*) as cnt FROM notifications WHERE is_read = 0");
$count = $result ? $result->fetch_assoc()['cnt'] : 0;
echo json_encode(['count' => $count]);
?>
