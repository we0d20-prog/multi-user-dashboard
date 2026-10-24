<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";
require "../includes/activity_log.php";
require "../includes/notification_helper.php";

// التحقق من صلاحية الموافقه على الإجازات
if(!hasPermission('leaves.approve'))
{
    die("Access Denied");
}

//استقبال رقم طلب الاجازه
$leaveId = isset($_GET['id'])
    ? (int)$_GET['id']
    : 0;

if($leaveId <= 0)
{
    die("Invalid Leave Request");
}        

// معرفة بيانات المستخدم الحالي
$currentUserId = $_SESSION['user_id'];
$currentRole = $_SESSION['user_role'];
$currentDepartment = $_SESSION['department_id'] ?? null;

//جلب بيانات طلب الاجازه
$stmt = $pdo->prepare("
    SELECT
        leave_requests.*,
        users.name AS employee_name,
        users.department_id
    FROM leave_requests
    JOIN users
    ON leave_requests.user_id = users.id
    WHERE leave_requests.id = ?
    LIMIT 1
");

$stmt->execute([
    $leaveId
]);

$leave = $stmt->fetch(PDO::FETCH_ASSOC);

//التاكد ان الطلب موجود
if(!$leave)
{
    die("Leave Request Not Found");
}

//حمايه المدير حسب القسم
if($currentRole == 2)
{
    if($leave['department_id'] != $currentDepartment)
    {
        die("Access Denied");
    }
}

//Pending التاكد ان الطلب ما زال
if($leave['status'] != 'pending')
{
    die("This leave request has already been processed");
}

//الموافقه على الطلب
$stmt = $pdo->prepare("
    UPDATE leave_requests
    SET status = 'approved'
    WHERE id = ?
");

$stmt->execute([
    $leaveId
]);

// إرسال إشعار للموظف
createNotification(
    $pdo,
    $leave['user_id'],
    "تمت الموافقة على طلب الإجازة",
    "تمت الموافقة على طلب الإجازة رقم #" . $leaveId . "."
);

//تسجيل النشاط
logActivity(
    $pdo,
    $currentUserId,
    "Approved Leave Request #".$leavedId
);

header("Location: index.php?success=approved");
exit;
