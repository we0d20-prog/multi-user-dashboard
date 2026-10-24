<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";
require "../includes/activity_log.php";
require "../includes/notification_helper.php";

// التحقق من صلاحية الحذف  
if(!hasPermission('departments.delete'))
{
    die("Access Denied");
}

//استقبال رقم القسم
$id = $_GET['id'];

//جلب بيانات القسم
$stmt = $pdo->prepare("
SELECT * 
FROM departments
WHERE id = ?
");

$stmt->execute([$id]);

$department = $stmt->fetch();

//التاكد ان القسم موجود
if(!$department)
{
    die("Department Not Found");
}

//حذف القسم
$delete = $pdo->prepare("
DELETE
FROM departments
WHERE id = ?
");

$delete->execute([$id]);

//تسجيل النشاط
logActivity(
    $pdo,
    $_SESSION['user_id'],
    "Deleted Department : ".$department['department_name']
);

// إرسال إشعار للأدمن
createNotification(
    $pdo,
    1,
    "تم حذف القسم",
    "تم حذف القسم " . $department['department_name'] . " بنجاح."
);

header("Location: index.php");
exit;
