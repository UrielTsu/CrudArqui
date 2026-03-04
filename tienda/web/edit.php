<?php
session_start();
if (!isset($_SESSION['admin_logged'])) {
    header('Location: login.php');
    exit();
}

require_once __DIR__ . '/../data/db.php';
$db = new Database();
$conn = $db->getConnection();

$id = isset($_GET['id']) ? (int)$_GET['id'] : (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    header('Location: admin.php?error=id-invalido');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $image = trim($_POST['image'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($stock < 0) {
        $stock = 0;
    }

    $stmtUpdate = $conn->prepare("UPDATE productos SET nombre = ?, categoria = ?, precio = ?, stock = ?, imagen_url = ?, descripcion = ? WHERE id = ?");
    $stmtUpdate->bind_param("ssdissi", $name, $category, $price, $stock, $image, $description, $id);

    if ($stmtUpdate->execute()) {
        header('Location: admin.php?status=updated');
        exit();
    }

    $error = 'No se pudo actualizar el producto.';
}

$stmt = $conn->prepare("SELECT id, nombre, categoria, precio, stock, imagen_url, descripcion FROM productos WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    header('Location: admin.php?error=no-encontrado');
    exit();
}

$product = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - TiendaTech</title>
    <link rel="stylesheet" href="styles.css?v=20260304">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .product-form-card {
            max-width: 680px;
            margin: 2rem auto;
            padding: 2rem;
            border-radius: 16px;
            background: #fff;
        }

        .product-form-title {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }

        .product-form {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.85rem;
        }

        .product-form label {
            display: block;
            font-size: 1rem;
            font-weight: 600;
            color: #0f172a;
        }

        .product-form input,
        .product-form textarea {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 0.9rem 1rem;
            font-size: 1.05rem;
            box-sizing: border-box;
            outline: none;
            background: #fff;
        }

        .product-form input:focus,
        .product-form textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }

        .form-actions {
            margin-top: 1.4rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        .btn-cancel {
            background: #e2e8f0;
            color: #1e3a8a;
            border: none;
            border-radius: 12px;
            padding: 0.65rem 1.1rem;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }

        .btn-save {
            border-radius: 12px;
            padding: 0.65rem 1.2rem;
            font-weight: 600;
        }
    </style>
</head>
<body class="admin-body">
    <header class="admin-header">
        <div class="container flex-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 2rem;">
                <a href="admin.php" class="btn-back"><i class="fas fa-arrow-left"></i> Volver</a>
                <h1><i class="fas fa-pen"></i> Editar Producto</h1>
            </div>
        </div>
    </header>

    <main class="container admin-main">
        <div class="card shadow product-form-card">
            <?php if (!empty($error)): ?>
                <div style="margin-bottom: 1rem; padding: 0.75rem 1rem; border-radius: 8px; background: #fee2e2; color: #991b1b; font-weight: 600;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <h2 class="product-form-title">Editar Producto</h2>
            <hr>

            <form action="edit.php" method="POST" class="product-form">
                <input type="hidden" name="id" value="<?php echo (int)$product['id']; ?>">

                <label>Nombre del Producto</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($product['nombre']); ?>" required>

                <label>Categoría</label>
                <input type="text" name="category" value="<?php echo htmlspecialchars($product['categoria']); ?>" required>

                <label>Precio</label>
                <input type="number" name="price" step="0.01" min="0" value="<?php echo htmlspecialchars($product['precio']); ?>" required>

                <label>Stock</label>
                <input type="number" name="stock" step="1" min="0" value="<?php echo (int)$product['stock']; ?>" required>

                <label>Ruta de la Imagen</label>
                <input type="text" name="image" value="<?php echo htmlspecialchars($product['imagen_url']); ?>" required>

                <label>Descripción</label>
                <textarea name="description" rows="4" placeholder="Detalles del producto..."><?php echo htmlspecialchars($product['descripcion']); ?></textarea>

                <div class="form-actions">
                    <a href="admin.php" class="btn-cancel">Cancelar</a>
                    <button type="submit" class="add-btn btn-save">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
