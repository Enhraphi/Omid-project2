<?php
include("db.php");
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["username"] != 'sharifi') {
    header("Location: login.php");
    exit();
}

$id = $_GET["id"];
mysqli_query($conn, "DELETE FROM products WHERE id=$id");
header("Location: admin_panel.php");
exit();
?>