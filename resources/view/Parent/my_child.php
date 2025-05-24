<?php
session_start();

include '../../../database/db_connect.php';

if (!isset($_SESSION['parent_id'])) {
    header("Location: ../../../index.php");
    exit();
}

$parent_id = $_SESSION['parent_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Student Guidance Record Management System</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/bar.css">
    <link rel="stylesheet" href="../../css/counsel.css">
    <link rel="stylesheet" href="../../css/addchild.css">
    <link rel="stylesheet" href="../../css/studentdata.css">
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

        <li class="active">
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
        <a href="#" class="nav-link">
            <?php
                if (isset($_SESSION['parent_name'])) {
                    echo "Welcome, " . htmlspecialchars($_SESSION['parent_name']);
                } else {
                    echo "Welcome, Parent";
                }
            ?>
        </a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode" aria-label="Switch Dark/Light Mode"></label>
            <a href="#" id="notificationBell" class="notification"><i class='bx bxs-bell'></i><span class="num"></span></a>
            <a href="#" class="profile"><img src="img/people.png" alt="Profile"></a>
        </nav>
        <div id="notificationDropdown" style="display:none; position:absolute; right:40px; top:70px; background:white; border:1px solid #ccc; width:250px; z-index:1000;">
            <ul style="list-style:none; margin:0; padding:0;"></ul>
            <div id="seeMoreWrapper" style="text-align:center; display:none;">
                <a href="#" id="seeMoreLink">See more</a>
            </div>
        </div>

        <div class="wrapper">


        <!-- HEAD -->
        <div class="head-title">
            <div class="left"><h1>My Child</h1></div>
        </div>
    </div>

   
    <main class="wrapper">
        <div class="profiles-container">
            <!-- Add new profile box -->
            <div class="profile-box add-box" onclick="openFormModal()">
                <i class='bx bx-plus add-profile-icon'></i>
                <h2>Link Child</h2>
            </div>

            <?php
              $sql = "SELECT * FROM students WHERE parent_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $parent_id);
                $stmt->execute();
                $result = $stmt->get_result();


              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $fullName = $row['lname'] . ', ' . $row['fname'] . ' ' . $row['mname'];
                    $img = !empty($row['s_image']) ? htmlspecialchars($row['s_image']) : '../../Public/user.img/people.png';
                    echo '<div class="profile-box view-child" data-student-id="' . $row['s_id'] . '">'; 
                    echo '<img src="' . $img . '" alt="Student Picture" />';
                    echo '<h2>' . htmlspecialchars($fullName) . '</h2>';
                    echo '<p>' . htmlspecialchars($row['educ_level']) . ' - Year ' . htmlspecialchars($row['year_level']) . '</p>';
                    echo '</div>';

                }
            } else {
                echo '<p>No students found for this parent.</p>';
            }
            $stmt->close();
            $conn->close();

            ?>
        </div>
    </main>
</section>

<?php include 'Modal/childModal.php'; ?>

<!-- SCRIPTS -->
<script src="../../js/head.js"></script>
<script src="../../js/linechart.js"></script>
<script src="../../js/Modal/childModal.js"></script>
<script src="../../js/Modal/parentModal.js"></script>

</body>
</html>
