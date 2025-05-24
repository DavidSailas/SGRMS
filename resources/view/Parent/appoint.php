<?php
session_start();

include '../../../database/db_connect.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>School Guidance Record Management System</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/bar.css">
    <link rel="stylesheet" href="../../css/table.css">
    <link rel="stylesheet" href="../../css/appoint.css">
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
        <li>
            <a href="dashboard.php">
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
        <li class="active">
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

  <main class="wrapper">

        <div class="box-container">

            <!-- LEFT SIDE -->
            <div class="box-left">
                <div class="add-appoint">
                    <h2>Add appointment in <br>your schedule now</h2>
                    <button class="add-btn btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                        Add Appointment
                    </button>
                </div>
                <div class="schedule">
                    <div class="flex">
                        <div class="text">
                            <h2>Your Schedule</h2>
                        </div>
                        <div class="toolbar buttons">
                            <button id="buttonDay">Day</button>
                            <button id="buttonWeek">Week</button>
                            <button id="buttonMonth">Month</button>
                        </div>
                    </div>
                    <div id="dpDay"></div>
                    <div id="dpWeek"></div>
                    <div id="dpMonth"></div>
                </div>   
            </div>

            <!-- RIGHT SIDE -->
            <div class="box-right">
                <div class="calendar">
                    <h2>calendar</h2>
                    <div id="nav"></div>
                </div>
                <div class="appointment">
                    <h2>Appointment Requests</h2>
                    <div class="table">
                        
                        
                    </div>
                </div>
              
            </div>

        </div>

    </main>

</section>

<?php include 'Modal/notifModal.php'; ?>
<?php include 'Modal/appointModal.php'; ?>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../js/head.js"></script>
<script src="../../js/daypilot/daypilot-all.min.js"></script>
<script src="../../js/daypilot/calendar.js"></script>
<script src="../../js/Modal/notifModal.js"></script>
</body>
</html>