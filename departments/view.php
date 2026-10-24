<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

if(!hasPermission('departments.view'))
{
    die("تم رفض الوصول");
}

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

$departmentId = (int)$_GET['id'];

// جلب بيانات القسم
$stmt = $pdo->prepare("
SELECT *
FROM departments
WHERE id = ?
");

$stmt->execute([
    $departmentId
]);

$department = $stmt->fetch();

if(!$department)
{
    die("القسم غير موجود");
}

// جلب جميع الموظفين الموجودين داخل هذا القسم
$stmt = $pdo->prepare("

SELECT 

/* جميع بيانات المستخدم */
users.*,

/* اسم الدور */
roles.role_name

FROM users

/* ربط المستخدمين مع الأدوار */
JOIN roles
ON users.role_id = roles.id

/* جلب جميع الموظفين الذين ينتمون لهذا القسم */
WHERE users.department_id = ?

/* تجاهل المستخدمين الموجودين في سلة المحذوفات */
AND users.deleted_at IS NULL

ORDER BY users.id DESC
");

$stmt->execute([
    $departmentId
]);

$employees = $stmt->fetchAll();

// حساب إحصائيات القسم
$totalEmployees = count($employees);

// عدد الموظفين النشطين
$activeEmployees = 0;

// عدد الموظفين غير النشطين
$inactiveEmployees = 0;

// المرور على جميع الموظفين
foreach($employees as $employee)
{
    if($employee['status'] == 'active')
    {
        $activeEmployees++;
    }    
    else 
    {
        $inactiveEmployees++;
    }    
}    
?>
<div class="content p-3 p-md-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="fa fa-building me-2 text-primary"></i>
            القسم: <?= htmlspecialchars($department['department_name']); ?>
        </h2>

        <a href="../users/create.php?department_id=<?= $department['id']; ?>" class="btn btn-primary rounded-pill px-4 d-flex align-items-center gap-2">
            <i class="fa fa-user-plus"></i> إضافة موظف
        </a>
    </div>

    <!-- إحصائيات القسم -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-primary text-white h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 fs-1">👥</div>
                    <div>
                        <h6 class="mb-0 text-white-50">إجمالي الموظفين</h6>
                        <h2 class="mb-0 display-6 fw-bold"><?= $totalEmployees; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-success text-white h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 fs-1">✅</div>
                    <div>
                        <h6 class="mb-0 text-white-50">الموظفين النشطين</h6>
                        <h2 class="mb-0 display-6 fw-bold"><?= $activeEmployees; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-danger text-white h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 fs-1">⛔</div>
                    <div>
                        <h6 class="mb-0 text-white-50">الموظفين غير النشطين</h6>
                        <h2 class="mb-0 display-6 fw-bold"><?= $inactiveEmployees; ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- وصف القسم -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-body-tertiary py-3">
            <h5 class="mb-0 fw-semibold">
                <i class="fa fa-file-text-o me-2 text-secondary"></i> الوصف
            </h5>
        </div>
        <div class="card-body">
            <p class="mb-0 text-body-secondary">
                <?= htmlspecialchars($department['description']) ?: '<em>لا يوجد وصف.</em>'; ?>
            </p>
        </div>
    </div>

    <!-- جدول موظفي القسم -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-body-tertiary py-3">
            <h5 class="mb-0 fw-semibold">
                <i class="fa fa-users me-2 text-secondary"></i> موظفو القسم
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 border-0">
                    <thead class="table-group-divider">
                        <tr>
                            <th>الصورة</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>الدور</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(empty($employees)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-body-secondary">
                                <i class="fa fa-user-times fs-3 d-block mb-2"></i>
                                لا يوجد موظفين في هذا القسم.
                            </td>
                        </tr>
                        <?php else: ?>

                        <?php foreach($employees as $employee): ?>
                        <tr>
                            <td>
                                <?php if(!empty($employee['image']) && file_exists("../assets/uploads/" . $employee['image'])): ?>
                                    <img src="../assets/uploads/<?= $employee['image']; ?>" width="45" height="45" class="rounded-circle object-fit-cover">
                                <?php else: ?>
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:45px; height:45px;">
                                        <?= strtoupper(substr($employee['name'], 0, 1)); ?>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td class="fw-semibold"><?= htmlspecialchars($employee['name']); ?></td>
                            <td><?= htmlspecialchars($employee['email']); ?></td>
                            <td><span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-3 py-2"><?= htmlspecialchars($employee['role_name']); ?></span></td>
                            <td>
                                <?php if($employee['status'] == 'active'): ?>
                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                        <i class="fa fa-check-circle me-1"></i> نشط
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger rounded-pill px-3 py-2">
                                        <i class="fa fa-times-circle me-1"></i> غير نشط
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

<?php include "../includes/footer.php"; ?>