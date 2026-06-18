<?php
session_start();
session_unset();   // حذف تمام متغیرهای جلسه
session_destroy(); // نابود کردن جلسه
header("Location: index.php");  // هدایت به صفحه اصلی
exit;
?>
