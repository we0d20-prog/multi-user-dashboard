<?php

require "../config/db.php";
require "../includes/mail.php";

// عند الضغط على زر الإرسال
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // استقبال البريد الإلكتروني
    $email = trim($_POST["email"]);

    // البحث عن المستخدم
    $stmt = $pdo->prepare("
        SELECT *
        FROM users
        WHERE email = ?
        LIMIT 1
    ");

    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // إذا كان البريد موجودًا
    if($user)
    {
        // إنشاء Token عشوائي
        $token = bin2hex(random_bytes(32));

        // حذف أي Token قديم لنفس البريد
        $delete = $pdo->prepare("
            DELETE FROM password_resets
            WHERE email = ?
        ");

        $delete->execute([$email]);

        // حفظ Token الجديد
        $insert = $pdo->prepare("
            INSERT INTO password_resets
            (
                email,
                token,
                created_at
            )
            VALUES
            (
                ?,
                ?,
                NOW()
            )
        ");

        $insert->execute([
            $email,
            $token
        ]);

        // إنشاء رابط إعادة التعيين
        // تنبيه: يفضل تغيير localhost إلى الدومين الحقيقي أو IP جهازك عند التجربة على الهاتف
        $link =
        "http://localhost/multi-user-dashboard/auth/reset_password.php?token=" . $token;

        // عنوان الرسالة
        $subject = "Reset Your Password";

        // محتوى الرسالة
        $body = "
        <h2>Password Reset</h2>

        <p>
        Click the button below to reset your password.
        </p>

        <a href='$link'>
            Reset Password
        </a>
        ";

        // إرسال البريد
        sendMail($email, $subject, $body);

        $success = "Password reset link has been sent to your email.";
    }
    else
    {
        $error = "Email not found.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<!-- Google Fonts (Poppins) -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }
    .card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
    .form-control:focus {
        border-color: #212529;
        box-shadow: 0 0 0 0.25rem rgba(33, 37, 41, 0.1);
    }
    .btn-dark {
        transition: all 0.3s ease;
    }
    .btn-dark:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
</style>

</head>

<body class="d-flex align-items-center justify-content-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">

                    <!-- أيقونة أعلى الصفحة -->
                    <div class="text-center mb-4">
                        <div class="bg-dark text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="bi bi-key fs-2"></i>
                        </div>
                    </div>

                    <h3 class="text-center mb-2 fw-bold text-dark">
                        Forgot Password?
                    </h3>
                    <p class="text-center text-muted small mb-4">
                        Enter your email and we'll send you a link to reset it.
                    </p>

                    <!-- Success Message -->
                    <?php if(isset($success)): ?>
                        <div class="alert alert-success border-0 rounded-3 small">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= $success; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Error Message -->
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger border-0 rounded-3 small">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <!-- Email with Floating Label -->
                        <div class="form-floating mb-4">
                            <input
                                type="email"
                                name="email"
                                class="form-control rounded-3"
                                id="floatingEmail"
                                placeholder="name@example.com"
                                required
                            >
                            <label for="floatingEmail">Email address</label>
                        </div>

                        <button class="btn btn-dark w-100 py-2 rounded-3 fw-bold">
                            Send Reset Link <i class="bi bi-send ms-2"></i>
                        </button>

                        <div class="text-center mt-4">
                            <a href="login.php" class="text-decoration-none text-muted small fw-medium">
                                <i class="bi bi-arrow-left me-1"></i> Back to Login
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>