<?php

// دالة تسجيل النشاطات
function logActivity($pdo, $userId, $action)
{
    /*الحصول على عنوان IP الخاص بالمستخدم*/
    $ipAddress = $_SERVER['REMOTE_ADDR'];

    /* الحصول على معلومات المتصفح */
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    /* تحديد اسم المتصفح */
    if(stripos($userAgent, "Chrome") !== false)
    {
        $browser = "Google Chrome";
    }
    elseif(stripos($userAgent, "Firefox") !== false)
    {
        $browser = "Mozilla Firefox";
    }
    elseif(stripos($userAgent, "Edge") !== false)
    {
        $browser = "Microsoft Edge";
    }
    elseif(stripos($userAgent, "Safari") !== false)
    {
        $browser = "Safari";
    }
    else
    {
        $browser = "Unknown Browser";
    }

    /* تحديد نظام التشغيل */
    if(stripos($userAgent, "Windows") !== false)
    {
        $operatingSystem = "Windows";
    }
    elseif(stripos($userAgent, "Android") !== false)
    {
        $operatingSystem = "Android";
    }
    elseif(stripos($userAgent, "iPhone") !== false)
    {
        $operatingSystem = "iPhone";
    }
    elseif(stripos($userAgent, "Mac") !== false)
    {
        $operatingSystem = "MacOS";
    }
    elseif(stripos($userAgent, "Linux") !== false)
    {
        $operatingSystem = "Linux";
    }
    else
    {
        $operatingSystem = "Unknown OS";
    }

    /* تجهيز استعلام حفظ النشاط */
    $stmt = $pdo->prepare("
        INSERT INTO activity_logs
        (
            user_id,
            action,
            ip_address,
            browser,
            operating_system
        )
        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?
        )
    ");

    /* تنفيذ الاستعلام */
    $stmt->execute([
        $userId,
        $action,
        $ipAddress,
        $browser,
        $operatingSystem
    ]);
}