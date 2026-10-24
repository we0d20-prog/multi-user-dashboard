<?php

require "../includes/auth_check.php";
require "../includes/activity_log.php";
require "../config/db.php";
require "../includes/permissions.php";
require "../includes/notification_helper.php";

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

// التأكد من وجود ID 
if(!isset($_GET['id']))
{
    header("Location: index.php");
    exit;
}

// جلب الدور ID
$id = (int)$_GET['id'];

// جلب بيانات الدور الحالي
$stmt = $pdo->prepare("
SELECT *
FROM roles
WHERE id = ?
");

$stmt->execute([$id]);

$role = $stmt->fetch();

// إذا لم يكن الدور موجود
if(!$role)
{
    header("Location: index.php");
    exit;
}

// عند الضغط على زر التحديث
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // جلب الاسم الجديد
    $roleName = trim($_POST['role_name']);

    // التحقق أن الحقل ليس فارغاً
    if(!empty($roleName))
    {
        // التحقق من عدم تكرار اسم الدور
        $check = $pdo->prepare("
        SELECT id
        FROM roles 
        WHERE role_name = ?
        AND id != ?
        LIMIT 1
        ");

        $check->execute([
            $roleName,
            $id
        ]);

        if($check->fetch())
        {
            header("Location: edit.php?id=".$id."&error=role_exists");
            exit;
        }

        // تحديث اسم الدور
        $update = $pdo->prepare("
        UPDATE roles
        SET role_name = ?
        WHERE id = ?
        ");

        $update->execute([
            $roleName,
            $id
        ]);

        // إنشاء إشعار للأدمن بتعديل الدور
        createNotification(
            $pdo,
            1,
            "تم تحديث الدور",
            "تم تحديث دور " . $roleName . " بنجاح."
        );

        logActivity(
            $pdo,
            $_SESSION['user_id'],
            "قام بتحديث دور: " . $roleName
        );

        // العودة لصفحة الأدوار
        header("Location: index.php?success=role_updated");
        exit;
    }
}

?>

<div class="content p-3 p-md-4">

    <div class="d-flex align-items-center gap-2 mb-4">
        <i class="fa fa-pencil-square-o fs-3 text-warning"></i>
        <h2 class="fw-bold mb-0">تعديل الدور</h2>
    </div>

    <!-- عرض رسالة الخطأ إذا وجدت -->
    <?php if(isset($_GET['error']) && $_GET['error'] == 'role_exists'): ?>
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="fa fa-exclamation-circle"></i>
        <strong>خطأ:</strong> اسم الدور موجود مسبقاً. يرجى اختيار اسم آخر.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- بطاقة الدور -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-body-tertiary py-3">
            <h5 class="mb-0 fw-semibold">
                <i class="fa fa-edit me-2"></i> تعديل تفاصيل الدور
            </h5>
        </div>

        <div class="card-body">
            <form method="POST" class="needs-validation" novalidate>

                <!-- اسم الدور -->
                <div class="mb-4">
                    <label for="roleName" class="form-label fw-semibold">
                        <i class="fa fa-tag me-1"></i> اسم الدور
                    </label>
                    <input
                        type="text"
                        name="role_name"
                        id="roleName"
                        class="form-control form-control-lg rounded-3"
                        value="<?= htmlspecialchars($role['role_name']); ?>"
                        placeholder="أدخل اسم الدور (مثال: مدير، موظف)"
                        required
                        autofocus
                    >
                    <div class="invalid-feedback">
                        يرجى إدخال اسم الدور.
                    </div>
                </div>

                <!-- الأزرار -->
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-warning rounded-pill px-4 d-flex align-items-center gap-2">
                        <i class="fa fa-save"></i> تحديث الدور
                    </button>

                    <a href="index.php" class="btn btn-secondary rounded-pill px-4 d-flex align-items-center gap-2">
                        <i class="fa fa-arrow-left"></i> رجوع
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

<?php include "../includes/footer.php"; ?>