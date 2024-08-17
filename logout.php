<?php
session_start();

// tjek banstatus på brugeren
$username = $_SESSION['username'];
$banfile = "data/users/{$username}/banned.txt";
if (file_get_contents($banfile) == "1") {
    $_SESSION = array();

// Destroy the session
    session_destroy();
    
    header('Location: banned.php');
    exit;
}
// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to index.php
header("Location: index.php");
exit;
?>
