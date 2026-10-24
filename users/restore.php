<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/activity_log.php";
require "../includes/notification_helper.php";

/* التحقق من صلاحية استرجاع المستخدم */
require "../includes/permissions.php";

if(!hasPermission('users.delete'))
{
    die("Access Denied");
}

/* التأكد من وصول رقم المستخدم */
if(!isset($_GET['id']))
{
    header("Location: trash.php");
    exit;
}

/*الى رقم صحيح ID تحويل*/
$id = (int)$_GET['id'];

/* جلب بيانات المستخدم */
$stmt = $pdo->prepare("
SELECT *
FROM users
WHERE id = ?
");

$stmt->execute([$id]);

$user = $stmt->fetch();

/* إذا لم يكن المستخدم موجودًا */
if(!$user)
{
    header("Location: trash.php");
    exit;
}

/* استرجاع المستخدم من سلة المحذوفات */
$restore = $pdo->prepare("
UPDATE users
SET deleted_at = NULL
WHERE id = ?
");

$restore->execute([$id]);

/* إنشاء إشعار باستعادة المستخدم */
createNotification(
    $pdo,
    1,
    "تمت استعادة المستخدم",
    "تمت استعادة المستخدم " . $user['name'] . " بنجاح."
);

/* تسجيل العملية في سجل النشاطات */
logActivity(
    $pdo,
    $_SESSION['user_id'],
    "تمت استعادة المستخدم: " . $user['name']
);

/* Trash الرجوع إلى صفحة */
header("Location: trash.php?success=restored");
exit;