<?php
$jsonFilePath = 'orders.json';
$orders = file_exists($jsonFilePath) ? json_decode(file_get_contents($jsonFilePath), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'] ?? null;

    if ($index !== null && isset($orders[$index])) {
        $orders[$index]['status'] = 'done';

        // Save the updated orders
        file_put_contents($jsonFilePath, json_encode($orders, JSON_PRETTY_PRINT));
    }
}

header("Location: shop_owner.php");
exit;
?>
