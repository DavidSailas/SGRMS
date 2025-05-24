<div class="login-modal">
    <div class="modal">
        <div class="modal-left">
            <img class="modal-image" alt="Image" src="public/images/img/login2.png"/>
        </div>
        <div class="modal-right">
            <!-- Close Button -->
            <button type="button" class="close-modal-btn" onclick="closeLoginModal()" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
            <div class="logo">
               <img src="public/images/logo/logo.svg" class="brand-logo" alt="SGRMS Logo"> 
            </div>  
            <h2>Log in to your Account</h2>
            <p>Welcome! Please enter your credentials to log in.</p>
            <form action="app/Controllers/Auth/LoginController.php" method="POST">
                <div class="input-box" style="position:relative;">
                    <input type="text" name="username" class="input-box" placeholder="Username or Student ID"
                        value="<?php echo isset($_SESSION['old_username']) ? htmlspecialchars($_SESSION['old_username']) : ''; ?>">
                    <span class="input-icon">
                        <i class="fas fa-user"></i>
                    </span>
                    <?php 
                         if (isset($_SESSION['error_username'])) { 
                            echo "<span class='error'>".$_SESSION['error_username']."</span>"; 
                            unset($_SESSION['error_username']);
                        } 
                    ?>
                </div>
                <div class="input-box password-box" style="position:relative;">            
                    <input type="password" name="password" class="input-box" id="login-password" placeholder="Password">
                    <span class="toggle-password" onclick="togglePassword()" tabindex="0">
                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                    </span>
                    <?php 
                    if (isset($_SESSION['error_password'])) { 
                        echo "<span class='error'>".$_SESSION['error_password']."</span>"; 
                        unset($_SESSION['error_password']);
                    } 
                    ?>
                </div>
                <div class="forgot-link">
                    <a href="">Forgot password?</a>
                </div>
                <button type="submit" class="log-btn">Login</button>
                <div class="signup-link">
                    <p>Don't have an account?<a href="resources/view/auth/register.php">Sign up</a></p>
                </div> 
            </form>  
        </div>
    </div>
</div>