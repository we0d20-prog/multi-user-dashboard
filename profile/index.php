<?php

require "../includes/auth_check.php";
require "../includes/permissions.php";
require "../config/db.php";

// التحقق من صلاحية مشاهدة الملف الشخصي
if (!hasPermission('profile.view')) {
    die("تم رفض الوصول");
}

/* جلب بيانات المستخدم الحالي */
$stmt = $pdo->prepare("
SELECT users.*, roles.role_name
FROM users
JOIN roles ON users.role_id = roles.id
WHERE users.id = ?
");

$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

?>

<?php
/* رسائل النجاح */
if (isset($_GET['success'])) {
    if ($_GET['success'] == 'password_changed') {
        echo "
        <script>
        document.addEventListener('DOMContentLoaded', function(){
            Swal.fire({
                icon:'success',
                title:'نجاح',
                text:'تم تغيير كلمة المرور بنجاح'
            });
        });
        </script>
        ";
    }
}

/* رسائل الخطأ */
if (isset($_GET['error'])) {
    if ($_GET['error'] == 'current_password') {
        echo "
        <script>
        document.addEventListener('DOMContentLoaded', function(){
            Swal.fire({
                icon:'error',
                title:'خطأ',
                text:'كلمة المرور الحالية غير صحيحة'
            });
        });
        </script>
        ";
    }

    if ($_GET['error'] == 'password_mismatch') {
        echo "
        <script>
        document.addEventListener('DOMContentLoaded', function(){
            Swal.fire({
                icon:'warning',
                title:'تحذير',
                text:'كلمات المرور غير متطابقة'
            });
        });
        </script>
        ";
    }

    if ($_GET['error'] == 'weak_password') {
        echo "
        <script>
        document.addEventListener('DOMContentLoaded', function(){
            Swal.fire({
                icon:'warning',
                title:'كلمة مرور ضعيفة',
                text:'يجب أن تتكون كلمة المرور من 8 أحرف على الأقل'
            });
        });
        </script>
        ";
    }
}
?>

<div class="content">

    <h2 class="mb-4 fw-bold text-primary">
        <i class="fas fa-user-circle me-2"></i>ملفي الشخصي
    </h2>

    <div class="row g-4">

        <!-- بطاقة المعلومات الشخصية -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center p-4">

                    <!-- صورة المستخدم -->
                    <div class="position-relative d-inline-block">

                        <?php if (!empty($user['image'])): ?>

                            <!-- عرض صورة المستخدم إذا كانت موجودة -->
                            <img
                                src="../assets/uploads/<?= htmlspecialchars($user['image']); ?>"
                                width="140"
                                height="140"
                                class="rounded-circle border border-3 border-primary p-1"
                                style="object-fit:cover;"
                                alt="صورة الملف الشخصي"
                            >

                        <?php else: ?>

                            <!-- حالة عدم وجود صورة -->
                            <div
                                class="rounded-circle border border-3 border-secondary d-flex align-items-center justify-content-center"
                                style="width:140px;height:140px;"
                            >
                                <i class="fas fa-user text-secondary" style="font-size:60px;"></i>
                            </div>

                        <?php endif; ?>

                        <span
                            class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2 border border-white"
                            style="width:18px;height:18px;"
                        ></span>

                    </div>

                    <h4 class="mt-3 fw-bold"><?= htmlspecialchars($user['name']); ?></h4>
                    <p class="text-muted mb-1"><i class="fas fa-envelope me-2"></i><?= htmlspecialchars($user['email']); ?></p>
                    <p class="mb-1"><span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill"><i class="fas fa-user-tag me-1"></i> <?= htmlspecialchars($user['role_name']); ?></span></p>
                    <p class="mb-0">
                        <span class="badge <?= ($user['status'] == 'active') ? 'bg-success' : 'bg-danger'; ?> bg-opacity-10 text-<?= ($user['status'] == 'active') ? 'success' : 'danger'; ?> px-3 py-2 rounded-pill">
                            <i class="fas fa-circle me-1" style="font-size:0.6rem;"></i> 
                            <?= ($user['status'] == 'active') ? 'نشط' : 'غير نشط'; ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- بطاقة تعديل الملف الشخصي -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4">

                    <?php if (hasPermission('profile.edit')): ?>
                        <!-- قسم تعديل الملف الشخصي -->
                        <h4 class="fw-bold mb-3"><i class="fas fa-edit me-2 text-primary"></i>تعديل الملف الشخصي</h4>
                        <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">الاسم</label>
                                    <input type="text" name="name" class="form-control form-control-lg rounded-3" value="<?= htmlspecialchars($user['name']); ?>" required>
                                </div>
                                
                                <div class="col-md-4">

                                    <label class="form-label fw-semibold">
                                    صورة الملف الشخصي
                                    </label>

                                    <input
                                        type="file"
                                        name="image"
                                        class="form-control form-control-lg rounded-3"
                                        accept="image/*"
                                    >

                                    <?php if (!empty($user['image'])): ?>

                                        <div class="form-check mt-2">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="delete_image"
                                                value="1"
                                                id="deleteImage"
                                            >

                                            <label
                                                class="form-check-label text-danger"
                                                for="deleteImage"
                                            >
                                                <i class="fas fa-trash-alt me-1"></i>
                                                حذف الصورة الحالية
                                            </label>
                                        </div>

                                    <?php endif; ?>

                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 mt-3">
                                <i class="fas fa-save me-2"></i>تحديث الملف الشخصي
                            </button>
                        </form>
                        <hr class="my-4">
                    <?php endif; ?>

                    <!-- قسم تغيير كلمة المرور -->
                    <h4 class="fw-bold mb-3"><i class="fas fa-key me-2 text-warning"></i>تغيير كلمة المرور</h4>
                    <form action="change_password.php" method="POST">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">كلمة المرور الحالية</label>
                                <input type="password" name="current_password" class="form-control form-control-lg rounded-3" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">كلمة المرور الجديدة</label>
                                <input type="password" name="new_password" class="form-control form-control-lg rounded-3" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">تأكيد كلمة المرور</label>
                                <input type="password" name="confirm_password" class="form-control form-control-lg rounded-3" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning btn-lg rounded-pill px-5 mt-3">
                            <i class="fas fa-exchange-alt me-2"></i>تغيير كلمة المرور
                        </button>
                    </form>

                </div>
            </div>
        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>