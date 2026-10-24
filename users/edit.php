<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

//التحقق من صلاحيه اضافه مستخدم
if(!hasPermission('users.edit'))
{
    die("Access Denied");
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);

$user = $stmt->fetch();

if (!$user) {
    die("User Not Found");
}

//حمايه المدير حسب القسم

//معرفه دور المستخدم الحالي
$currentRole = $_SESSION['user_role'];

//معرفه قسم المستخدم الحالي
$currentDepartment = $_SESSION['department_id'] ?? null;

//Manager اذا كان المستخدم
if($currentRole == 2)
{
    if($user['department_id'] != $currentDepartment)
    {
        die("Access Denied");
    }    
}

$roles = $pdo->query("SELECT * FROM roles")->fetchAll();

//جلب جميع الاقسام
$stmt = $pdo->query("
SELECT id, department_name FROM departments ORDER BY department_name ASC");

$departments = $stmt->fetchAll();

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card bg-body text-body shadow-lg border-0 rounded-4 mt-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>تعديل بيانات المستخدم</h4>
                    </div>
                    <div class="card-body p-4">

                        <form action="update.php" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="id" value="<?= $user['id']; ?>">
                            <input type="hidden" name="old_image" value="<?= $user['image']; ?>">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold"><i class="fas fa-user me-1"></i>الاسم</label>
                                    <input type="text"
                                           name="name"
                                           class="form-control form-control-lg"
                                           value="<?= htmlspecialchars($user['name']); ?>"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold"><i class="fas fa-envelope me-1"></i>البريد الإلكتروني</label>
                                    <input type="email"
                                           name="email"
                                           class="form-control form-control-lg"
                                           value="<?= htmlspecialchars($user['email']); ?>"
                                           required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold"><i class="fas fa-user-tag me-1"></i>الدور</label>
                                    <select name="role_id" class="form-select form-select-lg">
                                        <?php foreach($roles as $role): ?>
                                        <option value="<?= $role['id']; ?>" <?= ($role['id'] == $user['role_id']) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($role['role_name']); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold"><i class="fas fa-building me-1"></i>القسم</label>
                                    <select name="department_id" class="form-select form-select-lg">
                                        <option value="">اختر القسم</option>
                                        <?php foreach($departments as $department): ?>
                                        <option value="<?= $department['id']; ?>" <?= ($department['id'] == $user['department_id']) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($department['department_name']); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- عرض الصورة الحالية -->
                            <div class="mb-4">
                                <label class="form-label fw-bold"><i class="fas fa-image me-1"></i>الصورة الحالية</label>
                                <div class="d-flex align-items-center gap-3 p-2 border rounded-3 bg-body-secondary">
                                    <?php
                                    $imagePath = '../assets/uploads/' . $user['image'];
                                    if (!empty($user['image']) && file_exists($imagePath)) {
                                        echo '<img src="' . $imagePath . '" width="120" class="img-thumbnail rounded-3">';
                                    } else {
                                        echo '<img src="../assets/uploads/default.png" width="120" class="img-thumbnail rounded-3">';
                                    }
                                    ?>
                                    <span class="text-body-secondary small">(إذا لم تظهر الصورة، فهي غير موجودة أو تم حذفها)</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold"><i class="fas fa-upload me-1"></i>رفع صورة جديدة</label>
                                <input type="file"
                                       name="image"
                                       class="form-control form-control-lg"
                                       accept="image/*">
                                <div class="form-text">يفضل أن تكون الصورة بصيغة JPG أو PNG ولا تتجاوز 2 ميجابايت</div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-success btn-lg px-5">
                                    <i class="fas fa-save me-2"></i>تحديث البيانات
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