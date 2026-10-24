<?php

session_start();

require "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // جلب المستخدم

    $stmt = $pdo->prepare(
        "SELECT * FROM users WHERE email = ? LIMIT 1"
    );
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    //التحقق من حاله الحساب
    if($user && $user['status'] != 'active')
    {
        die("Your account is disabled");
    }    

    // التحقق من المستخدم
    if ($user && password_verify($password, $user['password'])) {

        // إنشاء Session

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role_id'];
        $_SESSION['department_id'] = $user['department_id'];

        //تسجيل عمليه الدخول
        require_once "../includes/activity_log.php";

        logActivity(
            $pdo,
            $user['id'],
            "User Login"
        );

        // تحويل للوحة التحكم

        header("Location: ../dashboard/index.php");
        exit;

    } else {

        echo "Invalid Email or Password";

    }

}
?>