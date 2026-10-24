<?php

require "../includes/auth_check.php";
require "../includes/activity_log.php";
require "../config/db.php";
require "../includes/permissions.php";
require "../includes/notification_helper.php";

/* التأكد من وجود ID*/
if(!isset($_GET['id']))
{
    header("Location: index.php");
    exit;
}

/* تحويل ID إلى رقم صحيح*/
$id = (int)$_GET['id'];

/*جلب بيانات الدور*/
$stmt = $pdo->prepare("
SELECT *
FROM roles
WHERE id = ?
");

$stmt->execute([$id]);

$role = $stmt->fetch();

/* التأكد أن الدور موجود*/
if(!$role)
{
    header("Location: index.php");
    exit;
}

/* منع حذف الأدوار الأساسية*/
$systemRoles = [

    'admin',
    'manager',
    'employee'

];

if(
    in_array(
        strtolower($role['role_name']),
        $systemRoles
    )
)
{
    header("Location: index.php?error=system_role");
    exit;
}

/*التحقق من وجود مستخدمين مرتبطين بالدور*/
$checkUsers = $pdo->prepare("
SELECT COUNT(*)
FROM users
WHERE role_id = ?
");

$checkUsers->execute([$id]);

$userCount = $checkUsers->fetchColumn();

/* إذا كان هناك مستخدمون مرتبطون بالدور*/
if($userCount > 0)
{
    header("Location: index.php?error=role_has_users");
    exit;
}

/*حذف الدور*/
$delete = $pdo->prepare("
DELETE FROM roles
WHERE id = ?
");

$delete->execute([$id]);

// إنشاء إشعار للأدمن بحذف الدور
createNotification(
    $pdo,
    1,
    "تم حذف الدور",
    "تم حذف الدور " . $role['role_name'] . " بنجاح."
);

// تسجيل العملية في السجل
logActivity(
    $pdo,
    $_SESSION['user_id'],
    "تم حذف الدور: " . $role['role_name']
);

header("Location: index.php?success=role_deleted");
exit;