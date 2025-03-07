<?php
include $_SERVER['DOCUMENT_ROOT'].'/SGRMS/Database/db_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>School Guidance Reports Management System - Manage Students</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #2563eb;
            color: white;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 16px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 10px;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: #374151;
            display: flex;
            align-items: center;
        }
        .sidebar ul li a:hover {
            background-color: #e5e7eb;
            border-radius: 5px;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .btn {
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-add {
            background: #2563eb;
        }
        .btn-edit {
            background: #f59e0b;
        }
        .btn-delete {
            background: #dc2626;
        }
        .btn-view {
            background: #10b981;
        }
        .status-circle {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        .green {
            background-color: green;
        }
        .search-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .search-bar input, .search-bar select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 5px;
        }
        .search-bar button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            background: #4a90e2;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">School Guidance Reports</div>
        <div>
            <a href="#">Dashboard</a>
            <a href="#">Reports</a>
            <a href="#">Settings</a>
            <a href="#">Logout</a>
        </div>
    </nav>
    <div class="container">
        <aside class="sidebar">
            <ul>
                <li><a href="superadmin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="counsel.php"><i class="fas fa-users"></i> Counselors</a></li>
                <li><a href="teacher.php"><i class="fas fa-user-tie"></i> Teachers</a></li>
                <li><a href="students.php"><i class="fas fa-user-graduate"></i> Students</a></li>
                <li><a href="case.php"><i class="fas fa-file-alt"></i> Reports</a></li>
                <li><a href="#"><i class="fas fa-cogs"></i> Settings</a></li>
            </ul>
        </aside>
        <main class="main-content">
            <div class="card">
                <section class="student-list">
                    <div class="search-flex">
                        <h2>Student List</h2>
                        <a href="addstud.php" class="btn btn-add">Add Student</a>
                        <div class="search-bar">
                            <!-- Search & Filter Inputs -->
                            <input type="text" id="search" name="search" class="search" placeholder="Search by ID or Name"
                                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <select name="filter_educ" id="filter_educ">
                                <option value="">All Levels</option>
                                <option value="Elementary" <?php if(isset($_GET['filter_educ']) && $_GET['filter_educ'] == 'Elementary') echo 'selected'; ?>>Elementary</option>
                                <option value="High School" <?php if(isset($_GET['filter_educ']) && $_GET['filter_educ'] == 'High School') echo 'selected'; ?>>High School</option>
                                <option value="College" <?php if(isset($_GET['filter_educ']) && $_GET['filter_educ'] == 'College') echo 'selected'; ?>>College</option>
                            </select>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Educational Level</th>
                                <th>Section</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="studentTableBody">
                            <?php
                                // Initially, display all students.
                                $sql = "SELECT s_id, lname, fname, mname, bod, educ_level, section FROM students";
                                $result = $conn->query($sql);
                                
                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $bod = $row['bod'];
                                        $birthdate = new DateTime($bod);
                                        $today = new DateTime();
                                        $age = $today->diff($birthdate)->y;
                                        
                                        echo "<tr>
                                            <td><span class='status-circle green'></span></td>
                                            <td>".$row['lname'].", ".$row['fname']." ".$row['mname']."</td>
                                            <td>".$age."</td>
                                            <td>".$row['educ_level']."</td>
                                            <td>".$row['section']."</td>
                                            <td>
                                                <a href='viewstud.php?s_id=".$row['s_id']."' class='btn btn-view'>View</a>
                                                <a href='editstud.php?s_id=".$row['s_id']."' class='btn btn-edit'>Edit</a>
                                                <a href='deletestud.php?s_id=".$row['s_id']."' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No students found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </section>
            </div>
        </main>
    </div>
    
    <!-- JavaScript to perform live search using AJAX -->
    <script>
    function updateTable() {
        var search = document.getElementById('search').value;
        var filter = document.getElementById('filter_educ').value;
        var url = "searchstud.php?search=" + encodeURIComponent(search) + "&filter_educ=" + encodeURIComponent(filter);
        fetch(url)
            .then(response => response.text())
            .then(data => {
                document.getElementById('studentTableBody').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    }
    
    // Update table as the user types or changes the filter
    document.getElementById('search').addEventListener('keyup', updateTable);
    document.getElementById('filter_educ').addEventListener('change', updateTable);
    </script>
</body>
</html>
