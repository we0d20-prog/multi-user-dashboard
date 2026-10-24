<?php

require "../includes/auth_check.php";
require "../includes/permissions.php";
require "../config/db.php";

// التحقق من صلاحية مشاهدة صفحة النسخ الاحتياطي
if(!hasPermission('settings.view'))
{
    die("Access Denied");
}

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

?>

<div class="content p-3 p-md-4">

    <div class="d-flex align-items-center gap-2 mb-4">
        <i class="fa fa-database fs-1 text-primary"></i>
        <div>
            <h2 class="fw-bold mb-0">النسخ الاحتياطي</h2>
            <p class="text-muted small mb-0">إنشاء واسترجاع نسخ احتياطية لقاعدة البيانات</p>
        </div>
    </div>

    <!-- رسالة نجاح إنشاء النسخة الاحتياطية -->
    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm rounded-4 border-0">
            <i class="fa fa-check-circle fs-4"></i>
            <span>تم إنشاء النسخة الاحتياطية بنجاح</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- رسالة نجاح استرجاع النسخة الاحتياطية -->
    <?php if(isset($_GET['restore'])): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm rounded-4 border-0">
            <i class="fa fa-check-circle fs-4"></i>
            <span>تم استرجاع قاعدة البيانات بنجاح</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-md-5">

            <!-- قسم إنشاء النسخة الاحتياطية -->
            <div class="mb-5">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="fa fa-cloud-upload fs-4 text-success"></i>
                    <h5 class="fw-semibold mb-0">إنشاء نسخة احتياطية</h5>
                </div>
                <p class="text-muted">اضغط على الزر لإنشاء نسخة احتياطية من قاعدة البيانات.</p>
                <a href="backup.php" class="btn btn-success btn-lg rounded-pill px-5 d-inline-flex align-items-center gap-2">
                    <i class="fa fa-download"></i> إنشاء نسخة احتياطية
                </a>
            </div>

            <hr class="border-2 border-dashed my-4">

            <!-- قسم استرجاع قاعدة البيانات -->
            <div>
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="fa fa-upload fs-4 text-danger"></i>
                    <h5 class="fw-semibold mb-0">استرجاع قاعدة البيانات</h5>
                </div>
                <form action="restore.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fa fa-file-code-o me-1 text-primary"></i> اختر ملف SQL
                        </label>
                        <input type="file" name="backup_file" class="form-control form-control-lg rounded-3" accept=".sql" required>
                        <div class="form-text text-muted">الملفات المدعومة: .sql فقط</div>
                        <div class="invalid-feedback">الرجاء اختيار ملف SQL.</div>
                    </div>

                    <button type="submit" class="btn btn-danger btn-lg rounded-pill px-5 d-inline-flex align-items-center gap-2">
                        <i class="fa fa-upload"></i> استرجاع قاعدة البيانات
                    </button>
                </form>
            </div>

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