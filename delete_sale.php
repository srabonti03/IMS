<?php
require_once('includes/load.php');
page_require_level(3);

$d_sale = find_by_id('sales', (int)$_GET['id']);
if (!$d_sale) {
    $session->msg("d", "Missing sale id.");
    redirect('sales.php');
}

$delete_id = delete_by_id('sales', (int)$d_sale['id']);
if ($delete_id) {
    $session->msg("s", "Sale deleted.");
    redirect('sales.php');
} else {
    $session->msg("d", "Sale deletion failed.");
    redirect('sales.php');
}
?>
