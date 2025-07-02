<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Handle delete action
if (isset($_POST['delete_booking'], $_POST['delete_id'], $_POST['delete_type'])) {
    $delete_id = (int)$_POST['delete_id'];
    $delete_type = $_POST['delete_type'];
    if ($delete_type === 'Photographer') {
        $del_query = "DELETE FROM photographer_bookings WHERE id = $delete_id";
    } else {
        $del_query = "DELETE FROM bookings WHERE id = $delete_id";
    }
    if (mysqli_query($db, $del_query)) {
        $message = 'Booking deleted successfully!';
        $message_type = 'success';
    } else {
        $message = 'Error deleting booking: ' . mysqli_error($db);
        $message_type = 'danger';
    }
}

// Handle venue booking status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['venue_booking_id'], $_POST['venue_new_status'])) {
    $venue_booking_id = (int)$_POST['venue_booking_id'];
    $venue_new_status = mysqli_real_escape_string($db, $_POST['venue_new_status']);
    $update_query = "UPDATE venue_bookings SET status = '$venue_new_status' WHERE id = $venue_booking_id";
    if (mysqli_query($db, $update_query)) {
        $message = 'Venue booking status updated to ' . htmlspecialchars(ucfirst($venue_new_status)) . '.';
        $message_type = 'success';
    } else {
        $message = 'Error updating venue booking status: ' . mysqli_error($db);
        $message_type = 'danger';
    }
}

// Handle venue booking delete action
if (isset($_POST['delete_venue_booking'], $_POST['venue_booking_id'])) {
    $venue_booking_id = (int)$_POST['venue_booking_id'];
    $del_query = "DELETE FROM venue_bookings WHERE id = $venue_booking_id";
    if (mysqli_query($db, $del_query)) {
        $message = 'Venue booking deleted successfully!';
        $message_type = 'success';
    } else {
        $message = 'Error deleting venue booking: ' . mysqli_error($db);
        $message_type = 'danger';
    }
}

// Fetch photographer bookings from the database
$bookings = [];
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$type_filter = isset($_GET['type']) ? $_GET['type'] : 'all';

// Photographer bookings
$query1 = "SELECT 'Photographer' AS booking_type, b.id, b.user_name AS name, b.user_email AS email, b.user_phone AS phone, b.service_type, p.name AS professional, b.preferred_date, b.additional_details, b.status, b.booking_date AS booked_at FROM photographer_bookings b LEFT JOIN photographers p ON b.professional_id = p.id";
if ($search !== '') {
    $search_escaped = mysqli_real_escape_string($db, $search);
    $query1 .= " WHERE b.user_name LIKE '%$search_escaped%' ";
    $query1 .= "OR b.user_email LIKE '%$search_escaped%' ";
    $query1 .= "OR b.user_phone LIKE '%$search_escaped%' ";
    $query1 .= "OR b.service_type LIKE '%$search_escaped%' ";
    $query1 .= "OR p.name LIKE '%$search_escaped%' ";
}
$query1 .= " ORDER BY b.booking_date DESC";
$res1 = mysqli_query($db, $query1);
if ($res1) {
    while ($row = mysqli_fetch_assoc($res1)) {
        $bookings[] = $row;
    }
    mysqli_free_result($res1);
}

// General bookings
$query2 = "SELECT 'Venues' AS booking_type, id, name, email, phone, service_type, preferred_professional AS professional, preferred_date, additional_details, 'N/A' AS status, created_at AS booked_at FROM bookings";
if ($search !== '') {
    $search_escaped = mysqli_real_escape_string($db, $search);
    $query2 .= " WHERE name LIKE '%$search_escaped%' ";
    $query2 .= "OR email LIKE '%$search_escaped%' ";
    $query2 .= "OR phone LIKE '%$search_escaped%' ";
    $query2 .= "OR service_type LIKE '%$search_escaped%' ";
    $query2 .= "OR preferred_professional LIKE '%$search_escaped%' ";
}
$query2 .= " ORDER BY created_at DESC";
$res2 = mysqli_query($db, $query2);
if ($res2) {
    while ($row = mysqli_fetch_assoc($res2)) {
        $bookings[] = $row;
    }
    mysqli_free_result($res2);
}

// Always fetch venue bookings and merge for ALL view
$venue_bookings = [];
$venue_query = "SELECT * FROM venue_bookings ORDER BY created_at DESC";
$venue_res = mysqli_query($db, $venue_query);
if ($venue_res) {
    while ($row = mysqli_fetch_assoc($venue_res)) {
        // Normalize venue booking data to match table columns
        $bookings[] = [
            'booking_type' => 'Venue',
            'id' => $row['id'],
            'name' => $row['user_name'],
            'email' => $row['user_email'],
            'phone' => $row['user_phone'],
            'service_type' => 'Venue',
            'professional' => $row['venue_name'],
            'preferred_date' => $row['event_date'],
            'additional_details' => $row['special_requirements'],
            'status' => $row['status'],
            'booked_at' => $row['created_at']
        ];
        $venue_bookings[] = $row;
    }
    mysqli_free_result($venue_res);
}

// Sort all bookings by booked_at (descending)
usort($bookings, function($a, $b) {
    return strtotime($b['booked_at']) - strtotime($a['booked_at']);
});

// After fetching and sorting $bookings, filter them by type if needed
if ($type_filter === 'photographer') {
    $bookings = array_filter($bookings, function($b) { return $b['booking_type'] === 'Photographer'; });
} elseif ($type_filter === 'venue') {
    // $venue_bookings already set above
}

// Count general bookings
$res = mysqli_query($db, "SELECT COUNT(*) as total FROM bookings");
$booking_count = 0;
if ($res && $row = mysqli_fetch_assoc($res)) $booking_count += (int)$row['total'];

// Count photographer bookings
$res = mysqli_query($db, "SELECT COUNT(*) as total FROM photographer_bookings");
if ($res && $row = mysqli_fetch_assoc($res)) $booking_count += (int)$row['total'];
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
.btn-book-now {
  position: relative;
  z-index: 2;
}
.btn-primary,
.btn-primary:hover,
.btn-primary:focus,
.btn-primary:active {
  background-color: #6f42c1 !important;
  border-color: #6f42c1 !important;
  color: #fff !important;
}
.btn-outline-primary:hover,
.btn-outline-primary:focus,
.btn-outline-primary:active {
  background-color: #6f42c1 !important;
  border-color: #6f42c1 !important;
  color: #fff !important;
}
.btn-filter {
  border-radius: 16px;
  font-weight: 600;
  padding: 0.75em 2em;
  font-size: 1.1em;
  transition: background 0.2s, color 0.2s;
}
.btn-filter-all.btn-primary,
.btn-filter-all.btn-primary:hover,
.btn-filter-all.btn-primary:focus,
.btn-filter-all.btn-primary:active {
  background-color: #6f42c1 !important;
  border-color: #6f42c1 !important;
  color: #fff !important;
}
.btn-filter-cameraman.btn-primary,
.btn-filter-cameraman.btn-primary:hover,
.btn-filter-cameraman.btn-primary:focus,
.btn-filter-cameraman.btn-primary:active {
  background-color: #007bff !important;
  border-color: #007bff !important;
  color: #fff !important;
}
.btn-filter-venue.btn-primary,
.btn-filter-venue.btn-primary:hover,
.btn-filter-venue.btn-primary:focus,
.btn-filter-venue.btn-primary:active {
  background-color: #fd7e14 !important;
  border-color: #fd7e14 !important;
  color: #fff !important;
}
.btn-outline-primary:hover,
.btn-outline-primary:focus,
.btn-outline-primary:active {
  color: #fff !important;
}
</style>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../../includes/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 mt-5">
            <?php include __DIR__ . '/../../includes/admin_header.php'; ?>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Photographer Booking Management</h1>
            </div>

            <!-- Search Form -->
            <form method="get" class="mb-3" style="max-width: 400px;">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search bookings..." value="<?php echo htmlspecialchars($search); ?>">
                    <button class="btn btn-success" type="submit">Search</button>
                    <?php if ($search !== ''): ?>
                        <a href="dashboard.php" class="btn btn-danger">Reset</a>
                    <?php endif; ?>
                </div>
            </form>

            <div class="d-flex gap-2 mb-3">
                <a href="dashboard.php?type=all<?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="btn btn-filter btn-filter-all btn-<?php echo $type_filter==='all'?'primary':'outline-primary'; ?>">All</a>
                <a href="dashboard.php?type=photographer<?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="btn btn-filter btn-filter-cameraman btn-<?php echo $type_filter==='photographer'?'primary':'outline-primary'; ?>">Cameraman</a>
                <a href="dashboard.php?type=venue<?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="btn btn-filter btn-filter-venue btn-<?php echo $type_filter==='venue'?'primary':'outline-primary'; ?>">Venues</a>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($type_filter !== 'venue'): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Type</th>
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
                                <tr><td colspan="12" class="text-center">No bookings found.</td></tr>
                            <?php else: ?>
                                <?php foreach ($bookings as $booking): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($booking['booking_type']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['id']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['name']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['email']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['phone']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['service_type']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['professional'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($booking['preferred_date']); ?></td>
                                        <td><?php echo nl2br(htmlspecialchars($booking['additional_details'])); ?></td>
                                        <td><?php echo htmlspecialchars($booking['booked_at']); ?></td>
                                        <td>
                                            <?php 
                                            $status = strtolower($booking['status']);
                                            if (in_array($booking['booking_type'], ['Photographer', 'Venue'])) {
                                                if ($status === 'pending') {
                                                    echo '<span class="badge bg-warning text-dark">Pending</span>';
                                                } elseif ($status === 'confirmed') {
                                                    echo '<span class="badge bg-success">Confirmed</span>';
                                                } elseif ($status === 'cancelled') {
                                                    echo '<span class="badge bg-danger">Cancelled</span>';
                                                } elseif ($status === 'completed') {
                                                    echo '<span class="badge bg-primary">Completed</span>';
                                                } else {
                                                    echo '<span class="badge bg-secondary">' . ucfirst($status) . '</span>';
                                                }
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($booking['booking_type'] === 'Photographer') {
                                                $status = strtolower($booking['status']); ?>
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
                                                            <button type="submit" class="btn btn-complete-booking">
                                                                <i class="fas fa-lock me-2"></i> COMPLETE BOOKING
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
                                                    <!-- Delete button for photographer booking -->
                                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                                        <input type="hidden" name="delete_booking" value="1">
                                                        <input type="hidden" name="delete_id" value="<?php echo $booking['id']; ?>">
                                                        <input type="hidden" name="delete_type" value="Photographer">
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                            <?php } else { ?>
                                                <div class="d-flex flex-row align-items-center gap-2">
                                                    N/A
                                                    <!-- Delete button for general booking -->
                                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                                        <input type="hidden" name="delete_booking" value="1">
                                                        <input type="hidden" name="delete_id" value="<?php echo $booking['id']; ?>">
                                                        <input type="hidden" name="delete_type" value="Venues">
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php if ($type_filter === 'venue'): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>User Email</th>
                                <th>User Phone</th>
                                <th>Venue Name</th>
                                <th>Event Date</th>
                                <th>Guests</th>
                                <th>Duration (hrs)</th>
                                <th>Special Requirements</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($venue_bookings)): ?>
                                <tr><td colspan="13" class="text-center">No venue bookings found.</td></tr>
                            <?php else: ?>
                                <?php foreach ($venue_bookings as $booking): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($booking['id']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['user_name']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['user_email']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['user_phone']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['venue_name']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['event_date']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['guests']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['duration_hours']); ?></td>
                                        <td><?php echo nl2br(htmlspecialchars($booking['special_requirements'])); ?></td>
                                        <td><?php echo htmlspecialchars($booking['payment_method']); ?></td>
                                        <td>
                                            <?php 
                                            $status = strtolower($booking['status']);
                                            if (in_array($booking['booking_type'], ['Photographer', 'Venue'])) {
                                                if ($status === 'pending') {
                                                    echo '<span class="badge bg-warning text-dark">Pending</span>';
                                                } elseif ($status === 'confirmed') {
                                                    echo '<span class="badge bg-success">Confirmed</span>';
                                                } elseif ($status === 'cancelled') {
                                                    echo '<span class="badge bg-danger">Cancelled</span>';
                                                } elseif ($status === 'completed') {
                                                    echo '<span class="badge bg-primary">Completed</span>';
                                                } else {
                                                    echo '<span class="badge bg-secondary">' . ucfirst($status) . '</span>';
                                                }
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($booking['created_at']); ?></td>
                                        <td>
                                            <div class="d-flex flex-row align-items-center gap-2">
                                                <?php if ($status === 'pending'): ?>
                                                    <form method="POST" style="display:inline;">
                                                        <input type="hidden" name="venue_booking_id" value="<?php echo $booking['id']; ?>">
                                                        <input type="hidden" name="venue_new_status" value="confirmed">
                                                        <button type="submit" class="btn btn-fab btn-fab-confirm" title="Confirm" data-bs-toggle="tooltip" data-bs-placement="top">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form method="POST" style="display:inline;">
                                                        <input type="hidden" name="venue_booking_id" value="<?php echo $booking['id']; ?>">
                                                        <input type="hidden" name="venue_new_status" value="cancelled">
                                                        <button type="submit" class="btn btn-fab btn-fab-cancel" title="Cancel" data-bs-toggle="tooltip" data-bs-placement="top">
                                                            <i class="fas fa-ban"></i>
                                                        </button>
                                                    </form>
                                                <?php elseif ($status === 'confirmed'): ?>
                                                    <form method="POST" style="display:inline;">
                                                        <input type="hidden" name="venue_booking_id" value="<?php echo $booking['id']; ?>">
                                                        <input type="hidden" name="venue_new_status" value="completed">
                                                        <button type="submit" class="btn btn-complete-booking">
                                                            <i class="fas fa-lock me-2"></i> COMPLETE BOOKING
                                                        </button>
                                                    </form>
                                                    <form method="POST" style="display:inline;">
                                                        <input type="hidden" name="venue_booking_id" value="<?php echo $booking['id']; ?>">
                                                        <input type="hidden" name="venue_new_status" value="cancelled">
                                                        <button type="submit" class="btn btn-fab btn-fab-cancel" title="Cancel" data-bs-toggle="tooltip" data-bs-placement="top">
                                                            <i class="fas fa-ban"></i>
                                                        </button>
                                                    </form>
                                                <?php elseif ($status === 'completed'): ?>
                                                    <span class="text-success">Done</span>
                                                <?php elseif ($status === 'cancelled'): ?>
                                                    <span class="text-warning">Cancelled</span>
                                                <?php endif; ?>
                                                <!-- Delete button for venue booking -->
                                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                                    <input type="hidden" name="delete_venue_booking" value="1">
                                                    <input type="hidden" name="venue_booking_id" value="<?php echo $booking['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
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

document.querySelectorAll('.book-event-btn').forEach(function(btn) {
  btn.addEventListener('click', function() {
    var eventId = this.getAttribute('data-event-id');
    document.getElementById('eventId').value = eventId;
    var modal = new bootstrap.Modal(document.getElementById('bookingModal'));
    modal.show();
  });
});
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?> 