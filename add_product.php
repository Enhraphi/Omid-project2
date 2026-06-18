<?php
include("db.php");
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["username"] != 'sharifi') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = mysqli_real_escape_string($conn, $_POST["title"]);
  $description = mysqli_real_escape_string($conn, $_POST["description"]);
  $price = (float)$_POST["price"];
  $category = mysqli_real_escape_string($conn, $_POST["category"]);

  $error = "";

  if (isset($_FILES["image"]) && $_FILES["image"]["name"]) {
    $allowed = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
      $error = "فرمت تصویر معتبر نیست. لطفا jpg، png، gif یا webp انتخاب کنید.";
    } else {
      $imageName = time() . "_" . preg_replace('/[^a-z0-9_\-\.]/i', '', $_FILES["image"]["name"]);
      $imageTmp = $_FILES["image"]["tmp_name"];
      move_uploaded_file($imageTmp, "uploads/" . $imageName);
    }
  } else {
    $error = "لطفا تصویر محصول را انتخاب کنید.";
  }

  if (!$error) {
    $sql = "INSERT INTO products (title, description, price, image, category) 
            VALUES ('$title', '$description', $price, '$imageName', '$category')";
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
  <title>افزودن محصول جدید</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet" />

<link rel="stylesheet" href="css/add_product.css">
</head>
<body>
  <div class="form-container">
    <h3>افزودن محصول جدید</h3>

    <?php if (!empty($error)): ?>
      <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" autocomplete="off">
      <input type="text" name="title" placeholder="نام محصول" required value="<?= isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>">
      <textarea name="description" placeholder="توضیحات"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
      <input type="number" name="price" placeholder="قیمت" step="0.01" min="0" required value="<?= isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '' ?>">
      <input type="text" name="category" placeholder="دسته‌بندی (mobile یا laptop)" required value="<?= isset($_POST['category']) ? htmlspecialchars($_POST['category']) : '' ?>">
      <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.webp" required>
      <button type="submit" class="btn-submit">ذخیره محصول</button>
   <div class="d-flex justify-content-center gap-3 mt-4">
  <a href="index.php" class="btn btn-outline-primary">🏠 صفحه اصلی</a>
  <button onclick="history.back()" class="btn btn-outline-secondary">⬅️ صفحه قبلی</button>
</div>
</div>
    </form>
    </div>


</body>

</html>
