<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true){
    header("location: " . dirname($_SERVER['PHP_SELF']) . "/../admin/login.php");
    exit;
}

// Check session timeout
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 3600)) {
    // Session has expired
    session_unset();
    session_destroy();
    header("location: " . dirname($_SERVER['PHP_SELF']) . "/../admin/login.php");
    exit;
}

// Update last activity time
$_SESSION['last_activity'] = time();

$password = 'Mama.123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
?> 