<?php

$stmt = $pdo->query("
SELECT site_name,
logo
FROM settings
LIMIT 1
");

$navbarSettings = $stmt->fetch(PDO::FETCH_ASSOC);

// جلب عدد الإشعارات غير المقروءة
$stmt = $pdo->prepare("
SELECT COUNT(*) AS total
FROM notifications
WHERE user_id = ?
AND is_read = 0
");

$stmt->execute([
    $_SESSION['user_id']
]);

$notificationCount = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<nav class="navbar navbar-expand-lg bg-body-secondary shadow-sm sticky-top py-2 px-3 border-bottom">

    <div class="container-fluid">

        <!-- Logo واسم الموقع -->
        <a class="d-flex align-items-center gap-2 text-decoration-none" href="../dashboard/index.php">

            <?php if(!empty($navbarSettings['logo'])): ?>
                <img
                    src="../uploads/logos/<?= htmlspecialchars($navbarSettings['logo']); ?>"
                    alt="Logo"
                    style="max-height: 45px; width: auto; object-fit: contain;"
                    class="d-inline-block align-text-top rounded bg-light p-1"
                >
            <?php endif; ?>

            <span id="brandText" class="fs-5 fw-bold text-body">
                <?= htmlspecialchars($navbarSettings['site_name'] ?? 'Employee Hub'); ?>
            </span>

        </a>

        <!-- العناصر الجانبية (يمين) -->
        <div class="d-flex align-items-center gap-3 ms-auto">

            <!-- زر تغيير الثيم -->
            <button 
                id="themeToggle"
                type="button"
                class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-flex align-items-center gap-1"
                title="تبديل الوضع الليلي"
            >
                <i class="fa fa-moon-o" id="themeIcon"></i> 
                <span class="d-none d-sm-inline" id="themeText">Dark Mode</span>
            </button>

            <!-- زر الإشعارات -->
            <a 
                href="../notifications/index.php"
                id="notificationLink"
                class="text-decoration-none position-relative text-body"
                style="font-size: 1.3rem; transition: transform 0.2s;"
                onmouseover="this.style.transform='scale(1.1)'" 
                onmouseout="this.style.transform='scale(1)'"
            >
                <i class="fa fa-bell"></i>
                <?php if(!empty($notificationCount['total']) && $notificationCount['total'] > 0): ?>
                    <span 
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-body"
                        style="font-size: 0.65rem; padding: 0.25rem 0.5rem;"
                    >
                        <?= (int)$notificationCount['total']; ?>
                    </span>
                <?php endif; ?>
            </a>

            <!-- اسم المستخدم -->
            <div id="userBadge" class="d-flex align-items-center gap-2 bg-body rounded-pill px-3 py-1 border text-body">
                <i class="fa fa-user-circle fa-lg text-primary"></i>
                <span class="fw-light small text-truncate" style="max-width: 120px;">
                    <?= htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>
                </span>
            </div>

        </div>

    </div>

</nav>

