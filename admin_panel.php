<?php
include("db.php");
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["username"] != 'sharifi') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
  <meta charset="UTF-8" />
  <title>پنل مدیریت - فروشگاه شریفی</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet" />
  
<link rel="stylesheet" href="css/admin_panel.css">
</head>

<body>

  <h3>پنل مدیریت فروشگاه شریفی</h3>
  <div class="d-flex justify-content-center">
    <a href="add_product.php" class="btn btn-add-product">➕ افزودن محصول جدید</a>
  </div>

  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>نام محصول</th>
          <th>قیمت</th>
          <th>عکس</th>
          <th>دسته‌بندی</th>
          <th>عملیات</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM products");
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
            <td>{$row['title']}</td>
            <td>{$row['price']} تومان</td>
            <td><img src='uploads/{$row['image']}' alt='{$row['title']}'></td>
            <td>{$row['category']}</td>
            <td>
              <a href='edit_product.php?id={$row['id']}' class='btn btn-warning btn-sm mx-1'>ویرایش</a>
              <a href='delete_product.php?id={$row['id']}' class='btn btn-danger btn-sm mx-1' onclick=\"return confirm('آیا از حذف این محصول مطمئن هستید؟');\">حذف</a>
            </td>
          </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
<div class="d-flex justify-content-center gap-3 mt-4">
  <a href="index.php" class="btn btn-outline-primary">🏠 صفحه اصلی</a>
  <button onclick="history.back()" class="btn btn-outline-secondary">⬅️ صفحه قبلی</button>
</div>

</body>
</html>
