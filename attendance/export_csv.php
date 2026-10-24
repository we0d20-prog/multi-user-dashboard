<?php
require "../includes/auth_check.php";
require "../includes/permissions.php";
require "../config/db.php";

// يجب أن يملك المستخدم صلاحية مشاهدة الحضور
if(!hasPermission('attendance.view'))
{
    die("تم رفض الوصول");
}

// يجب أن يملك المستخدم صلاحية تصدير التقارير
if(!hasPermission('reports.export'))
{
    die("ليس لديك صلاحية تصدير التقارير");
}

// معلومات المستخدم الحالي
$userId = (int)$_SESSION['user_id'];
$userRole = (int)$_SESSION['user_role'];

// جلب القسم الحالي للمدير من قاعدة البيانات

// لا نعتمد فقط على department_id الموجود في Session
// حتى نتأكد من أن القسم الحالي للمستخدم هو القسم الموجود في قاعدة البيانات
$stmtCurrentUser = $pdo->prepare("
    SELECT
        id,
        role_id,
        department_id
    FROM users
    WHERE id = ?
    AND deleted_at IS NULL
    LIMIT 1
");

$stmtCurrentUser->execute([
    $userId
]);

$currentUser = $stmtCurrentUser->fetch(PDO::FETCH_ASSOC);

if(!$currentUser)
{
    die("المستخدم غير موجود");
}

$departmentId = (int)($currentUser['department_id'] ?? 0);

// تحديد الفترة الزمنية
$fromDate = isset($_GET['from_date']) && !empty($_GET['from_date'])
    ? $_GET['from_date']
    : date('Y-m-01');

$toDate = isset($_GET['to_date']) && !empty($_GET['to_date'])
    ? $_GET['to_date']
    : date('Y-m-d');

// التحقق من صيغة التاريخ
if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fromDate))
{
    $fromDate = date('Y-m-01');
}

if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $toDate))
{
    $toDate = date('Y-m-d');
}

// إذا كان تاريخ البداية أكبر من تاريخ النهاية
if($fromDate > $toDate)
{
    $temp = $fromDate;
    $fromDate = $toDate;
    $toDate = $temp;
}

// تحديد الموظفين حسب الدور
$whereUsers = [];
$paramsUsers = [];

// الموظف
if($userRole == 3)
{
    // الموظف يستطيع تصدير بياناته فقط
    $whereUsers[] = "users.id = ?";
    $paramsUsers[] = $userId;
}

// المدير
elseif($userRole == 2)
{
    // المدير يستطيع تصدير موظفي قسمه فقط
    // ولا يستطيع تصدير موظفين من قسم آخر
    if($departmentId <= 0)
    {
        die("لم يتم تحديد قسم المدير");
    }

    $whereUsers[] = "users.department_id = ?";

    $paramsUsers[] = $departmentId;

    // التقرير مخصص للموظفين فقط
    $whereUsers[] = "users.role_id = 3";
}

// الأدمن
elseif($userRole == 1)
{
    // الأدمن يستطيع تصدير جميع الموظفين
    $whereUsers[] = "users.role_id = 3";
}

// أي دور آخر
else
{
    die("تم رفض الوصول");
}

// تجهيز شروط المستخدمين
$whereUsersSql = "";

if(!empty($whereUsers))
{
    $whereUsersSql = " AND " . implode(" AND ", $whereUsers);
}

// جلب الموظفين
$stmtUsers = $pdo->prepare("
    SELECT
        users.id,
        users.name,
        users.email,
        users.department_id,
        departments.department_name
    FROM users

    LEFT JOIN departments
        ON users.department_id = departments.id

    WHERE users.deleted_at IS NULL

    $whereUsersSql

    ORDER BY users.name ASC
");

$stmtUsers->execute($paramsUsers);

$users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

// إنشاء قائمة الأيام
$dates = [];

$currentDate = new DateTime($fromDate);
$endDate = new DateTime($toDate);

while($currentDate <= $endDate)
{
    $dates[] = $currentDate->format('Y-m-d');

    $currentDate->modify('+1 day');
}

// جلب سجلات الحضور
$attendanceMap = [];

$stmtAttendance = $pdo->prepare("
    SELECT
        id,
        user_id,
        attendance_date,
        check_in,
        check_out,
        status,
        late_minutes,
        work_minutes
    FROM attendance
    WHERE attendance_date BETWEEN ? AND ?
");

$stmtAttendance->execute([
    $fromDate,
    $toDate
]);

$attendanceRows = $stmtAttendance->fetchAll(PDO::FETCH_ASSOC);

foreach($attendanceRows as $row)
{
    $key = $row['user_id'] . '_' . $row['attendance_date'];

    $attendanceMap[$key] = $row;
}

// جلب الإجازات المعتمدة
$leaveMap = [];

$stmtLeaves = $pdo->prepare("
    SELECT
        id,
        user_id,
        start_date,
        end_date,
        status
    FROM leave_requests
    WHERE status = 'approved'
    AND start_date <= ?
    AND end_date >= ?
");

$stmtLeaves->execute([
    $toDate,
    $fromDate
]);

$approvedLeaves = $stmtLeaves->fetchAll(PDO::FETCH_ASSOC);

foreach($approvedLeaves as $leave)
{
    $leaveStart = new DateTime($leave['start_date']);
    $leaveEnd = new DateTime($leave['end_date']);

    foreach($dates as $date)
    {
        $checkDate = new DateTime($date);

        if(
            $checkDate >= $leaveStart &&
            $checkDate <= $leaveEnd
        )
        {
            $key = $leave['user_id'] . '_' . $date;

            $leaveMap[$key] = true;
        }
    }
}

// إنشاء اسم الملف
$fileName = "attendance_report_" . $fromDate . "_to_" . $toDate . ".csv";

// إرسال Headers الخاصة بملف CSV
header('Content-Type: text/csv; charset=UTF-8');

header(
    'Content-Disposition: attachment; filename="' .
    $fileName .
    '"'
);

header('Pragma: no-cache');
header('Expires: 0');

// فتح ملف CSV في الذاكرة
$output = fopen('php://output', 'w');

// إضافة BOM لدعم اللغة العربية في Excel
fprintf($output, "\xEF\xBB\xBF");

// عنوان التقرير
fputcsv($output, [
    'تقرير الحضور'
]);

fputcsv($output, [
    'من تاريخ',
    $fromDate,
    'إلى تاريخ',
    $toDate
]);

// سطر فارغ
fputcsv($output, []);

// عناوين الأعمدة
fputcsv($output, [
    'المعرف',
    'التاريخ',
    'اسم الموظف',
    'البريد الإلكتروني',
    'القسم',
    'وقت الدخول',
    'وقت الخروج',
    'الحالة',
    'دقائق التأخير',
    'وقت العمل بالدقائق'
]);

// إضافة بيانات التقرير
foreach($users as $user)
{
    foreach($dates as $date)
    {
        $key = $user['id'] . '_' . $date;

        $attendance = isset($attendanceMap[$key])
            ? $attendanceMap[$key]
            : null;

        $isLeave = isset($leaveMap[$key]);

        $checkIn = $attendance['check_in'] ?? '';
        $checkOut = $attendance['check_out'] ?? '';

        $lateMinutes = isset($attendance['late_minutes'])
            ? (int)$attendance['late_minutes']
            : 0;

        $workMinutes = isset($attendance['work_minutes'])
            ? (int)$attendance['work_minutes']
            : 0;

        // تحديد الحالة
        if($isLeave)
        {
            $displayStatus = 'إجازة';
        }
        elseif($attendance)
        {
            if(
                $attendance['status'] === 'late' ||
                $lateMinutes > 0
            )
            {
                $displayStatus = 'متأخر';
            }
            else
            {
                $displayStatus = 'حاضر';
            }
        }
        else
        {
            if($date < date('Y-m-d'))
            {
                $displayStatus = 'غائب';
            }
            else
            {
                $displayStatus = 'لم يسجل';
            }
        }

        // إضافة الصف إلى CSV
        fputcsv($output, [
            $user['id'],
            $date,
            $user['name'],
            $user['email'],
            $user['department_name'] ?? 'غير محدد',
            $checkIn,
            $checkOut,
            $displayStatus,
            $lateMinutes,
            $workMinutes
        ]);
    }
}

// إغلاق الملف
fclose($output);

exit;