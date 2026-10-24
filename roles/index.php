<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

/* رسائل النجاح */
if(isset($_GET['success']))
{
    if($_GET['success'] == 'role_deleted')
    {
        echo "
        <script>
        document.addEventListener('DOMContentLoaded', function(){

            Swal.fire({
                icon:'success',
                title:'نجاح',
                text:'تم حذف الدور بنجاح'
            });

        });
        </script>
        ";
    }

    if($_GET['success'] == 'role_updated')
    {
        echo "
        <script>
        document.addEventListener('DOMContentLoaded', function(){

            Swal.fire({
                icon:'success',
                title:'نجاح',
                text:'تم تحديث الدور بنجاح'
            });

        });
        </script>
        ";
    }

    if($_GET['success'] == 'role_added')
    {
        echo "
        <script>
        document.addEventListener('DOMContentLoaded', function(){

            Swal.fire({
                icon:'success',
                title:'نجاح',
                text:'تم إضافة الدور بنجاح'
            });

        });
        </script>
        ";
    }
}

/* رسائل الخطأ */
if(isset($_GET['error']))
{
    if($_GET['error'] == 'system_role')
    {
        echo "
        <script>
        document.addEventListener('DOMContentLoaded', function(){

            Swal.fire({
                icon:'error',
                title:'تم رفض الوصول',
                text:'لا يمكن حذف الأدوار النظامية'
            });

        });
        </script>
        ";
    }

    if($_GET['error'] == 'role_has_users')
    {
        echo "
        <script>
        document.addEventListener('DOMContentLoaded', function(){

            Swal.fire({
                icon:'warning',
                title:'تحذير',
                text:'هذا الدور يحتوي على مستخدمين مرتبطين به'
            });

        });
        </script>
        ";
    }
}

/* جلب جميع الأدوار */
$stmt = $pdo->query("
SELECT *
FROM roles
ORDER BY id ASC
");

$roles = $stmt->fetchAll();

?>

<div class="content p-3 p-md-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="fa fa-key me-2"></i> إدارة الأدوار
        </h2>

        <a href="create.php" class="btn btn-primary rounded-pill px-4 d-flex align-items-center gap-2">
            <i class="fa fa-plus-circle"></i> إضافة دور
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="rolesTable" class="table table-hover align-middle mb-0 border-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>اسم الدور</th>
                            <th class="text-center">الإجراءات</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($roles as $role): ?>
                        <tr>
                            <td><span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill"><?= $role['id']; ?></span></td>
                            <td class="fw-semibold"><?= htmlspecialchars($role['role_name']); ?></td>
                            <td class="text-center">
                                <a href="edit.php?id=<?= $role['id']; ?>" class="btn btn-warning btn-sm rounded-pill px-3">
                                    <i class="fa fa-edit"></i> تعديل
                                </a>
                                <a href="permissions.php?id=<?= $role['id']; ?>" class="btn btn-info btn-sm rounded-pill px-3 text-white">
                                    <i class="fa fa-lock"></i> الصلاحيات
                                </a>
                                <a href="delete.php?id=<?= $role['id']; ?>" class="btn btn-danger btn-sm rounded-pill px-3" onclick="return confirm('هل تريد حذف هذا الدور؟')">
                                    <i class="fa fa-trash"></i> حذف
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
 /* تفعيل DataTables */
 $(document).ready(function(){

    $('#rolesTable').DataTable({

        pageLength: 5,

        ordering: true,

        searching: true,

        paging: true,
        
        // تحسينات للغة العربية
        language: {
            search: "بحث:",
            lengthMenu: "عرض _MENU_ سجل",
            info: "عرض _START_ إلى _END_ من أصل _TOTAL_ دور",
            infoEmpty: "لا توجد أدوار متاحة",
            infoFiltered: "(تم التصفية من _MAX_ إجمالي الأدوار)"
        }
    });

 });

</script>

<?php include "../includes/footer.php"; ?>