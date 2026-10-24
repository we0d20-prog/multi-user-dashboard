<?php

session_start();

require "../config/db.php";
require "../includes/activity_log.php";

//تسجيل عمليه الخروج
if(isset($_SESSION['user_id']))
{
    logActivity(
        $pdo,
        $_SESSION['user_id'],
        "User Logout"
    );
}
session_destroy();

header("Location: login.php");

exit;

?>