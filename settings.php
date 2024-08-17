<?php
include 'design.php';
include "ostatus.php";
?>
<div id="content">
<?php
$username = $_SESSION['username'];
if (isset($_GET['module']) && $_GET['module'] === 'about') {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_GET['mode']) && $_GET['mode'] == 'save') {
            
            $aboutText = $_POST['about_text'];
            
            
            $filePath = "data/users/$username/about.txt";
            if (!file_exists($filePath)) {
                // Opret filen, hvis den ikke findes
                file_put_contents($filePath, '');
            }

            // Gem den nye profiltekst i filen
            file_put_contents($filePath, $aboutText);
            
            echo "Profilteksten er nu gemt ";
            // Redirect tilbage til settings.php
            echo '<a href="settings.php">Tilbage</a>';
            exit;
        }
    }

    // Hent den eksisterende profiltekst, hvis den findes
   
    $filePath = "data/users/$username/about.txt";
    $aboutText = file_exists($filePath) ? file_get_contents($filePath) : '';

    // Vis formularen til at ændre profilteksten
    ?>
    <h1>Indstillinger</h1>
    <form method="POST" action="settings.php?module=about&mode=save">
        <p>Sæt profiltekst</p>
        <textarea name="about_text"><?php echo $aboutText; ?></textarea>
        <button type="submit">Gem</button>
    </form>
    <?php

} elseif (isset($_GET['module']) && $_GET['module'] === 'farveprofil') {
    $filePath = "data/users/$username/colors.txt";
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_GET['mode']) && $_GET['mode'] == 'save') {
            $backgroundColor = $_POST['background_color'];
            $textColor = $_POST['text_color'];
            
            // Gem farverne som en enkelt streng med kolonadskillelse
            $colors = $backgroundColor . ':' . $textColor;
            
            // Gem farverne i filen
            file_put_contents($filePath, $colors);
            
            echo "Farverne er nu gemt ";
            // Redirect tilbage til settings.php
            echo '<a href="settings.php">Tilbage</a>';
            exit;
        }
    }
    
    // Hent farverne fra profilens colors.txt-fil (hvis den findes)
    $colors = file_exists($filePath) ? file_get_contents($filePath) : '';
    $colors = json_decode($colors, true);
    
    // Vis formularen til at ændre farverne
    ?>
    <h1>Indstillinger</h1>
    <form method="POST" action="settings.php?module=farveprofil&mode=save">
        <p>Vælg baggrundsfarve</p>
        <input type="color" name="background_color" value="<?php echo $colors['background-color']; ?>">
        <p>Vælg tekstfarve</p>
        <input type="color" name="text_color" value="<?php echo $colors['text-color']; ?>">
        <button type="submit">Gem</button>
    </form>
    <?php
} elseif (isset($_GET['module']) && $_GET['module'] === 'sletprofil') 
{
    // script og form til at slette data/users/$username mappen
  $profilepath = "data/users/$username";
  if (file_exists($profilepath)) {
    $files = glob($profilepath . '/*');
    foreach ($files as $file) {
      if (is_file($file)) {
        unlink($file);
      }
    }
    rmdir($profilepath);
  }    
    echo "Profilen er nu slettet ";
    header("Location: logout.php");
}
 


else {
    // Vis standardindholdet for settings.php
    ?>
    <h1>Indstillinger</h1>
    <ul>
        <li><a href="settings.php?module=about">Om mig</a></li>
        
        <li><a href="settings.php?module=farveprofil">Farveprofil (kun vist på profiler)</a></li>
        <li><a href="settings.php?module=sletprofil">Slet profil (der er ingen vej tilbage hvis du trykker her)</a></li>
        <li><a href="modules.php">Funktioner og moduler</a></li>
    </ul>

    
    <?php
}
?>
</div>
