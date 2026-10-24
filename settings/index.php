<?php

require "../includes/auth_check.php";
require "../includes/permissions.php";
require "../config/db.php";
require "../includes/notification_helper.php";

// التحقق من صلاحية عرض صفحة الإعدادات
if(!hasPermission('settings.view'))
{
    die("Access Denied");
}

/* جلب الإعدادات الحالية من قاعدة البيانات */
$stmt = $pdo->query("
SELECT *
FROM settings
LIMIT 1
");

$settings = $stmt->fetch(PDO::FETCH_ASSOC);

/* عند الضغط على زر الحفظ */
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // استقبال اسم الموقع
    $siteName =
    trim($_POST['site_name']);

    // استقبال اسم الشركة
    $companyName =
    trim($_POST['company_name']);

    //اسم الشعار الحالي
    $logoName = $settings['logo'];

    //التحقق هل تم اختيار صوره
    if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
    {
        //اسم الصوره
        $fileName = $_FILES['logo']['name'];

        //المسار المؤقت
        $tmpName = $_FILES['logo']['tmp_name'];

        //استخراج الامتداد
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        //الامتدادات المسموحه
        $allowed = [
            "jpg",
            "jpeg",
            "png",
            "webp"
        ];

        // حذف الشعار القديم إذا كان موجودًا
        if(
            !empty($settings['logo']) &&
            file_exists("../uploads/logos/" . $settings['logo'])
        )
        {
            unlink("../uploads/logos/" . $settings['logo']);
        }

        //التاكد ان الامتداد صحيح
        if(in_array($extension, $allowed))
        {
            //انشاء اسم جديد للصوره
            $logoName = 
            time() . "_" . uniqid() . "." . $extension;

            //نقل الصوره الى مجلد logos
            move_uploaded_file(
                $tmpName,
                "../uploads/logos/" . $logoName
            );
        }
    }

    // تحديث الإعدادات داخل قاعدة البيانات
    $update = $pdo->prepare("
    UPDATE settings
    SET
    site_name = ?,
    company_name = ?,
    logo = ?
    WHERE id = ?
    ");

    $update->execute([
        $siteName,
        $companyName,
        $logoName,
        $settings['id']
    ]);

    // إنشاء إشعار بتحديث إعدادات النظام
    createNotification(
        $pdo,
        $_SESSION['user_id'],
        "تم تحديث الإعدادات",
        "تم تحديث إعدادات النظام بنجاح."
    );

    // الرجوع لنفس الصفحة مع رسالة نجاح
    header("Location: index.php?success=1");
    exit;
}

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

?>

<div class="content p-3 p-md-4">

    <div class="d-flex align-items-center gap-2 mb-4">
        <i class="fa fa-cogs fs-1 text-primary"></i>
        <div>
            <h2 class="fw-bold mb-0">الإعدادات</h2>
            <p class="text-body-secondary small mb-0">تخصيص إعدادات النظام</p>
        </div>
    </div>

    <!-- رسالة نجاح الحفظ -->
    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm rounded-4 border-0">
            <i class="fa fa-check-circle fs-4"></i>
            <span>تم تحديث الإعدادات بنجاح</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-body-tertiary py-3 border-bottom-0">
            <h5 class="mb-0 fw-semibold">
                <i class="fa fa-pencil-square-o me-2 text-secondary"></i> تعديل الإعدادات
            </h5>
        </div>

        <div class="card-body p-4 p-md-5">
            <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

                <!-- اسم الموقع -->
                <div class="mb-4">
                    <div class="form-floating">
                        <input type="text" name="site_name" id="siteName" 
                               class="form-control form-control-lg rounded-3" 
                               placeholder="اسم الموقع" 
                               value="<?= htmlspecialchars($settings['site_name']); ?>" required>
                        <label for="siteName"><i class="fa fa-globe me-1 text-primary"></i> اسم الموقع</label>
                    </div>
                    <div class="invalid-feedback">الرجاء إدخال اسم الموقع.</div>
                </div>

                <!-- اسم الشركة -->
                <div class="mb-4">
                    <div class="form-floating">
                        <input type="text" name="company_name" id="companyName" 
                               class="form-control form-control-lg rounded-3" 
                               placeholder="اسم الشركة" 
                               value="<?= htmlspecialchars($settings['company_name']); ?>" required>
                        <label for="companyName"><i class="fa fa-building me-1 text-primary"></i> اسم الشركة</label>
                    </div>
                    <div class="invalid-feedback">الرجاء إدخال اسم الشركة.</div>
                </div>

                <!-- شعار الموقع -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="fa fa-image me-1 text-primary"></i> شعار الموقع
                    </label>
                    <input type="file" name="logo" class="form-control form-control-lg rounded-3" accept="image/*">
                    <small class="text-body-secondary">الصيغ المدعومة: JPG, PNG, WEBP. اترك الحقل فارغاً للإبقاء على الشعار الحالي.</small>
                </div>

                <!-- زر الحفظ -->
                <div class="d-flex flex-wrap gap-2 mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 d-flex align-items-center gap-2">
                        <i class="fa fa-save"></i> حفظ الإعدادات
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

<script>
// تفعيل التحقق من صحة النموذج
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