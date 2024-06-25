<?php
require_once('includes/load.php');

// Attempt to log out the user
if (!$session->logout()) {
   // Redirect to index.php if logout fails
    redirect("index.php");
}
?>
