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

// hvis der med en fejl er oprettet en ostatus.txt fil i data/users i stedet for data/users/$username/ så slet denne ostatus.xtxt fil
if (file_exists("data/users/ostatus.txt") && !file_exists($file)) {
    unlink("data/users/ostatus.txt");
}

?>
