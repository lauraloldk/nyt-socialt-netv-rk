<?php
// Start the session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    // User is logged in, show the user menu
    $username = $_SESSION['username'];
    echo "Welcome, <a href=profile.php?user=$username>$username</a>! This is your user menu.";
    echo "<a href='logout.php'>Logout</a>";
    echo "<br>";
    echo "<a href='settings.php'>Indstillinger</a>";
    echo "<br>";
    echo "<a href='tagwall.php'>Tagwall</a>";
} else {
    // User is not logged in, show the login form
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the username and password keys exist in the $_POST array
        if (isset($_POST['username']) && isset($_POST['password'])) {
            // Get the submitted username and password
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Check if the user folder exists
            $userFolder = 'data/users/' . $username;
            if (is_dir($userFolder)) {
                // Check if the password file exists
                $passwordFile = $userFolder . '/password.txt';
                if (file_exists($passwordFile)) {
                    // Read the password from the file
                    $storedPassword = file_get_contents($passwordFile);

                    // Check if the submitted password matches the stored password
                    if (trim($storedPassword) === $password) {
                        // Store the username in a session variable
                        $_SESSION['username'] = $username;

                        // Redirect the user to welcome.php
                        header('Location: welcome.php');
                        exit;
                    }
                }
            }

            // If no match found, display an error message
            $error = 'Invalid username or password';
        } else {
            // If the username or password keys are missing, display an error message
            $error = 'Please enter both username and password';
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" value="Login">
        <a href="signup.php">Opret Bruger</a>
    </form>
</body>
</html>
<?php } ?>

