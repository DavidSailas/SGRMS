<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

if (isset($_GET['id'])) {
    $case_id = $_GET['id'];
    
    // Fetch case details
    $sql = "SELECT * FROM case_records WHERE case_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $case_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $case = $result->fetch_assoc();
    } else {
        echo "Case not found!";
        exit;
    }
    $stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['student_name'];
    $grade_section = $_POST['grade_section'];
    $case_type = $_POST['case_type'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $update_sql = "UPDATE case_records SET student_name = ?, grade_section = ?, case_type = ?, description = ?, status = ? WHERE case_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssi", $student_name, $grade_section, $case_type, $description, $status, $case_id);

    if ($stmt->execute()) {
        echo "<script>alert('Case updated successfully!'); window.location.href='case.php';</script>";
    } else {
        echo "Error updating case: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Case</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #1e3a8a;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        textarea {
            height: 100px;
        }
        .button, .back-button {
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 10px auto;
            text-align: center;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
        .button {
            background-color: #1e3a8a;
            color: white;
            border: none;
        }
        .button:hover {
            background-color: #1c3d72;
        }
        .back-button {
            background-color: #6b7280;
            color: white;
            text-decoration: none;
            border: none;
        }
        .back-button:hover {
            background-color: #4b5563;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Update Case</h2>
    <form method="POST">
        <label for="student_name">Student Name:</label>
        <input type="text" id="student_name" name="student_name" value="<?= htmlspecialchars($case['student_name']) ?>" required>

        <label for="grade_section">Grade & Section:</label>
        <input type="text" id="grade_section" name="grade_section" value="<?= htmlspecialchars($case['grade_section']) ?>" required>

        <label for="case_type">Case Type:</label>
        <input type="text" id="case_type" name="case_type" value="<?= htmlspecialchars($case['case_type']) ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($case['description']) ?></textarea>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="Pending" <?= $case['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
            <option value="Resolved" <?= $case['status'] == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
            <option value="Closed" <?= $case['status'] == 'Closed' ? 'selected' : '' ?>>Closed</option>
        </select>

        <button type="submit" class="button">Update Case</button>
    </form>
    <a href="case.php" class="back-button">Back to Cases</a>
</div>

</body>
</html>
