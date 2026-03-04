<?php

session_start();
require_once __DIR__ . '/data/db.php';

function obtenerStockProducto($idProducto) {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT stock FROM productos WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows === 0) {
        return null;
    }

    $row = $result->fetch_assoc();
    return (int)$row['stock'];
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];

    switch ($action) {
        case 'add':
            $stockDisponible = obtenerStockProducto($id);
            if ($stockDisponible === null || $stockDisponible <= 0) {
                header("Location: web/cart.php?error=sin-stock");
                exit();
            }
            
            if (!isset($_SESSION['carrito'][$id])) {
                $_SESSION['carrito'][$id] = [
                    'nombre' => $_GET['name'] ?? '',
                    'precio' => (float)($_GET['price'] ?? 0),
                    'imagen' => $_GET['img'] ?? '',
                    'cantidad' => 1
                ];
            } else {
                if ($_SESSION['carrito'][$id]['cantidad'] >= $stockDisponible) {
                    header("Location: web/cart.php?error=stock-insuficiente");
                    exit();
                }
                $_SESSION['carrito'][$id]['cantidad']++;
            }
            break;

        case 'plus':
            $stockDisponible = obtenerStockProducto($id);
            if (isset($_SESSION['carrito'][$id])) {
                if ($stockDisponible === null || $_SESSION['carrito'][$id]['cantidad'] >= $stockDisponible) {
                    header("Location: web/cart.php?error=stock-insuficiente");
                    exit();
                }
                $_SESSION['carrito'][$id]['cantidad']++;
            }
            break;

        case 'minus':
            if (isset($_SESSION['carrito'][$id]) && $_SESSION['carrito'][$id]['cantidad'] > 1) {
                $_SESSION['carrito'][$id]['cantidad']--;
            }
            break;

        case 'remove':
            if (isset($_SESSION['carrito'][$id])) {
                unset($_SESSION['carrito'][$id]);
            }
            break;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'add') {
    header("Location: web/cart.php");
} else {
    $redirect = $_SERVER['HTTP_REFERER'] ?? 'web/cart.php';
    header("Location: " . $redirect);
}
exit();
?>