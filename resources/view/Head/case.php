<?php
session_start();
include '../../../database/db_connect.php';

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
    
    <!-- CSS Links -->
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/bar.css">
    <link rel="stylesheet" href="../../css/table.css">
    <link rel="stylesheet" href="../../css/case.css">
    <link rel="stylesheet" href="../../css/pagination.css">
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
            <a href="#" id="profiling-link">
                <i class='bx bxs-user'></i>
                <span class="text">Profiling</span>
                <i class='bx bx-chevron-down' style="margin-left:auto;"></i> 
            </a>
        </li> 
        <ul class="submenu" id="profiling-submenu">
              <li >
                <a href="counsel.php">
                    <i class='bx bxs-user-voice'></i> 
                        <span class="text">Counselors</span>
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
        </ul>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const profilingLink = document.getElementById('profiling-link');
        const profilingSubmenu = document.getElementById('profiling-submenu');

        profilingLink.addEventListener('click', function() {
            profilingSubmenu.classList.toggle('active');
        });
    });
</script>

<!-- CONTENT -->
<section id="content">
    <!-- NAVBAR -->
    <nav>
        <i class='bx bx-menu'></i>
        <a href="#" class="nav-link">Welcome, Admin</a>
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
            <div class="search-flex">
                <h2>Case Management</h2>
                <div class="flex">
                <div class="search-container">
                    <input type="text" id="searchInput" class="search-input" placeholder="Search by Case ID or Type" onkeyup="searchCases()">
                </div>
                <button id="openModalBtn" style="margin: 20px; padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 5px;">Add Case</button>
                </div>
            </div>


            <div class="search-container">
                
            </div>

            <!-- Academic Level Tabs -->
            <div class="tab-container">
                <button id="allTab" class="tab active" onclick="filterCases('all')">All Cases</button>
                <button id="collegeTab" class="tab" onclick="filterCases('college')">College Cases</button>
                <button id="highschoolTab" class="tab" onclick="filterCases('high school')">High School Cases</button>
                <button id="elementaryTab" class="tab" onclick="filterCases('elementary')">Elementary Cases</button>
                <button id="pendingTab" class="tab" onclick="filterCases('pending')">Pending Cases</button>
                <button id="archivedTab" class="tab" onclick="filterCases('archived')">Archived Cases</button>
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
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $studentName = htmlspecialchars($row['lname'] . ', ' . $row['fname']);
        $academicLevel = htmlspecialchars($row['educ_level']);
        $sectionOrProgram = !empty($row['section']) ? htmlspecialchars($row['section']) : htmlspecialchars($row['program']);
        $caseId = (int)$row['case_id'];
        $caseType = htmlspecialchars($row['case_type']);
        $status = htmlspecialchars($row['status']);

        echo "<tr>
                <td>$caseId</td>
                <td>$academicLevel</td>
                <td>$caseType</td>
                <td>$status</td>
                <td class='actions'>
                    <button class='btn btn-view' onclick='openViewCaseModal($caseId)'>View</button>
                    <button class='btn btn-edit' onclick='openEditCaseModal($caseId)'>Edit</button>";
        if (strtolower($row['status']) !== 'archived') {
            echo "<button class='btn btn-delete' onclick='openArchiveModal($caseId)'>Archive</button>";
        }
        echo "</td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No records found</td></tr>";
}
?>
<tr id="noRecordsRow" style="display: none;">
    <td colspan="5" style="text-align: center;">No records found</td>
</tr>
</tbody>
                </table>
            </div>

            <ul id="pagination-case" class="pagination"></ul>
        </div>
    </main>s
</section>
<?php include 'Modal/caseModal.php'; ?>
<?php include 'Modal/notifModal.php'; ?>

<script src="../../js/head.js"></script>
<script src="../../js/notify.js" defer></script>
<script src="../../js/pagination.js" defer></script>
<script src="../../js/case.js" defer></script>
<script src="../../js/Modal/caseModal.js"></script>
<script src="../../js/Modal/notifModal.js"></script>
</body>
</html>

