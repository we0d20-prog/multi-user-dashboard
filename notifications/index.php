<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

/* التحقق من صلاحية عرض الإشعارات */
if(!hasPermission('notifications.view'))
{
    die("Access Denied");
}

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

//جلب رقم المستخدم الحالي
$userId = $_SESSION['user_id'];

//جلب الاشعارات الخاصه بالمستخدم الحالي فقط
$stmt = $pdo->prepare("
SELECT *
FROM notifications
WHERE user_id = ?
ORDER BY created_at DESC
");

$stmt->execute([$userId]);

$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

//تعليم اشعارات المستخدم الحالي فقط كمقروء
$update = $pdo->prepare("
UPDATE notifications
SET is_read = 1
WHERE user_id = ?
AND is_read = 0
");

$update->execute([
    $userId
]);

?>

<div class="content p-3 p-md-4">

    <div class="d-flex align-items-center gap-2 mb-4">
        <i class="fa fa-bell fs-1 text-primary"></i>
        <div>
            <h2 class="fw-bold mb-0">الإشعارات</h2>
            <p class="text-body-secondary small mb-0">جميع الإشعارات الخاصة بك</p>
        </div>
    </div>

    <div class="card bg-body text-body shadow-sm border-0 rounded-4">
        <div class="card-header bg-body-tertiary py-3 border-bottom-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold d-flex align-items-center gap-2">
                <i class="fa fa-list-ul text-secondary"></i> قائمة الإشعارات
                <span class="badge bg-secondary rounded-pill ms-2"><?= count($notifications); ?></span>
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="notificationsTable" class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>العنوان</th>
                            <th>الرسالة</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($notifications)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-body-secondary">
                                    <i class="fa fa-inbox fs-1 d-block mb-2"></i>
                                    لا توجد إشعارات
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($notifications as $notification): ?>
                            <tr>
                                <td class="fw-semibold"><?= htmlspecialchars($notification['title']); ?></td>
                                <td><?= htmlspecialchars($notification['message']); ?></td>
                                <td>
                                    <?php if($notification['is_read'] == 0): ?>
                                        <span class="badge bg-danger rounded-pill px-3 py-2">
                                            <i class="fa fa-envelope me-1"></i> غير مقروء
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            <i class="fa fa-check-circle me-1"></i> مقروء
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td><small class="text-body-secondary"><?= $notification['created_at']; ?></small></td>
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
    $('#notificationsTable').DataTable({
        pageLength: 10,
        ordering: true,
        searching: true,
        paging: true,
        language: {
            search: "بحث:",
            lengthMenu: "عرض _MENU_ سجل",
            info: "عرض _START_ إلى _END_ من _TOTAL_ إشعار",
            infoEmpty: "لا توجد إشعارات",
            infoFiltered: "(تمت التصفية من _MAX_ إشعار إجمالي)"
        }
    });
});
</script>

<?php include "../includes/footer.php"; ?>