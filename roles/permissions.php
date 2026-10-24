<?php
require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

/* السماح للأدمن فقط بإدارة الصلاحيات */
if($_SESSION['user_role'] != 1)
{
    die("تم رفض الوصول");
}

/* جلب رقم الدور */
$roleId = (int)($_GET['id'] ?? 0);

/* جلب بيانات الدور */
$stmt = $pdo->prepare("
    SELECT *
    FROM roles
    WHERE id = ?
");

$stmt->execute([$roleId]);

$role = $stmt->fetch();

if(!$role)
{
    die("الدور غير موجود");
}

/* جلب جميع الصلاحيات الموجودة بالنظام */
$permissions = $pdo->query("
    SELECT *
    FROM permissions
    ORDER BY permission_name ASC
")->fetchAll();

/* جلب الصلاحيات الحالية لهذا الدور */
$stmt = $pdo->prepare("
    SELECT permission_id
    FROM role_permissions
    WHERE role_id = ?
");

$stmt->execute([$roleId]);

$currentPermissions = $stmt->fetchAll(PDO::FETCH_COLUMN);

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";
?>

<?php
/* رسالة النجاح */
if(isset($_GET['success']))
{
?>
<script>
document.addEventListener('DOMContentLoaded',function(){

    Swal.fire({
        icon:'success',
        title:'نجاح',
        text:'تم تحديث الصلاحيات بنجاح'
    });

});
</script>
<?php
}
?>

<div class="content p-3 p-md-4">

    <!-- عنوان الصفحة -->
    <div class="d-flex align-items-center gap-2 mb-4">

        <i class="fa fa-lock fs-3 text-info"></i>

        <h2 class="fw-bold mb-0">
            إدارة الصلاحيات
        </h2>

        <span class="badge bg-primary rounded-pill px-3 py-2">
            <?= htmlspecialchars($role['role_name']); ?>
        </span>

    </div>

    <!-- بطاقة الصلاحيات -->
    <div class="card shadow-sm border-0 rounded-3">

        <!-- رأس البطاقة -->
        <div class="card-header bg-body-tertiary py-3 border-bottom-0">

            <h5 class="mb-0 fw-semibold">

                <i class="fa fa-check-circle me-2 text-success"></i>

                تعيين الصلاحيات لـ

                <strong>
                    <?= htmlspecialchars($role['role_name']); ?>
                </strong>

            </h5>

        </div>

        <!-- محتوى البطاقة -->
        <div class="card-body">

            <form action="save_permissions.php" method="POST">

                <!-- رقم الدور -->
                <input
                    type="hidden"
                    name="role_id"
                    value="<?= $roleId; ?>"
                >

                <div class="row g-3">

                    <?php foreach($permissions as $permission): ?>

                    <div class="col-md-6 col-lg-4">

                        <div class="form-check form-switch p-3 bg-body-tertiary rounded-3 border">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                                name="permissions[]"
                                value="<?= $permission['id']; ?>"
                                <?= in_array($permission['id'],$currentPermissions) ? 'checked' : ''; ?>
                                id="perm_<?= $permission['id']; ?>"
                            >

                            <label
                                class="form-check-label fw-semibold"
                                for="perm_<?= $permission['id']; ?>"
                            >
                                <?= htmlspecialchars($permission['permission_name']); ?>
                            </label>

                        </div>

                    </div>

                    <?php endforeach; ?>

                </div>

                <!-- الأزرار -->
                <div class="mt-4 d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary rounded-pill px-4 d-flex align-items-center gap-2"
                    >
                        <i class="fa fa-save"></i>
                        حفظ الصلاحيات
                    </button>

                    <a
                        href="index.php"
                        class="btn btn-secondary rounded-pill px-4 d-flex align-items-center gap-2"
                    >
                        <i class="fa fa-arrow-left"></i>
                        رجوع
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>