<?php
require_once('includes/load.php');
page_require_level(1);

$delete_id = delete_by_id('users', (int)$_GET['id']);
if ($delete_id) {
    $session->msg("s", "User deleted.");
    redirect('users.php');
} else {
    $session->msg("d", "User deletion failed or missing parameter.");
    redirect('users.php');
}
?>
