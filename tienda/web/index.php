<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TiendaTech - Inicio</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    
    <?php include 'navbar.php'; ?>

    <section class="hero-section">
        <div class="hero-overlay">
            <img src="https://images.unsplash.com/photo-1768225707204-e334fb30bde1?..." alt="Banner Tech">
        </div>
        <div class="container hero-content">
            <div class="hero-text-wrapper">
                <h1>Bienvenido al Futuro de la Tecnología</h1>
                <p>Descubre tecnología de vanguardia y gadgets premium.</p>
                <a href="#productos" class="hero-btn">Comprar Ahora <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <section class="product-grid-container" id="productos">
        <div class="header-section">
            <h2>Productos Destacados</h2>
            <p>Explora nuestra selección curada de productos tecnológicos premium</p>
        </div>

        <div class="grid-layout">
            <?php
            // TRAEMOS LOS PRODUCTOS DE LA BASE DE DATOS
            $result = $conn->query("SELECT * FROM productos");
            if ($result->num_rows > 0):
                while($row = $result->fetch_assoc()):
            ?>
                <article class="product-card">
                    <div class="card-image">
                        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                    </div>
                    <div class="card-content">
                        <span class="category"><?php echo $row['category']; ?></span>
                        <h3><?php echo $row['name']; ?></h3>
                        <p class="description"><?php echo $row['description']; ?></p>
                    </div>
                    <div class="card-footer">
                        <span class="price">$<?php echo number_format($row['price'], 2); ?></span>
                        <a href="update_card.php?id=<?php echo $row['id']; ?>&action=add&name=<?php echo urlencode($row['name']); ?>&price=<?php echo $row['price']; ?>&img=<?php echo urlencode($row['image']); ?>" class="add-btn">
                            <i class="fas fa-shopping-cart"></i> Añadir
                        </a>
                    </div>
                </article>
            <?php 
                endwhile;
            else:
                echo "<p>Aún no hay productos disponibles.</p>";
            endif; 
            ?>
        </div>
    </section>

   
<footer class="main-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-section">
                <h3 class="footer-title">TiendaTech</h3>
                <p class="footer-text">
                    Tu destino de confianza para tecnología y gadgets premium. 
                    Te traemos las últimas innovaciones a los mejores precios.
                </p>
            </div>

            <div class="footer-section">
                <h3 class="footer-title">Contáctanos</h3>
                <div class="contact-list">
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+52 2211968664</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>gh202335806@alm.buap.mx</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Calle inventada 123, Puebla </span>
                    </div>
                </div>
            </div>

            <div class="footer-section">
                <h3 class="footer-title">Síguenos</h3>
                <div class="social-icons">
                    <a href="#" class="social-link" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 TiendaTech. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

</body>
</html>