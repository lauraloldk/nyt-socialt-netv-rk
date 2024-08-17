<?php
include "design.php";
include "ostatus.php";
?>

<div id="content">
    <h1>Brugerens Billeder</h1>

<?php
if (isset($_GET['user'])) {
    $username = $_GET['user'];
} else {
    $username = $_SESSION['username'];
}

if($username == $_SESSION['username']){
    $isOwnProfile = true;
}else{
    $isOwnProfile = false;
}   
// Display photos
if ($isOwnProfile) {
    ?>
    <a href="photo-manager.php">Håndter billeder</a>
    <?php
    $photoDirectory = "data/users/$username/photos/";
    if (!is_dir($photoDirectory)) 
    { 
        if (mkdir($photoDirectory, 0777, true)) {
            echo "Photo directory created successfully.";
        } else {
            echo "Failed to create photo directory.";
        }
    }
} else {
    $photoDirectory = "data/users/$username/photos/";
}

$photos = scandir($photoDirectory);
foreach ($photos as $photo) {
    if ($photo !== '.' && $photo !== '..') {
        echo "<br>";
        echo '<img src="' . $photoDirectory . $photo . '" alt="photo" width="500" height="500">';
    }
}
?>

<script>
// JavaScript code to display photos in larger format
// ...
</script>

</div>