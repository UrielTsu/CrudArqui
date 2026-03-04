<?php
session_start();
require_once __DIR__ . '/data/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: web/cart.php');
    exit();
}

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header('Location: web/cart.php?error=carrito-vacio');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

try {
    $conn->begin_transaction();

    foreach ($_SESSION['carrito'] as $id => $item) {
        $idProducto = (int)$id;
        $cantidadSolicitada = (int)($item['cantidad'] ?? 0);

        if ($cantidadSolicitada <= 0) {
            throw new Exception('Cantidad inválida.');
        }

        $stmtStock = $conn->prepare('SELECT stock FROM productos WHERE id = ? FOR UPDATE');
        $stmtStock->bind_param('i', $idProducto);
        $stmtStock->execute();
        $resultStock = $stmtStock->get_result();

        if (!$resultStock || $resultStock->num_rows === 0) {
            throw new Exception('Producto no encontrado.');
        }

        $row = $resultStock->fetch_assoc();
        $stockActual = (int)$row['stock'];

        if ($cantidadSolicitada > $stockActual) {
            throw new Exception('Stock insuficiente para completar la compra.');
        }

        $nuevoStock = $stockActual - $cantidadSolicitada;
        $stmtUpdate = $conn->prepare('UPDATE productos SET stock = ? WHERE id = ?');
        $stmtUpdate->bind_param('ii', $nuevoStock, $idProducto);

        if (!$stmtUpdate->execute()) {
            throw new Exception('No se pudo actualizar el stock.');
        }
    }

    $conn->commit();
    $_SESSION['carrito'] = [];

    header('Location: web/cart.php?success=compra-realizada');
    exit();
} catch (Exception $e) {
    $conn->rollback();
    header('Location: web/cart.php?error=' . urlencode($e->getMessage()));
    exit();
}
