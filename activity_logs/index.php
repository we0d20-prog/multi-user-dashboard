<?php

require "../includes/auth_check.php";
require "../includes/permissions.php";
require "../config/db.php";

/* السماح فقط لمن يملك صلاحية عرض السجلات*/
if(!hasPermission('activity_logs.view'))
{
    die("Access Denied");
}

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

/* المستخدم المختار من الفلتر */
$selectedUser =
$_GET['user_id'] ?? '';

//فلترة التاريخ
$fromDate =
$_GET['from_date'] ?? '';

$toDate = 
$_GET['to_date'] ?? '';

//شروط الفلتره
$conditions = [];

/*جلب جميع المستخدمين للقائمة المنسدلة */
$users = $pdo->query("
SELECT id,name
FROM users
ORDER BY name ASC
")->fetchAll();

/* بناء استعلام السجلات */
$sql = "
SELECT
activity_logs.id,
activity_logs.action,
activity_logs.created_at,
activity_logs.ip_address,
activity_logs.browser,
activity_logs.operating_system,
users.name

FROM activity_logs

JOIN users
ON activity_logs.user_id = users.id
";

$params = [];

/* فلترة حسب المستخدم */
if(!empty($selectedUser))
{
    $conditions[] =
    "activity_logs.user_id = ?";

    $params[] = $selectedUser;
}

//فلتره من تاريخ
if(!empty($fromDate))
{
    $conditions[] =
    "DATE(activity_logs.created_at) >= ?";

    $params[] = $fromDate;
}

//فلتره الى تاريخ
if(!empty($toDate))
{
    $conditions[] =
    "DATE(activity_logs.created_at) <= ?";

    $params[] = $toDate;
}

//اذ وجدت شروط WHERE اضافه
if(count($conditions) > 0)
{
    $sql .= "
    WHERE
    " . implode(" AND ", $conditions);
}

/* ترتيب السجلات من الأحدث للأقدم */
$sql .= "
ORDER BY activity_logs.id DESC
";

/* تنفيذ الاستعلام */
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$logs = $stmt->fetchAll();

//جلب احصائيه اكثر المستحدمين نشاطا
$topUsers = $pdo->query("
SELECT 
users.name,
COUNT(activity_logs.id) as total_actions
FROM activity_logs
JOIN users
ON activity_logs.user_id = users.id
GROUP BY users.id
ORDER BY total_actions DESC
LIMIT 5")->fetchAll();

?>

<div class="content p-3 p-md-4">

    <div class="d-flex align-items-center gap-2 mb-4">
        <i class="fa fa-history fs-1 text-primary"></i>
        <div>
            <h2 class="fw-bold mb-0">سجل النشاطات</h2>
            <p class="text-body-secondary small mb-0">مراقبة جميع أنشطة المستخدمين في النظام</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-body-tertiary py-3 border-bottom-0">
            <h5 class="mb-0 fw-semibold">
                <i class="fa fa-filter me-2 text-secondary"></i> تصفية النشاطات
            </h5>
        </div>

        <div class="card-body">
            <!-- فلترة المستخدم -->
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        <i class="fa fa-user me-1"></i> المستخدم
                    </label>
                    <select name="user_id" class="form-select form-select-lg rounded-3">
                        <option value="">جميع المستخدمين</option>
                        <?php foreach($users as $user): ?>
                        <option value="<?= $user['id']; ?>" <?= ($selectedUser == $user['id']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($user['name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        <i class="fa fa-calendar me-1"></i> من تاريخ
                    </label>
                    <input type="date" name="from_date" class="form-control form-control-lg rounded-3" value="<?= $fromDate; ?>">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        <i class="fa fa-calendar me-1"></i> إلى تاريخ
                    </label>
                    <input type="date" name="to_date" class="form-control form-control-lg rounded-3" value="<?= $toDate; ?>">
                </div>

                <div class="col-md-3">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4 d-flex align-items-center gap-2">
                            <i class="fa fa-search"></i> تصفية
                        </button>
                        <a href="index.php" class="btn btn-outline-secondary btn-lg rounded-pill px-4 d-flex align-items-center gap-2">
                            <i class="fa fa-undo"></i> إلغاء
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- جدول السجلات -->
    <div class="card shadow-sm border-0 rounded-4 mt-4">
        <div class="card-header bg-body-tertiary py-3 border-bottom-0">
            <h5 class="mb-0 fw-semibold d-flex align-items-center gap-2">
                <i class="fa fa-table text-secondary"></i> سجل النشاطات
                <span class="badge bg-secondary rounded-pill ms-2"><?= count($logs); ?></span>
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="logsTable" class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>المستخدم</th>
                            <th>الإجراء</th>
                            <th>عنوان IP</th>
                            <th>المتصفح</th>
                            <th>نظام التشغيل</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($logs as $log): ?>
                        <tr>
                            <td><span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill"><?= $log['id']; ?></span></td>
                            <td class="fw-semibold"><?= htmlspecialchars($log['name']); ?></td>
                            <td><span class="badge bg-info-subtle text-info-emphasis rounded-pill px-3 py-2"><?= htmlspecialchars($log['action']); ?></span></td>
                            <td><code class="bg-body-secondary p-1 rounded"><?= htmlspecialchars($log['ip_address']); ?></code></td>
                            <td><?= htmlspecialchars($log['browser']); ?></td>
                            <td><?= htmlspecialchars($log['operating_system']); ?></td>
                            <td><small class="text-body-secondary"><?= $log['created_at']; ?></small></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- أكثر المستخدمين نشاطاً -->
    <div class="card shadow-sm border-0 rounded-4 mt-4">
        <div class="card-header bg-body-tertiary py-3 border-bottom-0">
            <h5 class="mb-0 fw-semibold">
                <i class="fa fa-trophy text-warning me-2"></i> أكثر المستخدمين نشاطاً
            </h5>
        </div>

        <div class="card-body">
            <div class="list-group list-group-flush">
                <?php foreach($topUsers as $index => $user): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge <?= $index == 0 ? 'bg-warning text-dark' : 'bg-secondary'; ?> rounded-pill px-3 py-2">
                            <?= $index + 1; ?>
                        </span>
                        <strong><?= htmlspecialchars($user['name']); ?></strong>
                    </div>
                    <span class="badge bg-primary rounded-pill px-3 py-2">
                        <i class="fa fa-pencil-square-o me-1"></i> <?= $user['total_actions']; ?> إجراء
                    </span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>

<script>
$(document).ready(function(){
    $('#logsTable').DataTable({
        pageLength: 10,
        ordering: true,
        searching: true,
        paging: true,
        language: {
            search: "بحث:",
            lengthMenu: "عرض _MENU_ سجل",
            info: "عرض _START_ إلى _END_ من _TOTAL_ سجل",
            infoEmpty: "لا توجد سجلات",
            infoFiltered: "(تمت التصفية من _MAX_ سجل إجمالي)"
        }
    });
});
</script>

<?php include "../includes/footer.php"; ?>