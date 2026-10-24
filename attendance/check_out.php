<?php
require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";
require "../includes/activity_log.php";

/* التحقق من صلاحية الحضور */
if(!hasPermission('attendance.view'))
{
    die("Access Denied");
}

/* الموظف فقط يستطيع تسجيل الخروج */
$userId = (int)$_SESSION['user_id'];
$userRole = (int)$_SESSION['user_role'];

if($userRole != 3)
{
    include "../includes/header.php";
    include "../includes/navbar.php";
    include "../includes/sidebar.php";
?>
    <div class="content p-4">
        <div class="alert alert-danger shadow-sm border-0 rounded-4 d-flex align-items-center gap-3">
            <i class="fa fa-exclamation-triangle fs-2"></i>
            <div>
                <h5 class="alert-heading">وصول ممنوع</h5>
                <p class="mb-0">فقط الموظفون يمكنهم تسجيل الخروج.</p>
            </div>
        </div>
        <a href="index.php" class="btn btn-secondary rounded-pill px-4">
            <i class="fa fa-arrow-left me-2"></i>
            العودة
        </a>
    </div>
<?php
    include "../includes/footer.php";
    exit;
}

/* يجب أن يكون الطلب POST */
if($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    die("Invalid Request");
}

/* التأكد من تنفيذ عملية تسجيل الخروج */
if(
    !isset($_POST['action']) ||
    $_POST['action'] !== 'check_out'
)
{
    die("Invalid Action");
}

/* التاريخ والوقت الحالي */
$today = date('Y-m-d');
$currentTime = date('H:i:s');

/* جلب سجل حضور اليوم */
$stmt = $pdo->prepare("
    SELECT
        id,
        check_in,
        check_out
    FROM attendance
    WHERE user_id = ?
    AND attendance_date = ?
    LIMIT 1
");

$stmt->execute([
    $userId,
    $today
]);

$attendance = $stmt->fetch(PDO::FETCH_ASSOC);

/* لا يوجد تسجيل حضور */
if(!$attendance)
{
    include "../includes/header.php";
    include "../includes/navbar.php";
    include "../includes/sidebar.php";
?>
    <div class="content p-4">
        <div class="alert alert-warning shadow-sm border-0 rounded-4 d-flex align-items-center gap-3">
            <i class="fa fa-info-circle fs-2"></i>
            <div>
                <h5 class="alert-heading">لم يتم تسجيل الحضور</h5>
                <p class="mb-0">لا يوجد سجل حضور لهذا اليوم.</p>
            </div>
        </div>
        <a href="index.php" class="btn btn-secondary rounded-pill px-4">
            <i class="fa fa-arrow-left me-2"></i>
            العودة
        </a>
    </div>
<?php
    include "../includes/footer.php";
    exit;
}

/* لا يوجد وقت دخول */
if(empty($attendance['check_in']))
{
    die("Check In Time Not Found");
}

/* تم تسجيل الخروج مسبقاً */
if(!empty($attendance['check_out']))
{
    include "../includes/header.php";
    include "../includes/navbar.php";
    include "../includes/sidebar.php";
?>
    <div class="content p-4">
        <div class="alert alert-warning shadow-sm border-0 rounded-4 d-flex align-items-center gap-3">
            <i class="fa fa-info-circle fs-2"></i>
            <div>
                <h5 class="alert-heading">تم تسجيل الخروج مسبقاً</h5>
                <p class="mb-0">
                    لقد قمت بتسجيل الخروج من الدوام اليوم بالفعل.
                </p>
            </div>
        </div>
        <a href="index.php" class="btn btn-secondary rounded-pill px-4">
            <i class="fa fa-arrow-left me-2"></i>
            العودة
        </a>
    </div>
<?php
    include "../includes/footer.php";
    exit;
}

/* حساب وقت العمل بالدقائق */
$checkInTimestamp = strtotime($attendance['check_in']);
$checkOutTimestamp = strtotime($currentTime);

$workMinutes = (int)round(
    ($checkOutTimestamp - $checkInTimestamp) / 60
);

/* منع ظهور قيمة سالبة في حالة وجود مشكلة في الوقت */
if($workMinutes < 0)
{
    $workMinutes = 0;
}

/* تحديث سجل الحضور */
$stmt = $pdo->prepare("
    UPDATE attendance
    SET
        check_out = ?,
        work_minutes = ?
    WHERE id = ?
");

$stmt->execute([
    $currentTime,
    $workMinutes,
    $attendance['id']
]);

/* تسجيل العملية في Activity Log */
logActivity(
    $pdo,
    $userId,
    "تم تسجيل خروج الموظف - سجل رقم ".$attendance['id']." - وقت العمل ".$workMinutes." دقيقة"
);

/* العودة إلى صفحة الحضور */
header("Location: index.php?success=checkout");
exit;