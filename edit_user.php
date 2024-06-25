<?php
$page_title = 'Edit User';
require_once('includes/load.php');
// Check user permission level to view this page
page_require_level(1);

// Find the user by ID and fetch all user groups
$e_user = find_by_id('users', (int)$_GET['id']);
$groups = find_all('user_groups');

// Redirect if user ID is missing
if (!$e_user) {
    $session->msg("d", "Missing user ID.");
    redirect('users.php');
}

// Process form submission for updating user basic info
if (isset($_POST['update'])) {
    $req_fields = array('name', 'username', 'level');
    validate_fields($req_fields);

    if (empty($errors)) {
        // Sanitize and prepare data for SQL query
        $id = (int)$e_user['id'];
        $name = remove_junk($db->escape($_POST['name']));
        $username = remove_junk($db->escape($_POST['username']));
        $level = (int)$db->escape($_POST['level']);
        $status = remove_junk($db->escape($_POST['status']));

        // Construct SQL query to update user details
        $sql = "UPDATE users SET name='{$name}', username='{$username}', user_level='{$level}', status='{$status}' WHERE id='{$db->escape($id)}'";
        $result = $db->query($sql);

        // Handle query result and redirect accordingly
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Account updated.");
            redirect('edit_user.php?id=' . (int)$e_user['id'], false);
        } else {
            $session->msg('d', 'Failed to update account.');
            redirect('edit_user.php?id=' . (int)$e_user['id'], false);
        }
    } else {
        // Display errors if validation fails
        $session->msg("d", $errors);
        redirect('edit_user.php?id=' . (int)$e_user['id'], false);
    }
}

// Process form submission for updating user password
if (isset($_POST['update-pass'])) {
    $req_fields = array('password');
    validate_fields($req_fields);

    if (empty($errors)) {
        // Sanitize and prepare data for SQL query
        $id = (int)$e_user['id'];
        $password = remove_junk($db->escape($_POST['password']));
        $h_pass = sha1($password);

        // Construct SQL query to update user password
        $sql = "UPDATE users SET password='{$h_pass}' WHERE id='{$db->escape($id)}'";
        $result = $db->query($sql);

        // Handle query result and redirect accordingly
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "User password updated.");
            redirect('edit_user.php?id=' . (int)$e_user['id'], false);
        } else {
            $session->msg('d', 'Failed to update user password.');
            redirect('edit_user.php?id=' . (int)$e_user['id'], false);
        }
    } else {
        // Display errors if validation fails
        $session->msg("d", $errors);
        redirect('edit_user.php?id=' . (int)$e_user['id'], false);
    }
}
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    Update <?php echo remove_junk(ucwords($e_user['name'])); ?> Account
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_user.php?id=<?php echo (int)$e_user['id']; ?>" class="clearfix">
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo remove_junk(ucwords($e_user['name'])); ?>">
                    </div>
                    <div class="form-group">
                        <label for="username" class="control-label">Username</label>
                        <input type="text" class="form-control" name="username" value="<?php echo remove_junk(ucwords($e_user['username'])); ?>">
                    </div>
                    <div class="form-group">
                        <label for="level">User Role</label>
                        <select class="form-control" name="level">
                            <?php foreach ($groups as $group): ?>
                                <option <?php if ($group['group_level'] === $e_user['user_level']) echo 'selected="selected"'; ?> value="<?php echo $group['group_level']; ?>"><?php echo ucwords($group['group_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status">
                            <option <?php if ($e_user['status'] === '1') echo 'selected="selected"'; ?> value="1">Active</option>
                            <option <?php if ($e_user['status'] === '0') echo 'selected="selected"'; ?> value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group clearfix">
                        <button type="submit" name="update" class="btn btn-info">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change password form -->
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    Change <?php echo remove_junk(ucwords($e_user['name'])); ?> Password
                </strong>
            </div>
            <div class="panel-body">
                <form action="edit_user.php?id=<?php echo (int)$e_user['id']; ?>" method="post" class="clearfix">
                    <div class="form-group">
                        <label for="password" class="control-label">New Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter new password">
                    </div>
                    <div class="form-group clearfix">
                        <button type="submit" name="update-pass" class="btn btn-danger pull-right">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
