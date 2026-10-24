<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

// التأكد أن المستخدم لديه صلاحية
if(!hasPermission('settings.view'))
{
    die("Access Denied");
}

// التأكد من رفع ملف
if(!isset($_FILES['backup_file']))
{
    die("No file uploaded");
}

// مسار الملف المؤقت الذي رفعه المستخدم
$file = $_FILES['backup_file']['tmp_name'];

$database = "multi_user_dashboard";
$username = "root";
$password = "";

// مسار mysql.exe داخل XAMPP
$mysql = "C:\\xampp\\mysql\\bin\\mysql.exe";

// تجهيز أمر الاستعادة
$command = "\"$mysql\" --user=$username";

if($password != "")
{
    $command .= " --password=$password";
}

// تحديد قاعدة البيانات
$command .= " $database < \"$file\"";

// تنفيذ أمر الاستعادة
system($command, $result);

// إذا نجحت العملية
if($result == 0)
{
    header("Location: index.php?restore=success");
    exit;
}
else
{
    die("Restore Failed");
}