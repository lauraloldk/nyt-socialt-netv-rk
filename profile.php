<?php
include "design.php";
include "ostatus.php";
$admin = 'data/users/' . $username . '/admin.txt';
$allowed = "allaccess";
$allowedtomodule = "allow:users";
$userdata = 'data/users/' . $username . '/';
$profileText = file_get_contents("data/users/$username/about.txt");
$onlineStatus = file_get_contents("data/users/$username/ostatus.txt");
$modules = file_get_contents("data/users/$username/modules.txt");

// Check if the user is logged in
if (isset($_GET['user'])) {
    $username = $_GET['user'];
} else {
    $username = $_SESSION['username'];
}

if(isset($_GET['repport'])){
    $repport = $_GET['repport'];
    if($repport == true){
        $repport = true;
        file_put_contents($userdata . 'repport.txt', 'This is a report for the user.');
        echo "Bruger er blevet rapporteret";
        
    } else {
        $repport = false;
        unlink($userdata . 'repport.txt');
        echo "Rapport fjernet";
    }
}

// Get profile information


?>
<div id="farveprofil">
<div id="content">
    <h1><?php echo $username; ?></h1>
    <p><?php echo $profileText; ?></p>
    <p><?php echo "sidst online: " . date('d-m-Y H:i:s', $onlineStatus) ; ?></p>
    <?php
    if (file_exists($admin) && $allowed === "allaccess") {
        $repportFile = $userdata . 'repport.txt';
        if (file_exists($repportFile)) {
            echo "Brugeren er blevet rapporteret, du som admin kan vælge at tage handling på dette, eller fjerne rapporten";
            echo '<a href="profile.php?user=' . $username . '&repport=false">Fjern rapport</a>';
        }
    }
    ?>
    <h1>Profil menu</h1>
    <a href="profile-photos.php?user=<?php echo $username; ?>">Brugerens Billeder</a><br>
    <?php echo "<a href='profile.php?user=$username&repport=true'>Rapporter bruger</a>"; ?>

</div>

<script>
window.onload = function() {
    var farveprofil = document.getElementById('farveprofil');
    if (farveprofil) {
        var colorsFile = "/data/users/<?php echo $_SESSION['username']; ?>/colors.txt";
        console.log(colorsFile);
        fetch(colorsFile)
            .then(response => response.text())
            .then(colors => {
                // Split farverne ved kolon
                var [background, text] = colors.split(':');

                // Tjek, om begge farver er til stede
                if (background && text) {
                    farveprofil.style.backgroundColor = '' + background;
                    farveprofil.style.color = '' + text;
                }
                console.log(background +" " + text);
            })
            .catch(error => console.error('Fejl ved indlæsning af farver:', error));
    }
};

</script>

</div>
