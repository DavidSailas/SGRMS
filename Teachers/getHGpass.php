<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $enteredPassword = $_POST['authPassword'];

    $sql = "SELECT password FROM users WHERE role = 'Head Guidance'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password']; 

        if (password_verify($enteredPassword, $storedPassword)) {
            echo json_encode(["success" => true, "password" => $storedPassword]);
        } else {
            echo json_encode(["success" => false]);
        }        
    } else {
        echo json_encode(["success" => false]);
    }
}

$conn->close();
?>
