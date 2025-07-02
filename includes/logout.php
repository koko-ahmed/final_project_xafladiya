<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to admin login if coming from admin, else to home page
$referer = $_SERVER['HTTP_REFERER'] ?? '';
if (strpos($referer, '/admin/') !== false) {
    header('Location: ../admin/login.php');
} else {
    header('Location: ../index.php');
}
exit();
?> 