<?php
session_start();
$_SESSION['fname'] = isset($_SESSION['fname']) ? $_SESSION['fname'] : 'Student';
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
    <link rel="stylesheet" href="../../css/chatbot.css">
    <script src="../../js/notify.js" defer></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
</head>
<body>

<!-- SIDEBAR -->
<section id="sidebar">
    <a href="#" class="brand">
        <span class="text">SGRMS</span>
    </a>
    <ul class="side-menu top">
        <li class="active">
            <a href="dashboard.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
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
        <a href="#" class="nav-link">
            <?php
                if (isset($_SESSION['fname'])) {
                    echo "Welcome, " . htmlspecialchars($_SESSION['fname']);
                } else {
                    echo "Welcome, Student";
                }
            ?>
        </a>
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

        <!-- Welcome & Stats -->
        <div class="head-title">
            <div class="left"><h1>Dashboard</h1></div>
        </div>
        <div class="dashboard-cards">
            <div class="card stat-cases">
                <h4><i class='bx bxs-calendar-check' style="color:#4f8cff;"></i> Appointments</h4>
                <p>2</p>
            </div>
            <div class="card stat-white">
                <h4><i class='bx bxs-report' style="color:#fdcb6e;"></i> Reports</h4>
                <p>1</p>
            </div>
            <div class="card stat-white">
                <h4><i class='bx bxs-user' style="color:#00b894;"></i> Counselor</h4>
                <p>Ms. Cruz</p>
            </div>
        </div>

        <!-- Analytics & Activities -->
        <div class="box-page">
            <section class="analytics">
                <h2>Your Progress</h2>
                <canvas id="studentChart" style="max-height:220px;"></canvas>
            </section>
            <section class="activities">
                <div class="activities-box">
                    <h2>Reminders</h2>
                    <ul>
                        <li>Prepare for your next counseling session</li>
                        <li>Check your latest report</li>
                        <li>Update your profile if needed</li>
                    </ul>
                </div>
            </section>
        </div>

    </div>
</section>

<!-- Chatbot Button & Popup -->
<button id="chatbot-toggler">
    <span class="material-symbols-rounded">mode_comment</span>
    <span class="material-symbols-rounded">close</span>
</button>
<div class="chatbot-popup">
    <!-- Chat Header -->
    <div class="chat-header">
        <div class="header-info">
            <svg class="chatbot-logo" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
                <path d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"></path>
            </svg>
            <h2 class="logo-text">SGRMS Support</h2>
        </div>
        <button id="close-chatbot" class="material-symbols-rounded">keyboard_arrow_down</button>
    </div>
    <!-- Chat Body -->
    <div class="chat-body">
        <div class="message bot-message">
            <svg class="bot-avatar" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
                <path d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"></path>
            </svg>
            <div class="message-text">Hello 👋<br> How can I assist you today?</div>
        </div>
    </div>
    <!-- Chat Footer -->
    <div class="chat-footer">
        <form action="#" class="chat-form">
            <textarea placeholder="Message..." class="message-input" required></textarea>
            <div class="chat-controls">
                <button type="submit" id="send-message" class="material-symbols-rounded">arrow_upward</button>
            </div>
        </form>
    </div>
</div>

<?php include 'Modal/notifModal.php'; ?>

<!-- SCRIPTS -->
<script src="../../js/head.js"></script>
<script src="../../js/sidebar.js"></script>
<script src="../../js/chatbot.js"></script>
<script src="../../js/Modal/notifModal.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('studentChart').getContext('2d');
    // Create a gradient fill
    var gradient = ctx.createLinearGradient(0, 0, 0, 220);
    gradient.addColorStop(0, "#4f8cff");
    gradient.addColorStop(1, "#b3d1ff");

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                label: 'Sessions Attended',
                data: [1, 2, 1, 3, 2],
                backgroundColor: gradient,
                borderRadius: 12,
                barPercentage: 0.6,
                categoryPercentage: 0.5,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#22223b',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#4f8cff',
                    borderWidth: 1,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return ` ${context.parsed.y} session${context.parsed.y === 1 ? '' : 's'}`;
                        }
                    }
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#22223b',
                    font: { weight: 'bold' }
                }
            },
            layout: {
                padding: { top: 10 }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { family: 'Poppins, Arial, sans-serif', size: 14 },
                        color: '#22223b'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e0e7ef',
                        borderDash: [4, 4]
                    },
                    ticks: {
                        stepSize: 1,
                        font: { family: 'Poppins, Arial, sans-serif', size: 13 },
                        color: '#6b7280'
                    }
                }
            },
            animation: {
                duration: 1200,
                easing: 'easeOutQuart'
            }
        },
        plugins: [ChartDataLabels]
    });
});
</script>
</body>
</html>
