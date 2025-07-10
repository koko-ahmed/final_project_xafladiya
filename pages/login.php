<?php
require_once '../config/config.php';
$page_title = $site_name . ' - Login';
include '../includes/header.php';
?>

<style>
  body.login-bg {
    background: url('../assets/images/hero/21.jpg') no-repeat center center fixed;
    background-size: cover;
    min-height: 100vh;
  }
  .login-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    backdrop-filter: blur(2px);
  }
</style>

<body class="login-bg">
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg login-card">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Login to Your Account</h2>
                    
                     <?php 
                    // Display error or success messages here if needed
                    // Example: if(isset($_SESSION['message'])) { echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>'; unset($_SESSION['message']); } 
                    ?>

                    <form id="loginForm" action="../includes/process_login.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email </label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                       
                        <div class="d-grid">
                        <button type="submit" style="background-color: purple; color: white; border: none;" class="btn">Login</button>

                        </div>
                        <p class="text-center mt-3">
  Don't have an account? <a href="register.php" style="color: #f1c40f;">Register here</a>
</p>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="../assets/js/script.js"></script>
<script>
  // Password visibility toggle
  document.querySelectorAll('.toggle-password').forEach(function(toggle) {
    toggle.addEventListener('click', function() {
      const input = this.previousElementSibling;
      const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
      input.setAttribute('type', type);
      this.querySelector('i').classList.toggle('fa-eye');
      this.querySelector('i').classList.toggle('fa-eye-slash');
    });
  });

  // Dark mode toggle
  const darkModeToggle = document.getElementById('darkModeToggle');
  darkModeToggle.addEventListener('click', function() {
    document.body.classList.toggle('dark-mode');
    const icon = this.querySelector('i');
    icon.classList.toggle('fa-moon');
    icon.classList.toggle('fa-sun');
  });
</script>

</body>
</html> 