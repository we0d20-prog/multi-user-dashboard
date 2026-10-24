<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";
require "../includes/activity_log.php";
require "../includes/notification_helper.php";

// التحقق من صلاحية إضافة قسم
if(!hasPermission('departments.create'))
{
    die("Access Denied");
}

//التاكد ان الطلب جاء من الفورم
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    //استقبال البيانات القادمه من الفورم
    $departmentName = trim($_POST['department_name']);

    $description = trim($_POST['description']);

    //منع تكرار اسم القسم
    $check = $pdo->prepare("
    SELECT id
    FROM departments
    WHERE department_name = ?
    ");

    $check->execute([
        $departmentName
    ]);

    //اذا كان القسم موجود مسبقا
    if($check->fetch())
    {
        die("Department already exists");
    }

    //حفظ القسم
    $stmt = $pdo->prepare("
    INSERT INTO departments
    (
        department_name,
        description
    )
    VALUES
    (
        ?,
        ?
    )        
    ");

    $stmt->execute([
        $departmentName,
        $description
    ]);

    //تسجيل النشاط
    logActivity(
        $pdo,
        $_SESSION['user_id'],
        "Created Department : ".$departmentName
    );

    // إرسال إشعار للأدمن
    createNotification(
       $pdo,
       1,
       "قسم جديد",
       "تم إنشاء القسم " . $departmentName . " بنجاح."
    );

    header("Location: index.php");
    exit;
}    
