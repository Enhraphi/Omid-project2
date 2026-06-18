<?php
session_start();
$id = $_GET['id'];

include("db.php"); // فرض بر اینه دیتابیس رو اینجا وصل می‌کنی

// گرفتن نام محصول از دیتابیس بر اساس $id
$productName = '';
if ($stmt = $conn->prepare("SELECT title FROM products WHERE id = ?")) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($title);
    if ($stmt->fetch()) {
        $productName = $title;
    }
    $stmt->close();
}

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

if (!in_array($id, $_SESSION['cart'])) {
  $_SESSION['cart'][] = $id;
}

setcookie('cart', serialize($_SESSION['cart']), time() + 86400, "/");

// ریدایرکت به صفحه اصلی یا هر صفحه‌ای که می‌خوای پیام اضافه شدن نشون داده بشه
header("Location: products.php?added=1&product=" . urlencode($productName));
exit();
?>
