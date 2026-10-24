<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

//التحقق من صلاحيه انشاء طلب اجازه
if(!hasPermission('leaves.create'))
{
    die("Access Denied");
}

//جلب بيانات الموظف الحالي
$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT * 
    FROM users
    WHERE id = ?
    AND deleted_at IS NULL
");

$stmt->execute([
    $userId
]);

$user = $stmt->fetch();

//التاكد ان المستخدم موحود
if(!$user)
{
    die("User Not Found");
}

//جلب الاقسام
$stmt = $pdo->prepare("
    SELECT *
    FROM departments
    WHERE id = ?
");

$stmt->execute([
    $user['department_id']
]);

$department = $stmt->fetch();

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

?>
<div class="content p-3 p-md-4">

    <div class="d-flex align-items-center gap-2 mb-4">
        <i class="fa fa-pencil-square-o fs-1 text-primary"></i>
        <div>
            <h2 class="fw-bold mb-0">طلب إجازة جديد</h2>
            <p class="text-body-secondary small mb-0">قم بتقديم طلب إجازة جديدة</p>
        </div>
    </div>

    <div class="card bg-body text-body shadow-sm border rounded-4">
        <div class="card-header bg-body-tertiary py-3 border-bottom-0">
            <h5 class="mb-0 fw-semibold">
                <i class="fa fa-file-text-o me-2 text-secondary"></i> بيانات طلب الإجازة
            </h5>
        </div>

        <div class="card-body p-4 p-md-5">

            <form action="store.php" method="POST" class="needs-validation" novalidate>

                <!-- اسم الموظف والقسم -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" id="employeeName" class="form-control form-control-lg rounded-3" 
                                   value="<?= htmlspecialchars($user['name']); ?>" readonly>
                            <label for="employeeName"><i class="fa fa-user me-1 text-primary"></i> الموظف</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" id="departmentName" class="form-control form-control-lg rounded-3" 
                                   value="<?= $department ? htmlspecialchars($department['department_name']) : 'لا يوجد قسم'; ?>" readonly>
                            <label for="departmentName"><i class="fa fa-building me-1 text-primary"></i> القسم</label>
                        </div>
                    </div>
                </div>

                <!-- نوع الإجازة -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="leave_type" id="leaveType" class="form-select form-select-lg rounded-3" required>
                                <option value="">اختر نوع الإجازة</option>
                                <option value="Annual Leave">إجازة سنوية</option>
                                <option value="Sick Leave">إجازة مرضية</option>
                                <option value="Emergency Leave">إجازة طارئة</option>
                                <option value="Unpaid Leave">إجازة بدون راتب</option>
                            </select>
                            <label for="leaveType"><i class="fa fa-tag me-1 text-primary"></i> نوع الإجازة</label>
                        </div>
                        <div class="invalid-feedback">الرجاء اختيار نوع الإجازة.</div>
                    </div>
                </div>

                <!-- تاريخ البداية والنهاية -->
                <div class="row mt-4 g-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" name="start_date" id="startDate" class="form-control form-control-lg rounded-3" 
                                   min="<?= date('Y-m-d'); ?>" required>
                            <label for="startDate"><i class="fa fa-calendar me-1 text-primary"></i> تاريخ البداية</label>
                        </div>
                        <div class="invalid-feedback">الرجاء اختيار تاريخ البداية.</div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" name="end_date" id="endDate" class="form-control form-control-lg rounded-3" 
                                   min="<?= date('Y-m-d'); ?>" required>
                            <label for="endDate"><i class="fa fa-calendar me-1 text-primary"></i> تاريخ النهاية</label>
                        </div>
                        <div class="invalid-feedback">الرجاء اختيار تاريخ النهاية.</div>
                    </div>
                </div>

                <!-- سبب الإجازة -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea name="reason" id="reason" class="form-control rounded-3" 
                                      placeholder="أدخل سبب الإجازة..." rows="4" style="min-height: 120px;"></textarea>
                            <label for="reason"><i class="fa fa-comment me-1 text-primary"></i> السبب</label>
                        </div>
                    </div>
                </div>

                <!-- الأزرار -->
                <div class="d-flex flex-wrap gap-3 mt-5 pt-4 border-top">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 d-flex align-items-center gap-2">
                        <i class="fa fa-paper-plane"></i> إرسال الطلب
                    </button>
                    <a href="index.php" class="btn btn-outline-secondary btn-lg rounded-pill px-5 d-flex align-items-center gap-2">
                        <i class="fa fa-times"></i> إلغاء
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<script>
// تفعيل التحقق من صحة النموذج باستخدام Bootstrap
(function() {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>

<?php include "../includes/footer.php"; ?>