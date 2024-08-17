<?php
include "design.php";
include "ostatus.php";
?>
<div id="content">
    <h1>vælg muligheder</h1>
    <a href="photo-manager.php?mode=add">Tilføj billeder</a>
    <a href="photo-manager.php?mode=delete">Slet billeder</a>

    <?php
    if (isset($_GET['mode']) && $_GET['mode'] === 'add') {
        ?>
        <h1>Tilføj billeder</h1>
        <form method="POST" action="photo-manager.php?mode=upload" enctype="multipart/form-data">
            <input type="file" name="photo" accept="image/*">
            <button type="submit">Upload</button>
        </form>
        <?php
    } elseif (isset($_GET['mode']) && $_GET['mode'] === 'delete') {
        ?>
        <h1>Slet billeder</h1>
        <form method="POST" action="photo-manager.php?mode=remove">
            <?php
            $photoDirectory = "data/users/" . $_SESSION['username'] . "/photos/";
            $photos = scandir($photoDirectory);
            foreach ($photos as $photo) {
                if ($photo !== '.' && $photo !== '..') {
                    echo "<br>";
                    echo '<input type="checkbox" name="photos[]" value="' . $photo . '">';
                    echo '<img src="' . $photoDirectory . $photo . '" alt="photo" width="500" height="500">';
                }
            }
            ?>
            <button type="submit">Slet</button>
        </form>
        <?php
    } elseif (isset($_GET['mode']) && $_GET['mode'] === 'upload') {
        $photoDirectory = "data/users/" . $_SESSION['username'] . "/photos/";
        if (!is_dir($photoDirectory)) {
            if (mkdir($photoDirectory, 0777, true)) {
                echo "Photo directory created successfully.";
            } else {
                echo "Failed to create photo directory.";
            }
        }

        $photo = $_FILES['photo'];
        $photoPath = $photoDirectory . $photo['name'];
        if (move_uploaded_file($photo['tmp_name'], $photoPath)) {
            echo "Photo uploaded successfully.";
        } else {
            echo "Failed to upload photo.";
        }
    } elseif (isset($_GET['mode']) && $_GET['mode'] === 'remove') {
        $photoDirectory = "data/users/" . $_SESSION['username'] . "/photos/";
        $photos = $_POST['photos'];
        foreach ($photos as $photo) {
            $photoPath = $photoDirectory . $photo;
            if (unlink($photoPath)) {
                echo "Photo deleted successfully.";
            } else {
                echo "Failed to delete photo.";
            }
        }
    }
    ?>