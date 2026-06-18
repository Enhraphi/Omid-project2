<?php
include("db.php");
session_start();

// واکشی همه محصولات
$products = mysqli_query($conn, "SELECT * FROM products ORDER BY category, id ASC");
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <title>محصولات فروشگاه شریفی</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  
<link rel="stylesheet" href="css/products.css">
</head>
<body>
<div id="floating-alert" class="alert alert-success position-fixed top-0 end-0 m-3 d-none" style="z-index: 1050;">
  محصول با موفقیت به سبد خرید افزوده شد.
</div>

<script>
  function showSuccessMessage(message) {
    const alertBox = document.getElementById('floating-alert');
    alertBox.textContent = message;
    alertBox.classList.remove('d-none');
    setTimeout(() => {
      alertBox.classList.add('d-none');
    }, 3000);
  }

  const params = new URLSearchParams(window.location.search);
  if (params.get('added') === '1') {
    const productName = params.get('product') || 'محصول';
    showSuccessMessage(`محصول "${productName}" با موفقیت به سبد خرید افزوده شد.`);
  }
</script>
<header>
  <nav class="d-flex justify-content-between align-items-center container" dir="rtl">
    <div class="sharifi-logo ms-3">Sharifi</div>

    <ul class="nav-right d-flex align-items-center mb-0">
      <?php if (isset($_SESSION['username'])): ?>
        <?php if ($_SESSION['username'] === 'sharifi'): ?>
          <li><a href="admin_panel.php">پنل ادمین</a></li>
        <?php endif; ?>
        <li><a href="logout.php">خروج</a></li>
      <?php else: ?>
        <?php if (isset($_SESSION['username'])): ?>
          <div class="welcome-alert" style="direction: rtl; text-align: right; margin-bottom: 10px;">
            کاربر&nbsp;<strong><?= htmlspecialchars($_SESSION['username']); ?></strong>&nbsp;خوش آمدید!
          </div>
        <?php endif; ?>
        <li><a href="login.php">ورود/ثبت‌ نام</a></li>
      <?php endif; ?>
    </ul>

    <ul class="nav-center d-flex align-items-center mb-0">
      <li><a href="index.php">خانه</a></li>
      <li><a href="products.php">محصولات</a></li>
      <li><a href="about.php">درباره ما</a></li>
      <li><a href="contact.php">تماس با ما</a></li>
    </ul>

    <ul class="nav-left d-flex align-items-center mb-0">
      <li>
        <a href="cart.php" class="position-relative">
          🛒 سبد خرید
          <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
            <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
              <?= count($_SESSION['cart']); ?>
            </span>
          <?php endif; ?>
        </a>
      </li>
    </ul>

  </nav>
</header>

<div class="products-section container">
  <h2 class="section-title">تمامی محصولات</h2>

  <div class="products-container">
    <?php while ($row = mysqli_fetch_assoc($products)): ?>
      <div class="product-card">
        <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" loading="lazy">
        <div class="product-title"><?= htmlspecialchars($row['title']) ?></div>
        <div class="product-price"><?= number_format($row['price']) ?> تومان</div>
<div class="btn-group-custom">
  <a href="product_detail.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-buy">مشاهده</a>
  <a href="add_to_cart.php?id=<?= $row['id'] ?>" class="btn btn-success btn-buy">افزودن به سبد</a>
</div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>
