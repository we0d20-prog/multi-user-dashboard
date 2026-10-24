<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";
require "../includes/activity_log.php";
require "../includes/notification_helper.php";

// التحقق من صلاحية تعديل الاقسام 
if(!hasPermission('departments.edit'))
{
    die("Access Denied");
}

//التاكد ان البيانات جاءت من الفورم
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    //استقبال البيانات
    $id = $_POST['id'];

    $departmentName = trim(
        $_POST['department_name']
    );

    $description = trim(
        $_POST['description']
    );

    //منع تكرار اسم القسم
    $check = $pdo->prepare("
    SELECT id
    FROM departments
    WHERE department_name = ?
    AND id != ?
    ");

    $check->execute([
        $departmentName,
        $id
    ]);

    if($check->fetch())
    {
        die("Department already exists");
    }

    //تحديث القسم
    $update = $pdo->prepare("
    UPDATE departments
    SET
    department_name = ?,
    description = ?
    WHERE id = ?
    ");

    $update->execute([
        $departmentName,
        $description,
        $id
    ]);

    //تسجيل النشاط
    logActivity(
        $pdo, 
        $_SESSION['user_id'],
        "Update Department : ".$departmentName
    );

    // إشعار للأدمن
    createNotification(
        $pdo,
        1,
        "تم تحديث القسم",
        "تم تحديث القسم " . $departmentName . " بنجاح."
    ); 

    header("Location: index.php");
    exit;
}