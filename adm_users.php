<div id="content">
<?php
include 'design.php';
include "ostatus.php";
$username = $_SESSION['username'];
$file = 'data/users/' . $username . '/admin.txt';
$file_content = file_get_contents($file);
$allowed = "allaccess";
$allowedtomodule = "allow:users";

if (strpos($file_content, $allowed) !== false || strpos($file_content, $allowedtomodule) !== false) {
    // Adgang tilladt
    echo 'Adgang tilladt til admin modulet';

    // Get the list of usernames (folder names)
    $usernames = scandir('data/users/');
    $usernames = array_diff($usernames, array('.', '..'));

    // Display the dropdown list
    echo '<form action="" method="post">';
    echo '<select name="selected_user">';
    foreach ($usernames as $username) {
        echo '<option value="' . $username . '">' . $username . '</option>';
    }
    echo '</select>';
    echo '<input type="submit" value="Select User">';
    echo '</form>';

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $selected_user = $_POST['selected_user'];
        echo '<form action="" method="post">';

        // Display the selected user's fields for editing
        $user_folder = 'data/users/' . $selected_user . '/';
        $user_files = glob($user_folder . '*.txt');
        foreach ($user_files as $file) {
            $field_name = basename($file, '.txt');
            $field_value = file_get_contents($file);

            // Display the field for editing
            echo $user_folder;
            echo "<br>";
            echo '<label for="' . $field_name . '">' . $field_name . '</label>';
            echo '<input type="text" name="' . $field_name . '" value="' . $field_value . '">';
        }
        echo '<input type="hidden" name="selected_user" value="' .$selected_user.'">';
        // Display the option to delete user or save changes to the selected user
        echo '<input type="submit" name="delete_user" value="Delete User">';
        echo '<input type="submit" name="save_changes" value="Save Changes">';
        echo '<input type="submit" name="add_adm" value="Tilføj admin.txt">'; // tilføjer en tom admin.txt fil til brugeren
        echo '<input type="submit" name="del_adm" value="Slet admin.txt">';
        echo '<input type="submit" name="add_ban" value="Tilføj banned.txt">';
        echo '<input type="submit" name="del_ban" value="Slet banned.txt">';
        echo '<input type="submit" name="add_tagwallban" value="Tagwall Ban">';
        echo '<input type="submit" name="del_tagwallban" value="Slet Tagwall Ban">';
    echo '</form>';
       
    }

    // Handle delete user button click
    if (isset($_POST['delete_user'])) {
        // Delete the selected user's folder
        $selected_user = $_POST['selected_user'];
        $user_folder = 'data/users/' . $selected_user . '/';
        
        if (is_dir($user_folder)) {
            // Fjern alle filer i mappen
            $files = glob($user_folder . '*');
            foreach ($files as $file) {
                unlink($file);
            }
    
            // Forsøg at fjerne mappen
            if (rmdir($user_folder)) {
                // Redirect to the user manager page
                header('Location: adm_users.php');
                exit;
            } else {
                echo 'Kunne ikke fjerne mappen.';
            }
        } else {
            echo 'Mappen eksisterer ikke.';
        }
    }
    

    // Handle save changes button click
if (isset($_POST['save_changes'])) {
    $selected_user = $_POST['selected_user'];
    $user_folder = 'data/users/' . $selected_user . '/';
    $user_files = glob($user_folder . '*.txt');

    foreach ($user_files as $file) {
        $field_name = basename($file, '.txt');
        $field_value = $_POST[$field_name];

        // Update the field value in the corresponding file
        file_put_contents($file, $field_value);
    }

    // Redirect to the user manager page
    header('Location: adm_users.php');
    exit;
}
    


if (isset($_POST['add_adm'])) {
    $selected_user = $_POST['selected_user'];
    $user_folder = 'data/users/' . $selected_user . '/';
    $file = $user_folder . 'admin.txt';

    // Opretter en tom fil, hvis den ikke eksisterer
    if (!file_exists($file)) {
        file_put_contents($file, '');
    }

    // Nu kan du læse indholdet
    $file_content = file_get_contents($file);
}


if (isset($_POST['del_adm'])) {
    $selected_user = $_POST['selected_user'];
    $user_folder = 'data/users/' . $selected_user . '/';
    $file = $user_folder . 'admin.txt';
    // Delete the selected file
    if (is_file($file)) {
        unlink($file);
    }
    exit;
}

if (isset($_POST['add_ban'])) {
    $selected_user = $_POST['selected_user'];
    $user_folder = 'data/users/' . $selected_user . '/';
    $file = $user_folder . 'banned.txt';

    // Opretter en tom fil, hvis den ikke eksisterer
    if (!file_exists($file)) {
        file_put_contents($file, '');
    }

    // Nu kan du læse indholdet
    $file_content = file_get_contents($file);
}

if (isset($_POST['add_tagwallban'])) {
    $selected_user = $_POST['selected_user'];
    $user_folder = 'data/users/' . $selected_user . '/';
    $file = $user_folder . 'tagwallban.txt';

    // Opretter en tom fil, hvis den ikke eksisterer
    if (!file_exists($file)) {
        file_put_contents($file, '');
    }

    // Nu kan du læse indholdet
    $file_content = file_get_contents($file);
}

if (isset($_POST['del_ban'])) {
    $selected_user = $_POST['selected_user'];
    $user_folder = 'data/users/' . $selected_user . '/';
    $file = $user_folder . 'banned.txt';
    // Delete the selected file
    if (is_file($file)) {
        unlink($file);
    }
    exit;
}

if (isset($_POST['del_tagwallban'])) {
    $selected_user = $_POST['selected_user'];
    $user_folder = 'data/users/' . $selected_user . '/';
    $file = $user_folder . 'tagwallban.txt';
    // Delete the selected file
    if (is_file($file)) 
    {
        unlink($file);
    }
    exit;

}

}
else {
    // Adgang nægtet
    header('Location: index.php');
}

?>
</div>
