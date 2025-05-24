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
    <title>Student Guidance Record Management System</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/bar.css">
    <link rel="stylesheet" href="../../css/dashboard.css">
    <script src="../../js/notify.js" defer></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

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
                <input type="search" placeholder="Search...">
                <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </div>
        </form>
        <input type="checkbox" id="switch-mode" hidden>
        <label for="switch-mode" class="switch-mode" aria-label="Switch Dark/Light Mode"></label>
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


        <!-- STATS -->
        <section class="stats">
            <?php
                $entities = [
                    'case_records' => [
                        'label' => 'Cases',
                        'class' => 'stat-cases',
                        'icon'  => "<i class='bx bxs-folder-open' style='color:#004085; margin-right:8px;'></i>"
                    ],
                    'students' => [
                        'label' => 'Students',
                        'class' => 'stat-white',
                        'icon'  => "<i class='bx bxs-graduation' style='color:#004085; margin-right:8px;'></i>"
                    ],
                    'parents' => [
                        'label' => 'Parents',
                        'class' => 'stat-white',
                        'icon'  => "<i class='bx bxs-user-detail' style='color:#004085; margin-right:8px;'></i>"
                    ],
                    'counselors' => [
                        'label' => 'Counselors',
                        'class' => 'stat-white',
                        'icon'  => "<i class='bx bxs-user-voice' style='color:#004085; margin-right:8px;'></i>"
                    ]
                ];
                foreach ($entities as $table => $info) {
                    $result = $conn->query("SELECT COUNT(*) AS total FROM $table");
                    $count = $result ? $result->fetch_assoc()['total'] : "Error";
                    echo "<div class='stat-box {$info['class']}'>
                            <h2>{$info['icon']}{$info['label']}</h2>
                            <p>$count</p>
                          </div>";
                }
            ?>
        </section>


        <!-- CHART + ACTIVITIES -->
        <div class="box-page">
            <!-- CHART -->
            <section class="analytics">
                <h2>Case Report Analytics</h2>
                <canvas id="caseChart"></canvas>
                <?php
                    // Define all possible case types (adjust these to match your actual types)
                    $allCaseTypes = ['Behavioral', 'Emotional', 'Peer Conflict', 'Academic'];

                    // Initialize the data array with zeros for all months
                    $caseTypeData = [];
                    foreach ($allCaseTypes as $type) {
                        $caseTypeData[$type] = array_fill(1, 12, 0);
                    }
                    // Add a "Total" line
                    $caseTypeData['Total'] = array_fill(1, 12, 0);

                    // Fill in actual data from the database
                    $result = $conn->query("SELECT case_type, MONTH(filed_date) AS month, COUNT(*) AS total FROM case_records WHERE filed_date IS NOT NULL GROUP BY case_type, MONTH(filed_date)");
                    while ($row = $result->fetch_assoc()) {
                        $type = $row['case_type'];
                        $month = intval($row['month']);
                        if (isset($caseTypeData[$type])) {
                            $caseTypeData[$type][$month] = intval($row['total']);
                            $caseTypeData['Total'][$month] += intval($row['total']); // Add to total
                        }
                    }
                ?>
                <script>
                const caseTypeData = <?php echo json_encode($caseTypeData); ?>;
                </script>
            </section>

            <!-- ACTIVITIES -->
            <section class="activities">
                <div class="activities-box">
                    <h2>Case Distribution</h2>
                    <div class="pie-flex">
                        <div class="pie-chart-container">
                            <canvas id="caseTypePie"></canvas>
                        </div>
                        <div id="caseTypeLegend" class="pie-legend"></div>
                    </div>
                </div>
            </section>

            <!-- APPOINTMENTS -->
            <section class="appointment">
                <div class="appointment-box">
                   <h2>Upcoming Appointments</h2>
                    <ul>
                        <?php
                            if ($activityResult && $activityResult->num_rows > 0) {
                                while ($activityRow = $activityResult->fetch_assoc()) {
                                    echo "<li><strong>{$activityRow['timestamp']}</strong>: {$activityRow['activity']}</li>";
                                }
                            } else {
                                echo "<li>No upcoming counseling sessions.</li>";
                            }
                        ?>
                    </ul>
                </div>
            </section>
        </div>


        <!-- TABLE + TODO -->
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
                        <tr><td><img src="img/people.png"><p>Juan Dela Cruz</p></td><td>05-13-2025</td><td><span class="status completed">Completed</span></td></tr>
                        <tr><td><img src="img/people.png"><p>Maria Santos</p></td><td>05-14-2025</td><td><span class="status pending">Pending</span></td></tr>
                        <tr><td><img src="img/people.png"><p>Carlos Reyes</p></td><td>05-15-2025</td><td><span class="status process">Ongoing</span></td></tr>
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
</section>

<?php include 'Modal/notifModal.php'; ?>

<!-- SCRIPTS -->
<script src="../../js/head.js"></script>
<script src="../../js/linechart.js"></script>
<script src="../../js/piechart.js"></script>
<script src="../../js/Modal/notifModal.js"></script>

<?php
// Get case type counts for the current year
$currentYear = date('Y');
$pieLabels = [];
$pieData = [];
$pieColors = [
    'rgba(54, 162, 235, 0.8)',
    'rgba(255, 99, 132, 0.8)',
    'rgba(255, 206, 86, 0.8)',
    'rgba(75, 192, 192, 0.8)'
];
$result = $conn->query("SELECT case_type, COUNT(*) as total FROM case_records WHERE YEAR(filed_date) = $currentYear GROUP BY case_type");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $pieLabels[] = $row['case_type'];
        $pieData[] = (int)$row['total'];
    }
}
?>
<script>
const pieLabels = <?php echo json_encode($pieLabels); ?>;
const pieData = <?php echo json_encode($pieData); ?>;
const pieColors = <?php echo json_encode($pieColors); ?>;
</script>
</body>
</html>
<pre><?php print_r($caseTypeData); ?></pre>
