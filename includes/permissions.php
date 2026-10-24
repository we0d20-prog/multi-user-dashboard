<?php

function hasPermission($permissionName)
{
    // جلب الاتصال بقاعدة البيانات
    global $pdo;

    // التأكد من وجود مستخدم مسجل دخول
    if(!isset($_SESSION['user_role']))
    {
        return false;
    }

    // رقم الدور الحالي
    $roleId = $_SESSION['user_role'];

    /* البحث عن الصلاحية داخل قاعدة البيانات*/
    $stmt = $pdo->prepare("
    SELECT permissions.permission_name

    FROM role_permissions

    JOIN permissions
    ON role_permissions.permission_id = permissions.id

    WHERE role_permissions.role_id = ?
    AND permissions.permission_name = ?
    ");

    $stmt->execute([

        $roleId,
        $permissionName

    ]);

    // جلب النتيجة
    $permission = $stmt->fetch();

    // إذا وجد صلاحية يرجع true
    if($permission)
    {
        return true;
    }

    // إذا لم يجد يرجع false
    return false;
}