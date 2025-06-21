<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/db.php';

$message = '';
$message_type = '';

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'], $_POST['new_status'])) {
    $booking_id = (int)$_POST['booking_id'];
    $new_status = mysqli_real_escape_string($db, $_POST['new_status']);
    $update_query = "UPDATE photographer_bookings SET status = '$new_status' WHERE id = $booking_id";
    if (mysqli_query($db, $update_query)) {
        $message = 'Booking status updated to ' . htmlspecialchars(ucfirst($new_status)) . '.';
        $message_type = 'success';
    } else {
        $message = 'Error updating status: ' . mysqli_error($db);
        $message_type = 'danger';
    }
}

// Handle admin message update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_message'], $_POST['booking_id'])) {
    $booking_id = (int)$_POST['booking_id'];
    $admin_message = mysqli_real_escape_string($db, $_POST['admin_message']);
    $update_query = "UPDATE photographer_bookings SET message = '$admin_message' WHERE id = $booking_id";
    if (mysqli_query($db, $update_query)) {
        $message = 'Message updated successfully.';
        $message_type = 'success';
    } else {
        $message = 'Error updating message: ' . mysqli_error($db);
        $message_type = 'danger';
    }
}

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

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../../includes/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 mt-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Photographer Booking Management</h1>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
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
                            <th>Admin Message</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($bookings)): ?>
                            <tr><td colspan="12" class="text-center">No photographer bookings found.</td></tr>
                        <?php else: ?>
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
                                    <td>
                                        <?php $status = strtolower($booking['status']); ?>
                                        <?php if ($status === 'pending'): ?>
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        <?php elseif ($status === 'confirmed'): ?>
                                            <span class="badge bg-success">Confirmed</span>
                                        <?php elseif ($status === 'cancelled'): ?>
                                            <span class="badge bg-danger">Cancelled</span>
                                        <?php elseif ($status === 'completed'): ?>
                                            <span class="badge bg-primary">Completed</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?php echo ucfirst($status); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($booking['message'] ?? ''); ?>
                                        <button class="btn btn-link p-0" style="color: #ffc107; font-weight: bold;">EDIT</button>
                                        <!-- Modal for editing message -->
                                        <div class="modal fade" id="messageModal<?php echo $booking['id']; ?>" tabindex="-1">
                                          <div class="modal-dialog">
                                            <form method="POST">
                                              <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title">Edit Message</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                  <textarea name="admin_message" class="form-control"><?php echo htmlspecialchars($booking['message'] ?? ''); ?></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="submit" name="save_message" class="btn btn-primary">Save</button>
                                                </div>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <?php if ($status === 'pending'): ?>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                                    <input type="hidden" name="new_status" value="confirmed">
                                                    <button type="submit" class="btn btn-sm btn-success mb-1">Confirm</button>
                                                </form>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                                    <input type="hidden" name="new_status" value="cancelled">
                                                    <button type="submit" class="btn btn-sm btn-danger mb-1">Cancel</button>
                                                </form>
                                            <?php elseif ($status === 'confirmed'): ?>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                                    <input type="hidden" name="new_status" value="completed">
                                                    <button type="submit" class="btn btn-sm btn-primary mb-1">Complete</button>
                                                </form>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                                    <input type="hidden" name="new_status" value="cancelled">
                                                    <button type="submit" class="btn btn-sm btn-danger mb-1">Cancel</button>
                                                </form>
                                            <?php elseif ($status === 'completed'): ?>
                                                <span class="text-success">Done</span>
                                            <?php elseif ($status === 'cancelled'): ?>
                                                <span class="text-danger">Cancelled</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?> 