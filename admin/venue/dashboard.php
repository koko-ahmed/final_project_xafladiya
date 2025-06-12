<?php
require_once __DIR__ . '/../../config/config.php'; // Load config first (includes get_url function)
require_once __DIR__ . '/../../config/session_config.php'; // Then session config
require_once __DIR__ . '/../../includes/admin_auth.php'; // Then admin auth
require_once __DIR__ . '/../../includes/db.php';    // Then header

// Fetch venues from the database
$venues = [];
$query = "SELECT * FROM venues ORDER BY name ASC";
$result = mysqli_query($db, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $venues[] = $row;
    }
    mysqli_free_result($result);
} else {
    $_SESSION['message'] = 'Error fetching venues: ' . mysqli_error($db);
    $_SESSION['message_type'] = 'danger';
}

?>

<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 mt-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Manage Venues</h1>
                <a href="add_venue.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Venue
                </a>
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

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Capacity</th>
                            <th>Contact</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($venues)): ?>
                            <tr>
                                <td colspan="6" class="text-center">No venues found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($venues as $venue): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($venue['name']); ?></td>
                                    <td><?php echo htmlspecialchars($venue['location']); ?></td>
                                    <td>$<?php echo htmlspecialchars(number_format((float) preg_replace('/[^0-9.]/', '', $venue['price']), 2)); ?></td>
                                    <td><?php echo htmlspecialchars($venue['capacity']); ?> guests</td>
                                    <td><?php echo htmlspecialchars($venue['contact_name']) . ' (' . htmlspecialchars($venue['contact_phone']) . ')'; ?></td>
                                    <td>
                                        <a href="edit_venue.php?id=<?php echo $venue['id']; ?>" class="btn btn-sm btn-primary me-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete(<?php echo $venue['id']; ?>, '<?php echo htmlspecialchars($venue['name']); ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the venue "<span id="venueName"></span>"?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" action="delete_venue.php" method="POST" style="display: inline;">
                    <input type="hidden" name="venue_id" id="venueId">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(venueId, venueName) {
    document.getElementById('venueId').value = venueId;
    document.getElementById('venueName').textContent = venueName;
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Initialize all tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?> 