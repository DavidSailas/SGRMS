<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

$sql = "SELECT case_id, student_name, grade_section, case_type, description, status FROM case_records WHERE status = 'Pending'";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Student Guidance Record Management System</title>
    <link rel="stylesheet" href="/SGRMS/CSS/style.css">
    <link rel="stylesheet" href="/SGRMS/CSS/table.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <h1>SGRMS</h1>
            <ul>
                <li><a href="/SGRMS/SuperAdmin/superadmin.php"> Home</a></li>
                <li><a href="/SGRMS/Counselors/counsel.php"> Counselors</a></li>
                <li><a href="/SGRMS/Teachers/teacher.php"> Teachers</a></li>
                <li><a href="/SGRMS/Students/students.php"> Students</a></li>
                <li><a href="/SGRMS/Reports/case.php"> Reports</a></li>
                <li><a href="#"> Settings</a></li>
            </ul>
        </aside>
        <main class="wrapper">
            <div class="card">
                <div class="search-flex">
                    <h2>Case Management</h2>
                    <a href="add.case.php" class="btn btn-add">Add New Case</a>
                </div>    
                <div class="table-container">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Case Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['case_id']}</td>
                                            <td>{$row['case_type']}</td>
                                            <td>{$row['status']}</td>
                                            <td class='actions'>
                                                <a href='case.view.php?id={$row['case_id']}' class='btn btn-view'>View</a>
                                                <a href='case.update.php?id={$row['case_id']}' class='btn btn-edit'>Edit</a>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No records found</td></tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

