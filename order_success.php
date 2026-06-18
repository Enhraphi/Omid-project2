<?php
include("db.php");
$order_id = (int)$_GET["order_id"]; // امنیت بیشتر با تبدیل به عدد
$order_query = mysqli_query($conn, "SELECT * FROM orders WHERE id=$order_id");
if(!$order_query || mysqli_num_rows($order_query) == 0){
    die("<h3>سفارش پیدا نشد!</h3>");
}
$order = mysqli_fetch_assoc($order_query);
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>جزئیات سفارش شما</title>
  
<link rel="stylesheet" href="css/order_success.css">
</head>
<body>
  <div class="container">
    <h3>سفارش شما با موفقیت ثبت شد!</h3>
    <p><strong>کد سفارش:</strong> <?= htmlspecialchars($order['id']) ?></p>
    <p><strong>نام مشتری:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
    <p><strong>تلفن:</strong> <?= htmlspecialchars($order['phone']) ?></p>
    <p><strong>آدرس:</strong> <?= nl2br(htmlspecialchars($order['address'])) ?></p>
    <p><strong>مبلغ کل:</strong> <?= number_format($order['total']) ?> تومان</p>

    <h5>محصولات سفارش داده شده:</h5>
    <ul>
    <?php
      $res = mysqli_query($conn, "SELECT p.title FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id=$order_id");
      while ($row = mysqli_fetch_assoc($res)) {
        echo "<li>" . htmlspecialchars($row['title']) . "</li>";
      }
    ?>
    </ul>

    <a href="index.php" class="btn-home">بازگشت به صفحه اصلی</a>
  </div>
</body>
</html>
