<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

// Check if the counselor ID is set and is a valid integer
if (!isset($_GET['c_id']) || !filter_var($_GET['c_id'], FILTER_VALIDATE_INT)) {
    die("Invalid counselor ID.");
}

$c_id = intval($_GET['c_id']);

// Prepare the SQL statement to fetch the counselor's details
$sql = "SELECT * FROM counselors WHERE c_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $c_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Counselor not found.");
}

$row = $result->fetch_assoc();

// Close connections
$stmt->close();
$conn->close();

// Output counselor details
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Counselor</title>
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
        <h1>Counselor Details</h1>
        <div class="info"><strong>Name:</strong> <?php echo htmlspecialchars($row['lname'] . ", " . $row['fname'] . " " . $row['mname']); ?></div>
        <div class="info"><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></div>
        <div class="info"><strong>Phone:</strong> <?php echo htmlspecialchars($row['contact_num']); ?></div>
        <div class="info"><strong>Department:</strong> <?php echo htmlspecialchars($row['c_level']); ?></div>
        <a href="counsel.php" class="back">Back</a>
    </div>
</body>
</html>