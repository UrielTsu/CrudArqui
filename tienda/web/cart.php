<?php
session_start();
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$subtotal = 0;
foreach ($_SESSION['carrito'] as $item) {
    $subtotal += $item['precio'] * $item['cantidad'];
}
$iva = $subtotal * 0.21;
$total = $subtotal + $iva;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito - TiendaTech</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<header class="cart-header">
    <div class="container flex-between">
        <a href="index.php" class="btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="cart-title">
            <i class="fas fa-shopping-bag"></i>
            <span>Carrito de Compras</span>
        </div>
    </div>
</header>

<main class="container cart-container">
    <?php if (empty($_SESSION['carrito'])): ?>
        <div class="empty-cart">
            <i class="fas fa-shopping-bag fa-5x"></i>
            <h2>Tu carrito está vacío</h2>
            <p>Agrega algunos productos increíbles para comenzar.</p>
            <a href="index.php" class="btn-primary">Continuar Comprando</a>
        </div>
    <?php else: ?>
        <div class="cart-grid">
            <div class="cart-items">
                <?php foreach ($_SESSION['carrito'] as $id => $item): ?>
                <div class="cart-card">
                    <img src="<?php echo $item['imagen']; ?>" alt="Producto">
                    <div class="cart-info">
                        <h3><?php echo $item['nombre']; ?></h3>
                        <div class="cart-controls">
                            <div class="quantity-picker">
                                <a href="update_card.php?id=<?php echo $id; ?>&action=minus" class="q-btn">-</a>
                                <span><?php echo $item['cantidad']; ?></span>
                                <a href="update_card.php?id=<?php echo $id; ?>&action=plus" class="q-btn">+</a>
                            </div>
                            <span class="item-price">$<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></span>
                            <a href="update_card.php?id=<?php echo $id; ?>&action=remove" class="btn-remove">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <aside class="cart-summary">
                <div class="card shadow">
                    <h3>Resumen del Pedido</h3>
                    <div class="summary-row"><span>Subtotal</span> <span>$<?php echo number_format($subtotal, 2); ?></span></div>
                    <div class="summary-row"><span>IVA (21%)</span> <span>$<?php echo number_format($iva, 2); ?></span></div>
                    <div class="summary-row"><span>Envío</span> <span class="free">GRATIS</span></div>
                    <hr>
                    <div class="summary-row total"><span>Total</span> <span>$<?php echo number_format($total, 2); ?></span></div>
                    <button class="btn-checkout">Finalizar Compra</button>
                </div>
            </aside>
        </div>
    <?php endif; ?>
</main>

</body>
</html>