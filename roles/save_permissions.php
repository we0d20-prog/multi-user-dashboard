<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

// السماح للأدمن فقط
if($_SESSION['user_role'] != 1)
{
    die("Access Denied");
}

// استقبال رقم الدور
$roleId = (int)$_POST['role_id'];

// استقبال الصلاحيات المحددة
$permissions = $_POST['permissions'] ?? [];

// حذف الصلاحيات القديمة
$stmt = $pdo->prepare("
DELETE FROM role_permissions
WHERE role_id = ?
");

$stmt->execute([$roleId]);

// إضافة الصلاحيات الجديدة
foreach($permissions as $permissionId)
{
    $stmt = $pdo->prepare("
    INSERT INTO role_permissions
    (role_id, permission_id)
    VALUES (?, ?)
    ");

    $stmt->execute([
        $roleId,
        $permissionId
    ]);
}

// العودة للصفحة
header("Location: permissions.php?id=$roleId&success=1");
echo "تم الوصول لنهاية الملف";
exit;
