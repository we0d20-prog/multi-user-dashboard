<?php
require "../includes/auth_check.php";
require "../includes/permissions.php";
require "../config/db.php";

// تخزين رقم دور المستخدم الحالي
$currentRole = $_SESSION['user_role'];

// التحقق من صلاحية مشاهدة لوحة التحكم
if(!hasPermission('dashboard.view'))
{
    die("Access Denied");
}

// جلب الإحصائيات

// إجمالي عدد المستخدمين
$totalUsers = $pdo->query("
    SELECT COUNT(*)
    FROM users
    WHERE deleted_at IS NULL
")->fetchColumn();

// عدد الأدمن
$totalAdmins = $pdo->query("
    SELECT COUNT(*)
    FROM users
    WHERE role_id = 1
    AND deleted_at IS NULL
")->fetchColumn();

// عدد المدراء
$totalManagers = $pdo->query("
    SELECT COUNT(*)
    FROM users
    WHERE role_id = 2
    AND deleted_at IS NULL
")->fetchColumn();

// عدد الموظفين
$totalEmployees = $pdo->query("
    SELECT COUNT(*)
    FROM users
    WHERE role_id = 3
    AND deleted_at IS NULL
")->fetchColumn();

// جلب آخر النشاطات
$stmt = $pdo->prepare("
    SELECT
        activity_logs.*,
        users.name
    FROM activity_logs
    JOIN users
        ON activity_logs.user_id = users.id
    ORDER BY activity_logs.id DESC
    LIMIT 5
");

$stmt->execute();

$recentActivities = $stmt->fetchAll(PDO::FETCH_ASSOC);

// جلب آخر 5 مستخدمين
$stmt = $pdo->prepare("
    SELECT
        id,
        name,
        email
    FROM users
    WHERE deleted_at IS NULL
    ORDER BY id DESC
    LIMIT 5
");

$stmt->execute();

$recentUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// جلب آخر المستخدمين مع اسم الدور
$stmt = $pdo->prepare("
    SELECT
        users.id,
        users.name,
        users.email,
        roles.role_name
    FROM users
    LEFT JOIN roles
        ON users.role_id = roles.id
    WHERE users.deleted_at IS NULL
    ORDER BY users.id DESC
    LIMIT 5
");

$stmt->execute();

$latestUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";
?>

<!-- تحميل أيقونات Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* تحسينات عامة */
    .content {
        padding: 20px;
    }

    /* بطاقات الإحصائيات */
    .stat-card {
        border-radius: 15px;
        transition: transform 0.2s, box-shadow 0.2s;
        border: none;
        overflow: hidden;
        position: relative;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .stat-card .card-body {
        padding: 1.5rem;
    }
    .stat-card .stat-icon {
        font-size: 2.5rem;
        opacity: 0.3;
        position: absolute;
        right: 15px;
        bottom: 15px;
    }
    .stat-card .stat-number {
        font-weight: 700;
        font-size: 2.2rem;
        margin-bottom: 0;
    }
    .stat-card .stat-label {
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        opacity: 0.8;
        margin-bottom: 5px;
    }

    /* ألوان البطاقات */
    .stat-primary { background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; }
    .stat-success { background: linear-gradient(135deg, #1cc88a, #13855c); color: #fff; }
    .stat-warning { background: linear-gradient(135deg, #f6c23e, #dda20a); color: #fff; }
    .stat-danger { background: linear-gradient(135deg, #e74a3b, #be2617); color: #fff; }
    .stat-info { background: linear-gradient(135deg, #36b9cc, #258391); color: #fff; }

    /* تنسيق الجداول */
    .table-dashboard thead th {
        background-color: var(--bs-tertiary-bg);
        border-bottom: 2px solid var(--bs-border-color);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: var(--bs-primary);
    }
    .table-dashboard tbody tr {
        transition: background-color 0.15s;
    }
    .table-dashboard tbody tr:hover {
        background-color: var(--bs-tertiary-bg);
    }
    .table-dashboard td {
        vertical-align: middle;
    }

    /* صورة المستخدم الدائرية */
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #fff;
        background: #6c757d;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    /* قائمة الأنشطة */
    .activity-list .list-group-item {
        border-left: 4px solid #4e73df;
        border-radius: 8px;
        margin-bottom: 8px;
        transition: background 0.2s;
    }
    .activity-list .list-group-item:hover {
        background: var(--bs-tertiary-bg);
    }
    .activity-list .activity-time {
       font-size: 0.75rem;
       color: var(--bs-secondary-color);
    }

    /* عنوان البطاقات */
    .card-header-custom {
       background: transparent;
       border-bottom: 1px solid var(--bs-border-color);
       padding: 1rem 1.5rem;
       font-weight: 600;
       color: var(--bs-primary);
    }
    .card-header-custom i {
        margin-right: 8px;
    }

    /* تنسيق الرسم البياني */
    .chart-container {
        max-width: 380px;
        margin: 0 auto;
    }

    /* ترحيب الموظف */
    .employee-welcome {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: #fff;
        border-radius: 20px;
        padding: 2rem;
    }
    .employee-welcome h3 {
        font-weight: 700;
    }
</style>

<div class="content">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="bi bi-speedometer2"></i> لوحة التحكم
        </h2>
        <span class="badge bg-primary rounded-pill px-3 py-2">
            <?= date('l, d F Y') ?>
        </span>
    </div>

    <!-- الإحصائيات تظهر للأدمن والمدير فقط -->
    <?php if(in_array($currentRole, [1,2])): ?>

    <div class="row g-4 mb-4">
        <!-- إجمالي المستخدمين -->
        <div class="col-md-3">
            <div class="card stat-card stat-primary">
                <div class="card-body">
                    <div class="stat-label">إجمالي المستخدمين</div>
                    <div class="stat-number"><?= $totalUsers; ?></div>
                    <i class="bi bi-people stat-icon"></i>
                </div>
            </div>
        </div>

        <!-- عدد الأدمن تظهر للأدمن فقط -->
        <?php if($currentRole == 1): ?>
        <div class="col-md-3">
            <div class="card stat-card stat-danger">
                <div class="card-body">
                    <div class="stat-label">المشرفون</div>
                    <div class="stat-number"><?= $totalAdmins; ?></div>
                    <i class="bi bi-shield-lock stat-icon"></i>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- عدد المدراء -->
        <div class="col-md-3">
            <div class="card stat-card stat-warning">
                <div class="card-body">
                    <div class="stat-label">المدراء</div>
                    <div class="stat-number"><?= $totalManagers; ?></div>
                    <i class="bi bi-briefcase stat-icon"></i>
                </div>
            </div>
        </div>

        <!-- عدد الموظفين -->
        <div class="col-md-3">
            <div class="card stat-card stat-success">
                <div class="card-body">
                    <div class="stat-label">الموظفون</div>
                    <div class="stat-number"><?= $totalEmployees; ?></div>
                    <i class="bi bi-person-badge stat-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- أحدث المستخدمين الذين تمت إضافتهم -->
    <div class="card shadow border-0 mb-4">
        <div class="card-header card-header-custom">
            <i class="bi bi-clock-history"></i> أحدث المستخدمين
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dashboard table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>المستخدم</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>الدور</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($latestUsers)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-3 text-muted">
                                <i class="bi bi-inbox"></i> لا يوجد مستخدمين
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($latestUsers as $user): ?>
                        <tr>
                            <td>
                                <div class="user-avatar" style="background: <?= substr(md5($user['name']), 0, 6); ?>;">
                                    <?= strtoupper(substr($user['name'], 0, 1)); ?>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($user['name']); ?></td>
                            <td><?= htmlspecialchars($user['email']); ?></td>
                            <td><span class="badge bg-secondary"><?= htmlspecialchars($user['role_name'] ?? 'غير معروف'); ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- المستخدمون الجدد + النشاطات الأخيرة في عمودين -->
    <div class="row g-4 mb-4">
        <!-- المستخدمون الجدد -->
        <div class="col-md-6">
            <div class="card shadow border-0 h-100">
                <div class="card-header card-header-custom">
                    <i class="bi bi-person-plus"></i> المستخدمون الجدد
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dashboard table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(empty($recentUsers)): ?>
                                <tr>
                                    <td colspan="3" class="text-center py-3 text-muted">
                                        <i class="bi bi-inbox"></i> لا يوجد مستخدمين
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($recentUsers as $user): ?>
                                <tr>
                                    <td>#<?= $user['id']; ?></td>
                                    <td><?= htmlspecialchars($user['name']); ?></td>
                                    <td><?= htmlspecialchars($user['email']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- النشاطات الأخيرة -->
        <div class="col-md-6">
            <div class="card shadow border-0 h-100">
                <div class="card-header card-header-custom">
                    <i class="bi bi-activity"></i> النشاطات الأخيرة
                </div>
                <div class="card-body">
                    <?php if(empty($recentActivities)): ?>
                        <p class="text-muted mb-0">
                            <i class="bi bi-info-circle"></i> لا توجد نشاطات حديثة
                        </p>
                    <?php else: ?>
                        <ul class="list-group list-group-flush activity-list">
                            <?php foreach($recentActivities as $activity): ?>
                            <li class="list-group-item bg-transparent px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?= htmlspecialchars($activity['name']); ?></strong>
                                        <span class="text-muted">·</span>
                                        <?= htmlspecialchars($activity['action']); ?>
                                    </div>
                                    <small class="activity-time">
                                        <i class="bi bi-clock"></i> <?= htmlspecialchars($activity['created_at']); ?>
                                    </small>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات المستخدمين (رسم بياني) -->
    <div class="card shadow border-0 mb-4">
        <div class="card-header card-header-custom">
            <i class="bi bi-pie-chart"></i> إحصائيات المستخدمين
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="usersChart"></canvas>
            </div>
        </div>
    </div>

    <?php endif; ?>

    <!-- واجهة الموظف تظهر للموظف فقط -->
    <?php if($currentRole == 3): ?>
    <div class="card shadow border-0 mt-4">
        <div class="employee-welcome">
            <h3>
                <i class="bi bi-person-circle"></i> مرحباً، <?= htmlspecialchars($_SESSION['user_name']); ?>
            </h3>
            <hr class="border-light opacity-25">
            <p class="mb-2"><i class="bi bi-check-circle"></i> أنت مسجل كـ <strong>موظف</strong>.</p>
            <p class="mb-0"><i class="bi bi-info-circle"></i> في المستقبل ستظهر هنا ملفك الشخصي والمهام والإشعارات.</p>
        </div>
    </div>
    <?php endif; ?>

</div>

<?php include "../includes/footer.php"; ?>

<!-- الرسم البياني يظهر للأدمن والمدير فقط -->
<?php if(in_array($currentRole, [1,2])): ?>

<!-- تحميل مكتبة Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('usersChart');
    if(ctx) {
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['المشرفون', 'المدراء', 'الموظفون'],
                datasets: [{
                    data: [
                        <?= (int)$totalAdmins; ?>,
                        <?= (int)$totalManagers; ?>,
                        <?= (int)$totalEmployees; ?>
                    ],
                    backgroundColor: [
                        '#e74a3b',
                        '#f6c23e',
                        '#1cc88a'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = ((context.parsed / total) * 100).toFixed(1);
                                return label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>

<?php endif; ?>