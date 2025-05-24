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
    <link rel="stylesheet" href="../../css/table.css">
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
        <li>
            <a href="dashboard.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        
        <li class="active">
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

    
    <main class="wrapper">
        <div class="card">

            <!-- Notification Modal -->
            <div id="notificationModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:2000;">
    <div style="background:white; width:400px; margin:50px auto; padding:20px; border-radius:8px; position:relative;">
        <h3>All Notifications</h3>
        <ul id="modalNotificationList" style="list-style: none; padding: 0; max-height: 300px; overflow-y: auto;">
            <?php if ($notifModalResult && $notifModalResult->num_rows > 0): ?>
                <?php while($notif = $notifModalResult->fetch_assoc()): ?>
                    <li style="padding:8px 12px; border-bottom:1px solid #eee;">
                        <?= htmlspecialchars($notif['message']) ?><br>
                        <small style="color:#888;"><?= date('M d, Y H:i', strtotime($notif['timestamp'])) ?></small>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li style="padding:8px 12px;">No notifications</li>
            <?php endif; ?>
        </ul>
        <button onclick="closeModal()" style="margin-top: 10px;">Close</button>
    </div>
</div>

            <div class="table-container">
                <table id="caseTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Academic Level</th>
                            <th>Case Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                   <tbody>
<?php
if (isset($_SESSION['s_id'])) {
    $student_id = $_SESSION['s_id'];

    $sql = "SELECT 
                cr.case_id,
                s.educ_level AS academic_level,
                cr.case_type,
                cr.status
            FROM case_records cr
            JOIN students s ON cr.student_id = s.s_id
            WHERE cr.student_id = ?
            ORDER BY cr.referral_date DESC";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($row['case_id']) . "</td>
                    <td>" . htmlspecialchars($row['academic_level']) . "</td>
                    <td>" . htmlspecialchars($row['case_type']) . "</td>
                    <td>" . htmlspecialchars($row['status']) . "</td>
                    <td class='actions'>
                        <button class='btn btn-view' onclick='openViewCaseModal(" . $row['case_id'] . ")'>View</button>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align:center;'>No records found</td></tr>";
        }

        $stmt->close();
    } else {
        echo "<tr><td colspan='5' style='text-align:center;'>Failed to prepare query.</td></tr>";
    }
} else {
    echo "<tr><td colspan='5' style='text-align:center;'>Student not logged in.</td></tr>";
}
?>
</tbody>

                </table>
            </div>

            <div id="caseDetailsModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:2000;">
                <div style="background:white; width:600px; margin:50px auto; padding:20px; border-radius:8px; position:relative; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    <button class="close-modal-btn" aria-label="Close modal" style="position:absolute; top:12px; right:15px; background:transparent; border:none; font-size:1.8rem; font-weight:bold; color:#888; cursor:pointer; line-height:1; padding:0;">&times;</button>
                    <h3>Case Details</h3>
                    <div id="caseDetailsContent">Loading...</div>
                </div>
            </div>



            <ul id="pagination-case" class="pagination"></ul>
        </div>
    </main>
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
<script src="../../js/Modal/notifModal.js"></script>
<script src="../../js/chatbot.js"></script>
</body>
</html>
