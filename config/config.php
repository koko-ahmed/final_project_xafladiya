<?php
// Base path configuration
$base_path = '/Xafladia/';
$base_url = 'http://localhost' . $base_path;

// Database configuration
$db_host = 'localhost';
$db_name = 'xafladia_db';
$db_user = 'root';
$db_pass = '';

// Site configuration
$site_name = 'Xafladiya';
$site_description = 'Your Ultimate Event Partner';

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session configuration
session_start();

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
?> 