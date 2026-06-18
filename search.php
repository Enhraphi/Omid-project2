<?php
// دریافت عبارت جستجو
$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';

// تعریف آرایه محصولات (مثل نمونه شما)
$products = [
    ['id' => 1, 'title' => 'لپ‌تاپ 1', 'price' => '25,000,000 تومان', 'img' => 'uploads/laptop1.png', 'type' => 'laptop'],
    ['id' => 2, 'title' => 'لپ‌تاپ 2', 'price' => '27,500,000 تومان', 'img' => 'uploads/laptop2.png', 'type' => 'laptop'],
    ['id' => 3, 'title' => 'لپ‌تاپ 3', 'price' => '23,800,000 تومان', 'img' => 'uploads/laptop3.png', 'type' => 'laptop'],
    ['id' => 4, 'title' => 'لپ‌تاپ 4', 'price' => '26,300,000 تومان', 'img' => 'uploads/laptop4.png', 'type' => 'laptop'],
    ['id' => 5, 'title' => 'لپ‌تاپ 5', 'price' => '24,500,000 تومان', 'img' => 'uploads/laptop5.png', 'type' => 'laptop'],

    ['id' => 6, 'title' => 'گوشی 1', 'price' => '10,000,000 تومان', 'img' => 'uploads/phone1.png', 'type' => 'phone'],
    ['id' => 7, 'title' => 'گوشی 2', 'price' => '12,500,000 تومان', 'img' => 'uploads/phone2.png', 'type' => 'phone'],
    ['id' => 8, 'title' => 'گوشی 3', 'price' => '9,800,000 تومان', 'img' => 'uploads/phone3.png', 'type' => 'phone'],
    ['id' => 9, 'title' => 'گوشی 4', 'price' => '11,200,000 تومان', 'img' => 'uploads/phone4.png', 'type' => 'phone'],
    ['id' => 10, 'title' => 'گوشی 5', 'price' => '13,000,000 تومان', 'img' => 'uploads/phone5.png', 'type' => 'phone'],
];

// فیلتر محصولات بر اساس جستجو (عنوان)
$results = [];
if ($searchQuery !== '') {
    foreach ($products as $product) {
        if (mb_stripos($product['title'], $searchQuery) !== false) {
            $results[] = $product;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>نتایج جستجو - "<?php echo htmlspecialchars($searchQuery); ?>"</title>

    <!-- بوت‌استرپ RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    
<link rel="stylesheet" href="css/search.css">
</head>
<body>

<div class="container" style="max-width: 960px;">
    <h1>نتایج جستجو برای: «<?php echo htmlspecialchars($searchQuery); ?>»</h1>

    <?php if ($searchQuery === ''): ?>
        <div class="no-results">هیچ عبارتی برای جستجو وارد نشده است.</div>
    <?php elseif (count($results) === 0): ?>
        <div class="no-results">متأسفانه هیچ محصولی یافت نشد.</div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach ($results as $product): ?>
                <div class="col-md-3 mb-4">
                    <div class="card product-card h-100">
                        <img src="<?php echo htmlspecialchars($product['img']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="card-img-top product-img" />
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($product['price']); ?></p>
                            <div class="btn-group-custom mt-auto">
                                <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-primary btn-buy">مشاهده</a>
                                <a href="add_to_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-success btn-buy">افزودن به سبد</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="text-center">
        <a href="index.php" class="btn-back"><i class="fas fa-arrow-right"></i> بازگشت به صفحه اصلی</a>
    </div>
</div>

</body>
</html>
