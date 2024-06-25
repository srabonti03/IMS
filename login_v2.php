<?php
ob_start(); // Start output buffering
require_once('includes/load.php');

// Redirect to home.php if user is already logged in
if ($session->isUserLoggedIn(true)) {
    redirect('home.php', false);
}
?>

<!-- HTML header inclusion -->
<?php include_once('layouts/header.php'); ?>

<div class="login-page">
    <div class="text-center">
        <h1>Welcome</h1>
        <p>Sign in to start your session</p>
    </div>

    <?php echo display_msg($msg); ?> <!-- Display any messages -->

    <form method="post" action="auth_v2.php" class="clearfix">
        <div class="form-group">
            <label for="username" class="control-label">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <label for="password" class="control-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info pull-right">Login</button>
        </div>
    </form>
</div>

<?php include_once('layouts/footer.php'); ?>

<?php
// Flush the output from the buffer and turn off output buffering
ob_end_flush();
?>
