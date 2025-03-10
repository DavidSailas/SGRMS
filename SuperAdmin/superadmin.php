<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Guidance Record Management System</title>
    <link rel="stylesheet" href="/SGRMS/CSS/style.css">
    <link rel="stylesheet" href="/SGRMS/CSS/hg.css">
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
        <div class="wrapper">
            <section class="stats">
                <div class="stat-box1">
                    <h2>Cases</h2>
                    <p>
                        <?php
                            $result = $conn->query("SELECT COUNT(*) AS total FROM case_records");
                            if ($result) {
                                $row = $result->fetch_assoc();
                                echo $row['total'];
                            } else {
                                echo "Error: " . $conn->error;
                            }
                        ?>
                    </p> 
                </div>
                <div class="stat-box">
                    <h2>Students</h2>
                    <p>
                        <?php
                            $result = $conn->query("SELECT COUNT(*) AS total FROM students");
                            if ($result) {
                                $row = $result->fetch_assoc();
                                echo $row['total'];
                            } else {
                                echo "Error: " . $conn->error;
                            }
                        ?>
                    </p>
                </div>
                <div class="stat-box">
                    <h2>Teachers</h2>
                    <p>
                        <?php
                            $result = $conn->query("SELECT COUNT(*) AS total FROM teachers");
                            if ($result) {
                                $row = $result->fetch_assoc();
                                echo $row['total'];
                            } else {
                                echo "Error: " . $conn->error;
                            }
                        ?>
                    </p> 
                </div>
                <div class="stat-box">
                    <h2>Counselors</h2>
                    <p>
                        <?php
                            $result = $conn->query("SELECT COUNT(*) AS total FROM counselors");
                            if ($result) {
                                $row = $result->fetch_assoc();
                                echo $row['total'];
                            } else {
                                echo "Error: " . $conn->error;
                            }
                        ?>
                    </p> 
                </div>
            </section>
        </div>
    </div>
</body>
</html>
