<?php
// Base path configuration
$base_path = '/Xafladia/';
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $base_path;

// Database configuration
$db_host = 'localhost';
$db_name = 'xafladia_db';
$db_user = 'root';
$db_pass = '';

// Attempt to connect to MySQL database
$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if($connection === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Optional: Set character set
mysqli_set_charset($connection, "utf8mb4");

// Site configuration
$site_name = 'Xafladiya';
$site_description = 'Your Ultimate Event Partner';

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session configuration

// Function to get the correct path
function get_path($path) {
    global $base_path;
    return $base_path . ltrim($path, '/');
}

// Function to get the correct URL
function get_url($path) {
    global $base_url;
    return $base_url . ltrim($path, '/');
}