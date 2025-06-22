<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/config.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo isset($page_title) ? $page_title : 'Admin Panel - ' . $site_name; ?></title>
    <link rel="icon" href="<?php echo get_url('assets/images/logo/Xafladiya Logo_10.png'); ?>" type="image/png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo get_url('assets/css/style.css'); ?>" />
</head>
<body>
    <nav class="navbar navbar-light bg-light fixed-top border-bottom shadow-sm">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="<?php echo get_url('admin/dashboard.php'); ?>">
                <img src="<?php echo get_url('assets/images/logo/Xafladiya Logo_1.png'); ?>" alt="<?php echo $site_name; ?>" height="40" />
            </a>
            <div class="d-flex flex-column align-items-end">
                <div class="d-flex align-items-center gap-3">
                    <?php if(isset($_SESSION['username'])): ?>
                        <span class="d-flex align-items-center">
                            <i class="fas fa-user-circle me-1 text-secondary" style="font-size: 1.5rem;"></i>
                            <span class="fw-semibold">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                        </span>
                        <a href="<?php echo get_url('includes/logout.php'); ?>" class="btn btn-sm btn-danger ms-3">Logout</a>
                    <?php else: ?>
                        <span class="fw-semibold">Admin</span>
                    <?php endif; ?>
                </div>
                <span class="text-muted small mt-1">Admin</span>
            </div>
        </div>
    </nav>
    <div style="height: 64px;"></div> <!-- Spacer for fixed navbar --> 