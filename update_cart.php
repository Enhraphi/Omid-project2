<?php
session_start();
header('Content-Type: application/json');

if (!isset($_POST['id'], $_POST['action'])) {
    echo json_encode(['status' => 'error', 'message' => 'پارامترها ناقص هستند']);
    exit;
}

$id = (int)$_POST['id'];
$action = $_POST['action'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

function decreaseQuantity(&$cart, $id) {
    $key = array_search($id, $cart);
    if ($key !== false) {
        unset($cart[$key]);
        $cart = array_values($cart);
    }
}

function increaseQuantity(&$cart, $id) {
    $cart[] = $id;
}

if ($action === 'increase') {
    increaseQuantity($_SESSION['cart'], $id);
} elseif ($action === 'decrease') {
    decreaseQuantity($_SESSION['cart'], $id);
} else {
    echo json_encode(['status' => 'error', 'message' => 'عملیات نامعتبر']);
    exit;
}

echo json_encode(['status' => 'success']);
