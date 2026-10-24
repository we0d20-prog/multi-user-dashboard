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

/* بيانات المستخدم الحالي */
$userId = (int)$_SESSION['user_id'];
$userRole = (int)$_SESSION['user_role'];

/* الموظف فقط يستطيع تسجيل الحضور */
if($userRole != 3)
{
    include "../includes/header.php";
    include "../includes/navbar.php";
    include "../includes/sidebar.php";
?>
    <div class="content p-4">
        <div class="alert alert-danger shadow-sm border-0 rounded-4 d-flex align-items-center gap-3" role="alert">
            <i class="fa fa-exclamation-triangle fs-2"></i>
            <div>
                <h5 class="alert-heading">وصول ممنوع</h5>
                <p class="mb-0">فقط الموظفون يمكنهم تسجيل الحضور.</p>
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

/* التاريخ والوقت الحالي */
$today = date('Y-m-d');
$currentTime = date('H:i:s');

/* وقت بداية الدوام */
$workStartTime = '08:00:00';

/* التأكد من عدم وجود تسجيل حضور سابق اليوم */
$stmt = $pdo->prepare("
    SELECT
        id,
        check_in,
        check_out,
        status
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

/* إذا كان هناك سجل حضور بالفعل */
if($attendance)
{
    include "../includes/header.php";
    include "../includes/navbar.php";
    include "../includes/sidebar.php";
?>
    <div class="content p-4">
        <div class="alert alert-warning shadow-sm border-0 rounded-4 d-flex align-items-center gap-3" role="alert">
            <i class="fa fa-info-circle fs-2"></i>
            <div>
                <h5 class="alert-heading">تم التسجيل مسبقاً</h5>
                <p class="mb-0">
                    لقد قمت بتسجيل الدخول اليوم بالفعل.
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

/* حساب التأخير */
$currentSeconds = strtotime($currentTime);
$workStartSeconds = strtotime($workStartTime);

$lateMinutes = 0;
$status = 'present';

/* إذا كان الموظف متأخراً عن بداية الدوام */
if($currentSeconds > $workStartSeconds)
{
    $lateSeconds = $currentSeconds - $workStartSeconds;
    $lateMinutes = floor($lateSeconds / 60);
    $status = 'late';
}

/* إنشاء سجل الحضور */
$stmt = $pdo->prepare("
    INSERT INTO attendance
    (
        user_id,
        attendance_date,
        check_in,
        status,
        late_minutes,
        work_minutes,
        source
    )
    VALUES
    (
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?
    )
");

$stmt->execute([
    $userId,
    $today,
    $currentTime,
    $status,
    $lateMinutes,
    0,
    'system'
]);

/* الحصول على رقم سجل الحضور */
$attendanceId = $pdo->lastInsertId();

/* تسجيل العملية في Activity Log */
logActivity(
    $pdo,
    $userId,
    "تم تسجيل حضور الموظف - سجل رقم ".$attendanceId
);

/* العودة إلى صفحة الحضور */
header("Location: index.php?success=checkin");
exit;