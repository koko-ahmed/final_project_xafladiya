<?php
require_once '../config/config.php';
$page_title = $site_name . ' - Register';
include '../includes/header.php';
?>
<!-- Make the entire background purple -->
<div style="background-color: #6a0dad; min-height: 100vh; padding: 50px 0;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- White card on top of purple background -->
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4" style="color: #6a0dad;">Create Your Account</h2>
                        
                        <?php 
                        // Display error or success messages here if needed
                        ?>

                        <form id="registerForm" action="../includes/process_register.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username (Optional)</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address*</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password*</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
                            </div>
                            <div class="mb-4">
                                <label for="confirm_password" class="form-label">Confirm Password*</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-lg" style="background-color: #f1c40f; color: black;">Register</button>
                            </div>
                            <p class="text-center mt-3">Already have an account? <a href="login.php" style="color: #f1c40f;">Login here</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
