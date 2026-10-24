<?php
require "../includes/auth_check.php";
require "../includes/permissions.php";
require "../config/db.php";
require "../vendor/autoload.php";

use Mpdf\Mpdf;

// التحقق من الصلاحيات
if(!hasPermission('attendance.view'))
{
    die("تم رفض الوصول");
}

if(!hasPermission('reports.export'))
{
    die("ليس لديك صلاحية تصدير التقارير");
}

// بيانات المستخدم الحالي
$userId = (int)$_SESSION['user_id'];

// جلب بيانات المستخدم من قاعدة البيانات
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

$userRole = (int)$currentUser['role_id'];
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

// إذا كان تاريخ البداية أكبر من النهاية
if($fromDate > $toDate)
{
    $temp = $fromDate;
    $fromDate = $toDate;
    $toDate = $temp;
}

// تحديد الموظفين حسب الدور
$whereUsers = [];
$paramsUsers = [];

if($userRole == 3)
{
    // الموظف يرى بياناته فقط
    $whereUsers[] = "users.id = ?";

    $paramsUsers[] = $userId;
}
elseif($userRole == 2)
{
    // المدير يرى موظفي قسمه فقط
    if($departmentId <= 0)
    {
        die("لم يتم تحديد قسم المدير");
    }

    $whereUsers[] = "users.department_id = ?";

    $paramsUsers[] = $departmentId;

    // التقرير خاص بالموظفين فقط
    $whereUsers[] = "users.role_id = 3";
}
elseif($userRole == 1)
{
    // الأدمن يرى جميع الموظفين
    $whereUsers[] = "users.role_id = 3";
}
else
{
    die("تم رفض الوصول");
}

// تجهيز شروط الموظفين
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

// تجهيز التقرير والإحصائيات
$reportRows = [];

$totalPresent = 0;
$totalLate = 0;
$totalAbsent = 0;
$totalLeave = 0;
$totalNotCheckedIn = 0;
$totalWorkMinutes = 0;
$totalLateMinutes = 0;

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

            $totalLeave++;
        }
        elseif($attendance)
        {
            if(
                $attendance['status'] === 'late' ||
                $lateMinutes > 0
            )
            {
                $displayStatus = 'متأخر';

                $totalLate++;
                $totalLateMinutes += $lateMinutes;
            }
            else
            {
                $displayStatus = 'حاضر';

                $totalPresent++;
            }

            $totalWorkMinutes += $workMinutes;
        }
        else
        {
            if($date < date('Y-m-d'))
            {
                $displayStatus = 'غائب';

                $totalAbsent++;
            }
            else
            {
                $displayStatus = 'لم يسجل';

                $totalNotCheckedIn++;
            }
        }

        $reportRows[] = [
            'date' => $date,
            'user_id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'department' => $user['department_name'] ?? 'غير محدد',
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'status' => $displayStatus,
            'late_minutes' => $lateMinutes,
            'work_minutes' => $workMinutes
        ];
    }
}

// تحويل الدقائق إلى ساعات ودقائق
function formatMinutesPdf($minutes)
{
    $minutes = (int)$minutes;

    $hours = floor($minutes / 60);
    $remainingMinutes = $minutes % 60;

    if($hours > 0)
    {
        if($remainingMinutes > 0)
        {
            return $hours . " ساعة و " . $remainingMinutes . " دقيقة";
        }

        return $hours . " ساعة";
    }

    return $remainingMinutes . " دقيقة";
}

// حماية النصوص المستخدمة داخل HTML
function pdfText($text)
{
    return htmlspecialchars(
        (string)$text,
        ENT_QUOTES,
        'UTF-8'
    );
}

// إنشاء HTML
$html = '
<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>

<meta charset="UTF-8">

<style>

body
{
    direction: rtl;
    font-family: dejavusans;
    font-size: 9px;
    color: #222;
}

.header
{
    text-align: center;
    margin-bottom: 15px;
}

.header h1
{
    font-size: 20px;
    margin: 0 0 7px 0;
}

.header p
{
    font-size: 10px;
    margin: 0;
}

.info
{
    border: 1px solid #d5d5d5;
    background-color: #f5f5f5;
    padding: 8px;
    margin-bottom: 12px;
    text-align: right;
}

.stats
{
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}

.stats td
{
    border: 1px solid #d5d5d5;
    padding: 7px;
    text-align: center;
}

.stats-title
{
    font-size: 8px;
}

.stats-value
{
    font-size: 13px;
    font-weight: bold;
}

.report
{
    width: 100%;
    border-collapse: collapse;
}

.report th
{
    background-color: #0d6efd;
    color: white;
    border: 1px solid #0b5ed7;
    padding: 6px;
    text-align: center;
    font-weight: bold;
}

.report td
{
    border: 1px solid #d8d8d8;
    padding: 5px;
    text-align: center;
}

.present
{
    color: #198754;
    font-weight: bold;
}

.late
{
    color: #b58105;
    font-weight: bold;
}

.absent
{
    color: #dc3545;
    font-weight: bold;
}

.leave
{
    color: #0b8fa3;
    font-weight: bold;
}

.not-checked
{
    color: #6c757d;
    font-weight: bold;
}

.footer
{
    margin-top: 15px;
    border-top: 1px solid #ddd;
    padding-top: 8px;
    text-align: center;
    font-size: 8px;
    color: #666;
}

</style>

</head>

<body>

<div class="header">

    <h1>تقرير الحضور والانصراف</h1>

    <p>
        تقرير تفصيلي لحضور الموظفين
    </p>

</div>

<div class="info">

    <strong>الفترة:</strong>
    ' . pdfText($fromDate) . '
    إلى
    ' . pdfText($toDate) . '

</div>

<table class="stats">

<tr>

<td>
    <div class="stats-title">حاضر</div>
    <div class="stats-value">' . $totalPresent . '</div>
</td>

<td>
    <div class="stats-title">متأخر</div>
    <div class="stats-value">' . $totalLate . '</div>
</td>

<td>
    <div class="stats-title">غائب</div>
    <div class="stats-value">' . $totalAbsent . '</div>
</td>

<td>
    <div class="stats-title">إجازة</div>
    <div class="stats-value">' . $totalLeave . '</div>
</td>

<td>
    <div class="stats-title">لم يسجل</div>
    <div class="stats-value">' . $totalNotCheckedIn . '</div>
</td>

</tr>

</table>

<table class="report">

<thead>

<tr>

<th>#</th>
<th>التاريخ</th>
<th>الموظف</th>
<th>القسم</th>
<th>وقت الدخول</th>
<th>وقت الخروج</th>
<th>الحالة</th>
<th>التأخير</th>
<th>وقت العمل</th>

</tr>

</thead>

<tbody>
';

// إضافة صفوف التقرير
foreach($reportRows as $index => $row)
{
    $statusClass = 'not-checked';

    if($row['status'] === 'حاضر')
    {
        $statusClass = 'present';
    }
    elseif($row['status'] === 'متأخر')
    {
        $statusClass = 'late';
    }
    elseif($row['status'] === 'غائب')
    {
        $statusClass = 'absent';
    }
    elseif($row['status'] === 'إجازة')
    {
        $statusClass = 'leave';
    }

    $html .= '
    <tr>

        <td>
            ' . ($index + 1) . '
        </td>

        <td>
            ' . pdfText($row['date']) . '
        </td>

        <td>
            ' . pdfText($row['name']) . '
        </td>

        <td>
            ' . pdfText($row['department']) . '
        </td>

        <td>
            ' .
            (
                !empty($row['check_in'])
                ? pdfText($row['check_in'])
                : '—'
            )
            . '
        </td>

        <td>
            ' .
            (
                !empty($row['check_out'])
                ? pdfText($row['check_out'])
                : '—'
            )
            . '
        </td>

        <td class="' . $statusClass . '">
            ' . pdfText($row['status']) . '
        </td>

        <td>
            ' .
            (
                $row['late_minutes'] > 0
                ? $row['late_minutes'] . ' دقيقة'
                : '—'
            )
            . '
        </td>

        <td>
            ' .
            (
                $row['work_minutes'] > 0
                ? formatMinutesPdf($row['work_minutes'])
                : '—'
            )
            . '
        </td>

    </tr>
    ';
}

$html .= '

</tbody>

</table>

<div class="footer">

    إجمالي وقت العمل:
    ' . formatMinutesPdf($totalWorkMinutes) . '

    |

    إجمالي دقائق التأخير:
    ' . $totalLateMinutes . ' دقيقة

</div>

</body>

</html>
';

// إنشاء mPDF
try
{
    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4-L',
        'default_font' => 'dejavusans',
        'autoLangToFont' => true,
        'autoScriptToLang' => true,
        'margin_top' => 15,
        'margin_bottom' => 15,
        'margin_left' => 10,
        'margin_right' => 10
    ]);

    // تحديد اتجاه الصفحة من اليمين إلى اليسار
    $mpdf->SetDirectionality('rtl');

    // كتابة محتوى HTML
    $mpdf->WriteHTML(
        $html,
        \Mpdf\HTMLParserMode::DEFAULT_MODE
    );

    // اسم الملف
    $fileName =
        "attendance_report_" .
        $fromDate .
        "_to_" .
        $toDate .
        ".pdf";

    // إخراج PDF
    $mpdf->Output(
        $fileName,
        \Mpdf\Output\Destination::DOWNLOAD
    );
}
catch(\Throwable $e)
{
    die(
        "حدث خطأ أثناء إنشاء ملف PDF: " .
        htmlspecialchars(
            $e->getMessage(),
            ENT_QUOTES,
            'UTF-8'
        )
    );
}

exit;