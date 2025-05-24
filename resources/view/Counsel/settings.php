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
    <link rel="stylesheet" href="../../css/settings.css">
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
        <li>
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
        <li class="active">
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
        <div class="card" tabindex="0" onclick="window.location.href='#personal-info'">
            <i class="bx bxs-user-detail"></i>
            <h2>Personal info</h2>
            <p>Provide personal details and how we can reach you.</p>
        </div>
        <div class="card" tabindex="0" onclick="window.location.href='#login-security'">
            <i class="bx bxs-lock-alt"></i>
            <h2>Login &amp; Security</h2>
            <p>Update your password and secure your account.</p>
        </div>
        <div class="card" tabindex="0" onclick="window.location.href='#privacy'">
            <i class="bx bxs-shield"></i>
            <h2>Privacy</h2>
            <p>Manage your personal data and connected services.</p>
        </div>
    </div>
</section>

<?php include 'Modal/notifModal.php'; ?>

<!-- SCRIPTS -->
<script src="../../js/head.js"></script>
<script src="../../js/Modal/notifModal.js"></script>
</body>
</html>