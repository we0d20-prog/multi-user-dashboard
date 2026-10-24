<?php

require "../includes/auth_check.php";
require "../includes/activity_log.php";
require "../includes/notification_helper.php";
require "../config/db.php";

/* استقبال البيانات */
$currentPassword = $_POST['current_password'];
$newPassword = $_POST['new_password'];
$confirmPassword = $_POST['confirm_password'];

/* جلب المستخدم الحالي */
$stmt = $pdo->prepare("
SELECT *
FROM users
WHERE id = ?
");

$stmt->execute([
    $_SESSION['user_id']
]);

$user = $stmt->fetch();

/*التحقق من كلمة المرور الحالية */
if(
    !password_verify(
        $currentPassword,
        $user['password']
    )
)
{
    header("Location: index.php?error=current_password");
    exit;
}

/* التحقق من تطابق كلمة المرور الجديدة */
if(
    $newPassword != $confirmPassword
)
{
    header("Location: index.php?error=password_mismatch");
    exit;
}

/* تشفير كلمة المرور الجديدة */
$hashedPassword = password_hash(
    $newPassword,
    PASSWORD_DEFAULT
);

/* تحديث كلمة المرور */
$update = $pdo->prepare("
UPDATE users
SET password = ?
WHERE id = ?
");

$update->execute([
    $hashedPassword,
    $_SESSION['user_id']
]);

// إشعار للأدمن عند تغيير أي مستخدم لكلمة المرور
createNotification(
    $pdo,
    1,
    "تم تغيير كلمة المرور",
    "قام المستخدم " . $user['name'] . " بتغيير كلمة المرور الخاصة به."
);

// إشعار شخصي للمستخدم
createNotification(
    $pdo,
    $_SESSION['user_id'],
    "تم تغيير كلمة المرور",
    "تم تغيير كلمة المرور الخاصة بك بنجاح."
);

logActivity(
    $pdo, 
    $_SESSION['user_id'],
    "Changed Password"
);

header("Location: index.php?success=password_changed");

exit;