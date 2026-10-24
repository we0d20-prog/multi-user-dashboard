<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

// Admin فقط
if($_SESSION['user_role'] != 1)
{
    die("Access Denied");
}

// صلاحية إنشاء إعلان
if(!hasPermission('announcements.create'))
{
    die("Access Denied");
}

// جلب الأقسام
$stmt = $pdo->query("
    SELECT
        id,
        department_name
    FROM departments
    ORDER BY department_name ASC
");

$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// المتغيرات
$error = "";

// معالجة الفورم
if($_SERVER['REQUEST_METHOD'] == 'POST')
{

    $title = trim($_POST['title'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $targetType = $_POST['target_type'] ?? 'all';
    $targetId = $_POST['target_id'] ?? null;

    // التحقق
    if($title == '')
    {
        $error = "Please enter announcement title.";
    }

    elseif($message == '')
    {
        $error = "Please enter announcement message.";
    }

    elseif(
        !in_array(
            $targetType,
            ['all', 'department', 'role']
        )
    )
    {
        $error = "Invalid target type.";
    }

    elseif(
        $targetType == 'department'
        &&
        empty($targetId)
    )
    {
        $error = "Please select a department.";
    }

    elseif(
        $targetType == 'role'
        &&
        empty($targetId)
    )
    {
        $error = "Please select a role.";
    }

    // إنشاء الإعلان + الإشعارات
    if($error == '')
    {

        try
        {
            // بدء Transaction
            $pdo->beginTransaction();

            // target_id
            if($targetType == 'all')
            {
                $targetId = null;
            }
            else
            {
                $targetId = (int)$targetId;
            }

            // حفظ الإعلان
            $stmt = $pdo->prepare("
                INSERT INTO announcements
                (
                    title,
                    message,
                    created_by,
                    target_type,
                    target_id,
                    status
                )

                VALUES
                (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    'active'
                )
            ");

            $stmt->execute([
                $title,
                $message,
                $_SESSION['user_id'],
                $targetType,
                $targetId
            ]);

            // تحديد الموظفين الذين سيصلهم الإشعار
            if($targetType == 'all')
            {

                // جميع المستخدمين النشطين
                $stmt = $pdo->prepare("
                    SELECT id
                    FROM users
                    WHERE status = 'active'
                    AND deleted_at IS NULL
                ");

                $stmt->execute();

            }

            elseif($targetType == 'department')
            {

                // جميع المستخدمين داخل القسم
                $stmt = $pdo->prepare("
                    SELECT id
                    FROM users
                    WHERE department_id = ?
                    AND status = 'active'
                    AND deleted_at IS NULL
                ");

                $stmt->execute([
                    $targetId
                ]);

            }

            elseif($targetType == 'role')
            {

                // جميع المستخدمين أصحاب الدور
                $stmt = $pdo->prepare("
                    SELECT id
                    FROM users
                    WHERE role_id = ?
                    AND status = 'active'
                    AND deleted_at IS NULL
                ");

                $stmt->execute([
                    $targetId
                ]);

            }

            // جلب المستلمين
            $recipients =
                $stmt->fetchAll(PDO::FETCH_COLUMN);

            // إنشاء Notification لكل مستخدم
            if(!empty($recipients))
            {

                $notificationStmt = $pdo->prepare("
                    INSERT INTO notifications
                    (
                        user_id,
                        title,
                        message,
                        is_read
                    )

                    VALUES
                    (
                        ?,
                        ?,
                        ?,
                        0
                    )
                ");

                foreach($recipients as $recipientId)
                {

                    $notificationStmt->execute([
                        $recipientId,
                        $title,
                        $message
                    ]);

                }

            }

            // تأكيد العملية
            $pdo->commit();

            // العودة
            header(
                "Location: index.php?success=created"
            );

            exit;

        }

        catch(Exception $e)
        {

            // إلغاء العملية في حال حدوث خطأ
            if($pdo->inTransaction())
            {
                $pdo->rollBack();
            }

            $error =
                "An error occurred while creating the announcement.";

        }

    }

}

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

?>

<div class="content p-3 p-md-4">

    <!-- رأس الصفحة -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-megaphone-plus fs-1 text-primary"></i>
            <div>
                <h2 class="fw-bold mb-0">إنشاء إعلان جديد</h2>
                <p class="text-body-secondary mb-0 small">أضف إعلاناً جديداً للشركة</p>
            </div>
        </div>
        <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4 d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> رجوع
        </a>
    </div>

    <!-- رسالة الخطأ -->
    <?php if($error != ''): ?>
        <div class="alert alert-danger d-flex align-items-center gap-2 border-0 shadow-sm rounded-4">
            <i class="bi bi-exclamation-triangle-fill fs-4"></i>
            <span><?= htmlspecialchars($error); ?></span>
        </div>
    <?php endif; ?>

    <!-- النموذج -->
    <div class="card bg-body text-body shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 py-3">
            <h5 class="mb-0 fw-semibold d-flex align-items-center gap-2">
                <i class="bi bi-pencil-square"></i> بيانات الإعلان
            </h5>
        </div>
        <div class="card-body p-4 p-md-5">

            <form method="POST" action="">

                <!-- العنوان -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-heading text-primary me-1"></i> العنوان
                    </label>
                    <input type="text"
                           name="title"
                           class="form-control form-control-lg rounded-3"
                           placeholder="أدخل عنوان الإعلان"
                           value="<?= htmlspecialchars($_POST['title'] ?? ''); ?>"
                           required>
                </div>

                <!-- المحتوى -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-textarea text-primary me-1"></i> المحتوى
                    </label>
                    <textarea name="message"
                              class="form-control rounded-3"
                              rows="6"
                              placeholder="أدخل نص الإعلان"
                              required><?= htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                    <div class="form-text text-body-secondary">سيظهر هذا النص للموظفين المستهدفين</div>
                </div>

                <hr class="border-2 border-dashed my-4">

                <!-- جهة الإرسال -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-send text-primary me-1"></i> إرسال إلى
                    </label>
                    <select name="target_type" id="target_type" class="form-select form-select-lg rounded-3" required>
                        <option value="all" <?= (($_POST['target_type'] ?? 'all') == 'all') ? 'selected' : ''; ?>>جميع الموظفين</option>
                        <option value="department" <?= (($_POST['target_type'] ?? '') == 'department') ? 'selected' : ''; ?>>قسم محدد</option>
                        <option value="role" <?= (($_POST['target_type'] ?? '') == 'role') ? 'selected' : ''; ?>>دور محدد</option>
                    </select>
                </div>

                <!-- حقل القسم (يظهر عند اختيار "قسم") -->
                <div id="departmentBox" style="display:none;">
                    <div class="bg-body-tertiary p-3 rounded-3 border border-dashed mb-4">
                        <label class="fw-semibold d-block mb-2">
                            <i class="bi bi-building text-primary me-1"></i> اختر القسم
                        </label>
                        <select name="target_id" id="departmentSelect" class="form-select rounded-3">
                            <option value="">اختر القسم</option>
                            <?php foreach($departments as $department): ?>
                                <option value="<?= (int)$department['id']; ?>" <?= (($_POST['target_id'] ?? '') == $department['id']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($department['department_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- حقل الدور (يظهر عند اختيار "دور") -->
                <div id="roleBox" style="display:none;">
                    <div class="bg-body-tertiary p-3 rounded-3 border border-dashed mb-4">
                    
                        <label class="fw-semibold d-block mb-2">
                            <i class="bi bi-person-badge text-primary me-1"></i> اختر الدور
                        </label>
                        <select name="target_id" id="roleSelect" class="form-select rounded-3">
                            <option value="">اختر الدور</option>
                            <option value="1" <?= (($_POST['target_id'] ?? '') == 1) ? 'selected' : ''; ?>>مدير</option>
                            <option value="2" <?= (($_POST['target_id'] ?? '') == 2) ? 'selected' : ''; ?>>مشرف</option>
                            <option value="3" <?= (($_POST['target_id'] ?? '') == 3) ? 'selected' : ''; ?>>موظف</option>
                        </select>
                    </div>
                </div>

                <hr class="border-2 border-dashed my-4">

                <!-- الأزرار -->
                <div class="d-flex flex-wrap gap-3">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle"></i> إنشاء الإعلان
                    </button>
                    <a href="index.php" class="btn btn-outline-secondary btn-lg rounded-pill px-5 d-flex align-items-center gap-2">
                        <i class="bi bi-x-circle"></i> إلغاء
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<script>
document.addEventListener(
    "DOMContentLoaded",
    function()
    {
        const targetType =
            document.getElementById(
                "target_type"
            );

        const departmentBox =
            document.getElementById(
                "departmentBox"
            );

        const roleBox =
            document.getElementById(
                "roleBox"
            );

        function updateTargetFields()
        {
            departmentBox.style.display =
                "none";

            roleBox.style.display =
                "none";

            if(targetType.value == "department")
            {
                departmentBox.style.display =
                    "block";
            }

            if(targetType.value == "role")
            {
                roleBox.style.display =
                    "block";
            }

        }

        targetType.addEventListener(
            "change",
            updateTargetFields
        );

        updateTargetFields();

    }
);

</script>

<?php include "../includes/footer.php"; ?>