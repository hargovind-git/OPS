<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: shop_owner_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    $jsonFilePath = 'orders.json';
    $orders = json_decode(file_get_contents($jsonFilePath), true);

    if (isset($orders[$index])) {
        $orders[$index]['status'] = 'done';
        file_put_contents($jsonFilePath, json_encode($orders, JSON_PRETTY_PRINT));
    }

    header('Location: shop_owner.php');
    exit;
}
?>
