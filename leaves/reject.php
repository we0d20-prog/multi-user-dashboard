<?php

require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/permissions.php";
require "../includes/activity_log.php";
require "../includes/notification_helper.php";

//التحقق من صلاحيه رفض طلب الاجازه
if(!hasPermission('leaves.approve'))
{
    die("Access Denied");
}

//استقبال رقم طلب الاجازه
$leavedId = isset($_GET['id'])
    ? (int)$_GET['id']
    : 0;

if($leavedId <= 0)
{
    die("Invalid Leave Request");
}        

// معرفة بيانات المستخدم الحالي
$currentUserId = $_SESSION['user_id'];
$currentRole = $_SESSION['user_role'];
$currentDepartment = $_SESSION['department_id'] ?? null;

//اذا تم الرسال نموذج الرفض
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    //استقبال رقم الطلب من الفورم
    $leavedId = (int)$_POST['id'];

    //استقبال ملاحظه المدير
    $managerNote = trim($_POST['manager_note'] ?? '');

    //التاكد ان سبب الرفض موجود
    if(empty($managerNote))
    {
        die("Please enter a reason for rejection");
    }    

    //جلب طلب الاجازه
    $stmt = $pdo->prepare("
        SELECT
            leave_requests.*,
            users.name AS employee,
            users.department_id
            
        FROM leave_requests
        JOIN users
        ON leave_requests.user_id = users.id
        WHERE leave_requests.id = ?
        LIMIT 1
    ");

    $stmt->execute([
        $leavedId
    ]);

    $leave = $stmt->fetch(PDO::FETCH_ASSOC);

    //التاكد ان الطلب موجود
    if(!$leave)
    {
        die("Leave Request Not Found");
    }

    //حمايه المدير حسب القسم
    if($currentRole == 2)
    {
        if($leave['department_id'] != $currentDepartment)
        {
            die("Access Denied");
        }    
    }

    //Pending التاكد ان الطلب
    if($leave['status'] != 'pending')
    {
        die("This leave request has alreade been processed");
    }

    //Rejected تحديث حاله الطلب
    $stmt = $pdo->prepare("
        UPDATE leave_requests
        SET
            status = 'rejected',
            manager_note = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $managerNote,
        $leavedId
    ]);

    // إرسال إشعار للموظف
    createNotification(
        $pdo,
        $leave['user_id'],
        "تم رفض طلب الإجازة",
        "تم رفض طلب الإجازة رقم #" . $leavedId . "."
    );

    //تسجيل النشاظ
    logActivity(
        $pdo,
        $currentUserId,
        "Rejected Leave Request #".$leavedId
    );

    //العوده الى قائمه الطلبات
    header("Location: index.php?success=rejected");
    exit;
}

//جلب بيانات الطلب لعرضها قبل الرفض
$stmt = $pdo->prepare("
    SELECT 
        leave_requests.*,
        users.name AS employee_name,
        users.department_id
    FROM leave_requests
    JOIN users
    ON leave_requests.user_id = users.id
    WHERE leave_requests.id = ?
    LIMIT 1   
");

$stmt->execute([
    $leavedId
]);

$leave = $stmt->fetch(PDO::FETCH_ASSOC);

//التاكد ان الطلب موجود
if(!$leave)
{
    die("Leave Request Not Found");
}

//حمايه المدير حسب القسم
if($currentRole == 2)
{
    if($leave['department_id'] != $currentDepartment)
    {
        die("Access Denied");
    }
}

//Pending التاكد ان الطلب 
if($leave['status'] != 'pending')
{
    die("This leave request has already been processed");
}

include "../includes/header.php";
include "../includes/navbar.php";
include "../includes/sidebar.php";

?>

<div class="content p-3 p-md-4">

    <div class="d-flex align-items-center gap-2 mb-4">
        <i class="fa fa-times-circle fs-1 text-danger"></i>
        <div>
            <h2 class="fw-bold mb-0">رفض طلب الإجازة</h2>
            <p class="text-muted small mb-0">تأكيد رفض طلب الإجازة مع إضافة سبب الرفض</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white py-3 border-bottom-0">
            <h5 class="mb-0 fw-semibold d-flex align-items-center gap-2">
                <i class="fa fa-file-text-o text-secondary"></i> تأكيد الرفض
            </h5>
        </div>

        <div class="card-body p-4 p-md-5">

            <!-- معلومات الموظف -->
            <div class="alert alert-warning d-flex align-items-center gap-2 border-0 shadow-sm rounded-4">
                <i class="fa fa-exclamation-triangle fs-4"></i>
                <span>أنت بصدد رفض طلب الإجازة للموظف: <strong><?= htmlspecialchars($leave['employee_name']); ?></strong></span>
            </div>

            <!-- نموذج الرفض -->
            <form action="reject.php?id=<?= $leave['id']; ?>" method="POST" class="needs-validation" novalidate>

                <!-- رقم الطلب -->
                <input type="hidden" name="id" value="<?= $leave['id']; ?>">

                <!-- سبب الرفض -->
                <div class="mb-4">
                    <div class="form-floating">
                        <textarea name="manager_note" id="managerNote" class="form-control rounded-3" 
                                  placeholder="أدخل سبب رفض الطلب..." rows="5" style="min-height: 130px;" required></textarea>
                        <label for="managerNote"><i class="fa fa-comment me-1 text-primary"></i> سبب الرفض</label>
                    </div>
                    <div class="invalid-feedback">الرجاء إدخال سبب الرفض.</div>
                </div>

                <!-- الأزرار -->
                <div class="d-flex flex-wrap gap-3 mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-danger btn-lg rounded-pill px-5 d-flex align-items-center gap-2">
                        <i class="fa fa-times-circle"></i> رفض الطلب
                    </button>
                    <a href="view.php?id=<?= $leave['id']; ?>" class="btn btn-outline-secondary btn-lg rounded-pill px-5 d-flex align-items-center gap-2">
                        <i class="fa fa-arrow-left"></i> إلغاء
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<script>
// تفعيل التحقق من صحة النموذج
(function() {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>

<?php include "../includes/footer.php"; ?>