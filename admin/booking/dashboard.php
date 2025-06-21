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

<style>
.btn-fab {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 1.3em;
  box-shadow: 0 4px 16px rgba(0,0,0,0.13);
  border: none;
  margin-right: 0.5em;
  margin-bottom: 0.2em;
  transition: background 0.2s, color 0.2s, box-shadow 0.2s;
  position: relative;
}
.btn-fab-confirm {
  background: #43cea2;
  color: #fff;
}
.btn-fab-confirm:hover {
  background: #388e3c;
  color: #fff;
  box-shadow: 0 6px 24px rgba(67,206,162,0.18);
}
.btn-fab-cancel {
  background: #ffb300;
  color: #fff;
}
.btn-fab-cancel:hover {
  background: #ff8f00;
  color: #fff;
  box-shadow: 0 6px 24px rgba(255,179,0,0.18);
}
.btn-fab-complete {
  background: #42a5f5;
  color: #fff;
}
.btn-fab-complete:hover {
  background: #1565c0;
  color: #fff;
  box-shadow: 0 6px 24px rgba(66,165,245,0.18);
}
</style>

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
                                        <div class="d-flex flex-row align-items-center gap-2">
                                            <?php if ($status === 'pending'): ?>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                                    <input type="hidden" name="new_status" value="confirmed">
                                                    <button type="submit" class="btn btn-fab btn-fab-confirm" title="Confirm" data-bs-toggle="tooltip" data-bs-placement="top">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                                    <input type="hidden" name="new_status" value="cancelled">
                                                    <button type="submit" class="btn btn-fab btn-fab-cancel" title="Cancel" data-bs-toggle="tooltip" data-bs-placement="top">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                            <?php elseif ($status === 'confirmed'): ?>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                                    <input type="hidden" name="new_status" value="completed">
                                                    <button type="submit" class="btn btn-fab btn-fab-complete" title="Complete" data-bs-toggle="tooltip" data-bs-placement="top">
                                                        <i class="fas fa-flag-checkered"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                                    <input type="hidden" name="new_status" value="cancelled">
                                                    <button type="submit" class="btn btn-fab btn-fab-cancel" title="Cancel" data-bs-toggle="tooltip" data-bs-placement="top">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                            <?php elseif ($status === 'completed'): ?>
                                                <span class="text-success">Done</span>
                                            <?php elseif ($status === 'cancelled'): ?>
                                                <span class="text-warning">Cancelled</span>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.forEach(function(el) {
    new bootstrap.Tooltip(el);
  });
});
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?> 