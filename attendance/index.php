<?php
require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

/* التحقق من صلاحية الحضور */
if(!hasPermission('attendance.view'))
{
    die("Access Denied");
}

$currentUserId = $_SESSION['user_id'];
$currentRole = $_SESSION['user_role'];
$currentDepartment = $_SESSION['department_id'] ?? null;

/* التاريخ المختار */
$selectedDate = $_GET['date'] ?? date('Y-m-d');

/* التأكد أن التاريخ صحيح */
$dateObject = DateTime::createFromFormat('Y-m-d',$selectedDate);

if(!$dateObject || $dateObject->format('Y-m-d') !== $selectedDate)
{
    $selectedDate = date('Y-m-d');
}

/* تحديد الموظفين حسب الصلاحية */
if($currentRole == 3)
{
    $stmt = $pdo->prepare("
        SELECT
            users.id,
            users.name,
            users.email,
            users.department_id,
            departments.department_name,
            attendance.id AS attendance_id,
            attendance.check_in,
            attendance.check_out,
            attendance.status,
            attendance.late_minutes,
            attendance.work_minutes
        FROM users
        LEFT JOIN departments
            ON users.department_id = departments.id
        LEFT JOIN attendance
            ON attendance.user_id = users.id
            AND attendance.attendance_date = ?
        WHERE users.id = ?
        AND users.deleted_at IS NULL
        LIMIT 1
    ");

    $stmt->execute([
        $selectedDate,
        $currentUserId
    ]);
}
elseif($currentRole == 1)
{
    $stmt = $pdo->prepare("
        SELECT
            users.id,
            users.name,
            users.email,
            users.department_id,
            departments.department_name,
            attendance.id AS attendance_id,
            attendance.check_in,
            attendance.check_out,
            attendance.status,
            attendance.late_minutes,
            attendance.work_minutes
        FROM users
        LEFT JOIN departments
            ON users.department_id = departments.id
        LEFT JOIN attendance
            ON attendance.user_id = users.id
            AND attendance.attendance_date = ?
        WHERE users.deleted_at IS NULL
        ORDER BY users.id DESC
    ");

    $stmt->execute([$selectedDate]);
}
elseif($currentRole == 2)
{
    if(empty($currentDepartment))
    {
        die("Manager Department Not Found");
    }

    $stmt = $pdo->prepare("
        SELECT
            users.id,
            users.name,
            users.email,
            users.department_id,
            departments.department_name,
            attendance.id AS attendance_id,
            attendance.check_in,
            attendance.check_out,
            attendance.status,
            attendance.late_minutes,
            attendance.work_minutes
        FROM users
        LEFT JOIN departments
            ON users.department_id = departments.id
        LEFT JOIN attendance
            ON attendance.user_id = users.id
            AND attendance.attendance_date = ?
        WHERE users.deleted_at IS NULL
        AND users.department_id = ?
        ORDER BY users.id DESC
    ");

    $stmt->execute([
        $selectedDate,
        $currentDepartment
    ]);
}
else
{
    die("Invalid User Role");
}

$attendanceRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*تحديد الإجازات المعتمدة في التاريخ المختار */
$approvedLeaves = [];

if(!empty($attendanceRecords))
{
    $userIds = array_column($attendanceRecords,'id');
    $placeholders = implode(',',array_fill(0,count($userIds),'?'));

    $leaveStmt = $pdo->prepare("
        SELECT
            user_id,
            start_date,
            end_date
        FROM leave_requests
        WHERE user_id IN ($placeholders)
        AND status = 'approved'
        AND start_date <= ?
        AND end_date >= ?
    ");

    $leaveParams = array_merge(
        $userIds,
        [$selectedDate,$selectedDate]
    );

    $leaveStmt->execute($leaveParams);

    $approvedLeaves = $leaveStmt->fetchAll(PDO::FETCH_ASSOC);
}

/* إنشاء قائمة الموظفين الموجودين في إجازة */
$employeesOnLeave = [];

foreach($approvedLeaves as $leave)
{
    $employeesOnLeave[(int)$leave['user_id']] = true;
}

/*إحصائيات الحضور */
$totalEmployees = count($attendanceRecords);
$presentCount = 0;
$lateCount = 0;
$absentCount = 0;
$leaveCount = 0;
$notCheckedInCount = 0;
$notCheckedOutCount = 0;

/* التاريخ الحالي */
$today = date('Y-m-d');

/* تحديد الحالة التلقائية لكل موظف */
foreach($attendanceRecords as &$record)
{
    $userId = (int)$record['id'];

    /* هل الموظف في إجازة معتمدة؟ */
    if(isset($employeesOnLeave[$userId]))
    {
        $record['calculated_status'] = 'leave';
        $leaveCount++;
        continue;
    }

    /* لديه تسجيل حضور */
    if(!empty($record['check_in']))
    {
        /* متأخر */
        if(
            isset($record['late_minutes']) &&
            (int)$record['late_minutes'] > 0
        )
        {
            $record['calculated_status'] = 'late';
            $lateCount++;
        }
        else
        {
            $record['calculated_status'] = 'present';
            $presentCount++;
        }

        /* دخل ولم يخرج */
        if(empty($record['check_out']))
        {
            $notCheckedOutCount++;
        }

        continue;
    }

    /* التاريخ الحالي ولم يسجل دخول */
    if($selectedDate == $today)
    {
        $record['calculated_status'] = 'not_checked_in';
        $notCheckedInCount++;
    }
    else
    {
        /* تاريخ سابق ولم يسجل */
        $record['calculated_status'] = 'absent';
        $absentCount++;
    }
}

unset($record);

/* بيانات حضور الموظف الحالي */
$myAttendance = null;

if($currentRole == 3)
{
    $stmtMyAttendance = $pdo->prepare("
        SELECT *
        FROM attendance
        WHERE user_id = ?
        AND attendance_date = ?
        LIMIT 1
    ");

    $stmtMyAttendance->execute([
        $currentUserId,
        date('Y-m-d')
    ]);

    $myAttendance = $stmtMyAttendance->fetch(PDO::FETCH_ASSOC);
}

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";
?>

<div class="content p-3 p-md-4">

    <!-- رأس الصفحة -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div class="d-flex align-items-center gap-3">

            <i class="fa fa-calendar-check fs-2 text-primary"></i>

            <div>

                <h2 class="fw-bold mb-0">
                    الحضور و الانصراف
                </h2>

                <p class="text-body-secondary mb-0 small">
                    سجل حضور الموظفين
                </p>

            </div>

        </div>

        <span class="badge text-bg-primary rounded-pill px-4 py-2 fs-6">

            <i class="fa fa-calendar me-1"></i>

            <?= htmlspecialchars($selectedDate); ?>

        </span>

    </div>

    <!-- رسالة حسب الصلاحية -->
    <?php if($currentRole == 1): ?>

        <div class="alert alert-primary d-flex align-items-center gap-2 border-0 shadow-sm rounded-4">

            <i class="fa fa-eye fs-4"></i>

            <span>
                أنت تشاهد حضور
                <strong>جميع الموظفين</strong>
                (صلاحية المدير).
            </span>

        </div>

    <?php elseif($currentRole == 2): ?>

        <div class="alert alert-info d-flex align-items-center gap-2 border-0 shadow-sm rounded-4">

            <i class="fa fa-eye fs-4"></i>

            <span>
                أنت تشاهد حضور موظفي
                <strong>قسمك</strong>
                فقط.
            </span>

        </div>

    <?php elseif($currentRole == 3): ?>

        <div class="alert alert-success d-flex align-items-center gap-2 border-0 shadow-sm rounded-4">

            <i class="fa fa-eye fs-4"></i>

            <span>
                أنت تشاهد حضورك الشخصي.
            </span>

        </div>

    <?php endif; ?>

    <!-- إحصائيات الحضور -->
    <div class="row g-3 mb-4">

        <!-- إجمالي الموظفين -->
        <div class="col-6 col-md-4 col-xl-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-body-secondary mb-1">
                                إجمالي الموظفين
                            </p>

                            <h3 class="fw-bold mb-0">
                                <?= $totalEmployees; ?>
                            </h3>

                        </div>

                        <div class="rounded-circle bg-primary-subtle text-primary p-3">

                            <i class="fa fa-users fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- حاضر -->
        <div class="col-6 col-md-4 col-xl-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-body-secondary mb-1">
                                حاضر
                            </p>

                            <h3 class="fw-bold mb-0 text-success">
                                <?= $presentCount; ?>
                            </h3>

                        </div>

                        <div class="rounded-circle bg-success-subtle text-success p-3">

                            <i class="fa fa-check-circle fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- متأخر -->
        <div class="col-6 col-md-4 col-xl-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-body-secondary mb-1">
                                متأخر
                            </p>

                            <h3 class="fw-bold mb-0 text-warning">
                                <?= $lateCount; ?>
                            </h3>

                        </div>

                        <div class="rounded-circle bg-warning-subtle text-warning p-3">

                            <i class="fa fa-clock fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- غائب -->
        <div class="col-6 col-md-4 col-xl-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-body-secondary mb-1">
                                غائب
                            </p>

                            <h3 class="fw-bold mb-0 text-danger">
                                <?= $absentCount; ?>
                            </h3>

                        </div>

                        <div class="rounded-circle bg-danger-subtle text-danger p-3">

                            <i class="fa fa-times-circle fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- إجازة -->
        <div class="col-6 col-md-4 col-xl-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-body-secondary mb-1">
                                إجازة
                            </p>

                            <h3 class="fw-bold mb-0 text-info">
                                <?= $leaveCount; ?>
                            </h3>

                        </div>

                        <div class="rounded-circle bg-info-subtle text-info p-3">

                            <i class="fa fa-plane fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- لم يسجل دخول -->
        <div class="col-6 col-md-4 col-xl-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-body-secondary mb-1">
                                لم يسجل الدخول
                            </p>

                            <h3 class="fw-bold mb-0 text-secondary">
                                <?= $notCheckedInCount; ?>
                            </h3>

                        </div>

                        <div class="rounded-circle bg-secondary-subtle text-secondary p-3">

                            <i class="fa fa-sign-in fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- لم يسجل خروج -->
        <div class="col-6 col-md-4 col-xl-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-body-secondary mb-1">
                                لم يسجل الخروج
                            </p>

                            <h3 class="fw-bold mb-0 text-warning">
                                <?= $notCheckedOutCount; ?>
                            </h3>

                        </div>

                        <div class="rounded-circle bg-warning-subtle text-warning p-3">

                            <i class="fa fa-sign-out fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- فلترة التاريخ -->
    <?php if((int)$_SESSION['user_role'] !== 3): ?>

        <div class="card shadow-sm border-0 rounded-4 mb-4">

            <div class="card-header bg-body-tertiary border-bottom-0 py-3">

                <h5 class="mb-0 fw-semibold">

                    <i class="fa fa-filter me-2"></i>

                    فلترة الحضور

                </h5>

            </div>

            <div class="card-body">

                <form
                    method="GET"
                    action="index.php"
                    class="row g-3 align-items-end"
                >

                    <div class="col-md-5">

                        <label class="form-label fw-semibold">
                            اختر التاريخ
                        </label>

                        <input
                            type="date"
                            name="date"
                            class="form-control form-control-lg rounded-3"
                            value="<?= htmlspecialchars($selectedDate); ?>"
                            required
                        >

                    </div>

                    <div class="col-md-3">

                        <button
                            type="submit"
                            class="btn btn-primary btn-lg w-100 rounded-pill"
                        >

                            <i class="fa fa-search me-1"></i>

                            فلتر

                        </button>

                    </div>

                    <div class="col-md-3">

                        <a
                            href="index.php"
                            class="btn btn-outline-secondary btn-lg w-100 rounded-pill"
                        >

                            <i class="fa fa-calendar-day me-1"></i>

                            اليوم

                        </a>

                    </div>

                </form>

            </div>

        </div>

    <?php endif; ?>

    <!-- أزرار تسجيل الحضور للموظف -->
    <?php if($currentRole == 3): ?>

        <div class="card shadow-sm border-0 rounded-4 mb-4">

            <div class="card-header bg-body-tertiary border-bottom-0 py-3">

                <h5 class="mb-0 fw-semibold">

                    <i class="fa fa-clock me-2"></i>

                    إجراءات الحضور

                </h5>

            </div>

            <div class="card-body">

                <?php if(!$myAttendance): ?>

                    <p class="text-body-secondary">

                        <i class="fa fa-info-circle me-1"></i>

                        لم تقم بتسجيل الدخول اليوم.

                    </p>

                    <a
                        href="check_in.php"
                        class="btn btn-success btn-lg rounded-pill px-5"
                    >

                        <i class="fa fa-sign-in me-2"></i>

                        تسجيل الدخول

                    </a>

                <?php elseif(empty($myAttendance['check_out'])): ?>

                    <div class="alert alert-success border-0 rounded-4 d-flex align-items-center gap-2">

                        <i class="fa fa-check-circle fs-4"></i>

                        <div>

                            تم تسجيل الدخول بنجاح.

                            <br>

                            وقت الدخول:

                            <strong>
                                <?= htmlspecialchars($myAttendance['check_in']); ?>
                            </strong>

                        </div>

                    </div>

                    <form
                        action="check_out.php"
                        method="POST"
                        class="d-inline"
                    >

                        <input
                            type="hidden"
                            name="action"
                            value="check_out"
                        >

                        <button
                            type="submit"
                            class="btn btn-danger btn-lg rounded-pill px-5"
                        >

                            <i class="fa fa-sign-out me-2"></i>

                            تسجيل الخروج

                        </button>

                    </form>

                <?php else: ?>

                    <?php
                    $myWorkMinutes = (int)($myAttendance['work_minutes'] ?? 0);
                    $myWorkHours = floor($myWorkMinutes / 60);
                    $myWorkRemainingMinutes = $myWorkMinutes % 60;
                    ?>

                    <div class="alert alert-info border-0 rounded-4 d-flex align-items-center gap-2">

                        <i class="fa fa-check-double fs-4"></i>

                        <div>

                     تم تسجيل حضورك اليوم بالكامل.

                            <br>

                            <strong>دخول:</strong>
                            <?= htmlspecialchars($myAttendance['check_in']); ?>

                            <br>

                            <strong>خروج:</strong>
                            <?= htmlspecialchars($myAttendance['check_out']); ?>

                            <br>

                            <strong>وقت العمل:</strong>
                            <?= $myWorkHours; ?>س
                            <?= $myWorkRemainingMinutes; ?>د

                            </div>

                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            <?php endif; ?>

    <!-- جدول الحضور -->
    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-header bg-body-tertiary border-bottom-0 py-3">

            <h5 class="mb-0 fw-semibold">

                <i class="fa fa-table me-2"></i>

                جدول الحضور -
                <?= htmlspecialchars($selectedDate); ?>

            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover table-striped align-middle mb-0">

                    <thead class="table-primary">

                        <tr>

                            <th>#</th>
                            <th>الموظف</th>
                            <th>البريد</th>
                            <th>القسم</th>
                            <th>دخول</th>
                            <th>خروج</th>
                            <th>الحالة</th>
                            <th>تأخير</th>
                            <th>وقت العمل</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if(empty($attendanceRecords)): ?>

                        <tr>

                            <td
                                colspan="9"
                                class="text-center py-5 text-body-secondary"
                            >

                                <i class="fa fa-users fs-1 d-block mb-2"></i>

                                لا يوجد موظفون

                            </td>

                        </tr>

                    <?php else: ?>

                        <?php foreach($attendanceRecords as $record): ?>

                            <tr>

                                <td>
                                    <?= (int)$record['id']; ?>
                                </td>

                                <td>
                                    <strong>
                                        <?= htmlspecialchars($record['name']); ?>
                                    </strong>
                                </td>

                                <td>
                                    <?= htmlspecialchars($record['email']); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($record['department_name'] ?? 'لا يوجد'); ?>
                                </td>

                                <!-- وقت الدخول -->
                                <td>

                                    <?php if(!empty($record['check_in'])): ?>

                                        <span class="badge text-bg-success rounded-pill p-2 px-3">

                                            <?= htmlspecialchars($record['check_in']); ?>

                                        </span>

                                    <?php else: ?>

                                        <span class="text-body-secondary">
                                            --
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <!-- وقت الخروج -->
                                <td>

                                    <?php if(!empty($record['check_out'])): ?>

                                        <span class="badge text-bg-danger rounded-pill p-2 px-3">

                                            <?= htmlspecialchars($record['check_out']); ?>

                                        </span>

                                    <?php else: ?>

                                        <span class="text-body-secondary">
                                            --
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <!-- الحالة -->
                                <td>

                                    <?php

                                    $status = $record['calculated_status'];

                                    if($status == 'present')
                                    {
                                        $statusClass = 'text-bg-success';
                                        $statusLabel = 'حاضر';
                                        $statusIcon = 'fa-check-circle';
                                    }
                                    elseif($status == 'late')
                                    {
                                        $statusClass = 'text-bg-warning';
                                        $statusLabel = 'متأخر';
                                        $statusIcon = 'fa-clock';
                                    }
                                    elseif($status == 'leave')
                                    {
                                        $statusClass = 'text-bg-info';
                                        $statusLabel = 'إجازة';
                                        $statusIcon = 'fa-plane';
                                    }
                                    elseif($status == 'absent')
                                    {
                                        $statusClass = 'text-bg-danger';
                                        $statusLabel = 'غائب';
                                        $statusIcon = 'fa-times-circle';
                                    }
                                    elseif($status == 'not_checked_in')
                                    {
                                        $statusClass = 'text-bg-secondary';
                                        $statusLabel = 'لم يسجل';
                                        $statusIcon = 'fa-sign-in';
                                    }
                                    else
                                    {
                                        $statusClass = 'text-bg-secondary';
                                        $statusLabel = 'غير محدد';
                                        $statusIcon = 'fa-question-circle';
                                    }

                                    ?>

                                    <span class="badge <?= $statusClass; ?> rounded-pill px-3 py-2">

                                        <i class="fa <?= $statusIcon; ?> me-1"></i>

                                        <?= $statusLabel; ?>

                                    </span>

                                </td>

                                <!-- التأخير -->
                                <td>

                                    <?php if(!empty($record['late_minutes'])): ?>

                                        <span class="text-warning fw-semibold">

                                            <?= (int)$record['late_minutes']; ?>

                                            دقيقة

                                        </span>

                                    <?php else: ?>

                                        0 دقيقة

                                    <?php endif; ?>

                                </td>

                                <!-- وقت العمل -->
                                <td>

                                    <?php

                                    if(!empty($record['work_minutes']))
                                    {
                                        $minutes = (int)$record['work_minutes'];

                                        $hours = floor($minutes / 60);

                                        $mins = $minutes % 60;
                                    ?>

                                        <span class="fw-semibold">

                                            <?= $hours; ?>س
                                            <?= $mins; ?>د

                                        </span>

                                    <?php
                                    }
                                    else
                                    {
                                    ?>

                                        <span class="text-body-secondary">
                                            --
                                        </span>

                                    <?php
                                    }

                                    ?>

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

<?php include "../includes/footer.php"; ?>