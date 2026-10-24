<?php

require "../includes/auth_check.php";
require "../includes/permissions.php";
require "../config/db.php";

//التحقق من صلاحيه تصدير التقارير
if(!hasPermission('reports.export'))
{
    die("Access Denied");
}

//تحديد نوع الملف الذي سيتم تنزيله
header('Content-Type: text/csv; charset=utf-8');

header('content-Disposition: attachmen; filename=user_report.csv');

//فتح مخرج الملف
$output = fopen('php://output', 'w');

//كتابة رؤوس الاعمده
fputcsv($output, [

    'ID',
    'Name',
    'Email',
    'Role',
    'Status'

]);

//جلب المستخدمين مع الادوار
$stmt = $pdo->query("
SELECT users.*, roles.role_name
FROM users
JOIN roles ON users.role_id = roles.id
ORDER BY users.id ASC
");

//CSVكتابه البيانات داخل 
while($user = $stmt->fetch())
{
    fputcsv($output, [

         $user['id'],
         $user['name'],
         $user['email'],
         $user['role_name'],
         $user['status']

    ]);
}

fclose($output);

exit;