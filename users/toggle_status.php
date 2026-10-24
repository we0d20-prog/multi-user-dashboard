<?php

require "../includes/auth_check.php";
require "../includes/permissions.php";
require "../includes/activity_log.php";
require "../config/db.php";

/* التحقق من صلاحية التعديل */
if(!hasPermission('users.edit'))
{
    die("Access Denied");
}

/* التحقق من وجود ID */
if(!isset($_GET['id']))
{
    header("Location: index.php");
    exit;
}

/* تحويل ID إلى رقم */
$id = (int)$_GET['id'];

/* جلب المستخدم */
$stmt = $pdo->prepare("
SELECT *
FROM users
WHERE id = ?
");

$stmt->execute([$id]);

$user = $stmt->fetch();

/* التأكد أن المستخدم موجود */
if(!$user)
{
    header("Location: index.php");
    exit;
}

/* تحديد الحالة الجديدة */
$newStatus =
($user['status'] == 'active')
? 'inactive'
: 'active';

// منع تعطيل الأدمن الرئيسي
if($user['role_id'] == 1)
{
    die("لا يمكن تعطيل الأدمن الرئيسي");
}

/* تحديث الحالة */
$update = $pdo->prepare("
UPDATE users
SET status = ?
WHERE id = ?
");

$update->execute([
    $newStatus,
    $id
]);

/* تسجيل النشاط */
$action =
    ($newStatus == 'active')
    ? "تم تفعيل المستخدم: " . $user['name']
    : "تم تعطيل المستخدم: " . $user['name'];

logActivity(
    $pdo,
    $_SESSION['user_id'],
    $action
);

/* الرجوع للقائمة */
header("Location: index.php");
exit;