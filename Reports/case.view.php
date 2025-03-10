<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (isset($_GET['id'])) {
    $case_id = $_GET['id'];
    $sql = "SELECT * FROM case_records WHERE case_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $case_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $case = $result->fetch_assoc();
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Case Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #1e3a8a;
        }
        .case-details {
            text-align: left;
            margin-bottom: 20px;
        }
        .case-details p {
            margin: 8px 0;
        }
        .button {
            background-color: #1e3a8a;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .button:hover {
            background-color: #1c3d72;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Case Details</h2>
    <?php if ($case): ?>
        <div class="case-details">
            <p><strong>Student Name:</strong> <?php echo htmlspecialchars($case['student_name']); ?></p>
            <p><strong>Grade & Section:</strong> <?php echo htmlspecialchars($case['grade_section']); ?></p>
            <p><strong>Case Type:</strong> <?php echo htmlspecialchars($case['case_type']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($case['description']); ?></p>
            <p><strong>Reported By:</strong> <?php echo htmlspecialchars($case['reported_by']); ?></p>
            <p><strong>Filed Date:</strong> <?php echo htmlspecialchars($case['filed_date']); ?></p>
            <p><strong>Filed Time:</strong> <?php echo htmlspecialchars($case['filed_time']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($case['status']); ?></p>
        </div>
    <?php else: ?>
        <p>No case found.</p>
    <?php endif; ?>
    <a href="case.php" class="button">Back</a>
</div>

</body>
</html>
