<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

// التحقق من صلاحية مشاهدة الإجازات
if(!hasPermission('leaves.view'))
{
    die("Access Denied");
}

// معرفة بيانات المستخدم الحالي
$currentUserId = $_SESSION['user_id'];
$currentRole = $_SESSION['user_role'];
$currentDepartment = $_SESSION['department_id'] ?? null;

/*Admin يشاهد جميع طلبات الإجازات */
if($currentRole == 1)
{
    $stmt = $pdo->query("

        SELECT
            leave_requests.*,
            users.name AS employee_name,
            departments.department_name
        FROM leave_requests
        JOIN users
        ON leave_requests.user_id = users.id
        LEFT JOIN departments
        ON users.department_id = departments.id
        ORDER BY leave_requests.id DESC

    ");
}

/* Manager يشاهد طلبات موظفي قسمه فقط */
elseif($currentRole == 2)
{
    $stmt = $pdo->prepare("

        SELECT
            leave_requests.*,
            users.name AS employee_name,
            departments.department_name
        FROM leave_requests
        JOIN users
        ON leave_requests.user_id = users.id
        LEFT JOIN departments
        ON users.department_id = departments.id
        WHERE users.department_id = ?
        ORDER BY leave_requests.id DESC

    ");

    // إرسال قسم المدير للاستعلام
    $stmt->execute([
        $currentDepartment
    ]);
}

/* Employee يشاهد طلباته فقط */
elseif($currentRole == 3)
{
    $stmt = $pdo->prepare("

        SELECT
            leave_requests.*,
            users.name AS employee_name,
            departments.department_name
        FROM leave_requests
        JOIN users
        ON leave_requests.user_id = users.id
        LEFT JOIN departments
        ON users.department_id = departments.id
        WHERE leave_requests.user_id = ?

        ORDER BY leave_requests.id DESC

    ");

    // إرسال ID الموظف الحالي
    $stmt->execute([
        $currentUserId
    ]);
}

/* أي Role غير معروف */
else
{
    die("Access Denied");
}

// جلب النتائج
$leaveRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

?>

<div class="content p-3 p-md-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-2">
            <i class="fa fa-calendar-check-o fs-1 text-primary"></i>
            <div>
                <h2 class="fw-bold mb-0">طلبات الإجازات</h2>
                <p class="text-body-secondary small mb-0">إدارة طلبات الإجازات للموظفين</p>
            </div>
        </div>

       <!-- زر إنشاء طلب إجازة يظهر للموظف فقط -->
       <?php if(in_array($currentRole, [2, 3]) && hasPermission('leaves.create')): ?>

           <a href="create.php" class="btn btn-primary rounded-pill px-4 d-flex align-items-center gap-2">
               <i class="fa fa-plus-circle"></i> طلب إجازة
           </a>

       <?php endif; ?>

    </div>

    <!-- جدول طلبات الإجازات -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-body-tertiary py-3 border-bottom-0">
            <h5 class="mb-0 fw-semibold d-flex align-items-center gap-2">
                <i class="fa fa-list-ul text-secondary"></i> قائمة طلبات الإجازات
                <span class="badge bg-secondary rounded-pill ms-2"><?= count($leaveRequests); ?></span>
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="leavesTable" class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>الموظف</th>
                            <th>القسم</th>
                            <th>نوع الإجازة</th>
                            <th>تاريخ البداية</th>
                            <th>تاريخ النهاية</th>
                            <th>الحالة</th>
                            <th>تاريخ الطلب</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($leaveRequests as $leave): ?>
                        <tr>
                            <td><span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill"><?= $leave['id']; ?></span></td>
                            <td class="fw-semibold"><?= htmlspecialchars($leave['employee_name']); ?></td>
                            <td><?= htmlspecialchars($leave['department_name'] ?? 'لا يوجد'); ?></td>
                            <td><span class="badge bg-info-subtle text-info-emphasis rounded-pill px-3 py-2"><?= htmlspecialchars($leave['leave_type']); ?></span></td>
                            <td><small><?= htmlspecialchars($leave['start_date']); ?></small></td>
                            <td><small><?= htmlspecialchars($leave['end_date']); ?></small></td>
                            <td>
                                <?php if($leave['status'] == 'pending'): ?>
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                        <i class="fa fa-clock-o me-1"></i> قيد الانتظار
                                    </span>
                                <?php elseif($leave['status'] == 'approved'): ?>
                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                        <i class="fa fa-check-circle me-1"></i> موافق
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger rounded-pill px-3 py-2">
                                        <i class="fa fa-times-circle me-1"></i> مرفوض
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td><small class="text-body-secondary"><?= htmlspecialchars($leave['created_at']); ?></small></td>
                            <td>
                                <a href="view.php?id=<?= $leave['id']; ?>" class="btn btn-info btn-sm rounded-pill px-3 text-white d-inline-flex align-items-center gap-1">
                                    <i class="fa fa-eye"></i> عرض
                                </a>

                               <?php
                               // تحديد هل الطلب هو طلب المستخدم الحالي
                               $isOwnLeave = ($leave['user_id'] == $currentUserId);

                               // إظهار زر المراجعة فقط إذا لم يكن الطلب طلب المستخدم نفسه
                               if(
                                    hasPermission('leaves.approve') &&
                                    $leave['status'] == 'pending' &&
                                    !$isOwnLeave
                                ):
                                ?>
                                    <a href="view.php?id=<?= $leave['id']; ?>" class="btn btn-warning btn-sm rounded-pill px-3 d-inline-flex align-items-center gap-1">
                                        <i class="fa fa-edit"></i> مراجعة
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include "../includes/footer.php"; ?>

<!-- SweetAlert لإظهار رسائل نجاح العمليات -->
<script>
<?php if(isset($_GET['success'])): ?>
    <?php if($_GET['success'] == 'approved'): ?>
        Swal.fire({
            icon: 'success',
            title: 'تمت الموافقة!',
            text: 'تمت الموافقة على طلب الإجازة بنجاح.',
            confirmButtonText: 'حسناً'
        });
    <?php elseif($_GET['success'] == 'rejected'): ?>
        Swal.fire({
            icon: 'error',
            title: 'مرفوض!',
            text: 'تم رفض طلب الإجازة بنجاح.',
            confirmButtonText: 'حسناً'
        });
    <?php endif; ?>
<?php endif; ?>
</script>

<script>
$(document).ready(function(){
    $("#leavesTable").DataTable({
        pageLength: 10,
        ordering: true,
        searching: true,
        paging: true,
        language: {
            search: "بحث:",
            lengthMenu: "عرض _MENU_ سجل",
            info: "عرض _START_ إلى _END_ من _TOTAL_ طلب",
            infoEmpty: "لا توجد طلبات",
            infoFiltered: "(تمت التصفية من _MAX_ طلب إجمالي)"
        }
    });
});
</script>