<?php

// استدعاء مكتبات Composer
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../config/env.php";

// استخدام كلاس PHPMailer
use PHPMailer\PHPMailer\PHPMailer;

// استخدام كلاس الأخطاء
use PHPMailer\PHPMailer\Exception;

/*دالة إرسال البريد الإلكتروني
 $to      = بريد المستقبل
 $subject = عنوان الرسالة
 $body    = محتوى الرسالة
*/

function sendMail($to, $subject, $body)
{
    // إنشاء كائن جديد من PHPMailer
    $mail = new PHPMailer(true);

    try
    {
        /* إعدادات SMTP*/

        // استخدام SMTP
        $mail->isSMTP();

        // سيرفر Gmail
        $mail->Host = $_ENV['MAIL_HOST'];

        // تفعيل المصادقة
        $mail->SMTPAuth = true;

        // بريد Gmail المرسل
        $mail->Username = $_ENV['MAIL_USERNAME'];

        // App Password
        $mail->Password = $_ENV['MAIL_PASSWORD'];

        // نوع التشفير
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        // المنفذ
        $mail->Port = $_ENV['MAIL_PORT'];

        /* إعدادات الرسالة*/

        // من
        $mail->setFrom(
            $_ENV['MAIL_FROM'],
            $_ENV['MAIL_FROM_NAME']
        );

        // إلى
        $mail->addAddress($to);

        // ترميز UTF8
        $mail->CharSet = "UTF-8";

        // HTML
        $mail->isHTML(true);

        // عنوان الرسالة
        $mail->Subject = $subject;

        // محتوى الرسالة
        $mail->Body = $body;

        // إرسال
        $mail->send();

        return true;
    }
    catch(Exception $e)
    {
        die("Mail Error: " . $mail->ErrorInfo);
    }
}