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
    <link rel="stylesheet" href="../../css/table.css">
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
        <li class="active">
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
                    if (isset($_SESSION['parent_id'])) {
                    $parent_id = $_SESSION['parent_id'];

                    $sql = "SELECT 
                                cr.case_id,
                                s.educ_level AS academic_level,
                                cr.case_type,
                                cr.status
                            FROM case_records cr
                            JOIN students s ON cr.student_id = s.s_id
                            WHERE s.parent_id = ?
                            ORDER BY cr.referral_date DESC";

                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("i", $parent_id);
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
                            echo "<tr><td colspan='5'>No records found</td></tr>";
                        }

                        $stmt->close();
                    } else {
                        echo "<tr><td colspan='5'>Failed to prepare query.</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Parent not logged in.</td></tr>";
                }
                ?>
                    <tr id="noRecordsRow" style="display: none;">
                        <td colspan="5" style="text-align: center;">No records found</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php include 'Modal/notifModal.php'; ?>
<?php include 'Modal/caseModal.php'; ?>

<!-- SCRIPTS -->
<script src="../../js/head.js"></script>
<script src="../../js/Modal/notifModal.js"></script>
<script>
function openViewCaseModal(caseId) {
    var modal = document.getElementById('viewCaseModal');
    var content = document.getElementById('viewCaseContent');
    content.innerHTML = "<div style='padding:2em;text-align:center;'>Loading...</div>";
    modal.style.display = "block";
    fetch('../../../app/Controllers/Parent/CaseController/viewcase.php?case_id=' + caseId)
        .then(response => response.text())
        .then(data => {
            content.innerHTML = `
                <button class="close-modal-btn" onclick="closeViewCaseModal()">&times;</button>
                <h2 style="margin-top:0;color:#4f8cff;">Case Details</h2>
                <div style="margin-bottom:1em;">${data}</div>
            `;
        });
}
function closeViewCaseModal() {
    document.getElementById('viewCaseModal').style.display = "none";
}
// Close modal when clicking outside content
window.onclick = function(event) {
    var modal = document.getElementById('viewCaseModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>