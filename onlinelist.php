<?php
include 'design.php';
?>
<div id="content">
    <h2>Onlineliste</h2>
    <p>Her kan du se hvem der er online. og filter efter tidspunkt</p>

<form action="onlinelist.php" method="post">
    <p>Days: <input type="text" name="days" size="2" maxlength="2" value="0"></p>
    <p>Hours: <input type="text" name="hours" size="2" maxlength="2" value="0"></p>
    <p>Minutes: <input type="text" name="minutes" size="2" maxlength="2" value="<?php echo empty($_POST['minutes']) ? '5' : $_POST['minutes']; ?>"></p>
    <p>Seconds: <input type="text" name="seconds" size="2" maxlength="2" value="0"></p>
    <p><input type="submit" value="Submit"></p>
</form>
<?php
$usersDirectory = 'data/users/';

// Get the list of users
$users = scandir($usersDirectory);

// Remove "." and ".." from the list
$users = array_diff($users, array('.', '..'));

if(isset($_POST['days']) && isset($_POST['hours']) && isset($_POST['minutes']) && isset($_POST['seconds'])) {
$selectedDays = $_POST['days'];
$selectedHours = $_POST['hours'];
$selectedMinutes = $_POST['minutes'];
$selectedSeconds = $_POST['seconds'];
} else {
    $selectedDays = 0;
    $selectedHours = 0;
    $selectedMinutes = 5;
    $selectedSeconds = 0;
}
// Calculate the selected time in seconds
$selectedTime = ($selectedDays * 24 * 60 * 60) + ($selectedHours * 60 * 60) + ($selectedMinutes * 60) + $selectedSeconds;

// Set default values for selected time (10 minutes)
if (empty($selectedDays) && empty($selectedHours) && empty($selectedMinutes) && empty($selectedSeconds)) {
    $selectedMinutes = 10;
    $selectedTime = $selectedMinutes * 60;
}

// Loop through each user
foreach ($users as $username) {
    $statusFilePath = $usersDirectory . $username . '/ostatus.txt';

    // Check if the status file exists
    if (file_exists($statusFilePath)) {
        // Read the status from the file
        $status = trim(file_get_contents($statusFilePath));

        // Set the color based on the status
        $color = ($status > time() - $selectedTime) ? 'green' : 'red';
        $statustext = ($status > time() - $selectedTime) ? 'online' : 'offline';
        
        // Display the username and status
        echo "Username: <a href='profile.php?user=$username'>$username</a>, <span style='color: $color;'>$statustext</span><br>";
        echo "sidst online: " . date('d-m-Y H:i:s', $status) . "<br><br>";
    }
}
?>
</div>