<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

//التحقق من صلاحيه اضافه مستخدم
if(!hasPermission('users.create'))
{
    die("Access Denied");
}

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

//جلب جميع الاقسام من قاعده البيانات
$stmt = $pdo->query("
SELECT
id, 
department_name
FROM departments
ORDER BY department_name ASC
");

$departments = $stmt->fetchAll();

$roles = $pdo->query("SELECT * FROM roles")->fetchAll();

//استقبال رقم القسم القادم من صفحه القسم
$selectedDepartment = !empty($_GET['department_id'])
    ? (int)$_GET['department_id']
    : null;

?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-lg border-0 rounded-4 mt-4">
                    <div class="card-header bg-success text-white rounded-top-4">
                        <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i>إضافة مستخدم جديد</h4>
                    </div>
                    <div class="card-body p-4">

                        <form action="store.php" method="POST" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold"><i class="fas fa-user me-1"></i>الاسم</label>
                                    <input type="text"
                                           name="name"
                                           class="form-control form-control-lg"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold"><i class="fas fa-envelope me-1"></i>البريد الإلكتروني</label>
                                    <input type="email"
                                           name="email"
                                           class="form-control form-control-lg"
                                           required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold"><i class="fas fa-lock me-1"></i>كلمة المرور</label>
                                    <input type="password"
                                           name="password"
                                           class="form-control form-control-lg"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold"><i class="fas fa-user-tag me-1"></i>الدور</label>
                                    <select name="role_id"
                                            class="form-select form-select-lg"
                                            required>
                                        <?php foreach($roles as $role): ?>
                                            <option value="<?= $role['id']; ?>">
                                                <?= htmlspecialchars($role['role_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold"><i class="fas fa-building me-1"></i>القسم</label>
                                <select name="department_id"
                                        class="form-select form-select-lg">
                                    <option value="">اختر القسم</option>
                                    <?php foreach($departments as $department): ?>
                                        <option 
                                            value="<?= $department['id']; ?>"
                                            <?= ($department['id'] == $selectedDepartment) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($department['department_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold"><i class="fas fa-image me-1"></i>الصورة الشخصية</label>
                                <input type="file"
                                       name="image"
                                       class="form-control form-control-lg"
                                       accept="image/*">
                                <div class="form-text">يفضل أن تكون الصورة بصيغة JPG أو PNG ولا تتجاوز 2 ميجابايت</div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-success btn-lg px-5">
                                    <i class="fas fa-save me-2"></i>حفظ المستخدم
                                </button>
                                <a href="index.php" class="btn btn-secondary btn-lg px-4">
                                    <i class="fas fa-arrow-left me-2"></i>رجوع
                                </a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>