<?php
include("db.php");
session_start();
?>

<!DOCTYPE html>
<html lang="fa">
<head>
  <meta charset="UTF-8">
  <title>فروشگاه شریفی</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  

<link rel="stylesheet" href="css/index.css">
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
 <li class="dropdown position-relative">
    <a href="products.php">محصولات</a>

    <ul class="submenu">
        <li class="dropdown-sub">
            <a href="#">موبایل</a>

            <ul class="subsubmenu">
                <li><a href="dasteh.php?cat=mobile&brand=samsung">سامسونگ</a></li>
                <li><a href="dasteh.php?cat=mobile&brand=xiaomi">شیائومی</a></li>
                <li><a href="dasteh.php?cat=mobile&brand=apple">اپل</a></li>
                <li><a href="dasteh.php?cat=mobile&brand=huawei">هواوی</a></li>
            </ul>
        </li>

        <li class="dropdown-sub">
            <a href="#">لپ‌تاپ</a>

            <ul class="subsubmenu">
                <li><a href="dasteh.php?cat=laptop&brand=asus">ایسوس</a></li>
                <li><a href="dasteh.php?cat=laptop&brand=lenovo">لنوو</a></li>
                <li><a href="dasteh.php?cat=laptop&brand=hp">اچ‌پی</a></li>
                <li><a href="dasteh.php?cat=laptop&brand=apple">اپل</a></li>
            </ul>
        </li>
    </ul>
</li>
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

<br>
<form action="search.php" method="get" class="d-flex me-3" style="max-width: 250px;">
  <input class="form-control form-control-sm" type="search" placeholder="جستجو..." name="q" aria-label="جستجو">
  <button class="btn btn-sm btn-outline-light ms-2" type="submit">
    <i class="fas fa-search"></i>
  </button>
</form>



</header>

<div class="container">
<?php if (isset($_SESSION['username'])): ?>
  <div class="welcome-alert">
    کاربر&nbsp;<strong><?= htmlspecialchars($_SESSION['username']); ?></strong>&nbsp;خوش آمدید!
  </div>
<?php endif; ?>

<div class="products-section">

  <!-- پرفروش‌ترین‌ها -->
  <h2 class="section-title text-end mb-4">🔥 پرفروش‌ترین‌ها</h2>
  <div class="row g-3">
<div class="col-md-3 mb-4">
        <div class="card product-card h-100">
        <img src="uploads/laptop1.png" class="card-img-top product-img" alt="لپ‌تاپ 1">
        <div class="card-body">
          <h5 class="card-title">لپ‌تاپ 1</h5>
          <p class="card-text fw-bold text-danger">25,000,000 تومان</p>
          <div class="btn-group-custom">
            <a href="product_detail.php?id=1" class="btn btn-outline-primary btn-buy">مشاهده</a>
            <a href="add_to_cart.php?id=1" class="btn btn-success btn-buy">افزودن به سبد</a>
          </div>
        </div>
      </div>
    </div>

<div class="col-md-3 mb-4">
        <div class="card product-card h-100">
        <img src="uploads/laptop2.png" class="card-img-top product-img" alt="لپ‌تاپ 2">
        <div class="card-body">
          <h5 class="card-title">لپ‌تاپ 2</h5>
          <p class="card-text fw-bold text-danger">27,500,000 تومان</p>
          <div class="btn-group-custom">
            <a href="product_detail.php?id=2" class="btn btn-outline-primary btn-buy">مشاهده</a>
            <a href="add_to_cart.php?id=2" class="btn btn-success btn-buy">افزودن به سبد</a>
          </div>
        </div>
      </div>
    </div>

<div class="col-md-3 mb-4">
        <div class="card product-card h-100">
        <img src="uploads/laptop3.png" class="card-img-top product-img" alt="لپ‌تاپ 3">
        <div class="card-body">
          <h5 class="card-title">لپ‌تاپ 3</h5>
          <p class="card-text fw-bold text-danger">23,800,000 تومان</p>
          <div class="btn-group-custom">
            <a href="product_detail.php?id=3" class="btn btn-outline-primary btn-buy">مشاهده</a>
            <a href="add_to_cart.php?id=3" class="btn btn-success btn-buy">افزودن به سبد</a>
          </div>
        </div>
      </div>
    </div>

<div class="col-md-3 mb-4">
        <div class="card product-card h-100">
        <img src="uploads/laptop4.png" class="card-img-top product-img" alt="لپ‌تاپ 4">
        <div class="card-body">
          <h5 class="card-title">لپ‌تاپ 4</h5>
          <p class="card-text fw-bold text-danger">26,300,000 تومان</p>
          <div class="btn-group-custom">
            <a href="product_detail.php?id=4" class="btn btn-outline-primary btn-buy">مشاهده</a>
            <a href="add_to_cart.php?id=4" class="btn btn-success btn-buy">افزودن به سبد</a>
          </div>
        </div>
      </div>
    </div>

<div class="col-md-3 mb-4">
        <div class="card product-card h-100">
        <img src="uploads/laptop5.png" class="card-img-top product-img" alt="لپ‌تاپ 5">
        <div class="card-body">
          <h5 class="card-title">لپ‌تاپ 5</h5>
          <p class="card-text fw-bold text-danger">24,500,000 تومان</p>
          <div class="btn-group-custom">
            <a href="product_detail.php?id=5" class="btn btn-outline-primary btn-buy">مشاهده</a>
            <a href="add_to_cart.php?id=5" class="btn btn-success btn-buy">افزودن به سبد</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- پیشنهاد ویژه -->
  <h2 class="section-title text-end mt-5 mb-4">🎯 پیشنهادهای ویژه</h2>
  <div class="row g-3">
<div class="col-md-3 mb-4">
        <div class="card product-card h-100">
        <img src="uploads/phone1.png" class="card-img-top product-img" alt="گوشی 1">
        <div class="card-body">
          <h5 class="card-title">گوشی 1</h5>
          <p class="card-text fw-bold text-danger">10,000,000 تومان</p>
          <div class="btn-group-custom">
            <a href="product_detail.php?id=6" class="btn btn-outline-warning btn-buy">جزئیات</a>
            <a href="add_to_cart.php?id=6" class="btn btn-danger btn-buy">افزودن به سبد</a>
          </div>
        </div>
      </div>
    </div>

<div class="col-md-3 mb-4">
        <div class="card product-card h-100">
        <img src="uploads/phone2.png" class="card-img-top product-img" alt="گوشی 2">
        <div class="card-body">
          <h5 class="card-title">گوشی 2</h5>
          <p class="card-text fw-bold text-danger">12,500,000 تومان</p>
          <div class="btn-group-custom">
            <a href="product_detail.php?id=7" class="btn btn-outline-warning btn-buy">جزئیات</a>
            <a href="add_to_cart.php?id=7" class="btn btn-danger btn-buy">افزودن به سبد</a>
          </div>
        </div>
      </div>
    </div>

<div class="col-md-3 mb-4">
        <div class="card product-card h-100">
        <img src="uploads/phone3.png" class="card-img-top product-img" alt="گوشی 3">
        <div class="card-body">
          <h5 class="card-title">گوشی 3</h5>
          <p class="card-text fw-bold text-danger">9,800,000 تومان</p>
          <div class="btn-group-custom">
            <a href="product_detail.php?id=8" class="btn btn-outline-warning btn-buy">جزئیات</a>
            <a href="add_to_cart.php?id=8" class="btn btn-danger btn-buy">افزودن به سبد</a>
          </div>
        </div>
      </div>
    </div>

<div class="col-md-3 mb-4">
        <div class="card product-card h-100">
        <img src="uploads/phone4.png" class="card-img-top product-img" alt="گوشی 4">
        <div class="card-body">
          <h5 class="card-title">گوشی 4</h5>
          <p class="card-text fw-bold text-danger">11,200,000 تومان</p>
          <div class="btn-group-custom">
            <a href="product_detail.php?id=9" class="btn btn-outline-warning btn-buy">جزئیات</a>
            <a href="add_to_cart.php?id=9" class="btn btn-danger btn-buy">افزودن به سبد</a>
          </div>
        </div>
      </div>
    </div>

<div class="col-md-3 mb-4">
        <div class="card product-card h-100">
        <img src="uploads/phone5.png" class="card-img-top product-img" alt="گوشی 5">
        <div class="card-body">
          <h5 class="card-title">گوشی 5</h5>
          <p class="card-text fw-bold text-danger">13,000,000 تومان</p>
          <div class="btn-group-custom">
            <a href="product_detail.php?id=10" class="btn btn-outline-warning btn-buy">جزئیات</a>
            <a href="add_to_cart.php?id=10" class="btn btn-danger btn-buy">افزودن به سبد</a>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>


<footer class="text-center">
  <div class="container">
    <p>تمامی حقوق محفوظ است - فروشگاه شریفی © 2025</p>
    <div class="social-icons mt-2">
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-telegram"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
    </div>
    <div class="mt-2">
      <a href="#">قوانین</a> | <a href="#">حریم خصوصی</a> | <a href="#">سوالات متداول</a>
    </div>
  </div>
</footer>
  </div>
</body>
</html>