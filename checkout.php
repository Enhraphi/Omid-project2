<?php
include("db.php");
session_start();

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim($_POST["name"]);
  $phone = trim($_POST["phone"]);
  $address = trim($_POST["address"]);
  $cart = $_SESSION['cart'] ?? [];
  $total = 0;

  if (empty($cart)) {
    $error = "سبد خرید شما خالی است!";
  } else {
    foreach ($cart as $id) {
      $id = (int)$id;
      $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id=$id"));
      if ($p) {
        $total += $p['price'];
      }
    }

    if (!$error) {
      $name_safe = mysqli_real_escape_string($conn, $name);
      $phone_safe = mysqli_real_escape_string($conn, $phone);
      $address_safe = mysqli_real_escape_string($conn, $address);

      $sql = "INSERT INTO orders (customer_name, phone, address, total) VALUES ('$name_safe', '$phone_safe', '$address_safe', $total)";
      mysqli_query($conn, $sql);
      $order_id = mysqli_insert_id($conn);

      foreach ($cart as $id) {
        $id = (int)$id;
        mysqli_query($conn, "INSERT INTO order_items (order_id, product_id) VALUES ($order_id, $id)");
      }

      unset($_SESSION['cart']);
      setcookie('cart', "", time() - 3600, "/");

      header("Location: order_success.php?order_id=$order_id");
      exit();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <title>نهایی‌سازی خرید</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
<link rel="stylesheet" href="css/checkout.css">
</head>
<body>
  <div class="form-wrapper">
    <h3>نهایی‌سازی خرید</h3>

    <?php if ($error): ?>
      <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" autocomplete="off" novalidate>
      <input type="text" name="name" placeholder="نام کامل" required />
      <input type="text" name="phone" placeholder="شماره تماس" required />
      <textarea name="address" placeholder="آدرس دقیق" required></textarea>
      <button type="submit" class="btn-submit">ثبت سفارش</button>
    </form>
  </div>
</body>
</html>
