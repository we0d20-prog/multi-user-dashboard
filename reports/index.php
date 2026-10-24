<?php
require "../includes/auth_check.php";
require "../includes/permissions.php";
require "../config/db.php";

// التحقق من صلاحية مشاهدة التقارير
if(!hasPermission('reports.view'))
{
    die("تم رفض الوصول");
}

$userId = (int)$_SESSION['user_id'];
$userRole = (int)$_SESSION['user_role'];
$departmentId = isset($_SESSION['department_id']) ? (int)$_SESSION['department_id'] : 0;

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

// جلب الإحصائيات

// الأدمن يرى جميع المستخدمين
if($userRole == 1)
{
    // إجمالي المستخدمين
    $totalUsers = $pdo->query("
        SELECT COUNT(*)
        FROM users
        WHERE deleted_at IS NULL
    ")->fetchColumn();

    // عدد المشرفين
    $totalAdmins = $pdo->query("
        SELECT COUNT(*)
        FROM users
        WHERE role_id = 1
        AND deleted_at IS NULL
    ")->fetchColumn();

    // عدد المدراء
    $totalManagers = $pdo->query("
        SELECT COUNT(*)
        FROM users
        WHERE role_id = 2
        AND deleted_at IS NULL
    ")->fetchColumn();

    // عدد الموظفين
    $totalEmployees = $pdo->query("
        SELECT COUNT(*)
        FROM users
        WHERE role_id = 3
        AND deleted_at IS NULL
    ")->fetchColumn();

    // جلب جميع المستخدمين للأدمن
    $stmt = $pdo->query("
        SELECT
            users.*,
            roles.role_name
        FROM users
        JOIN roles ON users.role_id = roles.id
        WHERE users.deleted_at IS NULL
        ORDER BY users.id DESC
    ");

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// المدير يرى موظفي قسمه فقط
elseif($userRole == 2)
{
    // إجمالي المستخدمين داخل قسم المدير
    $stmt = $pdo->prepare("
        SELECT COUNT(*)
        FROM users
        WHERE department_id = ?
        AND deleted_at IS NULL
        AND role_id = 3
    ");
    $stmt->execute([$departmentId]);
    $totalEmployees = $stmt->fetchColumn();

    // المدير لا يرى الأدمن أو المدراء في إحصائيات التقرير
    $totalAdmins = 0;
    $totalManagers = 0;

    // إجمالي المستخدمين الذين سيظهرون في التقرير
    $totalUsers = $totalEmployees;

    // جلب موظفي قسم المدير فقط
    $stmt = $pdo->prepare("
        SELECT
            users.*,
            roles.role_name
        FROM users
        JOIN roles ON users.role_id = roles.id
        WHERE users.department_id = ?
        AND users.role_id = 3
        AND users.deleted_at IS NULL
        ORDER BY users.id DESC
    ");

    $stmt->execute([$departmentId]);

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// الموظف
else
{
    // الموظف يرى بياناته فقط
    $stmt = $pdo->prepare("
        SELECT
            users.*,
            roles.role_name
        FROM users
        JOIN roles ON users.role_id = roles.id
        WHERE users.id = ?
        AND users.deleted_at IS NULL
        LIMIT 1
    ");

    $stmt->execute([$userId]);

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalUsers = count($users);
    $totalAdmins = 0;
    $totalManagers = 0;
    $totalEmployees = count($users);
}

?>

<div class="content p-3 p-md-4">

    <!-- عنوان الصفحة -->
    <div class="d-flex align-items-center gap-2 mb-4">
        <i class="fa fa-bar-chart fs-1 text-primary"></i>

        <div>
            <h2 class="fw-bold mb-0">التقارير</h2>

            <p class="text-body-secondary small mb-0">
                إحصائيات وتفاصيل مستخدمي النظام
            </p>
        </div>
    </div>

    <!-- بطاقات الإحصائيات -->
    <div class="row g-4 mb-4">

        <!-- إجمالي المستخدمين -->
        <div class="col-md-3 col-6">

            <div class="card shadow-sm border-0 bg-primary text-white h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="me-3 fs-1">
                        <i class="fa fa-users"></i>
                    </div>

                    <div>

                        <h6 class="mb-0 text-white-50">
                            إجمالي المستخدمين
                        </h6>

                        <h2 class="mb-0 display-6 fw-bold">
                            <?= $totalUsers ?>
                        </h2>

                    </div>

                </div>

            </div>

        </div>

        <!-- المشرفون -->
        <?php if($userRole == 1): ?>

        <div class="col-md-3 col-6">

            <div class="card shadow-sm border-0 bg-danger text-white h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="me-3 fs-1">
                        <i class="fa fa-user-shield"></i>
                    </div>

                    <div>

                        <h6 class="mb-0 text-white-50">
                            المشرفون
                        </h6>

                        <h2 class="mb-0 display-6 fw-bold">
                            <?= $totalAdmins ?>
                        </h2>

                    </div>

                </div>

            </div>

        </div>

        <!-- المدراء -->
        <div class="col-md-3 col-6">

            <div class="card shadow-sm border-0 bg-warning text-dark h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="me-3 fs-1">
                        <i class="fa fa-user-tie"></i>
                    </div>

                    <div>

                        <h6 class="mb-0 text-dark-emphasis">
                            المدراء
                        </h6>

                        <h2 class="mb-0 display-6 fw-bold">
                            <?= $totalManagers ?>
                        </h2>

                    </div>

                </div>

            </div>

        </div>

        <?php endif; ?>

        <!-- الموظفين -->
        <div class="col-md-3 col-6">

            <div class="card shadow-sm border-0 bg-success text-white h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="me-3 fs-1">
                        <i class="fa fa-user"></i>
                    </div>

                    <div>

                        <h6 class="mb-0 text-white-50">
                            الموظفون
                        </h6>

                        <h2 class="mb-0 display-6 fw-bold">
                            <?= $totalEmployees ?>
                        </h2>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- أزرار التصدير -->
    <?php if(hasPermission('reports.export')): ?>

    <div class="d-flex flex-wrap gap-2 mb-4">

        <a href="export_csv.php"
           class="btn btn-success rounded-pill px-4 d-flex align-items-center gap-2">

            <i class="fa fa-file-excel-o"></i>

            تصدير CSV

        </a>

        <a href="export_pdf.php"
           class="btn btn-danger rounded-pill px-4 d-flex align-items-center gap-2">

            <i class="fa fa-file-pdf-o"></i>

            تصدير PDF

        </a>

    </div>

    <?php endif; ?>

    <!-- جدول المستخدمين -->
    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-header bg-body py-3 border-bottom">

            <h5 class="mb-0 fw-semibold">

                <i class="fa fa-table me-2 text-body-secondary"></i>

                تقرير المستخدمين

            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table id="reportTable"
                       class="table table-hover table-striped align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>المعرف</th>

                            <th>الاسم</th>

                            <th>البريد الإلكتروني</th>

                            <th>الدور</th>

                            <th>الحالة</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach($users as $user): ?>

                        <tr>

                            <!-- المعرف -->
                            <td>

                                <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill">

                                    <?= $user['id']; ?>

                                </span>

                            </td>

                            <!-- الاسم -->
                            <td class="fw-semibold">

                                <?= htmlspecialchars($user['name']); ?>

                            </td>

                            <!-- البريد الإلكتروني -->
                            <td>

                                <?= htmlspecialchars($user['email']); ?>

                            </td>

                            <!-- الدور -->
                            <td>

                                <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill px-3 py-2">

                                    <?= htmlspecialchars($user['role_name']); ?>

                                </span>

                            </td>

                            <!-- الحالة -->
                            <td>

                                <?php if($user['status'] == 'active'): ?>

                                    <span class="badge bg-success rounded-pill px-3 py-2">

                                        <i class="fa fa-check-circle me-1"></i>

                                        نشط

                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-danger rounded-pill px-3 py-2">

                                        <i class="fa fa-times-circle me-1"></i>

                                        غير نشط

                                    </span>

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

<script>

$(document).ready(function(){

    $('#reportTable').DataTable({

        pageLength: 10,
        ordering: true,
        searching: true,
        paging: true,
        language: {

            search: "بحث:",
            lengthMenu: "عرض _MENU_ سجل",
            info: "عرض _START_ إلى _END_ من أصل _TOTAL_ مستخدم",
            infoEmpty: "لا يوجد مستخدمين متاحين",
            infoFiltered: "(تم التصفية من _MAX_ إجمالي المستخدمين)"

        }

    });

});

</script>

<?php include "../includes/footer.php"; ?>