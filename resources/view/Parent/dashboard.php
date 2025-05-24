<?php
session_start();

include '../../../database/db_connect.php';
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
        <span class="text">SGRMS</span>
    </a>
    <ul class="side-menu top">
        <li class="active">
            <a href="parent_dashboard.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>

        <li>
            <a href="my_child.php">
                  <i class='bx bxs-user'></i>
                <span class="text">My Child</span>
            </a>
        </li>
        <li>
            <a href="reports.php">
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
        <a href="#" class="nav-link">Welcome, Parent</a>
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

        <!-- HEAD -->
        <div class="head-title">
            <div class="left"><h1>Dashboard</h1></div>
        </div>


        <!-- CHART + ACTIVITIES -->
        <div class="box-page">

            <section class="analytics">
                <div style="display:flex;align-items:center;gap:18px;">
                    <img src="img/people.png" alt="Parent" style="width:60px;height:60px;border-radius:50%;border:2px solid #e0e7ef;">
                    <div>
                        <h2 style="margin:0;">Welcome<?php if(isset($_SESSION['parent_name'])) echo ', ' . htmlspecialchars($_SESSION['parent_name']); ?>!</h2>
                        <span style="color:#6b7280;">Here’s a quick overview of your account.</span>
                    </div>
                </div>
            </section>

            <section class="activities">
                <div class="activities-box">
                    <h2>Calendar</h2>
                    <ul>
                      
                    </ul>
                </div>
            </section>

            <section class="appointment">
                <div class="appointment-box">
                    <h2>Analytics</h2>
                </div>
            </section>
        </div>


        <!-- TABLE + TODO -->
        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Upcoming Appointments</h3>
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
                            <td><span class="status completed"><i class='bx bx-check-circle'></i> Completed</span></td>
                        </tr>
                        <tr>
                            <td><img src="img/people.png"><p>Maria Santos</p></td>
                            <td>05-14-2025</td>
                            <td><span class="status pending"><i class='bx bx-time'></i> Pending</span></td>
                        </tr>
                        <tr>
                            <td><img src="img/people.png"><p>Carlos Reyes</p></td>
                            <td>05-15-2025</td>
                            <td><span class="status process"><i class='bx bx-loader-circle'></i> Ongoing</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="todo">
                <div class="head">
                    <h3>Counseling History</h3>
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
</section>
<?php include 'Modal/notifModal.php'; ?>

<!-- SCRIPTS -->
<script src="../../js/head.js"></script>
<script src="../../js/linechart.js"></script>
<script src="../../js/Modal/notifModal.js"></script>
</body>
</html>
