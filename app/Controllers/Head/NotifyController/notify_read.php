<?php
include '../../../../database/db_connect.php';

$sql = "UPDATE notifications SET is_read = 1 WHERE is_read = 0";
$conn->query($sql);
?>
