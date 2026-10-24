<?php
require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";
require "../includes/activity_log.php";

// الأدمن فقط
if($_SESSION['user_role'] != 1) { die("Access Denied"); }
if(!hasPermission('announcements.edit')) { die("Access Denied"); }

$announcementId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($announcementId <= 0) { die("Invalid Announcement ID"); }

// جلب الأقسام
$stmt = $pdo->query("SELECT id, department_name FROM departments ORDER BY department_name ASC");
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// جلب بيانات الإعلان
$stmt = $pdo->prepare("SELECT id, title, message, target_type, target_id, status FROM announcements WHERE id = ? LIMIT 1");
$stmt->execute([$announcementId]);
$announcement = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$announcement) { die("Announcement Not Found"); }

$error = "";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $title = trim($_POST['title'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $targetType = $_POST['target_type'] ?? '';
    $targetId = $_POST['target_id'] ?? null;
    $status = $_POST['status'] ?? 'active';

    if($title == '') { $error = "الرجاء إدخال عنوان الإعلان."; }
    elseif($message == '') { $error = "الرجاء إدخال محتوى الإعلان."; }
    elseif(!in_array($targetType, ['all', 'department', 'role'])) { $error = "نوع الهدف غير صحيح."; }
    elseif($targetType == 'department' && empty($targetId)) { $error = "الرجاء اختيار القسم."; }
    elseif($targetType == 'role' && empty($targetId)) { $error = "الرجاء اختيار الدور."; }
    elseif(!in_array($status, ['active', 'inactive'])) { $error = "حالة الإعلان غير صحيحة."; }

    if($error == '')
    {
        try
        {
            if($targetType == 'all') { $targetId = null; }
            else { $targetId = (int)$targetId; }

            $stmt = $pdo->prepare("UPDATE announcements SET title = ?, message = ?, target_type = ?, target_id = ?, status = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$title, $message, $targetType, $targetId, $status, $announcementId]);

            logActivity($pdo, $_SESSION['user_id'], "Updated Announcement #".$announcementId);
            header("Location: index.php?success=updated");
            exit;
        }
        catch(Exception $e)
        {
            $error = "حدث خطأ أثناء تحديث الإعلان.";
        }
    }

    $announcement['title'] = $title;
    $announcement['message'] = $message;
    $announcement['target_type'] = $targetType;
    $announcement['target_id'] = $targetId;
    $announcement['status'] = $status;
}

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";
?>

<div class="content p-3 p-md-4">

    <!-- رأس الصفحة -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-pencil-square fs-1 text-primary"></i>
            <div>
                <h2 class="fw-bold mb-0">تعديل الإعلان</h2>
                <p class="text-muted mb-0 small">قم بتحديث بيانات الإعلان الحالي</p>
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

    <!-- البطاقة الرئيسية -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold d-flex align-items-center gap-2">
                <i class="bi bi-pencil"></i> تحرير الإعلان
            </h5>
            <span class="badge <?= $announcement['status'] == 'active' ? 'bg-success' : 'bg-secondary'; ?> rounded-pill px-3 py-2">
                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                <?= $announcement['status'] == 'active' ? 'فعال' : 'غير فعال'; ?>
            </span>
        </div>

        <div class="card-body p-4 p-md-5">

            <form method="POST" action="edit.php?id=<?= $announcementId; ?>">

                <!-- العنوان والحالة -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="title" id="title" class="form-control form-control-lg rounded-3" 
                                   placeholder="عنوان الإعلان" value="<?= htmlspecialchars($announcement['title']); ?>" required>
                            <label for="title"><i class="bi bi-heading me-1"></i> العنوان</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="status" id="status" class="form-select form-select-lg rounded-3">
                                <option value="active" <?= $announcement['status'] == 'active' ? 'selected' : ''; ?>>فعال</option>
                                <option value="inactive" <?= $announcement['status'] == 'inactive' ? 'selected' : ''; ?>>غير فعال</option>
                            </select>
                            <label for="status"><i class="bi bi-toggle-on me-1"></i> الحالة</label>
                        </div>
                    </div>
                </div>

                <!-- المحتوى -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea name="message" id="message" class="form-control rounded-3" 
                                      placeholder="محتوى الإعلان" rows="6" style="min-height: 150px;" required><?= htmlspecialchars($announcement['message']); ?></textarea>
                            <label for="message"><i class="bi bi-textarea me-1"></i> المحتوى</label>
                        </div>
                    </div>
                </div>

                <!-- جهة الإرسال -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h6 class="text-muted text-uppercase fw-bold small mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-send"></i> إرسال إلى
                        </h6>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="target_type" id="target_type" class="form-select form-select-lg rounded-3" required>
                                <option value="all" <?= $announcement['target_type'] == 'all' ? 'selected' : ''; ?>>جميع الموظفين</option>
                                <option value="department" <?= $announcement['target_type'] == 'department' ? 'selected' : ''; ?>>قسم محدد</option>
                                <option value="role" <?= $announcement['target_type'] == 'role' ? 'selected' : ''; ?>>دور محدد</option>
                            </select>
                            <label for="target_type"><i class="bi bi-people me-1"></i> الهدف</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- حقل القسم (يظهر عند اختيار "قسم محدد") -->
                        <div id="departmentBox" style="display: none;">
                            <div class="form-floating">
                                <select name="target_id" id="departmentSelect" class="form-select form-select-lg rounded-3">
                                    <option value="">اختر القسم</option>
                                    <?php foreach($departments as $department): ?>
                                        <option value="<?= (int)$department['id']; ?>" 
                                            <?= ($announcement['target_type'] == 'department' && $announcement['target_id'] == $department['id']) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($department['department_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="departmentSelect"><i class="bi bi-building me-1"></i> القسم</label>
                            </div>
                        </div>
                        <!-- حقل الدور (يظهر عند اختيار "دور محدد") -->
                        <div id="roleBox" style="display: none;">
                            <div class="form-floating">
                                <select name="target_id" id="roleSelect" class="form-select form-select-lg rounded-3">
                                    <option value="">اختر الدور</option>
                                    <option value="1" <?= ($announcement['target_type'] == 'role' && $announcement['target_id'] == 1) ? 'selected' : ''; ?>>مدير</option>
                                    <option value="2" <?= ($announcement['target_type'] == 'role' && $announcement['target_id'] == 2) ? 'selected' : ''; ?>>مشرف</option>
                                    <option value="3" <?= ($announcement['target_type'] == 'role' && $announcement['target_id'] == 3) ? 'selected' : ''; ?>>موظف</option>
                                </select>
                                <label for="roleSelect"><i class="bi bi-person-badge me-1"></i> الدور</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- أزرار الإجراء -->
                <div class="d-flex flex-wrap gap-3 mt-5 pt-4 border-top">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle"></i> تحديث الإعلان
                    </button>
                    <a href="index.php" class="btn btn-outline-secondary btn-lg rounded-pill px-5 d-flex align-items-center gap-2">
                        <i class="bi bi-x-circle"></i> إلغاء
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<!-- JavaScript لإظهار/إخفاء حقول القسم/الدور -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const targetType = document.getElementById("target_type");
    const departmentBox = document.getElementById("departmentBox");
    const roleBox = document.getElementById("roleBox");

    function updateTargetFields() {
        departmentBox.style.display = "none";
        roleBox.style.display = "none";
        if (targetType.value == "department") {
            departmentBox.style.display = "block";
        } else if (targetType.value == "role") {
            roleBox.style.display = "block";
        }
    }

    targetType.addEventListener("change", updateTargetFields);
    updateTargetFields();
});
</script>

<?php include "../includes/footer.php"; ?>