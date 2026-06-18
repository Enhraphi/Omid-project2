<?php
include("db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if (mysqli_query($conn, $sql)) {
        header("Location: login.php");
        exit();
    } else {
        echo "خطا: " . mysqli_error($conn);
    }
}
?>

<h3>ثبت‌نام</h3>
<form method="post" class="w-25 mx-auto mt-3">
  <input type="text" name="username" placeholder="نام کاربری" required class="form-control mb-2">
  <input type="password" name="password" placeholder="رمز عبور" required class="form-control mb-2">
  <button type="submit" class="btn btn-primary w-100">ثبت‌نام</button>
</form>