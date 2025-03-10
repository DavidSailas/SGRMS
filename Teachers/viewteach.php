<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (!isset($_GET['t_id']) || !filter_var($_GET['t_id'], FILTER_VALIDATE_INT)) {
    die("Invalid teacher ID.");
}

$t_id = intval($_GET['t_id']);

$sql = "SELECT * FROM teachers WHERE t_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $t_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Teacher not found.");
}

$row = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <h2>Teacher Details</h2>
        <div class="info"><strong>Name:</strong> <?php echo htmlspecialchars($row['lname'] . ", " . $row['fname'] . " " . $row['mname']); ?></div>
        <div class="info"><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></div>
        <div class="info"><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?></div>
        <div class="info"><strong>Department Level:</strong> <?php echo htmlspecialchars($row['teach_level']); ?></div>
        <div class="info"><strong>Section:</strong> <?php echo htmlspecialchars($row['section']); ?></div>
        <a href="teacher.php" class="back">Back</a>
    </div>
</body>
</html>
