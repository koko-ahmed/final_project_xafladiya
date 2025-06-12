<?php
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true){
    header("location: " . dirname($_SERVER['PHP_SELF']) . "/login.php");
    exit;
}

$password = 'Mama.123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
?> 