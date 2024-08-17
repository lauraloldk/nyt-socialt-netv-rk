<?php
$username = $_SESSION['username'];

$file = "data/users/{$username}/ostatus.txt";
$banfile = "data/users/{$username}/banned.txt"; 
$data = time();

file_put_contents($file, $data);

// hvis indholdet af $banfile er "1" log brugeren ud
if (file_get_contents($banfile) == "1") {
    header('Location: logout.php');
    exit;
}

?>