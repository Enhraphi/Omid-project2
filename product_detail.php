<?php
include("db.php");

// بررسی وجود شناسه محصول در URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "شناسه محصول مشخص نشده است.";
    exit;
}

// دریافت شناسه محصول از URL
$product_id = $_GET['id'];

// گرفتن اطلاعات محصول از دیتابیس
$query = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// بررسی اینکه آیا محصولی با این شناسه در دیتابیس موجود است
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "محصولی با این شناسه یافت نشد.";
    exit;
}

// بررسی کد تخفیف (در اینجا یک کد تخفیف ساده فرضی برای توضیح می‌دهیم)
$discount_code = isset($_POST['discount_code']) ? $_POST['discount_code'] : '';
$discount_percentage = 0;
if ($discount_code == "SALE10") {
    $discount_percentage = 10; // 10% تخفیف
}

$final_price = $product['price'] - ($product['price'] * $discount_percentage / 100);
?>

<!DOCTYPE html>
<html lang="fa">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>جزئیات محصول</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  
<link rel="stylesheet" href="css/product_detail.css">
</head>
<body>

<header class="product-detail-header">
  <h1>جزئیات محصول</h1>
</header>

<div class="container">
  <div class="row">
    <div class="col-md-6">
      <!-- بررسی وجود تصویر قبل از نمایش -->
      <?php if (isset($product['image']) && !empty($product['image'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid product-image" alt="<?php echo htmlspecialchars($product['title']); ?>">
      <?php else: ?>
        <p>تصویر محصول موجود نیست.</p>
      <?php endif; ?>
    </div>
    <div class="col-md-6">
      <h2 class="product-title"><?php echo htmlspecialchars($product['title']); ?></h2>
      <p><?php echo htmlspecialchars($product['description']); ?></p>
<div class="mb-3">
    ⭐⭐⭐⭐
    <span class="text-muted">(
      4 / 5)</span>
</div>

<div class="mb-3">
    <span class="badge bg-success">موجود در انبار</span>
</div>
      <h3 class="product-price">قیمت: <?php echo number_format($final_price); ?> تومان</h3>
      
      <!-- فرم کد تخفیف -->
      <div class="discount-section">
        <form method="POST" action="">
          <div class="mb-3">
            <label for="discount_code" class="form-label">کد تخفیف</label>
            <input type="text" class="form-control" id="discount_code" name="discount_code" placeholder="کد تخفیف را وارد کنید">
          </div>
          <button type="submit" class="btn btn-warning">اعمال تخفیف</button>
        </form>
        <?php if ($discount_percentage > 0): ?>
          <div class="mt-3 alert alert-success">
            کد تخفیف با موفقیت اعمال شد! شما <?php echo $discount_percentage; ?>% تخفیف دریافت کردید.
          </div>
        <?php endif; ?>
      </div>
<a href="add_to_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-custom w-100">
🛒 افزودن به سبد خرید
</a>
    </div>
  </div>
</div>
<div class="navigation-buttons">  <a href="index.php" class="btn btn-outline-primary">🏠 صفحه اصلی</a>
  <button onclick="history.back()" class="btn btn-outline-secondary">⬅️ صفحه قبلی</button>
</div>
</body>
</html>
