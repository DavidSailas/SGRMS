<?php
session_start();
include '../../../database/db_connect.php';

// Fetch activity logs
$activitySql = "SELECT activity, timestamp FROM activity_logs ORDER BY timestamp DESC LIMIT 10";
$activityResult = $conn->query($activitySql);

$parentSql = "SELECT p.*, u.username, u.status as account_status FROM parents p
              LEFT JOIN users u ON u.parent_id = p.p_id AND u.role = 'Parent'";
$parentResult = $conn->query($parentSql);

$caseSql = "SELECT cr.case_id, s.educ_level, s.section, s.program, s.lname, s.fname, cr.case_type, cr.status 
            FROM case_records cr
            JOIN students s ON cr.student_id = s.s_id";
$caseResult = $conn->query($caseSql);

$notifModalResult = $conn->query("SELECT message, timestamp FROM notifications ORDER BY id DESC LIMIT 20");
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
    <link rel="stylesheet" href="../../css/table.css">
    <link rel="stylesheet" href="../../css/pagination.css">
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
        <li class="active">
            <a href="#" id="profiling-link">
                <i class='bx bxs-user'></i>
                <span class="text">Profiling</span>
                <i class='bx bx-chevron-down' style="margin-left:auto;"></i> 
            </a>
        </li> 
        <ul class="submenu" id="profiling-submenu">
            <li>
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
            <section class="parent-list">
                <div class="search-flex">
                    <h2>Parent List</h2>
                    <div class="search-bar">
                        <input type="text" id="parentSearch" name="parentSearch" class="search" placeholder="Search by Parent Name">
                    </div>
                </div>
                <div class="table-container">
                    <table class="styled-table" id="parentTable">
                        <thead>
                            <tr>
                                <th>Parent Name</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>Account Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="parentTableBody">
                            <?php
                            if ($parentResult && $parentResult->num_rows > 0) {
                                while ($parent = $parentResult->fetch_assoc()) {
                                    $statusBadge = is_null($parent['account_status']) ? "<span class='badge badge-gray'>No Account</span>" : 
                                                   (strtolower($parent['account_status']) === 'active' ? "<span class='badge badge-green'>Has Account</span>" : 
                                                   "<span class='badge badge-orange'>Inactive Account</span>");
                                    echo "<tr>
                                        <td>" . htmlspecialchars($parent['guardian_name']) . "</td>
                                        <td>" . htmlspecialchars($parent['contact_num']) . "</td>
                                        <td>" . htmlspecialchars($parent['email']) . "</td>
                                        <td>$statusBadge</td>
                                        <td>
                                            <button class='btn btn-view' data-id='" . $parent['p_id'] . "'>View</button>
                                            <button class='btn btn-edit' data-id='" . $parent['p_id'] . "'>Edit</button>
                                            <button class='btn btn-delete' data-id='" . $parent['p_id'] . "'>Archive</button>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No parent accounts found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <ul id="pagination-parent" class="pagination"></ul>
            </section>
        </div>
    </main>
</section>

<?php include 'Modal/notifModal.php'; ?>
<?php include 'Modal/parentModal.php'; ?>

<!-- SCRIPTS -->
<script src="../../js/head.js"></script>
<script src="../../js/Modal/notifModal.js"></script>
<script src="../../js/parent.js"></script>
<script src="../../js/pagination.js"></script>
<script src="../../js/Modal/parentModal.js"></script>

</body>
</html>
