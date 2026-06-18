<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "sharifi_shop";

// اتصال به دیتابیس
$conn = mysqli_connect($host, $user, $pass, $dbname);

// بررسی اتصال به دیتابیس
if (!$conn) {
    die("خطا در اتصال به دیتابیس: " . mysqli_connect_error());
}

// تنظیم کدگذاری UTF-8 برای ارتباطات با دیتابیس
mysqli_set_charset($conn, "utf8mb4");
?>
