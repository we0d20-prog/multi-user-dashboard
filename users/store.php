<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/activity_log.php";
require "../includes/permissions.php";
require "../includes/notification_helper.php";
require "../includes/mail.php";

//التحقق من صلاحيه اضافه مستخدم
if(!hasPermission('users.create'))
{
    die("Access Denied");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    //استقبال كلمه المرور كما كتبها المدير
    $plainPassword = trim($_POST['password']);
    //تشفير كلمه المرور قبل حفظها في قاعده البيانات
    $password = password_hash($plainPassword, PASSWORD_DEFAULT);
    $role_id = (int)$_POST['role_id'];
    $image = "default.png";
    //استقبال القسم المختار
    $departmentId = !empty($_POST['department_id'])
        ? $_POST['department_id']
        : null;

    //التحقق من وجود القسم
    if($departmentId !== null)
    {
        $departmentCheck = $pdo->prepare("
            SELECT id
            FROM departments
            WHERE id = ?
        ");

        $departmentCheck->execute([
            $departmentId
        ]);

        if(!$departmentCheck->fetch())
        {
            die("Department Not Found");
        }
    }        

    // رفع الصوره
    if (!empty($_FILES['image']['name'])) {

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        $extension = strtolower(

            pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)

        );

        if (in_array($extension, $allowed)) {

            $image = time() . "." . $extension;

            move_uploaded_file(

                $_FILES['image']['tmp_name'],

                "../assets/uploads/" . $image

            );
        }
    }

    // منع تكرار البريد
    $check = $pdo->prepare(
        "SELECT id FROM users WHERE email = ?"
    );
    $check->execute([$email]);

    if ($check->fetch()) {

        die("Email already exists");
    }

    // حفظ المستخدم
    $stmt = $pdo->prepare(
        "INSERT INTO users
        (name,email,password,image,role_id,department_id)
        VALUES
        (?,?,?,?,?,?)"
    );

    $stmt->execute([
        $name,
        $email,
        $password,
        $image,
        $role_id,
        $departmentId
    ]);

    /* عنوان البريد */
    $subject = "Welcome to Multi User Dashboard";

    /* محتوى البريد */
    $body = "

    <h2>Welcome ".$name."</h2>

    <p>
    Your account has been created successfully.
    </p>

    <p>
    Your login information:
    </p>

    <ul>
    <li><strong>Email:</strong> ".$email."</li>
    <li><strong>Password:</strong> ".$plainPassword."</li>
    </ul>

    <p>
    You can login using the system.
    </p>
    ";

    /* إرسال البريد */
    sendMail(
        $email,
        $subject,
        $body
    );

    //جلب اسم القسم
    $departmentName = "No Department";

    //اذا كان الموظف مرتبطا بقسم
    if($departmentId !== null)
    {
        //جلب اسم القسم من قاعده البيانات
        $departmentStmt = $pdo->prepare("
            SELECT department_name
            FROM departments
            WHERE id = ?
        ");

        $departmentStmt->execute([
            $departmentId
        ]);

        $department = $departmentStmt->fetch();

        if($department)
        {
            $departmentName = $department['department_name'];
        }
    }

    // إنشاء إشعار للأدمن فقط
    createNotification(
       $pdo,
       1,
       "موظف جديد",
       "تمت إضافة الموظف " . $name . " إلى قسم " . $departmentName . " بنجاح."
    );

    // تسجيل النشاط
    logActivity(
       $pdo,
       $_SESSION['user_id'],
       "تم إنشاء المستخدم: " . $name
    );

    header("Location: index.php");
    exit;
}