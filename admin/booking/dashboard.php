<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/db.php';

// Fetch photographer bookings from the database
$bookings = [];
$query = "SELECT b.*, p.name as professional_name 
          FROM photographer_bookings b 
          LEFT JOIN photographers p ON b.professional_id = p.id 
          ORDER BY b.booking_date DESC";
$result = mysqli_query($db, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $bookings[] = $row;
    }
    mysqli_free_result($result);
} else {
    $_SESSION['message'] = 'Error fetching bookings: ' . mysqli_error($db);
    $_SESSION['message_type'] = 'danger';
}
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 mt-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Photographer Booking Management</h1>
            </div>

            <?php if(isset($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                    <?php 
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (empty($bookings)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>No photographer bookings found.
                </div>
            <?php else: ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
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
                                            <td>
                                                <span class="badge bg-primary">
                                                    <?php echo htmlspecialchars($booking['service_type']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($booking['professional_name'] ?? 'N/A'); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($booking['preferred_date'])); ?></td>
                                            <td>
                                                <?php if (!empty($booking['additional_details'])): ?>
                                                    <button type="button" class="btn btn-sm btn-link" data-bs-toggle="modal" data-bs-target="#detailsModal<?php echo $booking['id']; ?>">
                                                        View Details
                                                    </button>
                                                <?php else: ?>
                                                    <span class="text-muted">No details</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($booking['booking_date'])); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo $booking['status'] === 'pending' ? 'warning' : ($booking['status'] === 'confirmed' ? 'success' : 'danger'); ?>">
                                                    <?php echo ucfirst(htmlspecialchars($booking['status'])); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $booking['id']; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $booking['id']; ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Details Modal -->
                                        <div class="modal fade" id="detailsModal<?php echo $booking['id']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Booking Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php echo nl2br(htmlspecialchars($booking['additional_details'])); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal<?php echo $booking['id']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Booking Status</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="update_booking.php" method="POST">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select class="form-select" name="status" id="status">
                                                                    <option value="pending" <?php echo $booking['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                                    <option value="confirmed" <?php echo $booking['status'] === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                                                    <option value="cancelled" <?php echo $booking['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal<?php echo $booking['id']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this booking?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="delete_booking.php" method="POST" class="d-inline">
                                                            <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?> 