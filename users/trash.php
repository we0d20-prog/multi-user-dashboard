<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

if(!hasPermission('users.view'))
{
    die("Access Denied");
}

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

//جلب المستخدمين الموجودين بسلة المحذوفات
$stmt = $pdo->query("
SELECT users.*,roles.role_name
FROM users
JOIN roles
ON users.role_id = roles.id
WHERE users.deleted_at IS NOT NULL
ORDER BY users.deleted_at DESC
");

$users = $stmt->fetchAll();

?>

<div class="content p-3 p-md-4">

    <div class="d-flex align-items-center gap-2 mb-4">
        <i class="fa fa-trash fs-1 text-danger"></i>
        <div>
            <h2 class="fw-bold mb-0">سلة المحذوفات</h2>
            <p class="text-body-secondary small mb-0">استعادة أو حذف نهائي للمستخدمين المحذوفين</p>
        </div>
    </div>

    <div class="card bg-body text-body shadow-sm border rounded-4">
        <div class="card-header bg-body-tertiary py-3 border-bottom-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold d-flex align-items-center gap-2">
                <i class="fa fa-users text-secondary"></i> المستخدمين المحذوفين
                <span class="badge bg-secondary rounded-pill ms-2"><?= count($users); ?></span>
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="trashTable" class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-danger">
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>الدور</th>
                            <th>تاريخ الحذف</th>
                            <th class="text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($users)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-body-secondary">
                                    <i class="fa fa-inbox fs-1 d-block mb-2"></i>
                                    لا يوجد مستخدمين في سلة المحذوفات
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($users as $user): ?>
                            <tr>
                                <td><span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill"><?= $user['id']; ?></span></td>
                                <td class="fw-semibold"><?= htmlspecialchars($user['name']); ?></td>
                                <td><?= htmlspecialchars($user['email']); ?></td>
                                <td><span class="badge bg-primary-subtle text-primary-emphasis rounded-pill px-3 py-2"><?= htmlspecialchars($user['role_name']); ?></span></td>
                                <td><small class="text-body-secondary">
                                    <i class="fa fa-clock-o me-1"></i>
                                    <?= htmlspecialchars($user['deleted_at']); ?></small>
                                </td>
                                <td class="text-center">
                                    <a href="restore.php?id=<?= $user['id']; ?>" class="btn btn-success btn-sm rounded-pill px-3 d-inline-flex align-items-center gap-1">
                                        <i class="fa fa-undo"></i> استعادة
                                    </a>
                                    <a href="force_delete.php?id=<?= $user['id']; ?>" 
                                       class="btn btn-danger btn-sm rounded-pill px-3 d-inline-flex align-items-center gap-1"
                                       onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم نهائياً؟');">
                                        <i class="fa fa-trash"></i> حذف نهائي
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
$(document).ready(function(){
    $('#trashTable').DataTable({
        pageLength: 10,
        ordering: true,
        searching: true,
        paging: true,
        language: {
            search: "بحث:",
            lengthMenu: "عرض _MENU_ سجل",
            info: "عرض _START_ إلى _END_ من _TOTAL_ مستخدم",
            infoEmpty: "لا يوجد مستخدمين",
            infoFiltered: "(تمت التصفية من _MAX_ مستخدم إجمالي)"
        }
    });
});
</script>

<?php include "../includes/footer.php"; ?>