<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="/SGRMS/CSS/log.css">
    <style>
        .error {
            color: red;
            margin-left: 10px;
            font-size: 0.9em;
        }
        .input-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="../Database/authenticatelog.php" method="POST">
            <div class="input-group">
                <input type="text" name="username" class="input-box" placeholder="Username"
                       value="<?php echo isset($_SESSION['old_username']) ? htmlspecialchars($_SESSION['old_username']) : ''; ?>">
                <?php 
                if (isset($_SESSION['error_username'])) { 
                    echo "<span class='error'>".$_SESSION['error_username']."</span>"; 
                    unset($_SESSION['error_username']);
                } 
                ?>
            </div>
            <div class="input-group">
                <input type="password" name="password" class="input-box" placeholder="Password">
                <?php 
                if (isset($_SESSION['error_password'])) { 
                    echo "<span class='error'>".$_SESSION['error_password']."</span>"; 
                    unset($_SESSION['error_password']);
                } 
                ?>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>