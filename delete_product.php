<?php
require_once('includes/load.php');
page_require_level(2);

$product = find_by_id('products', (int)$_GET['id']);
if (!$product) {
    $session->msg("d", "Missing Product id.");
    redirect('product.php');
}

$delete_id = delete_by_id('products', (int)$product['id']);
if ($delete_id) {
    $session->msg("s", "Product deleted.");
    redirect('product.php');
} else {
    $session->msg("d", "Product deletion failed.");
    redirect('product.php');
}
?>
