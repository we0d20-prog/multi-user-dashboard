<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

if(!hasPermission('settings.view'))
{
    die("Access Denied");
}

$host = "localhost";
$username = "root";
$password = "";
$database = "multi_user_dashboard";

$backupFile = $database . "_" . date("Y-m-d_H-i-s") . ".sql";

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $backupFile . '"');

$command = "\"C:\\xampp\\mysql\\bin\\mysqldump.exe\" --host=$host --user=$username";

if($password != "")
{
    $command .= " --password=$password";
}

$command .= " $database";

system($command);
exit;