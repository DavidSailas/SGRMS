<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments & Schedules</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
       body {
      font-family: 'Roboto', sans-serif;
      background-color: #eef2ff;
      margin: 0;
      padding: 0;
      display: flex;
  
      font-family: 'Roboto', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            
       }
  .sidebar {
      width: 250px;
      background: #4c6ef5;
      color: white;
      height: 100vh;
      padding: 20px;
      position: fixed;
      display: flex;
      flex-direction: column;
  }
  
  .sidebar ul {
      list-style: none;
      padding: 0;
      margin-top: 20px;
  }
  
  .sidebar ul li {
      padding: 15px 0;
  }
  
  .sidebar ul li a {
      color: white;
      text-decoration: none;
      display: flex;
      align-items: center;
      font-weight: 500;
      transition: 0.3s;
  }
  
  .sidebar ul li a i {
      margin-right: 10px;
  }
  
  .sidebar ul li a:hover {
      background: rgba(255, 255, 255, 0.2);
      padding: 10px;
      border-radius: 8px;
  }
  
  /* Main Content */
  .main-content {
      margin-left: 270px;
      padding: 40px;
      width: calc(100% - 270px);
  }
  
  .container {
      background: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }
  
  /* Form Styles */
  .appointment-form {
      display: flex;
      flex-direction: column;
  }
  
  .appointment-form label {
      margin-top: 10px;
      font-weight: 500;
  }
  
  .appointment-form input, 
  .appointment-form textarea {
      padding: 12px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
  }
  
  /* Button Styles */
  .btn {
      background-color: #4c6ef5;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 15px;
      font-size: 16px;
      font-weight: 500;
      transition: 0.3s;
  }
  
  .btn:hover {
      background-color: #3b5bdb;
  }
  
  /* Responsive Design */
  @media (max-width: 768px) {
      .sidebar {
          width: 200px;
      }
      .main-content {
          margin-left: 220px;
          width: calc(100% - 220px);
      }
  }
    </style>
</head>
<body>
    <aside class="sidebar">
        <ul>
            <li><a href="superadmin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="appointments.php"><i class="fas fa-calendar-alt"></i> Appointments</a></li>
            <li><a href="counsel.php"><i class="fas fa-users"></i> Counselors</a></li>
            <li><a href="students.php"><i class="fas fa-user-graduate"></i> Students</a></li>
            <li><a href="case.php"><i class="fas fa-file-alt"></i> Reports</a></li>
            <li><a href="#"><i class="fas fa-cogs"></i> Settings</a></li>
        </ul>
    </aside>
    <main class="main-content">
        <div class="container">
            <h2>Book an Appointment</h2>
            <form action="appointment.php" method="POST" class="appointment-form">
                <label for="s_id">Student ID:</label>
                <input type="number" name="s_id" >
                <label for="t_id">Teacher ID:</label>
                <input type="number" name="t_id" >
                <label for="p_id">Parent ID:</label>
                <input type="number" name="p_id">
                <label for="date">Date:</label>
                <input type="date" name="date" >
                <label for="time">Time:</label>
                <input type="time" name="time" >
                <label for="reason">Reason:</label>
                <textarea name="reason" ></textarea>
                <button type="submit" name="submit" class="btn">Book Appointment</button>
            </form>
        </div>
    </main>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    $student_id = $_POST['s_id'];
    $teacher_id = $_POST['t_id'];
    $parent_id = $_POST['p_id'] ?? NULL;
    $date = $_POST['date'];
    $time = $_POST['time'];
    $reason = $_POST['reason'];

    $stmt = $conn->prepare("INSERT INTO appointments (s_id, t_id, p_id, date, time, reason) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisss", $student_id, $teacher_id, $parent_id, $date, $time, $reason);

    if ($stmt->execute()) {
        echo "<p style='color:green; text-align:center;'>Appointment booked successfully!</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>Error booking appointment: " . $conn->error . "</p>";
    }
    $stmt->close();
}

?>
