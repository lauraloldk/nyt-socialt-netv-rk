<div id="content">
<?php
include 'design.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Step 1: Add a folder with the same name as $username in data/users/ if the username does not exist
    $userFolder = 'data/users/' . $username;
    if (!file_exists($userFolder)) {
        mkdir($userFolder, 0777, true);
    } else {
        echo "Username already exists. Please choose a different username.";
        exit;
    }

    // Step 2: Create a password.txt file with the $password in it, in data/users/$username/
    $passwordFile = $userFolder . '/password.txt';
    file_put_contents($passwordFile, $password);

    // Step 3: Check if the files are created correctly
    if (file_exists($userFolder) && file_exists($passwordFile)) {
        header('Location: index.php');
        exit;
    } else {
        // Delete the changes if something went wrong
        if (file_exists($userFolder)) {
            rmdir($userFolder);
        }
        echo "Something went wrong. Please try again.";
        exit;
    }
}
?>
<form method="POST" action="">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required><br>

    <input type="submit" value="Sign Up">
</form>
</div>

