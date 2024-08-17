<?php
include "design.php";
include "ostatus.php";

$username = $_SESSION['username'];
$tagwallpath = "data/tagwall.txt";
$adminfile = 'data/users/' . $username . '/admin.txt';
$file_content = file_get_contents($adminfile);
$allowed = "allaccess";
$allowedtomodule = "allow:tagwall";

// tjek hvis data/users/$username/ indeholder tagwallban.txt og hvis det gør, så redirect til index.php
if (file_exists('data/users/' . $username . '/tagwallban.txt')) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['mode']) && $_GET['mode'] === 'send') {
    $tagwall_text = $_POST['tagwall_text'];
    $tagwall_entry = time() . ':' . $username . ':' . $tagwall_text . PHP_EOL;

    file_put_contents($tagwallpath, $tagwall_entry, FILE_APPEND);
    header('Location: tagwall.php');
}


if (isset($_GET['mode']) && $_GET['mode'] === 'delete') {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $tagwall_messages = file($tagwallpath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if ($id !== null && isset($tagwall_messages[$id])) {
        unset($tagwall_messages[$id]);
        
        // Fjern tomme linjer og genumerér indekser
        $tagwall_messages = array_values(array_filter($tagwall_messages));

        file_put_contents($tagwallpath, implode("\n", $tagwall_messages));
    }
    
    header('Location: tagwall.php');
}

if (isset($_GET['mode']) && $_GET['mode'] === 'clear') {
    // Åbn filen i skrivetilstand og tøm indholdet
    file_put_contents($tagwallpath, '');

    // Omdiriger tilbage til tagwall.php
    header('Location: tagwall.php');
    exit; // Sørg for at afslutte scriptet efter header-omdirigering
}


$messages_per_page = 10;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $messages_per_page;

$tagwall_messages = file($tagwallpath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$total_messages = count($tagwall_messages);
$total_pages = ceil($total_messages / $messages_per_page);

$tagwall_messages = array_reverse($tagwall_messages);
$tagwall_messages = array_slice($tagwall_messages, $offset, $messages_per_page);
?>

<div id="content">
    <h1>Tagwall</h1>
    <form method="POST" action="tagwall.php?mode=send">
        <textarea name="tagwall_text"></textarea>
        <button type="submit">Send</button>
        <a href="tagwall.php?mode=clear">Tøm Tagwall</a>
    </form>

    <?php foreach ($tagwall_messages as $line => $message) {
    list($time, $user, $text) = explode(':', $message, 3);
    $id = $total_messages - $line - 1; // Få det korrekte id
    ?>
    <div class="message">
        <span class="username"><a href="profile.php?user=<?php echo $user; ?>"><?php echo $user; ?></a></span>
        <span class="time"><?php echo date('Y-m-d H:i:s', $time); ?></span>
        <p><?php echo $text; ?></p>
        <?php if (strpos($file_content, $allowed) !== false || strpos($file_content, $allowedtomodule) !== false) { ?>
            <a href="tagwall.php?mode=delete&id=<?php echo $id ?>">Slet</a>
        <?php } ?>
    </div>
    <?php } ?>


    <div class="pagination">
        <?php if ($current_page > 1) { ?>
            <a href="tagwall.php?page=<?php echo $current_page - 1; ?>">Previous</a>
        <?php } ?>
        <?php if ($current_page < $total_pages) { ?>
            <a href="tagwall.php?page=<?php echo $current_page + 1; ?>">Next</a>
        <?php } ?>
    </div>
</div>
</div>

