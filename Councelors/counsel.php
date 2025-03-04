<?php
    include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Counselors</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .btn {
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-add {
            background: #2563eb;
            padding: 10px 15px;
            display: inline-block;
            margin-bottom: 15px;
        }
        .btn-edit {
            background: #f59e0b;
            padding: 5px 10px;
        }
        .btn-delete {
            background: #dc2626;
            padding: 5px 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .actions {
            display: flex;
            gap: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
    <aside class="sidebar">
            <ul>
                <li><a href="superadmin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="counsel.php"><i class="fas fa-users"></i> Counselors</a></li>
                <li><a href="teacher.php"><i class="fas fa-user-tie"></i> Teachers</a></li>
                <li><a href="students.php"><i class="fas fa-user-graduate"></i> Students</a></li>
                <li><a href="case.php"><i class="fas fa-file-alt"></i> Reports</a></li>
                <li><a href="#"><i class="fas fa-cogs"></i> Settings</a></li>
            </ul>
        </aside>
        <main class="main-content">
            <div class="card">
                <section class="counselor-list">
                    <div class="search-flex">
        <h2>Manage Counselors</h2>
        <a href="addadmin.php" class="btn btn-add">Add Counselor</a>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM counselors";
                    $result = $conn->query($sql);

                    if (!$result) {
                        die("<tr><td colspan='5'>Query failed: " . $conn->error . "</td></tr>");
                    }

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>".$row['lname'].", ".$row['fname']." ".$row['mname']."</td>
                                <td>".$row['email']."</td>
                                <td>".$row['phone']."</td>
                                <td>".$row['role']."</td>
                                <td class='actions'>
                                    <a href='edit_admin.php?id=".$row['c_id']."' class='btn btn-edit'>Edit</a>
                                    <a href='delete_admin.php?id=".$row['c_id']."' class='btn btn-delete' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No counselors found</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
