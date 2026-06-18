<?php
session_start();

// حذف سبد خرید از سشن
if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);
}

// حذف کوکی سبد خرید (اگر استفاده می‌کنی)
if (isset($_COOKIE['cart'])) {
    setcookie('cart', '', time() - 3600, "/"); // منقضی کردن کوکی
}

header("Location: cart.php");
exit;
