<?php 
// 1. Iniciamos sesión y verificamos 
session_start();
if (!isset($_SESSION['admin_logged'])) {
    // Si no hay sesión, mandamos al usuario al login 
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/../data/db.php';
$db = new Database();
$conn = $db->getConnection();

// Eliminar productos 
if(isset($_GET['delete'])){
    $id = (int) $_GET['delete'];
    $conn->query("DELETE FROM productos WHERE id=$id");
    header("location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - TiendaTech</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-body">

    <header class="admin-header">
        <div class="container flex-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 2rem;">
                <a href="index.html" class="btn-back"><i class="fas fa-arrow-left"></i> Volver</a>
                <h1><i class="fas fa-store"></i> Panel de Administración</h1>
            </div>
            
            <a href="../logout.php" class="btn-delete" style="border-radius: 20px; padding: 0.5rem 1.2rem; text-decoration: none; font-weight: bold;">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </header>

    <main class="container admin-main">
        <div class="card shadow">
            <div class="card-header">
                <h2>Gestión de Productos</h2>
                <button class="add-btn" style="padding: 0.8rem 1.5rem;" onclick="openModal()">
                    <i class="fas fa-plus"></i> Añadir Producto
                </button>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT id, nombre AS name, categoria AS category, precio AS price, imagen_url AS image FROM productos");
                        while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><img src="<?php echo $row['image']; ?>" class="img-thumb"></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><span class="badge"><?php echo $row['category']; ?></span></td>
                            <td>$<?php echo number_format($row['price'], 2); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-edit"><i class="fas fa-pencil"></i></a>
                                <a href="admin.php?delete=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php if ($result->num_rows == 0): ?>
                    <p style="text-align: center; padding: 2rem;">No hay productos registrados.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <div id="modalProduct" class="modal">
        <div class="modal-content">
            <h3><i class="fas fa-plus-circle"></i> Nuevo Producto</h3>
            <hr>
            <form action="../save_product.php" method="POST">
                <div class="modal-body">
                    <label>Nombre del Producto</label>
                    <input type="text" name="name" placeholder="Ej. Laptop Gaming" required>
                    
                    <label>Categoría</label>
                    <input type="text" name="category" placeholder="Ej. Computadoras" required>
                    
                    <label>Precio</label>
                    <input type="number" name="price" step="0.01" placeholder="0.00" required>
                    
                    <label>URL de la Imagen</label>
                    <input type="url" name="image" placeholder="https://..." required>
                    
                    <label>Descripción</label>
                    <textarea name="description" rows="4" placeholder="Detalles del producto..."></textarea>
                </div>
                <div class="modal-footer" style="margin-top: 1rem; display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="button" onclick="closeModal()" class="btn-edit" style="border-radius: 8px;">Cancelar</button>
                    <button type="submit" class="add-btn" style="border-radius: 8px;">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() { document.getElementById('modalProduct').style.display = 'flex'; }
        function closeModal() { document.getElementById('modalProduct').style.display = 'none'; }
        
        window.onclick = function(event) {
            let modal = document.getElementById('modalProduct');
            if (event.target == modal) { closeModal(); }
        }
    </script>
</body>
</html>