<?php
session_start();
include '../../../database/db_connect.php';

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
    <title>School Guidance Record Management System</title>
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
            <section class="student-list">
                <div class="search-flex">
                    <h2>Student List</h2>                       
                    <div class="search-bar">
                        <input type="text" id="search" name="search" class="search" placeholder="Search by ID or Name">
                        <button class="btn btn-add" onclick="openAddModal()">Add Student</button>
                    </div>
                </div>

                <!-- Education Level Tabs -->
                <div class="tab-container">
                    <a href="students.php" class="tab <?= !isset($_GET['status']) ? 'active' : '' ?>">All Students</a>
                    <a href="students.php?status=college" class="tab <?= ($_GET['status'] ?? '') == 'college' ? 'active' : '' ?>">College</a>
                    <a href="students.php?status=highschool" class="tab <?= ($_GET['status'] ?? '') == 'highschool' ? 'active' : '' ?>">Highschool</a>
                    <a href="students.php?status=elementary" class="tab <?= ($_GET['status'] ?? '') == 'elementary' ? 'active' : '' ?>">Elementary</a>
                    <a href="students.php?status=inactive" class="tab <?= ($_GET['status'] ?? '') == 'inactive' ? 'active' : '' ?>">Inactive</a>
                    <a href="students.php?status=archived" class="tab <?= ($_GET['status'] ?? '') == 'archived' ? 'active' : '' ?>">Archived</a>
                </div>

                <div class="table-container">
                    <table id="studentTable">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Educational Level</th>
                                <th>Section/Program</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="studentTableBody">
                            <?php
                                $filter = $_GET['status'] ?? 'active';

                                $educLevelMap = [
                                    'college' => 'College',
                                    'highschool' => 'High School',
                                    'elementary' => 'Elementary'
                                ];

                                if (in_array($filter, ['college', 'highschool', 'elementary'])) {
                                    $educLevel = $educLevelMap[$filter];
                                    $sql = "SELECT s_id, id_num, suffix, lname, fname, mname, sex, bod, address, mobile_num, email, 
                                            educ_level, year_level, section, program, previous_school, status,
                                            (SELECT COUNT(*) FROM case_records WHERE student_id = students.s_id) AS case_count
                                            FROM students
                                            WHERE educ_level = ?
                                            AND status = 'active'
                                            ORDER BY lname ASC";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("s", $educLevel);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                } elseif (in_array($filter, ['inactive', 'archived'])) {
                                    $sql = "SELECT s_id, id_num, suffix, lname, fname, mname, sex, bod, address, mobile_num, email, 
                                            educ_level, year_level, section, program, previous_school, status,
                                            (SELECT COUNT(*) FROM case_records WHERE student_id = students.s_id) AS case_count
                                            FROM students
                                            WHERE status = ?
                                            ORDER BY lname ASC";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("s", $filter);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                } else {
                                    // default: show all active students
                                    $sql = "SELECT s_id, id_num, suffix, lname, fname, mname, sex, bod, address, mobile_num, email, 
                                            educ_level, year_level, section, program, previous_school, status,
                                            (SELECT COUNT(*) FROM case_records WHERE student_id = students.s_id) AS case_count
                                            FROM students
                                            WHERE status = 'active'
                                            ORDER BY lname ASC";
                                    $result = $conn->query($sql);
                                }


                                if (!isset($stmt)) {
                                    $result = $conn->query($sql);
                                }


                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $caseCount = (int)$row['case_count'];
                                        if ($caseCount === 0) {
                                            $statusClass = 'green';
                                        } elseif ($caseCount <= 2) {
                                            $statusClass = 'orange';
                                        } else {
                                            $statusClass = 'red';
                                        }

                                        $bod = $row['bod'];
                                        $birthdate = new DateTime($bod);
                                        $today = new DateTime();
                                        $age = $today->diff($birthdate)->y;

                                        $suffix = ($row['suffix'] !== 'N/A') ? $row['suffix'] : '';
                                        $mname = trim($row['mname']);
                                        $mname = ($mname !== '') ? strtoupper(substr($mname, 0, 1)) . '.' : '';
                                        $name = trim($row['lname'] . ", " . $row['fname'] . " " . $mname . " " . $suffix);

                                        echo "<tr data-status='" . htmlspecialchars(strtolower($row['status'])) . "'>
                                            <td><span class='status-circle $statusClass' style='background: $statusClass !important;'></span></td>
                                            <td>".htmlspecialchars($row['id_num'])."</td>
                                            <td>".htmlspecialchars($name)."</td>
                                            <td>".$age."</td>
                                            <td>".htmlspecialchars($row['educ_level'])."</td>
                                            <td>".(!empty($row['section']) ? htmlspecialchars($row['section']) : htmlspecialchars($row['program']))."</td>
                                            <td style='display:none;' class='status-text'>".htmlspecialchars(strtolower($row['status']))."</td>
                                            <td>
                                                <button class='btn btn-view' onclick='viewStudent(".$row['s_id'].")'>View</button>
                                                <button class='btn btn-edit' onclick='openEditModal(".$row['s_id'].")'>Edit</button>
                                                <button class='btn btn-delete' onclick='openDeleteConfirmationModal(".$row['s_id'].")'>Delete</button>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No students found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <ul id="pagination-student" class="pagination"></ul>
            </section>
        </div>
    </main>
</section>

<?php include 'Modal/studModal.php'; ?>
<?php include 'Modal/notifModal.php'; ?>

<!-- SCRIPTS -->
<script src="../../js/head.js"></script>
<script src="../../js/studfilter.js"></script>
<script src="../../js/Modal/studModal.js"></script>
<script src="../../js/pagination.js"></script>
<script src="../../js/Modal/notifModal.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        paginateTable();
    });
    
    document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    const tableBody = document.getElementById("studentTableBody");

    searchInput.addEventListener("input", function () {
        const query = this.value;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../../../app/Controllers/Head/StudentController/searchstud.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            if (this.status === 200) {
                tableBody.innerHTML = this.responseText;
            }
        };

        xhr.send("search=" + encodeURIComponent(query));
    });
});
</script>
</body>
</html>