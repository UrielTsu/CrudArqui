<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="navbar.css">
<nav class="navbar">
    <div class="container navbar-content">
        <a href="index.php" class="logo">
            <i class="fas fa-store"></i>
            <span>TiendaTech</span>
        </a>

        <div class="search-container desktop-search">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="search" placeholder="Buscar productos..." class="search-input">
            </div>
        </div>

        <div class="nav-actions">
            <a href="admin.php" class="btn-admin">Admin</a>
            <?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$cartCount = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $cartCount += $item['cantidad'];
    }
}
?>
<a href="cart.php" class="cart-btn">
    <i class="fas fa-shopping-cart"></i>
    <span class="cart-badge"><?php echo $cartCount; ?></span>
</a>
        </div>
    </div>

    <div class="container mobile-search">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="search" placeholder="Buscar productos..." class="search-input">
        </div>
    </div>
</nav>