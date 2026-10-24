<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";
require "../includes/activity_log.php";
require "../includes/notification_helper.php";

// التحقق من صلاحية إنشاء طلب إجازة
if(!hasPermission('leaves.create'))
{
    die("Access Denied");
}

// التأكد أن البيانات جاءت من POST
if($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    die("Invalid Request");
}

// الحصول على ID المستخدم من Session
$userId = $_SESSION['user_id'];

// معرفة دور المستخدم الحالي
$currentRole = (int)$_SESSION['user_role'];

// استقبال بيانات الطلب
$leaveType = trim($_POST['leave_type'] ?? '');
$startDate = $_POST['start_date'] ?? '';
$endDate   = $_POST['end_date'] ?? '';
$reason    = trim($_POST['reason'] ?? '');

// التحقق من البيانات المطلوبة
if(
    empty($leaveType) ||
    empty($startDate) ||
    empty($endDate)
)
{
    die("Please fill in all required fields");
}

// التحقق من صحة التاريخ
if(!strtotime($startDate) || !strtotime($endDate))
{
    die("Invalid Date");
}

// التأكد أن تاريخ النهاية ليس قبل البداية
if($endDate < $startDate)
{
    die("End date cannot be before start date");
}

// جلب بيانات المستخدم الحالي
$stmt = $pdo->prepare("
    SELECT
        id,
        name,
        role_id,
        department_id
    FROM users
    WHERE id = ?
    AND deleted_at IS NULL
    LIMIT 1
");

$stmt->execute([
    $userId
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// التأكد أن المستخدم موجود
if(!$user)
{
    die("User Not Found");
}

// التأكد أن المستخدم لديه قسم
if(empty($user['department_id']))
{
    die("You are not assigned to a department");
}

// منع وجود طلب إجازة متداخل
$stmt = $pdo->prepare("
    SELECT id
    FROM leave_requests
    WHERE user_id = ?
    AND status IN ('pending', 'approved')
    AND start_date <= ?
    AND end_date >= ?
    LIMIT 1
");

$stmt->execute([
    $userId,
    $endDate,
    $startDate
]);

$existingLeave = $stmt->fetch();

if($existingLeave)
{
    die("You already have a leave request during this period");
}

// إنشاء طلب الإجازة
$stmt = $pdo->prepare("
    INSERT INTO leave_requests
    (
        user_id,
        leave_type,
        start_date,
        end_date,
        reason,
        status
    )
    VALUES
    (
        ?,
        ?,
        ?,
        ?,
        ?,
        'pending'
    )
");

$stmt->execute([
    $userId,
    $leaveType,
    $startDate,
    $endDate,
    $reason
]);

// الحصول على ID الطلب الجديد
$leaveId = $pdo->lastInsertId();

// إرسال الإشعار حسب دور مقدم الطلب

// إذا كان مقدم الطلب مدير
if($currentRole == 2)
{
    // جلب جميع الأدمن النشطين
    $stmt = $pdo->query("
        SELECT id
        FROM users
        WHERE role_id = 1
        AND status = 'active'
        AND deleted_at IS NULL
    ");

    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // إرسال إشعار لكل أدمن
    foreach($admins as $admin)
    {
        createNotification(
            $pdo,
            $admin['id'],
            "New Manager Leave Request",
            "Manager ".$user['name']." has submitted a new leave request."
        );
    }
}

// إذا كان مقدم الطلب موظف
elseif($currentRole == 3)
{
    // جلب مديري نفس القسم
    $stmt = $pdo->prepare("
        SELECT id
        FROM users
        WHERE role_id = 2
        AND department_id = ?
        AND status = 'active'
        AND deleted_at IS NULL
    ");

    $stmt->execute([
        $user['department_id']
    ]);

    $managers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // إرسال إشعار للمدير
    foreach($managers as $manager)
    {
       createNotification(
          $pdo,
          $manager['id'],
          "طلب إجازة جديد",
          "قام الموظف " . $user['name'] . " بتقديم طلب إجازة جديد."
       );
    }
}

// تسجيل النشاط
logActivity(
    $pdo,
    $userId,
    "Created Leave Request #".$leaveId
);

// العودة إلى صفحة الطلبات
header("Location: index.php?success=1");
exit;