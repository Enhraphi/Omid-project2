<?php
session_start();
$id = $_GET['id'];
if (($key = array_search($id, $_SESSION['cart'])) !== false) {
  unset($_SESSION['cart'][$key]);
}
setcookie('cart', serialize($_SESSION['cart']), time() + 86400, "/");
header("Location: cart.php");