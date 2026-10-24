<?php
require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";
require "../includes/activity_log.php";

// الأدمن فقط يستطيع حذف الإعلانات
if($_SESSION['user_role'] != 1)
{
    die("Access Denied");
}

// التحقق من صلاحية الحذف
if(!hasPermission('announcements.delete'))
{
    die("Access Denied");
}

// استقبال رقم الإعلان
$announcementId = isset($_GET['id'])
    ? (int)$_GET['id']
    : 0;

// التحقق من الرقم
if($announcementId <= 0)
{
    die("Invalid Announcement ID");
}

// التأكد أن الإعلان موجود
$stmt = $pdo->prepare("
    SELECT
        id,
        title
    FROM announcements
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([
    $announcementId
]);

$announcement = $stmt->fetch(PDO::FETCH_ASSOC);

// إذا لم يوجد الإعلان
if(!$announcement)
{
    die("Announcement Not Found");
}

try
{
    // بدء Transaction
    $pdo->beginTransaction();

    // حذف الإعلان
    $stmt = $pdo->prepare("
        DELETE FROM announcements
        WHERE id = ?
    ");

    $stmt->execute([
        $announcementId
    ]);

    // تسجيل عملية الحذف
    logActivity(
        $pdo,
        $_SESSION['user_id'],
        "Deleted Announcement #".$announcementId." - ".$announcement['title']
    );

    // تأكيد العملية
    $pdo->commit();

    // العودة إلى صفحة الإعلانات
    header(
        "Location: index.php?success=deleted"
    );

    exit;
}
catch(Exception $e)
{
    // إلغاء العملية في حالة حدوث خطأ
    if($pdo->inTransaction())
    {
        $pdo->rollBack();
    }

    die("An error occurred while deleting the announcement.");
}