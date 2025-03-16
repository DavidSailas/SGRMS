<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Counselors</title>
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
                <section class="student-list">
                    <div class="search-flex">
                        <h2>Manage Counselors</h2>
                        <a href="addadmin.php" class="btn btn-add">Add Counselor</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Department</th>
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
                                            <td>".$row['contact_num']."</td>
                                            <td>".$row['c_level']."</td>
                                            <td class='actions'>
                                                <a href='editadmin.php?c_id=".$row['c_id']."' class='btn btn-edit'>Edit</a>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No counselors found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
