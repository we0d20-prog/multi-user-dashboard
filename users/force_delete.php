<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/activity_log.php";
require "../includes/notification_helper.php";
require "../includes/permissions.php";

//السماح فقط لم يملك صلاحيه حذف المستخدمين
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

/* حذف الصورة إذا لم تكن الصورة الافتراضية */
if(
    $user['image'] != 'default.png'
    &&
    file_exists("../assets/uploads/".$user['image'])
)

{
    unlink("../assets/uploads/".$user['image']);
}

/* حذف المستخدم نهائياً */
$delete = $pdo->prepare("
DELETE FROM users
WHERE id = ?
");

$delete->execute([$id]);

/* إنشاء إشعار بحذف المستخدم نهائيًا */
createNotification(
    $pdo,
    1,
    "تم حذف المستخدم نهائيًا",
    "تم حذف المستخدم " . $user['name'] . " نهائيًا."
);

/* تسجيل العملية */
logActivity(
    $pdo,
    $_SESSION['user_id'],
    "تم حذف المستخدم نهائيًا: " . $user['name']
);

header("Location: trash.php?success=deleted");
exit;