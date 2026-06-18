<?php
include("db.php");
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["username"] != 'sharifi') {
    header("Location: login.php");
    exit();
}


$id = (int)$_GET["id"]; // تبدیل به عدد برای امنیت
$product_query = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
if (!$product_query || mysqli_num_rows($product_query) == 0) {
  die("<h3 class='text-center mt-5'>محصول مورد نظر پیدا نشد!</h3>");
}
$product = mysqli_fetch_assoc($product_query);

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = mysqli_real_escape_string($conn, $_POST["title"]);
  $description = mysqli_real_escape_string($conn, $_POST["description"]);
  $price = (float)$_POST["price"];
  $category = mysqli_real_escape_string($conn, $_POST["category"]);

  if ($_FILES["image"]["name"]) {
    $allowed = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
      $error = "فرمت تصویر معتبر نیست. لطفا jpg، png، gif یا webp انتخاب کنید.";
    } else {
      $imageName = time() . "_" . preg_replace('/[^a-z0-9_\-\.]/i', '', $_FILES["image"]["name"]);
      $imageTmp = $_FILES["image"]["tmp_name"];
      move_uploaded_file($imageTmp, "uploads/" . $imageName);
      $sql = "UPDATE products SET title='$title', description='$description', price=$price, image='$imageName', category='$category' WHERE id=$id";
    }
  } else {
    $sql = "UPDATE products SET title='$title', description='$description', price=$price, category='$category' WHERE id=$id";
  }

  if (!$error) {
    mysqli_query($conn, $sql);
    header("Location: admin_panel.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <title>ویرایش محصول</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet" />

<link rel="stylesheet" href="css/edit_product.css">
</head>
<body>
  <div class="form-container">
    <h3>ویرایش محصول</h3>

    <?php if ($error): ?>
      <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" autocomplete="off">
      <input type="text" name="title" placeholder="نام محصول" value="<?= htmlspecialchars($product['title']) ?>" required>
      <textarea name="description" placeholder="توضیحات"><?= htmlspecialchars($product['description']) ?></textarea>
      <input type="number" name="price" placeholder="قیمت" value="<?= htmlspecialchars($product['price']) ?>" step="0.01" min="0" required>
      <input type="text" name="category" placeholder="دسته‌بندی (mobile یا laptop)" value="<?= htmlspecialchars($product['category']) ?>" required>
      <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.webp">
      <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="تصویر محصول" class="current-image" loading="lazy" />
      <button type="submit" class="btn-submit">بروزرسانی</button>
       <div class="d-flex justify-content-center gap-3 mt-4">
  <a href="index.php" class="btn btn-outline-primary">🏠 صفحه اصلی</a>
  <button onclick="history.back()" class="btn btn-outline-secondary">⬅️ صفحه قبلی</button>
</div>
    </form>
  </div>
</body>
</html>
