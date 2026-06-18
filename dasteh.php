<?php
// آرایه محصولات موبایل
$products_mobile = [
    'samsung' => [
        ['id' => 11, 'title' => 'سامسونگ مدل A', 'price' => 12000000, 'image' => 'phone1.png'],
        ['id' => 12, 'title' => 'سامسونگ مدل B', 'price' => 15000000, 'image' => 'phone2.png'],
    ],
    'xiaomi' => [
        ['id' => 13, 'title' => 'شیائومی مدل A', 'price' => 9000000, 'image' => 'phone3.png'],
        ['id' => 14, 'title' => 'شیائومی مدل B', 'price' => 11000000, 'image' => 'phone4.png'],
    ],
    'apple' => [
        ['id' => 15, 'title' => 'اپل مدل A', 'price' => 25000000, 'image' => 'phone5.png'],
        ['id' => 16, 'title' => 'اپل مدل B', 'price' => 28000000, 'image' => 'phone6.png'],
    ],
    'huawei' => [
        ['id' => 17, 'title' => 'هواوی مدل A', 'price' => 10000000, 'image' => 'phone7.png'],
        ['id' => 18, 'title' => 'هواوی مدل B', 'price' => 13000000, 'image' => 'phone8.png'],
    ],
];

// آرایه محصولات لپ‌تاپ
$products_laptop = [
    'asus' => [
        ['id' => 1, 'title' => 'ایسوس مدل A', 'price' => 25000000, 'image' => 'laptop1.png'],
        ['id' => 2, 'title' => 'ایسوس مدل B', 'price' => 27000000, 'image' => 'laptop2.png'],
    ],
    'lenovo' => [
        ['id' => 3, 'title' => 'لنوو مدل A', 'price' => 22000000, 'image' => 'laptop3.png'],
        ['id' => 4, 'title' => 'لنوو مدل B', 'price' => 24000000, 'image' => 'laptop4.png'],
    ],
    'hp' => [
        ['id' => 5, 'title' => 'اچ‌پی مدل A', 'price' => 26000000, 'image' => 'laptop5.png'],
        ['id' => 6, 'title' => 'اچ‌پی مدل B', 'price' => 28000000, 'image' => 'laptop6.png'],
    ],
    'apple' => [
        ['id' => 7, 'title' => 'اپل مدل A', 'price' => 35000000, 'image' => 'laptop7.png'],
        ['id' => 8, 'title' => 'اپل مدل B', 'price' => 37000000, 'image' => 'laptop8.png'],
    ],
];

$cat = $_GET['cat'] ?? '';
$brand = $_GET['brand'] ?? '';

if (!$cat || !$brand) {
    echo "دسته‌بندی یا برند مشخص نشده است.";
    exit;
}

// انتخاب محصولات بر اساس دسته‌بندی و برند
$products = [];
if ($cat === 'mobile' && isset($products_mobile[$brand])) {
    $products = $products_mobile[$brand];
} elseif ($cat === 'laptop' && isset($products_laptop[$brand])) {
    $products = $products_laptop[$brand];
} else {
    echo "محصولی برای این دسته‌بندی و برند یافت نشد.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <title>محصولات <?= htmlspecialchars($brand) ?> - دسته <?= htmlspecialchars($cat) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
<link rel="stylesheet" href="css/dasteh.css">
</head>
<body>

<a href="index.php" class="back-link">بازگشت به صفحه اصلی</a>

<div class="products-container">
<?php foreach ($products as $p): ?>
  <div class="product-box">
    <img src="uploads/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['title']) ?>" />
    <h3><?= htmlspecialchars($p['title']) ?></h3>
    <p><?= number_format($p['price']) ?> تومان</p>
    <a href="add_to_cart.php?id=<?= $p['id'] ?>" class="btn-add-cart">افزودن به سبد</a>
    <a href="product_detail.php?id=<?= $p['id'] ?>" class="btn-details">جزئیات</a>
  </div>
<?php endforeach; ?>
</div>

</body>
</html>
