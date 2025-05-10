<?php
$page_title = 'Xafladiya - Login';
include '../includes/header.php';
?>

<div class="login-container position-relative">
  <div class="login-options">
    <!-- Removed dark mode toggle button here -->
  </div>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card shadow login-card">
          <div class="card-body">
            <div class="text-center mb-4">
              <a href="../index.php" class="text-decoration-none">
                <h2 class="fw-bold text-primary mb-2">Xafladiya</h2>
              </a>
              <p class="text-muted">Your Ultimate Event Partner</p>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs nav-fill mb-4" id="loginTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-tab-pane" type="button" role="tab" aria-controls="login-tab-pane" aria-selected="true">
                  <span class="login-tab-text">Login</span>
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-tab-pane" type="button" role="tab" aria-controls="register-tab-pane" aria-selected="false">
                  <span class="register-tab-text">Register</span>
                </button>
              </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="loginTabsContent">
              <!-- Login Tab -->
              <div class="tab-pane fade show active" id="login-tab-pane" role="tabpanel" aria-labelledby="login-tab" tabindex="0">
                <form id="loginForm" action="../includes/login_process.php" method="POST">
                  <div class="form-floating">
                    <input type="email" class="form-control" id="loginEmail" name="email" placeholder="name@example.com" required />
                    <label for="loginEmail">Email address</label>
                  </div>
                  <div class="form-floating">
                    <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Password" required />
                    <label for="loginPassword">Password</label>
                    <span class="toggle-password" data-bs-toggle="tooltip" data-bs-title="Show/Hide Password">
                      <i class="fas fa-eye"></i>
                    </span>
                  </div>
                  <div class="d-flex justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" />
                      <label class="form-check-label" for="rememberMe">
                        <span class="remember-me-text">Remember me</span>
                      </label>
                    </div>
                    <a href="forgot-password.php" class="text-decoration-none">
                      <span class="forgot-password-text">Forgot password?</span>
                    </a>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 mb-3">
                    <span class="sign-in-btn-text">Sign In</span>
                  </button>
                  <div class="text-center mb-3">
                    <span class="or-text">Or continue with</span>
                  </div>
                  <div class="social-login-buttons">
                    <a href="#" class="social-login-btn google">
                      <i class="fab fa-google"></i>
                    </a>
                    <a href="#" class="social-login-btn facebook">
                      <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-login-btn twitter">
                      <i class="fab fa-twitter"></i>
                    </a>
                  </div>
                </form>
              </div>

              <!-- Register Tab -->
              <div class="tab-pane fade" id="register-tab-pane" role="tabpanel" aria-labelledby="register-tab" tabindex="0">
                <form id="registerForm" action="../includes/register_process.php" method="POST">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="registerName" name="name" placeholder="Full Name" required />
                    <label for="registerName">Full Name</label>
                  </div>
                  <div class="form-floating">
                    <input type="email" class="form-control" id="registerEmail" name="email" placeholder="name@example.com" required />
                    <label for="registerEmail">Email address</label>
                  </div>
                  <div class="form-floating">
                    <input type="password" class="form-control" id="registerPassword" name="password" placeholder="Password" required />
                    <label for="registerPassword">Password</label>
                    <span class="toggle-password" data-bs-toggle="tooltip" data-bs-title="Show/Hide Password">
                      <i class="fas fa-eye"></i>
                    </span>
                  </div>
                  <div class="form-floating">
                    <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Confirm Password" required />
                    <label for="confirmPassword">Confirm Password</label>
                  </div>
                  <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="termsCheck" required />
                    <label class="form-check-label" for="termsCheck">
                      <span class="terms-text">I agree to the <a href="terms.php" class="text-decoration-none">Terms of Service</a> and <a href="privacy.php" class="text-decoration-none">Privacy Policy</a></span>
                    </label>
                  </div>
                  <button type="submit" class="btn btn-primary w-100">
                    <span class="create-account-btn-text">Create Account</span>
                  </button>
                </form>
              </div>
            </div>
          </div>
          <div class="card-footer text-center py-3">
            <a href="../index.php" class="text-decoration-none">
              <span class="back-home-text"><i class="fas fa-arrow-left me-2"></i>Back to Home</span>
            </a>
          </div>
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