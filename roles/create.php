<?php

require "../includes/auth_check.php";
require "../includes/activity_log.php";
require "../config/db.php";
require "../includes/permissions.php";
require "../includes/notification_helper.php";

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

/* عند الضغط على زر الحفظ */
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // استقبال اسم الدور من الفورم
    $roleName = trim($_POST['role_name']);

    /* التحقق أن الحقل غير فارغ */
    if(!empty($roleName))
    {
        /* التحقق من عدم تكرار اسم الدور */
        $check = $pdo->prepare("
        SELECT id 
        FROM roles
        WHERE role_name = ?
        LIMIT 1
        ");

        $check->execute([$roleName]);
        if($check->fetch())
        {
            header("Location: create.php?error=role_exists");
            exit;
        }

        /* إضافة الدور داخل قاعدة البيانات */
        $stmt = $pdo->prepare("
        INSERT INTO roles (role_name)
        VALUES (?)
        ");

        $stmt->execute([$roleName]);

        /* إنشاء إشعار بإضافة دور جديد */
        createNotification(
           $pdo,
           1,
           "دور جديد",
           "تم إنشاء دور " . $roleName . " بنجاح."
        );

        logActivity(
            $pdo,
            $_SESSION['user_id'],
            "قام بإنشاء دور: " . $roleName
        );

        /* الرجوع لصفحة الأدوار بعد الإضافة */
        header("Location: index.php?success=role_added");
        exit;
    }
}

?>

<div class="content p-3 p-md-4">

    <div class="d-flex align-items-center gap-2 mb-4">
        <i class="fa fa-plus-circle fs-3 text-primary"></i>
        <h2 class="fw-bold mb-0">إضافة دور جديد</h2>
    </div>

    <?php if(isset($_GET['error']) && $_GET['error'] == 'role_exists'): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="fa fa-exclamation-triangle"></i>
            <strong>خطأ:</strong> اسم الدور موجود مسبقاً. يرجى اختيار اسم آخر.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- بطاقة النموذج -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-body-tertiary py-3 border-bottom-0">
            <h5 class="mb-0 fw-semibold">
                <i class="fa fa-tag me-2 text-secondary"></i> 
                أدخل تفاصيل الدور
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
                        placeholder="مثال: مدير، مشرف، موظف"
                        required
                        autofocus
                    >
                    <div class="invalid-feedback">
                        يرجى إدخال اسم الدور.
                    </div>
                </div>

                <!-- الأزرار -->
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 d-flex align-items-center gap-2">
                        <i class="fa fa-save"></i> حفظ الدور
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