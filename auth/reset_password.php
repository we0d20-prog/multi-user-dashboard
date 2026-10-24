<?php

require "../config/db.php";

// التأكد من وجود Token داخل الرابط
if(!isset($_GET['token']))
{
    die("Invalid Token");
}

// استقبال الـ Token
$token = $_GET['token'];

// البحث عن الـ Token داخل جدول password_resets
$stmt = $pdo->prepare("
SELECT *
FROM password_resets
WHERE token = ?
LIMIT 1
");

$stmt->execute([$token]);

$reset = $stmt->fetch(PDO::FETCH_ASSOC);

// إذا لم يجد الـ Token
if(!$reset)
{
    die("Invalid Or Expired Token");
}

// عند الضغط على زر حفظ كلمة المرور
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // استقبال كلمة المرور الجديدة
    $password = trim($_POST["password"]);

    // تشفير كلمة المرور
    $hashedPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    // تحديث كلمة المرور داخل جدول users
    $update = $pdo->prepare("
    UPDATE users
    SET password = ?
    WHERE email = ?
    ");

    $update->execute([
        $hashedPassword,
        $reset["email"]
    ]);

    // حذف الـ Token بعد استخدامه
    $delete = $pdo->prepare("
    DELETE FROM password_resets
    WHERE token = ?
    ");

    $delete->execute([$token]);

    $success = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>
Reset Password
</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-5" style="max-width:500px;">

<h2 class="mb-4">
Reset Password
</h2>

<?php if(isset($success)): ?>

<div class="alert alert-success">

Password Changed Successfully

</div>

<a
href="login.php"
class="btn btn-success">

Go To Login

</a>

<?php else: ?>

<form method="POST">

<div class="mb-3">

<label>
New Password
</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button
class="btn btn-primary">

Save Password

</button>

</form>

<?php endif; ?>

</div>

</body>

</html>