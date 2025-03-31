<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';

$activitySql = "SELECT activity, timestamp FROM activity_logs ORDER BY timestamp DESC LIMIT 10";
$activityResult = $conn->query($activitySql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Guidance Record Management System</title>
    <link rel="stylesheet" href="/SGRMS/CSS/style.css">
    <link rel="stylesheet" href="/SGRMS/CSS/hg.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>

        .box-page {
            display: grid;
            grid-template-columns: 2fr 1fr; 
            grid-template-rows: auto 1fr;
            gap: 20px;
            margin-top: 15px;
        }

        .analytics {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            grid-column: 1; 
            grid-row: 1; 
            height: 400px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .analytics canvas {
            width: 100% !important;
            height: 100% !important;
            max-height: 300px;
        }

        .appointment {
            grid-column: 1; 
            grid-row: 2; 
            height: 300px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .activities {
            grid-column: 2; 
            grid-row: 1 / span 2; 
            height: 725px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .analytics h2, .activities h2, .appointment h2 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #004085;
            font-weight: bold;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            position: relative;
        }

        .submenu {
            display: none;
            padding-left: 20px;
        }

        .submenu.active {
            display: block;
        }

    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <h1>SGRMS</h1>
            <ul>
                <li><a href="/SGRMS/HG/SuperAdmin/superadmin.php">Home</a></li>
                <li class="has-submenu">
                    <a href="#" id="profiling-link">Profiling</a>
                    <ul class="submenu" id="profiling-submenu">
                        <li><a href="/SGRMS/HG/Counselors/counsel.php">Counselors</a></li>
                        <li><a href="/SGRMS/HG/Teachers/teacher.php">Teachers</a></li>
                        <li><a href="/SGRMS/HG/Students/students.php">Students</a></li>
                    </ul>
                </li>
                <li><a href="/SGRMS/HG/Reports/case.php">Reports</a></li>
                <li><a href="/SGRMS/HG/Appointment/schedule.php">Appointments</a></li>
                <li><a href="#">Settings</a></li>
            </ul>
        </aside>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const profilingLink = document.getElementById("profiling-link");
                const profilingSubmenu = document.getElementById("profiling-submenu");

                profilingLink.addEventListener("click", function (event) {
                    event.preventDefault();
                    profilingSubmenu.classList.toggle("active");
                });

                document.addEventListener("click", function (event) {
                    if (!profilingLink.contains(event.target) && !profilingSubmenu.contains(event.target)) {
                        profilingSubmenu.classList.remove("active");
                    }
                });
            });
        </script>

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
            <div class="box-page">
                <section class="analytics">
                    <h2>Case Report Analytics</h2>
                    <canvas id="caseChart"></canvas>

                    <?php
                        $caseData = array_fill(1, 12, 0); // Initialize array for 12 months (Jan-Dec)

                        $result = $conn->query("SELECT MONTH(filed_date) AS month, COUNT(*) AS total FROM case_records WHERE filed_date IS NOT NULL GROUP BY MONTH(filed_date)");

                        while ($row = $result->fetch_assoc()) {
                            $caseData[intval($row['month'])] = $row['total']; // Ensure keys are integers
                        }
                    ?>

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            var ctx = document.getElementById('caseChart').getContext('2d');
                            var caseChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                    datasets: [{
                                        label: 'Number of Cases',
                                        data: <?php echo json_encode(array_values($caseData)); ?>,
                                        borderColor: 'rgba(0, 102, 255, 1)',
                                        backgroundColor: 'rgba(0, 102, 255, 0.2)',
                                        borderWidth: 2,
                                        fill: true
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                </section>

                <section class="activities">
                    <div class="activities-box">
                        <h2>Recent Activities</h2>
                        <ul>
                            <?php
                                if ($activityResult && $activityResult->num_rows > 0) {
                                    while ($activityRow = $activityResult->fetch_assoc()) {
                                        echo "<li><strong>{$activityRow['timestamp']}</strong>: {$activityRow['activity']}</li>";
                                    }
                                } else {
                                    echo "No recent activities found.";
                                }
                            ?>
                        </ul>
                    </div>
                </section>

                <section class="appointment">
                    <div class="appointment-box">
                        <h2>Appointments</h2>
                        <!-- appointments content -->
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
