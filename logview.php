<?php
// for hver linje i log.txt vis det i en tabel men uden at explode dataen
include "design.php";
include "ostatus.php";
$logfile = 'data/log.txt';
$log_content = file_get_contents($logfile);
$log_lines = explode("\n", $log_content);

// Get filter options from GET parameters
$user_filter = isset($_GET['user']) ? trim($_GET['user']) : '';
$action_filter = isset($_GET['action']) ? trim($_GET['action']) : '';
?>

<div id="adminlog">
    <div id="content">
        <h1>Log</h1>
        <form method="get" style="margin-bottom: 15px;">
            <label for="user">Bruger:</label>
            <input type="text" name="user" id="user" value="<?php echo htmlspecialchars($user_filter); ?>">
            <label for="action">Handling:</label>
            <input type="text" name="action" id="action" value="<?php echo htmlspecialchars($action_filter); ?>">
            <button type="submit">Filtrer</button>
            <a href="logview.php" style="margin-left:10px;">Nulstil</a>
        </form>
        <table>
            <tr>
                <th>Tidspunkt</th>
                <th>Bruger</th>
                <th>Handling</th>
            </tr>
            <?php foreach ($log_lines as $line): ?>
                <?php if (trim($line) !== ''): ?>
                    <?php
                    $parts = explode(':', $line, 3);
                    $timestamp = isset($parts[0]) ? trim($parts[0]) : '';
                    $username = isset($parts[1]) ? trim($parts[1]) : '';
                    $action = isset($parts[2]) ? trim($parts[2]) : '';

                    // Apply filters if set
                    $show = true;
                    if ($user_filter !== '' && stripos($username, $user_filter) === false) {
                        $show = false;
                    }
                    if ($action_filter !== '' && stripos($action, $action_filter) === false) {
                        $show = false;
                    }
                    ?>
                    <?php if ($show): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($timestamp); ?></td>
                            <td><a href="profile.php?user=<?php echo urlencode($username); ?>"><?php echo htmlspecialchars($username); ?></a></td>
                            <td><?php echo htmlspecialchars($action); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    </div>
</div>
