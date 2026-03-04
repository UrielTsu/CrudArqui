<?php

session_start();

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    switch ($action) {
        case 'add':
            
            if (!isset($_SESSION['carrito'][$id])) {
                $_SESSION['carrito'][$id] = [
                    'nombre' => $_GET['name'],
                    'precio' => $_GET['price'],
                    'imagen' => $_GET['img'],
                    'cantidad' => 1
                ];
            } else {
                $_SESSION['carrito'][$id]['cantidad']++;
            }
            break;

        case 'plus':
            if (isset($_SESSION['carrito'][$id])) {
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
    header("Location: cart.php");
} else {
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
exit();
?>