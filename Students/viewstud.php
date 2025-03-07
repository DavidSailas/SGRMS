<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid student ID.");
}

$s_id = intval($_GET['id']);
$sql = "SELECT * FROM students WHERE s_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $s_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Student not found.");
}

$row = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Student</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            margin: 50px auto;
            width: 50%;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 {
            color: #2563eb;
        }
        .info {
            text-align: left;
            margin-bottom: 10px;
        }
        .back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back:hover {
            background-color: #1e40af;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Details</h2>
        <div class="info"><strong>Name:</strong> <?php echo $row['lname'] . ", " . $row['fname'] . " " . $row['mname']; ?></div>
        <div class="info"><strong>Date of Birth:</strong> <?php echo $row['bod']; ?></div>
        <div class="info"><strong>Age:</strong> <?php echo (new DateTime($row['bod']))->diff(new DateTime())->y; ?></div>
        <div class="info"><strong>Educational Level:</strong> <?php echo $row['educ_level']; ?></div>
        <div class="info"><strong>Section:</strong> <?php echo $row['section']; ?></div>
        <a href="students.php" class="back">Back to Students</a>
    </div>
</body>
</html>
