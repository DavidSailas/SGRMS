<?php
session_start();
include '../../Database/db_connect.php';

$activitySql = "SELECT activity, timestamp FROM activity_logs ORDER BY timestamp DESC LIMIT 10";
$activityResult = $conn->query($activitySql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Guidance Record Management System</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/SGRMS/CSS/style.css">
    <link rel="stylesheet" href="/SGRMS/CSS/hgadmin.css">
    <link rel="stylesheet" href="/SGRMS/CSS/hg.css">
    <script src="/SGRMS/HG/SuperAdmin/hgscript.js"></script>
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

        /* Base style for submenu (hidden by default) */
        .submenu {
            display: none;
            padding-left: 40px;
            flex-direction: column;
        }

        /* Show submenu when active */
        .submenu.active {
            display: flex;
        }


    </style>
</head>
<body>

<!-- SIDEBAR -->
<section id="sidebar">
    <a href="#" class="brand">
        <i class='bx bxs-smile'></i>
        <span class="text">SGRMS</span>
    </a>
    <ul class="side-menu top">
        <li class="active">
            <a href="/SGRMS/HG/SuperAdmin/superadmin.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="#" id="profiling-link">
                <i class='bx bxs-user'></i>
                <span class="text">Profiling</span>
                <i class='bx bx-chevron-down' style="margin-left:auto;"></i> <!-- Optional dropdown arrow -->
            </a>
            <ul class="submenu" id="profiling-submenu">
                <li>
                    <a href="/SGRMS/HG/Counselors/counsel.php">
                        <i class='bx bxs-user-voice'></i> <!-- Counselors icon -->
                        <span class="text">Counselors</span>
                    </a>
                </li>
                <li>
                    <a href="/SGRMS/HG/Teachers/teacher.php">
                        <i class='bx bxs-chalkboard'></i> <!-- Teachers icon -->
                        <span class="text">Teachers</span>
                    </a>
                </li>
                <li>
                    <a href="/SGRMS/HG/Students/students.php">
                        <i class='bx bxs-graduation'></i> <!-- Students icon -->
                        <span class="text">Students</span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="/SGRMS/HG/Reports/case.php">
                <i class='bx bxs-report'></i>
                <span class="text">Reports</span>
            </a>
        </li>
        <li>
            <a href="/SGRMS/HG/Appointment/schedule.php">
                <i class='bx bxs-calendar'></i>
                <span class="text">Appointments</span>
            </a>
        </li>
    </ul>
    <ul class="side-menu">
        <li>
            <a href="#">
                <i class='bx bxs-cog'></i>
                <span class="text">Settings</span>
            </a>
        </li>
        <li>
            <a href="#" class="logout">
                <i class='bx bxs-log-out-circle'></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</section>
<!-- END SIDEBAR -->

<!-- CONTENT -->
<section id="content">
    <!-- NAVBAR -->
<nav>
    <i class='bx bx-menu'></i>
    <a href="#" class="nav-link">Welcome, Admin</a>
    <form action="#">
        <div class="form-input">
            <input type="search" placeholder="Search...">
            <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
        </div>
    </form>
    <input type="checkbox" id="switch-mode" hidden>
    <label for="switch-mode" class="switch-mode" aria-label="Switch Dark/Light Mode"></label>
    <a href="#" class="notification">
        <i class='bx bxs-bell'></i>
        <span class="num">8</span>
    </a>
    <a href="#" class="profile">
        <img src="img/people.png" alt="Profile">
    </a>
</nav>
    <!-- END NAVBAR -->

 <script>
document.addEventListener("DOMContentLoaded", function () {
    // SIDEBAR ACTIVE LINK TOGGLE
    const sidebarLinks = document.querySelectorAll('#sidebar .side-menu.top li a');
    sidebarLinks.forEach(link => {
        const li = link.parentElement;
        link.addEventListener('click', () => {
            sidebarLinks.forEach(l => l.parentElement.classList.remove('active'));
            li.classList.add('active');
        });
    });

    // TOGGLE SIDEBAR SHOW/HIDE
    const sidebarToggleButton = document.querySelector('#content nav .bx.bx-menu');
    const sidebar = document.getElementById('sidebar');
    sidebarToggleButton.addEventListener('click', () => {
        sidebar.classList.toggle('hide');
    });

    // NAVBAR SEARCH TOGGLE (Mobile)
    const searchButton = document.querySelector('#content nav form .form-input button');
    const searchButtonIcon = searchButton.querySelector('.bx');
    const searchForm = document.querySelector('#content nav form');

    searchButton.addEventListener('click', function (e) {
        if (window.innerWidth < 576) {
            e.preventDefault();
            searchForm.classList.toggle('show');
            if (searchForm.classList.contains('show')) {
                searchButtonIcon.classList.replace('bx-search', 'bx-x');
            } else {
                searchButtonIcon.classList.replace('bx-x', 'bx-search');
            }
        }
    });

    // PROFILING DROPDOWN MENU
    const profilingToggle = document.getElementById("profiling-link");
    const profilingDropdown = document.getElementById("profiling-submenu");

    profilingToggle.addEventListener("click", function (event) {
        event.preventDefault();
        profilingDropdown.classList.toggle("active");
    });

    document.addEventListener("click", function (event) {
        if (!profilingToggle.contains(event.target) && !profilingDropdown.contains(event.target)) {
            profilingDropdown.classList.remove("active");
        }
    });

    // DARK MODE TOGGLE
    const switchMode = document.getElementById('switch-mode');

    // Load saved mode
    if (localStorage.getItem('mode') === 'dark') {
        switchMode.checked = true;
        document.body.classList.add('dark');
    }

    switchMode.addEventListener('change', function () {
        document.body.classList.toggle('dark', this.checked);
        localStorage.setItem('mode', this.checked ? 'dark' : 'light');
    });
});
</script>


<div class="wrapper">

    <!-- PAGE TITLE -->
    <div class="head-title">
        <div class="left">
            <h1>Dashboard</h1>
            <ul class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Home</a></li>
            </ul>
        </div>
    </div>

    <!-- STATS -->
    <section class="stats">
        <div class="stat-box1">
            <h2>Cases</h2>
            <p>
                <?php
                    $result = $conn->query("SELECT COUNT(*) AS total FROM case_records");
                    echo $result ? $result->fetch_assoc()['total'] : "Error: " . $conn->error;
                ?>
            </p>
        </div>
        <div class="stat-box">
            <h2>Students</h2>
            <p>
                <?php
                    $result = $conn->query("SELECT COUNT(*) AS total FROM students");
                    echo $result ? $result->fetch_assoc()['total'] : "Error: " . $conn->error;
                ?>
            </p>
        </div>
        <div class="stat-box">
            <h2>Teachers</h2>
            <p>
                <?php
                    $result = $conn->query("SELECT COUNT(*) AS total FROM teachers");
                    echo $result ? $result->fetch_assoc()['total'] : "Error: " . $conn->error;
                ?>
            </p>
        </div>
        <div class="stat-box">
            <h2>Counselors</h2>
            <p>
                <?php
                    $result = $conn->query("SELECT COUNT(*) AS total FROM counselors");
                    echo $result ? $result->fetch_assoc()['total'] : "Error: " . $conn->error;
                ?>
            </p>
        </div>
    </section>

    <!-- CHART + UPCOMING + APPOINTMENT -->
    <div class="box-page">
        <section class="analytics">
            <h2>Case Report Analytics</h2>
            <canvas id="caseChart"></canvas>

            <?php
                $caseData = array_fill(1, 12, 0);
                $result = $conn->query("SELECT MONTH(filed_date) AS month, COUNT(*) AS total FROM case_records WHERE filed_date IS NOT NULL GROUP BY MONTH(filed_date)");
                while ($row = $result->fetch_assoc()) {
                    $caseData[intval($row['month'])] = $row['total'];
                }
            ?>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var ctx = document.getElementById('caseChart').getContext('2d');
                    new Chart(ctx, {
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
                                y: { beginAtZero: true }
                            }
                        }
                    });
                });
            </script>
        </section>

        <section class="activities">
            <div class="activities-box">
                <h2>Upcoming Counselings</h2>
                <ul>
                    <?php
                        if ($activityResult && $activityResult->num_rows > 0) {
                            while ($activityRow = $activityResult->fetch_assoc()) {
                                echo "<li><strong>{$activityRow['timestamp']}</strong>: {$activityRow['activity']}</li>";
                            }
                        } else {
                            echo "No upcoming counseling sessions.";
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

    <!-- COUNSELINGS + TASKS -->
    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Recent Counselings</h3>
                <i class='bx bx-search'></i>
                <i class='bx bx-filter'></i>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Date Scheduled</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="img/people.png"><p>Juan Dela Cruz</p></td>
                        <td>05-13-2025</td>
                        <td><span class="status completed">Completed</span></td>
                    </tr>
                    <tr>
                        <td><img src="img/people.png"><p>Maria Santos</p></td>
                        <td>05-14-2025</td>
                        <td><span class="status pending">Pending</span></td>
                    </tr>
                    <tr>
                        <td><img src="img/people.png"><p>Carlos Reyes</p></td>
                        <td>05-15-2025</td>
                        <td><span class="status process">Ongoing</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="todo">
            <div class="head">
                <h3>Counselor's Tasks</h3>
                <i class='bx bx-plus'></i>
                <i class='bx bx-filter'></i>
            </div>
            <ul class="todo-list">
                <li class="completed"><p>Review case reports</p><i class='bx bx-dots-vertical-rounded'></i></li>
                <li class="not-completed"><p>Call parent of student X</p><i class='bx bx-dots-vertical-rounded'></i></li>
                <li class="completed"><p>Submit monthly report</p><i class='bx bx-dots-vertical-rounded'></i></li>
                <li class="not-completed"><p>Schedule new counseling session</p><i class='bx bx-dots-vertical-rounded'></i></li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>
