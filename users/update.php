<?php

require "../includes/auth_check.php";
require "../includes/activity_log.php";
require "../config/db.php";
require "../includes/permissions.php";
require "../includes/notification_helper.php";

//التحقق من صلاحيه اضافه مستخدم
if(!hasPermission('users.edit'))
{
    die("Access Denied");
}

$id = (int)$_POST['id'];

//جلب بيانات الموظف المطلوب تعديله
$stmt = $pdo->prepare("
    SELECT *
    FROM users
    WHERE id = ?
");

$stmt->execute([
    $id
]);

$existingUser = $stmt->fetch();

//التاكد ان الموظف موجود
if(!$existingUser)
{
    die("User Not Found");
}

//حمايه المدير حسب القسم
$currentRole = $_SESSION['user_role'];

$currentDepartment = $_SESSION['department_id'] ?? null;

//Manager اذا كان المستخدم 
if($currentRole == 2)
{
    if($existingUser['department_id'] != $currentDepartment)
    {
        die("Access Denied");
    }    
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$role_id = (int)$_POST['role_id'];
if($currentRole == 2)
{
    $departmentId = $currentDepartment;
}
else
{
    $departmentId = !empty($_POST['department_id'])
    ? $_POST['department_id']
    : null;
}    

$image = $_POST['old_image'];

if (!empty($_FILES['image']['name'])) {

    $allowed = ['jpg','jpeg','png','webp'];

    $extension = strtolower(
        pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)
    );

    if (in_array($extension, $allowed)) {

        if (
            $image != "default.png" &&
            file_exists("../assets/uploads/".$image)
        ) {
            unlink("../assets/uploads/".$image);
        }

        $image = time().".".$extension;

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../assets/uploads/".$image
        );
    }
}

$stmt = $pdo->prepare(
    "UPDATE users
     SET name=?, email=?, image=?, role_id=?, department_id = ?
     WHERE id=?"
);

$stmt->execute([
    $name,
    $email,
    $image,
    $role_id,
    $departmentId,
    $id
]); 

// إنشاء إشعار للأدمن عند تعديل مستخدم
createNotification(
    $pdo,
    1,
    "تم تحديث بيانات المستخدم",
    "تم تحديث بيانات المستخدم " . $name . " بنجاح."
);

// تسجيل تعديل المستخدم
logActivity(
    $pdo,
    $_SESSION['user_id'],
    "تم تحديث بيانات المستخدم: " . $name
);

header("Location: index.php");
exit;
