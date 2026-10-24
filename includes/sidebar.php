<div class="sidebar bg-body-secondary border-end vh-100 d-flex flex-column p-3"
     style="width: 250px; min-width: 250px;">

    <ul class="nav flex-column gap-1">

        <!-- لوحة التحكم -->
        <?php if(hasPermission('dashboard.view')): ?>
        <li class="nav-item">
            <a href="../dashboard/index.php"
               class="nav-link text-body rounded-3"
               onmouseover="this.classList.add('bg-body-tertiary')"
               onmouseout="this.classList.remove('bg-body-tertiary')">
                <i class="fa fa-dashboard me-2"></i> لوحة التحكم
            </a>
        </li>
        <?php endif; ?>

        <!-- المستخدمون -->
        <?php if(hasPermission('users.view')): ?>
        <li class="nav-item">
            <a href="../users/index.php"
               class="nav-link text-body rounded-3"
               onmouseover="this.classList.add('bg-body-tertiary')"
               onmouseout="this.classList.remove('bg-body-tertiary')">
                <i class="fa fa-users me-2"></i> المستخدمون
            </a>
        </li>
        <?php endif; ?>

        <!-- الأدوار - للأدمن فقط -->
        <?php if($_SESSION['user_role'] == 1): ?>
        <li class="nav-item">
            <a href="../roles/index.php"
               class="nav-link text-body rounded-3"
               onmouseover="this.classList.add('bg-body-tertiary')"
               onmouseout="this.classList.remove('bg-body-tertiary')">
                <i class="fa fa-key me-2"></i> الأدوار
            </a>
        </li>
        <?php endif; ?>

        <!-- الأقسام -->
        <?php if(hasPermission('departments.view')): ?>
        <li class="nav-item">
            <a href="../departments/index.php"
               class="nav-link text-body rounded-3"
               onmouseover="this.classList.add('bg-body-tertiary')"
               onmouseout="this.classList.remove('bg-body-tertiary')">
                <i class="fa fa-building me-2"></i> الأقسام
            </a>
        </li>
        <?php endif; ?>

        <!-- الحضور والانصراف -->
        <?php if(hasPermission('attendance.view')): ?>
        <li class="nav-item">
            <a href="../attendance/index.php"
               class="nav-link text-body rounded-3"
               onmouseover="this.classList.add('bg-body-tertiary')"
               onmouseout="this.classList.remove('bg-body-tertiary')">
                <i class="fa-solid fa-clock me-2"></i> الحضور والانصراف
            </a>
        </li>
        <?php endif; ?>

        <!-- تقرير الحضور -->
        <?php if(hasPermission('attendance.view')): ?>
        <li class="nav-item">
            <a href="../attendance/report.php"
               class="nav-link text-body rounded-3"
               onmouseover="this.classList.add('bg-body-tertiary')"
               onmouseout="this.classList.remove('bg-body-tertiary')">
                <i class="fa-solid fa-chart-bar me-2"></i> تقرير الحضور
            </a>
        </li>
        <?php endif; ?>

        <!-- الإعلانات -->
        <?php if(hasPermission('announcements.view')): ?>
        <li class="nav-item">
            <a href="../announcements/index.php"
               class="nav-link text-body rounded-3"
               onmouseover="this.classList.add('bg-body-tertiary')"
               onmouseout="this.classList.remove('bg-body-tertiary')">
                <i class="fa fa-bullhorn me-2"></i> الإعلانات
            </a>
        </li>
        <?php endif; ?>

        <!-- التقارير -->
        <?php if(hasPermission('reports.view')): ?>
        <li class="nav-item">
            <a href="../reports/index.php"
               class="nav-link text-body rounded-3"
               onmouseover="this.classList.add('bg-body-tertiary')"
               onmouseout="this.classList.remove('bg-body-tertiary')">
                <i class="fa fa-bar-chart me-2"></i> التقارير
            </a>
        </li>
        <?php endif; ?>

        <!-- سجل النشاطات -->
        <?php if(hasPermission('activity_logs.view')): ?>
        <li class="nav-item">
            <a href="../activity_logs/index.php"
               class="nav-link text-body rounded-3"
               onmouseover="this.classList.add('bg-body-tertiary')"
               onmouseout="this.classList.remove('bg-body-tertiary')">
                <i class="fa fa-history me-2"></i> سجل النشاطات
            </a>
        </li>
        <?php endif; ?>

        <!-- طلبات الإجازات -->
        <?php if(hasPermission('leaves.view') || hasPermission('leaves.create')): ?>
        <li class="nav-item">
            <a href="../leaves/index.php"
               class="nav-link text-body rounded-3"
               onmouseover="this.classList.add('bg-body-tertiary')"
               onmouseout="this.classList.remove('bg-body-tertiary')">
                <i class="fa fa-envelope-open me-2"></i> طلبات الإجازات
            </a>
        </li>
        <?php endif; ?>

        <!-- ملفي الشخصي -->
        <li class="nav-item">
            <a href="../profile/index.php"
               class="nav-link text-body rounded-3"
               onmouseover="this.classList.add('bg-body-tertiary')"
               onmouseout="this.classList.remove('bg-body-tertiary')">
                <i class="fa fa-user-circle me-2"></i> ملفي الشخصي
            </a>
        </li>

        <!-- الإعدادات -->
        <?php if(hasPermission('settings.view')): ?>
        <li class="nav-item">
            <a href="../settings/index.php"
               class="nav-link text-body rounded-3"
               onmouseover="this.classList.add('bg-body-tertiary')"
               onmouseout="this.classList.remove('bg-body-tertiary')">
                <i class="fa fa-cog me-2"></i> الإعدادات
            </a>
        </li>
        <?php endif; ?>

        <!-- سلة المستخدمين -->
        <?php if(hasPermission('users.view')): ?>
        <li class="nav-item">
            <a href="../users/trash.php"
               class="nav-link text-body rounded-3"
               onmouseover="this.classList.add('bg-body-tertiary')"
               onmouseout="this.classList.remove('bg-body-tertiary')">
                <i class="fa fa-trash me-2"></i> سلة المستخدمين
            </a>
        </li>
        <?php endif; ?>

        <!-- النسخ الاحتياطي لقاعدة البيانات -->
        <?php if(hasPermission('settings.view')): ?>
        <li class="nav-item">
            <a href="../backup/index.php"
               class="nav-link text-body rounded-3"
               onmouseover="this.classList.add('bg-body-tertiary')"
               onmouseout="this.classList.remove('bg-body-tertiary')">
                <i class="fa fa-database me-2"></i> النسخ الاحتياطي
            </a>
        </li>
        <?php endif; ?>

        <!-- تسجيل الخروج -->
        <li class="nav-item mt-auto">
            <a href="../auth/logout.php"
               class="nav-link text-body rounded-3 border-top border-secondary pt-3"
               onmouseover="this.classList.add('bg-body-tertiary')"
               onmouseout="this.classList.remove('bg-body-tertiary')">
                <i class="fa fa-sign-out me-2"></i> تسجيل الخروج
            </a>
        </li>

    </ul>

</div>