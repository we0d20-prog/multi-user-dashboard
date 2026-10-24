<?php
require "../includes/auth_check.php";
require "../includes/permissions.php";
require "../config/db.php";

if(!hasPermission('attendance.view'))
{
    die("تم رفض الوصول");
}

$userId = (int)$_SESSION['user_id'];
$userRole = (int)$_SESSION['user_role'];
$departmentId = isset($_SESSION['department_id']) ? (int)$_SESSION['department_id'] : 0;

$fromDate = isset($_GET['from_date']) && !empty($_GET['from_date'])
    ? $_GET['from_date']
    : date('Y-m-01');

$toDate = isset($_GET['to_date']) && !empty($_GET['to_date'])
    ? $_GET['to_date']
    : date('Y-m-d');

if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fromDate))
{
    $fromDate = date('Y-m-01');
}

if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $toDate))
{
    $toDate = date('Y-m-d');
}

if($fromDate > $toDate)
{
    $temp = $fromDate;
    $fromDate = $toDate;
    $toDate = $temp;
}

/*
|--------------------------------------------------------------------------
| تحديد الموظفين حسب الدور
|--------------------------------------------------------------------------
*/

$whereUsers = [];
$paramsUsers = [];

if($userRole == 3)
{
    // الموظف يرى سجلاته فقط
    $whereUsers[] = "users.id = ?";
    $paramsUsers[] = $userId;
}
elseif($userRole == 2)
{
    // المدير يرى موظفي قسمه فقط
    $whereUsers[] = "users.department_id = ?";
    $paramsUsers[] = $departmentId;

    // التقرير مخصص للموظفين
    $whereUsers[] = "users.role_id = 3";
}
else
{
    // الأدمن يرى جميع الموظفين
    $whereUsers[] = "users.role_id = 3";
}

$whereUsersSql = "";

if(!empty($whereUsers))
{
    $whereUsersSql = " AND " . implode(" AND ", $whereUsers);
}

/*
|--------------------------------------------------------------------------
| جلب الموظفين
|--------------------------------------------------------------------------
*/

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
    WHERE 1 = 1
    AND users.deleted_at IS NULL
    $whereUsersSql
    ORDER BY users.name ASC
");

$stmtUsers->execute($paramsUsers);

$users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| إنشاء قائمة الأيام
|--------------------------------------------------------------------------
*/

$dates = [];

$currentDate = new DateTime($fromDate);
$endDate = new DateTime($toDate);

while($currentDate <= $endDate)
{
    $dates[] = $currentDate->format('Y-m-d');
    $currentDate->modify('+1 day');
}

/*
|--------------------------------------------------------------------------
| جلب سجلات الحضور
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| جلب الإجازات المعتمدة
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| تجهيز التقرير
|--------------------------------------------------------------------------
*/

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

        $checkIn = $attendance['check_in'] ?? null;
        $checkOut = $attendance['check_out'] ?? null;

        $lateMinutes = isset($attendance['late_minutes'])
            ? (int)$attendance['late_minutes']
            : 0;

        $workMinutes = isset($attendance['work_minutes'])
            ? (int)$attendance['work_minutes']
            : 0;

        /*
        |--------------------------------------------------------------------------
        | تحديد الحالة
        |--------------------------------------------------------------------------
        */

        if($isLeave)
        {
            $displayStatus = 'إجازة';
            $statusClass = 'info';

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
                $statusClass = 'warning';

                $totalLate++;
                $totalLateMinutes += $lateMinutes;
            }
            else
            {
                $displayStatus = 'حاضر';
                $statusClass = 'success';

                $totalPresent++;
            }

            $totalWorkMinutes += $workMinutes;
        }
        else
        {
            if($date < date('Y-m-d'))
            {
                $displayStatus = 'غائب';
                $statusClass = 'danger';

                $totalAbsent++;
            }
            else
            {
                $displayStatus = 'لم يسجل';
                $statusClass = 'secondary';

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
            'status_class' => $statusClass,
            'late_minutes' => $lateMinutes,
            'work_minutes' => $workMinutes
        ];
    }
}

/*
|--------------------------------------------------------------------------
| تحويل دقائق العمل إلى ساعات ودقائق
|--------------------------------------------------------------------------
*/

function formatMinutes($minutes)
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

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";
?>

<div class="content p-3 p-md-4">

    <!-- عنوان التقرير -->

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                <i class="fa-solid fa-chart-bar me-2"></i>
                تقرير الحضور
            </h2>

            <p class="text-body-secondary mb-0">
                تقرير تفصيلي لحضور الموظفين خلال الفترة المحددة
            </p>

        </div>

    </div>

    <!-- فلترة التاريخ -->

    <div class="card shadow-sm border-0 rounded-4 mb-4">

        <div class="card-body p-4">

            <form method="GET">

                <div class="row g-3 align-items-end">

                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            من تاريخ
                        </label>

                        <input
                            type="date"
                            name="from_date"
                            class="form-control"
                            value="<?= htmlspecialchars($fromDate); ?>"
                            required
                        >

                    </div>

                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            إلى تاريخ
                        </label>

                        <input
                            type="date"
                            name="to_date"
                            class="form-control"
                            value="<?= htmlspecialchars($toDate); ?>"
                            required
                        >

                    </div>

                    <div class="col-md-4">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            <i class="fa fa-search me-2"></i>
                            عرض التقرير
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- الإحصائيات -->

    <div class="row g-3 mb-4">

        <div class="col-md-3 col-lg">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-body-secondary small">
                                حاضر
                            </div>

                            <h3 class="fw-bold mb-0">
                                <?= $totalPresent; ?>
                            </h3>

                        </div>

                        <i class="fa fa-check-circle text-success fs-2"></i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3 col-lg">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-body-secondary small">
                                متأخر
                            </div>

                            <h3 class="fw-bold mb-0">
                                <?= $totalLate; ?>
                            </h3>

                        </div>

                        <i class="fa fa-clock-o text-warning fs-2"></i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3 col-lg">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-body-secondary small">
                                غائب
                            </div>

                            <h3 class="fw-bold mb-0">
                                <?= $totalAbsent; ?>
                            </h3>

                        </div>

                        <i class="fa fa-user-times text-danger fs-2"></i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3 col-lg">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-body-secondary small">
                                إجازة
                            </div>

                            <h3 class="fw-bold mb-0">
                                <?= $totalLeave; ?>
                            </h3>

                        </div>

                        <i class="fa fa-calendar text-info fs-2"></i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-3 col-lg">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-body-secondary small">
                                دقائق التأخير
                            </div>

                            <h3 class="fw-bold mb-0">
                                <?= $totalLateMinutes; ?>
                            </h3>

                        </div>

                        <i class="fa fa-hourglass-half text-warning fs-2"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <?php if(hasPermission('reports.export')): ?>

    <div class="mb-4 d-flex gap-2 flex-wrap">

        <a href="export_csv.php?from_date=<?= $fromDate; ?>&to_date=<?= $toDate; ?>"
           class="btn btn-success rounded-pill">

            <i class="fa fa-file-excel-o me-2"></i>
            تصدير CSV

        </a>

        <a href="export_pdf.php?from_date=<?= $fromDate; ?>&to_date=<?= $toDate; ?>"
           class="btn btn-danger rounded-pill">

            <i class="fa fa-file-pdf-o me-2"></i>
            تصدير PDF

        </a>

    </div>

    <?php endif; ?>

    <!-- معلومات الفترة -->
    <div class="alert alert-info border-0 rounded-4 shadow-sm">

        <i class="fa fa-calendar me-2"></i>

        التقرير من

        <strong>
            <?= htmlspecialchars($fromDate); ?>
        </strong>

        إلى

        <strong>
            <?= htmlspecialchars($toDate); ?>
        </strong>

        <span class="ms-2">

            |

            إجمالي وقت العمل:

            <strong>
                <?= formatMinutes($totalWorkMinutes); ?>
            </strong>

        </span>

    </div>

    <!-- جدول التقرير -->
    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    id="attendanceReportTable"
                    class="table table-hover align-middle mb-0"
                >

                    <thead class="table-primary">

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

                    <?php if(empty($reportRows)): ?>

                        <tr>

                            <td
                                colspan="9"
                                class="text-center py-5 text-body-secondary"
                            >

                                <i class="fa fa-inbox fs-1 d-block mb-3"></i>

                                لا توجد بيانات لعرضها.

                            </td>

                        </tr>

                    <?php else: ?>

                        <?php foreach($reportRows as $index => $row): ?>

                            <tr>

                                <td>
                                    <?= $index + 1; ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['date']); ?>
                                </td>

                                <td>

                                    <div class="fw-semibold">
                                        <?= htmlspecialchars($row['name']); ?>
                                    </div>

                                    <small class="text-body-secondary">
                                        <?= htmlspecialchars($row['email']); ?>
                                    </small>

                                </td>

                                <td>
                                    <?= htmlspecialchars($row['department']); ?>
                                </td>

                                <td>

                                    <?php if(!empty($row['check_in'])): ?>

                                        <span class="text-success fw-semibold">
                                            <?= htmlspecialchars($row['check_in']); ?>
                                        </span>

                                    <?php else: ?>

                                        <span class="text-body-secondary">
                                            —
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <?php if(!empty($row['check_out'])): ?>

                                        <span class="text-danger fw-semibold">
                                            <?= htmlspecialchars($row['check_out']); ?>
                                        </span>

                                    <?php else: ?>

                                        <span class="text-body-secondary">
                                            —
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <span class="badge text-bg-<?= htmlspecialchars($row['status_class']); ?>">

                                        <?= htmlspecialchars($row['status']); ?>

                                    </span>

                                </td>

                                <td>

                                    <?php if($row['late_minutes'] > 0): ?>

                                        <span class="text-warning fw-semibold">
                                            <?= $row['late_minutes']; ?> دقيقة
                                        </span>

                                    <?php else: ?>

                                        <span class="text-body-secondary">
                                            —
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <?php if($row['work_minutes'] > 0): ?>

                                        <?= formatMinutes($row['work_minutes']); ?>

                                    <?php else: ?>

                                        <span class="text-body-secondary">
                                            —
                                        </span>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script>

$(document).ready(function(){

    $('#attendanceReportTable').DataTable({

        pageLength: 25,

        ordering: true,

        searching: true,

        paging: true,

        order: [
            [1, 'desc']
        ],

        language: {

            search: "بحث:",

            lengthMenu: "عرض _MENU_ سجل",

            info: "عرض _START_ إلى _END_ من أصل _TOTAL_ سجل",

            infoEmpty: "لا توجد سجلات",

            zeroRecords: "لا توجد نتائج مطابقة",

            paginate: {
                first: "الأول",
                last: "الأخير",
                next: "التالي",
                previous: "السابق"
            }

        }

    });

});

</script>

<?php include "../includes/footer.php"; ?>