<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">

<!-- تطبيق الثيم المحفوظ قبل ظهور الصفحة -->
<script>
(function(){
    const theme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-bs-theme', theme);
})();
</script>

<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<!-- DataTables CSS -->
<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<!-- CSS الرئيسي للمشروع -->
<link rel="stylesheet" href="../assets/css/style.css">

<!-- CSS الخاص بالثيم إذا كنت تحتاجه -->
<link rel="stylesheet" href="../assets/css/theme.css">

<?php
require_once "../config/db.php";

/* جلب اسم الموقع */
$stmt = $pdo->query("
    SELECT site_name
    FROM settings
    LIMIT 1
");

$siteSettings = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!-- اسم الموقع -->
<title>
<?= htmlspecialchars($siteSettings['site_name'] ?? 'Employee Management System'); ?>
</title>

</head>

<body>