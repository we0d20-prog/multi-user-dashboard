<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

// التحقق من صلاحية عرض المستخدمين
if (!hasPermission('users.view')) {
    die("تم رفض الوصول");
}

// معرفة بيانات المستخدم الحالي
$currentRole = $_SESSION['user_role'];
$currentDepartment = $_SESSION['department_id'] ?? null;

// Admin يستطيع رؤية جميع المستخدمين
if ($currentRole == 1) {
    $stmt = $pdo->query("
        SELECT
            users.*,
            roles.role_name,
            departments.department_name
        FROM users
        JOIN roles ON users.role_id = roles.id
        LEFT JOIN departments ON users.department_id = departments.id
        WHERE users.deleted_at IS NULL
        ORDER BY users.id DESC
    ");
} 
// Manager يرى موظفي قسمه فقط
elseif ($currentRole == 2) {
    $stmt = $pdo->prepare("
        SELECT
            users.*,
            roles.role_name,
            departments.department_name
        FROM users
        JOIN roles ON users.role_id = roles.id
        LEFT JOIN departments ON users.department_id = departments.id
        WHERE users.deleted_at IS NULL
        AND users.department_id = ?
        ORDER BY users.id DESC
    ");
    $stmt->execute([$currentDepartment]);
} else {
    die("تم رفض الوصول");
}

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary"><i class="fas fa-users me-2"></i>المستخدمين</h2>
        <?php if (hasPermission('users.create')): ?>
            <a href="create.php" class="btn btn-primary btn-lg rounded-pill px-4">
                <i class="fas fa-user-plus me-2"></i>إضافة مستخدم
            </a>
        <?php endif; ?>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <table id="usersTable" class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>المعرف</th>
                        <th>الصورة</th>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>الدور</th>
                        <th>القسم</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="fw-semibold"><?= $user['id']; ?></td>
                        <td class="text-center">
                            <?php 
                            // التحقق: إذا كان حقل الصورة غير فارغ، والملف موجود فعلاً في المجلد
                            if (!empty($user['image'])
                            && file_exists("../assets/uploads/" . $user['image'])): 
                            ?>
                            <!-- إذا كانت الصورة موجودة، اعرضها -->
                            <img src="../assets/uploads/<?= htmlspecialchars($user['image']); ?>"
                            width="45" height="45"
                            class="rounded-circle border border-2 border-light"
                            style="object-fit:cover;"
                            alt="صورة المستخدم">
                            <?php else: ?>
                            <!-- إذا لم توجد صورة، اعرض الرمز 👤 -->
                            <span style="font-size: 1.8rem; display: inline-block; 
                            width: 45px; text-align: center; color: #6c757d;">👤</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($user['name']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td><span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill"><?= $user['role_name']; ?></span></td>
                        <td><?= $user['department_name'] ?? '<span class="text-muted">لا يوجد قسم</span>'; ?></td>
                        <td>
                            <span class="badge <?= ($user['status'] == 'active') ? 'bg-success' : 'bg-danger'; ?> bg-opacity-10 text-<?= ($user['status'] == 'active') ? 'success' : 'danger'; ?> px-3 py-2 rounded-pill">
                                <i class="fas fa-circle me-1" style="font-size:0.6rem;"></i> 
                                <?= ($user['status'] == 'active') ? 'نشط' : 'غير نشط'; ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                <?php if (hasPermission('users.edit')): ?>
                                    <a href="edit.php?id=<?= $user['id']; ?>" class="btn btn-warning btn-sm rounded-pill px-3">
                                        <i class="fas fa-edit me-1"></i> تعديل
                                    </a>
                                    <a href="toggle_status.php?id=<?= $user['id']; ?>" class="btn btn-secondary btn-sm rounded-pill px-3">
                                        <i class="fas <?= ($user['status'] == 'active') ? 'fa-user-slash' : 'fa-user-check'; ?> me-1"></i>
                                        <?= ($user['status'] == 'active') ? 'إلغاء التنشيط' : 'تنشيط'; ?>
                                    </a>
                                <?php endif; ?>
                                <?php if (hasPermission('users.delete')): ?>
                                    <a href="#" class="btn btn-danger btn-sm rounded-pill px-3 delete-btn" data-id="<?= $user['id']; ?>">
                                        <i class="fas fa-trash-alt me-1"></i> حذف
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>

<script>
$(document).ready(function(){
    $('#usersTable').DataTable({
        pageLength: 5,
        ordering: true,
        searching: true,
        paging: true,
        language: {
            search: "<i class='fas fa-search me-1'></i> بحث:"
        }
    });
});

document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(){
        let userId = this.dataset.id;
        Swal.fire({
            title: 'حذف المستخدم؟',
            text: 'هذا الإجراء لا يمكن التراجع عنه',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، حذف',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if(result.isConfirmed){
                window.location = "delete.php?id=" + userId;
            }
        });
    });
});
</script>