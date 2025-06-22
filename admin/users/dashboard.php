<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/db.php';
include __DIR__ . '/../../includes/admin_header.php';

// Fetch users from the database
$users = [];
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$query = "SELECT id, username, email, created_at FROM users";
if ($search !== '') {
    $search_escaped = mysqli_real_escape_string($db, $search);
    $query .= " WHERE username LIKE '%$search_escaped%' OR email LIKE '%$search_escaped%'";
}
$query .= " ORDER BY id DESC";
$result = mysqli_query($db, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    mysqli_free_result($result);
}

// Handle delete action
if (isset($_POST['delete_user'], $_POST['user_id'])) {
    $user_id = (int)$_POST['user_id'];
    $del_query = "DELETE FROM users WHERE id = $user_id";
    if (mysqli_query($db, $del_query)) {
        $_SESSION['message'] = 'User deleted successfully!';
        $_SESSION['message_type'] = 'success';
        header('Location: dashboard.php');
        exit;
    } else {
        $_SESSION['message'] = 'Error deleting user: ' . mysqli_error($db);
        $_SESSION['message_type'] = 'danger';
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../../includes/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 mt-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Registered Users</h1>
            </div>
            <!-- Search Form -->
            <form method="get" class="mb-3" style="max-width: 400px;">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search users..." value="<?php echo htmlspecialchars($search); ?>">
                    <button class="btn btn-success" type="submit">Search</button>
                    <?php if ($search !== ''): ?>
                        <a href="dashboard.php" class="btn btn-danger">Reset</a>
                    <?php endif; ?>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr><td colspan="5" class="text-center">No users found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo isset($user['created_at']) ? htmlspecialchars($user['created_at']) : 'N/A'; ?></td>
                                    <td>
                                        <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            <input type="hidden" name="delete_user" value="1">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                        </form>
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
<?php include __DIR__ . '/../../includes/footer.php'; ?> 