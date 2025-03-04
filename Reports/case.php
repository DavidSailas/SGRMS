<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Guidance Records Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        header, footer {
            background-color: #1e3a8a;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
        }
        nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        nav a {
            color: white;
            text-decoration: none;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            margin: 20px auto;
        }
        .button {
            background-color: #1e3a8a;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #1c3d72;
        }
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border-bottom: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .actions button {
            margin-right: 5px;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }
        .view-button {
            background-color: #1e3a8a;
            color: white;
        }
        .view-button:hover {
            background-color: #1c3d72;
        }
        .delete-button {
            background-color: #8b0000;
            color: white;
        }
        .delete-button:hover {
            background-color: #700000;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>School Guidance Records Management</h1>
            <nav>
                <ul>
                <li><a href="superadmin w.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="counsel.php"><i class="fas fa-users"></i> Counselors</a></li>
                <li><a href="teacher.php"><i class="fas fa-user-tie"></i> Teachers</a></li>
                <li><a href="students.php"><i class="fas fa-user-graduate"></i> Students</a></li>
                <li><a href="case.php"><i class="fas fa-file-alt"></i> Reports</a></li>
                <li><a href="#"><i class="fas fa-cogs"></i> Settings</a></li>
                </ul>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="table-container">
            <h2>Case Management</h2>
            <button class="button">Add New Case</button>
            <table>
                <thead>
                    <tr>
                        <th>Case ID</th>
                        <th>Student Name</th>
                        <th>Issue</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>Bullying</td>
                        <td>Open</td>
                        <td class="actions">
                            <button class="view-button"><i class="fas fa-eye"></i> View</button>
                            <button class="delete-button"><i class="fas fa-trash-alt"></i> Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane Smith</td>
                        <td>Academic Performance</td>
                        <td>Closed</td>
                        <td class="actions">
                            <button class="view-button"><i class="fas fa-eye"></i> View</button>
                            <button class="delete-button"><i class="fas fa-trash-alt"></i> Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2023 School Guidance Records Management. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>