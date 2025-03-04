<?php
    include '../Database/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Record Management System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .status-circle {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        .green {
            background-color: green;
        }
    </style>
</head> 
<body>
    <header>
        <div class="head">
            <h1>Student Record Management System</h1>
            <aside class="sidebar">
                <nav>
                    <ul>
                        <li><a href="superadmin.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                        <li><a href="counsel.php"><i class="fas fa-user-cog"></i>Counselors</a></li>
                        <li><a href="teacher.php"><i class="fas fa-chalkboard-teacher"></i>Teachers</a></li>
                        <li><a href="students.php"><i class="fas fa-user-graduate"></i>Students</a></li>
                        <li><a href="case.php"><i class="fas fa-file-alt"></i>Reports</a></li>
                        <li><a href="#"><i class="fas fa-cogs mr-2"></i>Settings</a></li>
                    </ul> 
                </nav>
            </aside> 
        </div>
    </header>

    <div class="wrapper">
        <section class="stats">
            <div class="stat-box">
                <h2>Total Students</h2>
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
                <h2>Total Teachers</h2>
                <p></p> 
            </div>
            <div class="stat-box">
                <h2>Total Cases</h2>
                <p></p> 
            </div>
        </section>


    </div>
</body>
</html>
