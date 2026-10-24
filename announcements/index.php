<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

// بيانات المستخدم الحالي
$currentUserId = $_SESSION['user_id'];
$currentRole = (int)$_SESSION['user_role'];
$currentDepartment = $_SESSION['department_id'] ?? null;

// التحقق من صلاحية مشاهدة الإعلانات
if(!hasPermission('announcements.view'))
{
    die("Access Denied");
}

// جلب الإعلانات حسب الدور
if($currentRole == 1)
{
    $stmt = $pdo->prepare("
        SELECT
            announcements.id,
            announcements.title,
            announcements.message,
            announcements.target_type,
            announcements.target_id,
            announcements.status,
            announcements.created_by,
            announcements.created_at,
            announcements.updated_at,
            users.name AS creator_name
        FROM announcements
        LEFT JOIN users
        ON announcements.created_by = users.id
        ORDER BY announcements.created_at DESC
    ");

    $stmt->execute();
}
else
{
    if(empty($currentDepartment))
    {
        $currentDepartment = 0;
    }

    $stmt = $pdo->prepare("
        SELECT
            announcements.id,
            announcements.title,
            announcements.message,
            announcements.target_type,
            announcements.target_id,
            announcements.status,
            announcements.created_by,
            announcements.created_at,
            announcements.updated_at,
            users.name AS creator_name
        FROM announcements
        LEFT JOIN users
        ON announcements.created_by = users.id
        WHERE announcements.status = 'active'
        AND
        (
            announcements.target_type = 'all'
            OR
            (
                announcements.target_type = 'department'
                AND announcements.target_id = ?
            )
            OR
            (
                announcements.target_type = 'role'
                AND announcements.target_id = ?
            )
        )
        ORDER BY announcements.created_at DESC
    ");

    $stmt->execute([
        $currentDepartment,
        $currentRole
    ]);
}

$announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

?>

<style>
    /* بطاقات الإعلانات — تأثير رفع خفيف */
    .announcement-card {
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .announcement-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .75rem 1.5rem rgba(0,0,0,.08) !important;
    }

    /* رأس البطاقة — تدرج ثابت يظهر جيداً في الوضعين */
    .announcement-card .card-header {
        background: linear-gradient(135deg, #667eea, #764ba2) !important;
    }

    /* Badge الحالة داخل رأس البطاقة */
    .announcement-card .badge {
        font-weight: 600;
        letter-spacing: .2px;
    }

    /* نص الرسالة */
    .announcement-card .card-text {
        max-height: 180px;
        overflow-y: auto;
    }

    /* شريط التمرير أنيق */
    .announcement-card .card-text::-webkit-scrollbar {
        width: 5px;
    }
    .announcement-card .card-text::-webkit-scrollbar-thumb {
        background: var(--bs-secondary-bg);
        border-radius: 50px;
    }

    /* أيقونة الحالة (النقطة) */
    .status-dot {
        font-size: .5rem;
        vertical-align: middle;
    }

    /* تحسين الكارد الفارغ */
    .empty-icon {
        background: var(--bs-tertiary-bg);
    }
</style>

<div class="content p-3 p-md-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div class="d-flex align-items-center gap-3">

            

            <div>

                <h2 class="fa fa-bullhorn me-2">
                    الإعلانات
                </h2>

                <p class="text-body-secondary mb-0 small">
                    جميع إعلانات الشركة في مكان واحد
                </p>

            </div>

        </div>

        <!-- زر إضافة إعلان -->
        <?php if(hasPermission('announcements.create')): ?>

            <a href="create.php"
               class="btn btn-primary btn-lg rounded-pill px-4 d-flex align-items-center gap-2 shadow-sm">

                <i class="bi bi-plus-circle"></i>

                إضافة إعلان

            </a>

        <?php endif; ?>

    </div>

    <!-- رسالة حسب الدور -->
    <?php if($currentRole == 1): ?>

        <div class="alert alert-primary border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4">

            <i class="bi bi-info-circle-fill fs-4"></i>

            <span>
                أنت تشاهد
                <strong>جميع الإعلانات</strong>
                بصلاحيات المدير.
            </span>

        </div>

    <?php elseif($currentRole == 2): ?>

        <div class="alert alert-info border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4">

            <i class="bi bi-info-circle-fill fs-4"></i>

            <span>
                أنت تشاهد الإعلانات المتاحة لـ
                <strong>قسمك ودورك</strong>.
            </span>

        </div>

    <?php elseif($currentRole == 3): ?>

        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4">

            <i class="bi bi-info-circle-fill fs-4"></i>

            <span>
                أنت تشاهد الإعلانات المتاحة
                <strong>لك</strong>.
            </span>

        </div>

    <?php endif; ?>

    <!-- شريط الإحصائيات -->
    <div class="row g-3 mb-4">

        <div class="col-6 col-md-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center gap-3">

                    <div>

                        <div class="text-body-secondary small">
                            إجمالي الإعلانات
                        </div>

                        <div class="fw-bold fs-4">
                            <?= count($announcements); ?>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-6 col-md-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center gap-3">

                    <div>

                        <div class="text-body-secondary small">
                            الإعلانات الفعالة
                        </div>

                        <div class="fw-bold fs-4">
                            <?= count(array_filter($announcements, fn($a) => $a['status'] == 'active')); ?>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-6 col-md-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center gap-3">

                    <div>

                        <div class="text-body-secondary small">
                            للجميع
                        </div>

                        <div class="fw-bold fs-4">
                            <?= count(array_filter($announcements, fn($a) => $a['target_type'] == 'all')); ?>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-6 col-md-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center gap-3">

                    <div>

                        <div class="text-body-secondary small">
                            حسب القسم
                        </div>

                        <div class="fw-bold fs-4">
                            <?= count(array_filter($announcements, fn($a) => $a['target_type'] == 'department')); ?>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- لا توجد إعلانات -->
    <?php if(empty($announcements)): ?>

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body text-center py-5">

                <h5 class="fw-bold mt-2">
                    لا توجد إعلانات
                </h5>

                <p class="text-body-secondary mb-3">
                    لم يتم نشر أي إعلانات حتى الآن.
                </p>

                <?php if(hasPermission('announcements.create')): ?>

                    <a href="create.php"
                       class="btn btn-primary rounded-pill px-4">

                        <i class="bi bi-plus-circle me-1"></i>

                        إضافة أول إعلان

                    </a>

                <?php endif; ?>

            </div>

        </div>

    <?php else: ?>

        <!-- بطاقات الإعلانات -->
        <div class="row g-4">

            <?php foreach($announcements as $announcement): ?>

                <div class="col-md-6 col-xl-4">

                    <div class="card announcement-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">

                        <!-- رأس الإعلان -->
                        <div class="card-header text-white border-0 py-3">

                            <div class="d-flex justify-content-between align-items-start gap-2">

                                <h5 class="mb-0 fw-bold text-truncate flex-grow-1"
                                    title="<?= htmlspecialchars($announcement['title']); ?>">

                                    <?= htmlspecialchars($announcement['title']); ?>

                                </h5>

                                <?php if($announcement['status'] == 'active'): ?>

                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill flex-shrink-0">

                                        <i class="bi bi-circle-fill status-dot me-1"></i>

                                        فعال

                                    </span>
                                <?php else: ?>

                                    <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill flex-shrink-0">

                                        <i class="bi bi-circle-fill status-dot me-1"></i>

                                        غير فعال

                                    </span>
                                <?php endif; ?>

                            </div>

                        </div>

                        <!-- محتوى الإعلان -->
                        <div class="card-body">

                            <p class="card-text text-body-secondary mb-0"
                               style="line-height:1.7;">

                                <?= nl2br(htmlspecialchars($announcement['message'])); ?>

                            </p>

                        </div>

                        <!-- معلومات الإعلان -->
                        <div class="card-footer bg-body-tertiary border-top">

                            <div class="d-flex flex-wrap gap-2 mb-2">

                                <!-- نوع الاستهداف -->
                                <?php if($announcement['target_type'] == 'all'): ?>

                                    <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill px-3 py-2">

                                        <i class="bi bi-people-fill me-1"></i>

                                        جميع الموظفين

                                    </span>
                                <?php elseif($announcement['target_type'] == 'department'): ?>

                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill px-3 py-2">

                                        <i class="bi bi-building me-1"></i>

                                        قسم محدد

                                    </span>
                                <?php elseif($announcement['target_type'] == 'role'): ?>

                                    <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-2">

                                        <i class="bi bi-person-badge me-1"></i>

                                        دور محدد

                                    </span>
                                <?php else: ?>

                                    <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-3 py-2">

                                        <?= htmlspecialchars($announcement['target_type']); ?>

                                    </span>
                                <?php endif; ?>

                            </div>

                            <div class="d-flex justify-content-between align-items-center small text-body-secondary">

                                <span>

                                    <i class="bi bi-person-circle me-1"></i>

                                    <?= htmlspecialchars($announcement['creator_name'] ?? 'غير معروف'); ?>

                                </span>

                                <span>

                                    <i class="bi bi-clock me-1"></i>

                                    <?= date(
                                        'Y-m-d H:i',
                                        strtotime($announcement['created_at'])
                                    ); ?>

                                </span>

                            </div>

                        </div>

                        <!-- أزرار الإجراءات -->
                        <?php if(
                            hasPermission('announcements.edit')
                            ||
                            hasPermission('announcements.delete')
                        ): ?>

                            <div class="card-footer bg-body border-top">

                                <div class="d-flex gap-2">

                                    <?php if(hasPermission('announcements.edit')): ?>

                                        <a href="edit.php?id=<?= (int)$announcement['id']; ?>"
                                           class="btn btn-outline-warning btn-sm rounded-pill flex-fill">

                                            <i class="bi bi-pencil me-1"></i>

                                            تعديل

                                        </a>
                                    <?php endif; ?>

                                    <?php if(hasPermission('announcements.delete')): ?>

                                        <a href="delete.php?id=<?= (int)$announcement['id']; ?>"
                                           class="btn btn-outline-danger btn-sm rounded-pill flex-fill"
                                           onclick="return confirm('هل أنت متأكد من حذف هذا الإعلان؟');">

                                            <i class="bi bi-trash me-1"></i>

                                            حذف

                                        </a>
                                    <?php endif; ?>

                                </div>

                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>

<?php include "../includes/footer.php"; ?>