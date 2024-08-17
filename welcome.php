<div id="content">
<?php
include 'design.php';
include "ostatus.php";
// Get the username from the session
$username = $_SESSION['username'];

// Print the welcome message
echo "Welcome, $username!";
?>
</div>