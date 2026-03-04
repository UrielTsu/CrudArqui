<?php
session_start();
header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

$cartCount = 0;
if (isset($_SESSION['carrito']) && is_array($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $cartCount += (int)($item['cantidad'] ?? 0);
    }
}

echo json_encode([
    'status' => 'success',
    'count' => $cartCount
]);
