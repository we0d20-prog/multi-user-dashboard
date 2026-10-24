<?php

require "../includes/auth_check.php";
require "../includes/permissions.php";
require "../config/db.php";

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

// جلب الأقسام مع عدد الموظفين داخل كل قسم
$stmt = $pdo->query("
SELECT 

/* جميع بيانات القسم */
departments.*,

/* حساب عدد الموظفين داخل القسم */
COUNT(users.id) AS employees_count
FROM departments

/* ربط جدول المستخدمين مع الأقسام */
LEFT JOIN users
ON departments.id = users.department_id

/* تجاهل المستخدمين الموجودين في سلة المحذوفات */
AND users.deleted_at IS NULL

/* تجميع النتائج حسب القسم */
GROUP BY departments.id

/* ترتيب الأقسام من الأحدث */
ORDER BY departments.id DESC
");

$departments = $stmt->fetchAll();

?>

<div class="content p-3 p-md-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="fa fa-building me-2"></i> الأقسام
        </h2>

        <a href="create.php" class="btn btn-primary rounded-pill px-4 d-flex align-items-center gap-2">
            <i class="fa fa-plus-circle"></i> إضافة قسم
        </a>
    </div>

    <!-- بطاقة تحتوي الجدول -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-body-tertiary py-3 border-bottom-0">
            <h5 class="mb-0 fw-semibold">
                <i class="fa fa-list-ul me-2 text-secondary"></i> قائمة الأقسام
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="departmentsTable" class="table table-hover align-middle mb-0 border-0">
                    <thead class="bg-body-secondary">
                        <tr>
                            <th>#</th>
                            <th>القسم</th>
                            <th>الموظفين</th>
                            <th>الوصف</th>
                            <th>تاريخ الإنشاء</th>
                            <th class="text-center">الإجراءات</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($departments as $department): ?>
                        <tr>
                            <td><span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill"><?= $department['id']; ?></span></td>
                            <td class="fw-semibold"><?= htmlspecialchars($department['department_name']); ?></td>
                            <td><span class="badge bg-primary rounded-pill"><?= $department['employees_count']; ?></span></td>
                            <td class="text-truncate" style="max-width: 200px;"><?= htmlspecialchars($department['description'] ?? ''); ?></td>
                            <td><small class="text-body-secondary"><?= $department['created_at']; ?></small></td>
                            <td class="text-center">
                                <a href="view.php?id=<?= $department['id']; ?>" class="btn btn-info btn-sm rounded-pill px-3 text-white">
                                    <i class="fa fa-eye"></i> عرض
                                </a>
                                <a href="edit.php?id=<?= $department['id']; ?>" class="btn btn-warning btn-sm rounded-pill px-3">
                                    <i class="fa fa-edit"></i> تعديل
                                </a>
                                <button class="btn btn-danger btn-sm rounded-pill px-3 deleteDepartment" data-id="<?= $department['id']; ?>" data-name="<?= htmlspecialchars($department['department_name']); ?>">
                                    <i class="fa fa-trash"></i> حذف
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include "../includes/footer.php"; ?>

<script>
$(document).ready(function(){
    $("#departmentsTable").DataTable({
        pageLength: 10,
        ordering: true,
        searching: true,
        paging: true,
        language: {
            search: "بحث:",
            lengthMenu: "عرض _MENU_ سجل",
            info: "عرض _START_ إلى _END_ من أصل _TOTAL_ قسم",
            infoEmpty: "لا توجد أقسام متاحة",
            infoFiltered: "(تم التصفية من _MAX_ إجمالي الأقسام)"
        }
    });

    $(".deleteDepartment").click(function(){
        let id = $(this).data("id");
        let name = $(this).data("name");

        Swal.fire({
            title: "هل أنت متأكد؟",
            text: "حذف القسم: " + name + " ؟",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "<i class='fa fa-trash'></i> حذف",
            cancelButtonText: "<i class='fa fa-times'></i> إلغاء"
        }).then((result)=>{
            if(result.isConfirmed) {
                window.location = "delete.php?id=" + id;
            }
        });
    });
});
</script>