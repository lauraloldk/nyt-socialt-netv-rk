<?php
include "design.php";
include "ostatus.php";

$username = $_SESSION['username'];
$userdata = 'data/users/' . $username . '/';

// check hvis $userdata indeholder modules.txt og hvis ikke så opret filen
if (!file_exists($userdata . 'modules.txt')) {
    file_put_contents($userdata . 'modules.txt', '');
}

?>
<div id ="content">
<h1>Slå moduler og testfunktioner til/fra</h1>

</div>