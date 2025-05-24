<?php
session_start();
include '../../../database/db_connect.php';

if (!isset($_SESSION['counselor_id'])) {
    header("Location: ../../../index.php");
    exit();
}

$activitySql = "SELECT activity, timestamp FROM activity_logs ORDER BY timestamp DESC LIMIT 10";
$activityResult = $conn->query($activitySql);

$sql = "SELECT cr.case_id, s.educ_level, s.section, s.program, s.lname, s.fname, cr.case_type, cr.status 
        FROM case_records cr
        JOIN students s ON cr.student_id = s.s_id";
$result = $conn->query($sql);

// Fetch notifications for modal
$notifModalResult = $conn->query("SELECT message, timestamp FROM notifications ORDER BY id DESC LIMIT 20");

// Fetch notification count and for bell (optional)
$notifCountResult = $conn->query("SELECT COUNT(*) as cnt FROM notifications WHERE is_read = 0");
$notifCount = $notifCountResult ? $notifCountResult->fetch_assoc()['cnt'] : 0;
$notifResult = $conn->query("SELECT message FROM notifications ORDER BY id DESC LIMIT 10");
$studRes = $conn->query("SELECT s_id, lname, fname FROM students WHERE status = 'active'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Student Guidance Record Management System</title>
     <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/bar.css">
    <link rel="stylesheet" href="../../css/dashboard.css">
    <script src="../../js/notify.js" defer></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<!-- SIDEBAR -->
<section id="sidebar">
    <a href="#" class="brand">
        <img src="../../../public/images/logo/logo.svg" class="brand-logo" alt="SGRMS Logo">
    </a>
    <ul class="side-menu top">
        <li class="active">
            <a href="dashboard.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="parents.php">
                <i class='bx bxs-chalkboard'></i> 
                <span class="text">Parents</span>
            </a>
        </li>
        <li>
            <a href="students.php">
                <i class='bx bxs-graduation'></i> 
                <span class="text">Students</span>
            </a>
        </li>
        <li>
            <a href="case.php">
                <i class='bx bxs-report'></i>
                <span class="text">Reports</span>
            </a>
        </li>
        <li>
            <a href="appoint.php">
                <i class='bx bxs-calendar'></i>
                <span class="text">Appointments</span>
            </a>
        </li>
    </ul>
    <ul class="side-menu">
        <li>
            <a href="settings.php">
                <i class='bx bxs-cog'></i>
                <span class="text">Settings</span>
            </a>
        </li>
        <li>
            <a href="../../../index.php" class="logout">
                <i class='bx bxs-log-out-circle'></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</section>

<!-- CONTENT -->
<section id="content">
    <!-- NAVBAR -->
    <nav>
        <i class='bx bx-menu'></i>
        <a href="#" class="nav-link">Welcome, Counselor</a>
        <form action="#">
            <div class="form-input">
             
            </div>
        </form>
        <input type="checkbox" id="switch-mode" hidden>
        
        <a href="#" id="notificationBell" class="notification">
            <i class='bx bxs-bell'></i>
            <span class="num" style="<?= $notifCount > 0 ? '' : 'display:none;' ?>">
                <?= $notifCount > 0 ? $notifCount : '' ?>
            </span>
        </a>
        <a href="#" class="profile"><img src="img/people.png" alt="Profile"></a>
    </nav>

    <div class="wrapper">
        <section class="stats">
            <?php
                $entities = [
                    'case_records' => [
                        'label' => 'Cases',
                        'class' => 'stat-cases',
                        'icon'  => "<i class='bx bxs-folder-open' style='color:#004085; margin-right:8px;'></i>",
                        'query' => "SELECT COUNT(*) AS total FROM case_records"
                    ],
                    'all_students' => [
                        'label' => 'Students',
                        'class' => 'stat-white',
                        'icon'  => "<i class='bx bxs-graduation' style='color:#004085; margin-right:8px;'></i>",
                        'query' => "SELECT COUNT(*) AS total FROM students"
                    ],
                    'elementary_students' => [
                        'label' => 'Elementary',
                        'class' => 'stat-white',
                        'icon'  => "<i class='bx bxs-user-detail' style='color:#004085; margin-right:8px;'></i>",
                        'query' => "SELECT COUNT(*) AS total FROM students WHERE educ_level = 'Elementary'"
                    ],
                    'highschool_students' => [
                        'label' => 'High School',
                        'class' => 'stat-white',
                        'icon'  => "<i class='bx bxs-user-voice' style='color:#004085; margin-right:8px;'></i>",
                        'query' => "SELECT COUNT(*) AS total FROM students WHERE educ_level = 'High School'"
                    ],
                    'college_students' => [
                        'label' => 'College',
                        'class' => 'stat-white',
                        'icon'  => "<i class='bx bxs-user-voice' style='color:#004085; margin-right:8px;'></i>",
                        'query' => "SELECT COUNT(*) AS total FROM students WHERE educ_level = 'College'"
                    ]
                ];

                foreach ($entities as $key => $info) {
                    $result = $conn->query($info['query']);
                    $count = $result ? $result->fetch_assoc()['total'] : "Error";
                    echo "<div class='stat-box {$info['class']}'>
                            <h2>{$info['icon']}{$info['label']}</h2>
                            <p>$count</p>
                        </div>";
                }
            ?>
        </section>


        <!-- BAR CHART SECTION -->
        <div class="chart-container">
            <h3>Student Distribution</h3>
            <div class="bar-chart">
                <canvas id="studentChart"></canvas>
            </div>
        </div>

        <!-- UPCOMING APPOINTMENTS -->
        <div class="appointments-container">
            <h3>Upcoming Counseling Appointments</h3>
            <div class="appointments-list">
                <div class="appointment-item">

                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'Modal/notifModal.php'; ?>

<!-- SCRIPTS -->
<script src="../../js/head.js"></script>
<script src="../../js/Modal/notifModal.js"></script>
</body>
</html>