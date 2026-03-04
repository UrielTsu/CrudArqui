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
        <a href="index.html" class="btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="cart-title">
            <i class="fas fa-shopping-bag"></i>
            <span>Carrito de Compras</span>
        </div>
    </div>
</header>

<main class="container cart-container">
    <?php if (isset($_GET['error'])): ?>
        <div style="margin: 1rem 0; padding: 0.75rem 1rem; border-radius: 8px; background: #fee2e2; color: #991b1b; font-weight: 600;">
            <?php
                $error = $_GET['error'];
                if ($error === 'stock-insuficiente') {
                    echo 'No puedes agregar más unidades: el stock disponible es menor.';
                } elseif ($error === 'sin-stock') {
                    echo 'Este producto no tiene stock disponible.';
                } elseif ($error === 'carrito-vacio') {
                    echo 'Tu carrito está vacío.';
                } else {
                    echo htmlspecialchars($error);
                }
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'compra-realizada'): ?>
        <div style="margin: 1rem 0; padding: 0.75rem 1rem; border-radius: 8px; background: #dcfce7; color: #166534; font-weight: 600;">
            Compra realizada. El stock fue actualizado correctamente.
        </div>
    <?php endif; ?>

    <?php if (empty($_SESSION['carrito'])): ?>
        <div class="empty-cart">
            <i class="fas fa-shopping-bag fa-5x"></i>
            <h2>Tu carrito está vacío</h2>
            <p>Agrega algunos productos increíbles para comenzar.</p>
            <a href="index.html" class="btn-primary">Continuar Comprando</a>
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
                                <a href="../update_card.php?id=<?php echo $id; ?>&action=minus" class="q-btn">-</a>
                                <span><?php echo $item['cantidad']; ?></span>
                                <a href="../update_card.php?id=<?php echo $id; ?>&action=plus" class="q-btn">+</a>
                            </div>
                            <span class="item-price">$<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></span>
                            <a href="../update_card.php?id=<?php echo $id; ?>&action=remove" class="btn-remove">
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
                    <form action="../checkout.php" method="POST">
                        <button type="submit" class="btn-checkout">Finalizar Compra</button>
                    </form>
                </div>
            </aside>
        </div>
    <?php endif; ?>
</main>

</body>
</html>