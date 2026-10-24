<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

// التحقق من صلاحية التعديل
if(!hasPermission('departments.edit'))
{
    die("تم رفض الوصول");
}

// استقبال رقم القسم من الرابط
$id = $_GET['id'];

// جلب بيانات القسم
$stmt = $pdo->prepare("
SELECT * 
FROM departments
WHERE id = ?
");

$stmt->execute([$id]);

$department = $stmt->fetch();

// إذا لم يوجد القسم
if(!$department)
{
    die("القسم غير موجود");
}

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

?>

<div class="content p-3 p-md-4">

    <div class="d-flex align-items-center gap-2 mb-4">
        <i class="fa fa-pencil-square-o fs-3 text-warning"></i>
        <h2 class="fw-bold mb-0">تعديل القسم</h2>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-body-tertiary py-3 border-bottom-0">
            <h5 class="mb-0 fw-semibold">
                <i class="fa fa-building me-2 text-secondary"></i> 
                تحديث تفاصيل القسم
            </h5>
        </div>

        <div class="card-body">
            <form action="update.php" method="POST" class="needs-validation" novalidate>

                <!-- إرسال رقم القسم -->
                <input type="hidden" name="id" value="<?= $department['id']; ?>">

                <!-- اسم القسم -->
                <div class="mb-4">
                    <label for="departmentName" class="form-label fw-semibold">
                        <i class="fa fa-tag me-1"></i> اسم القسم
                    </label>
                    <input
                        type="text"
                        name="department_name"
                        id="departmentName"
                        class="form-control form-control-lg rounded-3"
                        value="<?= htmlspecialchars($department['department_name']); ?>"
                        placeholder="مثال: تقنية المعلومات، الموارد البشرية، المالية"
                        required
                        autofocus
                    >
                    <div class="invalid-feedback">
                        يرجى إدخال اسم القسم.
                    </div>
                </div>

                <!-- الوصف -->
                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold">
                        <i class="fa fa-file-text-o me-1"></i> الوصف
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control rounded-3"
                        rows="4"
                        placeholder="أدخل وصف القسم (اختياري)"
                    ><?= htmlspecialchars($department['description']); ?></textarea>
                </div>

                <!-- الأزرار -->
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-success rounded-pill px-4 d-flex align-items-center gap-2">
                        <i class="fa fa-save"></i> تحديث القسم
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