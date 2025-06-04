<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/db.php';

$message = '';
$message_type = '';

// Fetch photographer bookings from the database
$bookings = [];
$query = "SELECT b.*, p.name as professional_name FROM photographer_bookings b LEFT JOIN photographers p ON b.professional_id = p.id ORDER BY b.booking_date DESC";
$result = mysqli_query($db, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $bookings[] = $row;
    }
    mysqli_free_result($result);
} else {
    $message = 'Error fetching bookings: ' . mysqli_error($db);
    $message_type = 'danger';
}
?>

<div class="container mt-5">
    <h1>Photographer Booking Management</h1>

    <h2>Existing Bookings</h2>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($bookings)): ?>
        <p>No photographer bookings found.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>User Phone</th>
                        <th>Service Type</th>
                        <th>Professional</th>
                        <th>Preferred Date</th>
                        <th>Additional Details</th>
                        <th>Booking Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['id']); ?></td>
                            <td><?php echo htmlspecialchars($booking['user_name']); ?></td>
                            <td><?php echo htmlspecialchars($booking['user_email']); ?></td>
                            <td><?php echo htmlspecialchars($booking['user_phone']); ?></td>
                            <td><?php echo htmlspecialchars($booking['service_type']); ?></td>
                            <td><?php echo htmlspecialchars($booking['professional_name'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($booking['preferred_date']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($booking['additional_details'])); ?></td>
                            <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                            <td><?php echo htmlspecialchars($booking['status']); ?></td>
                            <td>
                                <!-- Add edit/delete/status update links later -->
                                <a href="#" class="btn btn-sm btn-warning disabled">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger disabled">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?> 