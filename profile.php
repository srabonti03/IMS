<?php
$page_title = 'My profile';
require_once('includes/load.php');

// Check user permission level to view this page
page_require_level(3);

// Retrieve user ID from GET parameter and validate
$user_id = (int)$_GET['id'];
if (empty($user_id)) {
    redirect('home.php', false);
} else {
    // Fetch user details by ID
    $user_p = find_by_id('users', $user_id);
}
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-4">
        <div class="panel profile">
            <div class="jumbotron text-center bg-red">
                <img class="img-circle img-size-2" src="uploads/users/<?php echo $user_p['image']; ?>" alt="">
                <h3><?php echo first_character($user_p['name']); ?></h3>
            </div>
            <?php if ($user_p['id'] === $user['id']): ?>
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="edit_account.php"><i class="glyphicon glyphicon-edit"></i> Edit profile</a></li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
