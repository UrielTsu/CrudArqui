<?php
require_once __DIR__ . '/data/db.php';

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturamos los datos del formulario
    $name = $_POST['name'] ?? '';
    $category = $_POST['category'] ?? '';
    $price = (float) ($_POST['price'] ?? 0);
    $stock = (int) ($_POST['stock'] ?? 0);
    if ($stock < 0) {
        $stock = 0;
    }
    $image = $_POST['image'] ?? '';
    $description = $_POST['description'] ?? '';
    $id_proveedor = 1;

    $stmt = $conn->prepare("INSERT INTO productos (nombre, categoria, precio, stock, imagen_url, descripcion, id_proveedor) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdissi", $name, $category, $price, $stock, $image, $description, $id_proveedor);

    if ($stmt->execute()) {
       
        header("Location: web/admin.php?status=success");
        exit();
    } else {
        echo "Error al guardar: " . $conn->error;
    }
}
?>