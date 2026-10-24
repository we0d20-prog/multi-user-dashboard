<?php

require "../includes/auth_check.php";
require "../includes/activity_log.php";
require "../config/db.php";
require "../includes/permissions.php";
require "../includes/notification_helper.php";

//التحقق من صلاحيه اضافه مستخدم
if(!hasPermission('users.delete'))
{
    die("Access Denied");
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("
    SELECT users.*, roles.role_name
    FROM users
    JOIN roles ON users.role_id = roles.id
    WHERE users.id = ?
");

$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    die("User Not Found");
}

/* منع حذف آخر Admin */
if ($user['role_name'] == 'admin') {

    $countAdmins = $pdo->query("
        SELECT COUNT(*) 
        FROM users
        WHERE role_id = 1
    ")->fetchColumn();

    if ($countAdmins <= 1) {
        die("Cannot delete the last Admin.");
    }
}

// إنشاء إشعار بحذف مستخدم ونقله إلى سلة المحذوفات
createNotification(
    $pdo,
    1,
    "تم نقل المستخدم إلى سلة المحذوفات",
    "تم نقل المستخدم " . $user['name'] . " إلى سلة المحذوفات."
);

//قبل الحذف اجلب اسم المستخدم
$stmt = $pdo->prepare("
SELECT name
FROM users
WHERE id = ?
");

$stmt->execute([$id]);
$user = $stmt->fetch();

// تسجيل العملية بعد نقل المستخدم إلى سلة المحذوفات
logActivity(
    $pdo,
    $_SESSION['user_id'],
    "تم نقل المستخدم إلى سلة المحذوفات: " . $user['name']
);

/* نقل المستخدم الى سله المحذوفات */
$delete = $pdo->prepare("
    UPDATE users
    SET deleted_at = NOW()
    WHERE id = ?
");
$delete->execute([$id]);

header("Location: index.php");
exit;