<?php

// تحميل Composer
require_once __DIR__ . '/../vendor/autoload.php';

// استدعاء مكتبة Dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');

// تحميل ملف .env
$dotenv->load();