<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

//التحقق من صلاحيه مشاهده الاجازات
if(!hasPermission('leaves.view'))
{
    die("Access Denied");
}

//استقبال رقم طلب الاجازه
$leaveId = isset($_GET['id'])
    ? (int)$_GET['id']
    : 0;

//التاكد من وجود رقم الطلب
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
        users.email AS employee_email,
        users.department_id,
        departments.department_name
    FROM leave_requests
    JOIN users
    ON leave_requests.user_id = users.id
    LEFT JOIN departments
    ON users.department_id = departments.id
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

//مشاهده طلباته فقط Employee
if($currentRole == 3)
{
    if($leave['user_id'] != $currentUserId)
    {
        die("Acccess Denied");
    }
}

//يستطيع مشاهده طلبات قسمه فقط Manager
elseif($currentRole == 2)
{
    if($leave['department_id'] != $currentDepartment)
    {
        die("Access Denied");
    }    
}

//يستطيع مشاهده جميع الطلبات Admin
elseif($currentRole == 1)
{
    //لانحتاج الى تقييد الطلب
}  

//غير معروف Role
else
{
    die("Access Denied");
}    

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

?>

<div class="content p-3 p-md-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-2">
            <i class="fa fa-file-text-o fs-1 text-primary"></i>
            <div>
                <h2 class="fw-bold mb-0">طلب إجازة #<?= $leave['id']; ?></h2>
                <p class="text-body-secondary small mb-0">عرض تفاصيل طلب الإجازة</p>
            </div>
        </div>
        <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4 d-flex align-items-center gap-2">
            <i class="fa fa-arrow-left"></i> رجوع
        </a>
    </div>

    <!-- معلومات الموظف -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-body-tertiary py-3 border-bottom-0">
            <h5 class="mb-0 fw-semibold">
                <i class="fa fa-user-circle me-2 text-secondary"></i> معلومات الموظف
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="d-flex flex-column">
                        <span class="text-body-secondary small fw-semibold">الاسم</span>
                        <span class="fw-semibold"><?= htmlspecialchars($leave['employee_name']); ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column">
                        <span class="text-body-secondary small fw-semibold">البريد الإلكتروني</span>
                        <span><?= htmlspecialchars($leave['employee_email']); ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column">
                        <span class="text-body-secondary small fw-semibold">القسم</span>
                        <span><?= htmlspecialchars($leave['department_name'] ?? 'لا يوجد'); ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column">
                        <span class="text-body-secondary small fw-semibold">نوع الإجازة</span>
                        <span><span class="badge bg-info-subtle text-info-emphasis rounded-pill px-3 py-2"><?= htmlspecialchars($leave['leave_type']); ?></span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- تفاصيل الإجازة -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-body-secondary py-3 border-bottom-0">
            <h5 class="mb-0 fw-semibold">
                <i class="fa fa-calendar-check-o me-2 text-secondary"></i> تفاصيل الإجازة
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="d-flex flex-column">
                        <span class="text-body-secondary small fw-semibold">تاريخ البداية</span>
                        <span><?= htmlspecialchars($leave['start_date']); ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column">
                        <span class="text-body-secondary small fw-semibold">تاريخ النهاية</span>
                        <span><?= htmlspecialchars($leave['end_date']); ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column">
                        <span class="text-body-secondary small fw-semibold">الحالة</span>
                        <?php if($leave['status'] == 'pending'): ?>
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2" style="width: fit-content;">
                                <i class="fa fa-clock-o me-1"></i> قيد الانتظار
                            </span>
                        <?php elseif($leave['status'] == 'approved'): ?>
                            <span class="badge bg-success rounded-pill px-3 py-2" style="width: fit-content;">
                                <i class="fa fa-check-circle me-1"></i> موافق
                            </span>
                        <?php else: ?>
                            <span class="badge bg-danger rounded-pill px-3 py-2" style="width: fit-content;">
                                <i class="fa fa-times-circle me-1"></i> مرفوض
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- سبب الإجازة -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-body-secondary py-3 border-bottom-0">
            <h5 class="mb-0 fw-semibold">
                <i class="fa fa-commenting-o me-2 text-secondary"></i> السبب
            </h5>
        </div>
        <div class="card-body">
            <p class="mb-0">
                <?php if(!empty($leave['reason'])): ?>
                    <?= nl2br(htmlspecialchars($leave['reason'])); ?>
                <?php else: ?>
                    <span class="text-body-secondary">لا يوجد سبب مذكور.</span>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- ملاحظة المدير (إن وجدت) -->
    <?php if(!empty($leave['manager_note'])): ?>
        <div class="card bg-body text-body shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="mb-0 fw-semibold">
                    <i class="fa fa-comment me-2 text-secondary"></i> ملاحظة المدير
                </h5>
            </div>
            <div class="card-body">
                <p class="mb-0">
                    <?= nl2br(htmlspecialchars($leave['manager_note'])); ?>
                </p>
            </div>
        </div>
    <?php endif; ?>

    <!-- أزرار الموافقة والرفض -->
    <?php
    // التحقق هل الطلب يخص المستخدم الحالي
    $isOwnLeave = ($leave['user_id'] == $currentUserId);

    // المدير لا يستطيع الموافقة أو رفض طلب إجازته بنفسه
    if(
        hasPermission('leaves.approve') &&
        $leave['status'] == 'pending' &&
        !$isOwnLeave
    ):
    ?>
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <h5 class="fw-semibold mb-3">
                    <i class="fa fa-gavel me-2 text-warning"></i> إجراءات المدير
                </h5>
                <hr>

                <div class="d-flex flex-wrap gap-2">

                    <a href="approve.php?id=<?= $leave['id']; ?>"
                       class="btn btn-success rounded-pill px-4 d-flex align-items-center gap-2">
                        <i class="fa fa-check-circle"></i> موافقة
                    </a>

                    <a href="reject.php?id=<?= $leave['id']; ?>"
                       class="btn btn-danger rounded-pill px-4 d-flex align-items-center gap-2">
                        <i class="fa fa-times-circle"></i> رفض
                    </a>

                </div>
            </div>
        </div>

    <?php endif; ?>

</div>

<?php include "../includes/footer.php"; ?>