<?php

require "../includes/auth_check.php";
require "../includes/activity_log.php";
require "../includes/notification_helper.php";
require "../config/db.php";

/* جلب المستخدم الحالي */
$stmt = $pdo->prepare("
    SELECT *
    FROM users
    WHERE id = ?
");

$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

/* البيانات القادمة من الفورم */
$name = trim($_POST['name'] ?? '');

/* التحقق من الاسم */
if ($name === '') {
    header("Location: index.php?error=name_required");
    exit;
}

/* الصورة الحالية */
$imageName = $user['image'] ?? '';

/* حذف الصورة الحالية */
if (isset($_POST['delete_image']) && $_POST['delete_image'] == '1') {

    /* حذف ملف الصورة من السيرفر */
    if (
        !empty($imageName) &&
        file_exists("../assets/uploads/" . $imageName)
    ) {
        unlink("../assets/uploads/" . $imageName);
    }

    /* جعل خانة الصورة فارغة في قاعدة البيانات */
    $imageName = '';
}

/*رفع صورة جديدة*/

/*
   إذا اختار المستخدم صورة جديدة
   وكانت الصورة الجديدة موجودة،
   يتم رفعها.
*/
if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] === UPLOAD_ERR_OK &&
    !empty($_FILES['image']['name'])
) {

    /* اسم الملف */
    $newImage = time() . "_" . basename($_FILES['image']['name']);

    /* مكان التخزين */
    $destination = "../assets/uploads/" . $newImage;

    /* رفع الصورة */
    if (move_uploaded_file(
        $_FILES['image']['tmp_name'],
        $destination
    )) {

        /*
           إذا كانت هناك صورة قديمة
           نحذفها.
        */
        if (
            !empty($imageName) &&
            file_exists("../assets/uploads/" . $imageName)
        ) {
            unlink("../assets/uploads/" . $imageName);
        }

        /* حفظ اسم الصورة الجديدة */
        $imageName = $newImage;
    }
}

/*تحديث بيانات المستخدم */
$update = $pdo->prepare("
    UPDATE users
    SET
        name = ?,
        image = ?
    WHERE id = ?
");

$update->execute([
    $name,
    $imageName,
    $_SESSION['user_id']
]);

/* إشعار للأدمن */
createNotification(
    $pdo,
    1,
    "تم تحديث الملف الشخصي",
    "قام المستخدم " . $name . " بتحديث ملفه الشخصي."
);

/* إشعار شخصي للمستخدم */
createNotification(
    $pdo,
    $_SESSION['user_id'],
    "تم تحديث الملف الشخصي",
    "تم تحديث ملفك الشخصي بنجاح."
);

/* تسجيل النشاط */
logActivity(
    $pdo,
    $_SESSION['user_id'],
    "Updated Profile"
);

/* تحديث الاسم داخل Session */
$_SESSION['user_name'] = $name;

header("Location: index.php?success=profile_updated");
exit;