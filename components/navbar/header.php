<?php
// Header Component
// Get the base path for assets based on whether we're in the home page or not
$base_path = isset($is_home) && $is_home ? '' : '../../';

// Set default page title if not set
if (!isset($page_title)) {
    $page_title = 'Xafladiya - Event Planning';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Make your special moments unforgettable."
    />
    <meta
      name="keywords"
      content="events, planning, wedding, party, celebration"
    />
    <title><?php echo $page_title; ?></title>
    <!-- Favicon -->
    <link
      rel="icon"
      href="<?php echo $base_path; ?>assets/images/logo/Xafladiya Logo_10.png"
      type="image/png"
    />
    <!-- Bootstrap 5 CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/style.css" />
  </head>
  <body> 