<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGRMS</title>
    <link rel="stylesheet" href="resources/css/landing.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="logo">
            <img src="public/images/logo/logo.svg" class="brand-logo" alt="SGRMS Logo">
        </div>
        <div class="menu-btn">
            <span class="solar--hamburger-menu-linear"></span>
        </div>
        <div class="navigation">
            <div class="navigation-links">
                <button type="button" class="btn-login" onclick="openLoginModal()"><a href="#">Log in</a></button>
                <a class="btn-primary" href="#">
                    <span class="text">Sign Up</span>
                </a>
            </div>
        </div>
    </header>

    <section class="home">
        <div class="video-overlay">
            <video class="video-slide active" src="public/video/landing.mp4" muted></video>
            <video class="video-slide" src="public/video/parent.mp4" muted></video>
            <video class="video-slide" src="public/video/appointment.mp4" muted></video>
            <video class="video-slide" src="public/video/counseling.mp4" muted></video>
            <video class="video-slide" src="public/video/program.mp4" muted></video>
        </div>
        <div class="content active">
            <h1>Student<br><span>Well-being</span></h1>
            <p>We care about your growth. Our Guidance Office offers a safe and welcoming space for students to talk, reflect, and seek help when needed.</p>
            <a href="#">Learn More</a>
        </div>

        <div class="content">
            <h1>Parental<br><span>Involvement</span></h1>
            <p>Parents can stay informed and connected. Our system allows guardians to monitor their child's guidance records and progress securely.</p>
            <a href="#">Parent Portal</a>
        </div>

        <div class="content">
            <h1>Request<br><span>Appointment</span></h1>
            <p>Need to talk? Both students and parents can easily schedule a counseling session through our online appointment system.</p>
            <a href="#">Book Now</a>
        </div>

        <div class="content">
            <h1>Counseling<br><span>Support</span></h1>
            <p>Our licensed counselors are here to guide students through emotional challenges, academic stress, peer conflicts, and future planning.</p>
            <a href="#">Meet the Counselors</a>
        </div>

        <div class="content">
            <h1>Guidance<br><span>Programs</span></h1>
            <p>We offer seminars, group sessions, and workshops to promote self-awareness, communication skills, and a healthy student environment.</p>
            <a href="#">View Programs</a>
        </div>

        <div class="slider-navigation">
            <div class="nav-btn active"></div>
            <div class="nav-btn"></div>
            <div class="nav-btn"></div>
            <div class="nav-btn"></div>
            <div class="nav-btn"></div>
        </div>

    </section>

    <?php include 'resources/view/auth/login.php'; ?>
    <script src="resources/js/landing.js"></script>
    <script>
    function openLoginModal() {
        document.querySelector('.login-modal').classList.add('show');
    }
    function closeLoginModal() {
        document.querySelector('.login-modal').classList.remove('show');
    }
    // Optional: Close modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.querySelector('.login-modal');
        if (event.target === modal) {
            closeLoginModal();
        }
    }

    function togglePassword() {
        const passwordInput = document.getElementById("login-password");
        const icon = document.getElementById("togglePasswordIcon");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
</body>
</html>