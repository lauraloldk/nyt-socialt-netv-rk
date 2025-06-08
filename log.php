<?php

function addlog($username, $action) 
{
    $logfile = 'data/log.txt';
    if (!is_dir(dirname($logfile))) {
        mkdir(dirname($logfile), 0777, true);
    }
    $timestamp = date('Y-m-d H-i-s');
    $log_entry = "$timestamp : $username: $action\n";

    // Append the log entry to the log file
    file_put_contents($logfile, $log_entry, FILE_APPEND);
}
?>
