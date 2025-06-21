<?php
session_start();

// Remove specific session variables
unset($_SESSION['cart']);  // <-- clear cart
unset($_SESSION['full_name']);
unset($_SESSION['loggedin']);

// Destroy session
session_unset();
session_destroy();

// Start fresh session to set logout message
session_start();
$_SESSION['logout_success'] = "You have successfully logged out.";

header("Location: index.php");
exit();
?>
