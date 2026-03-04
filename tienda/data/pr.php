<?php
// Archivo: /data/ProductoRepository.php
require_once __DIR__ . '/db.php';

class ProductoRepository {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Operación READ (Leer todos)
    public function obtenerTodos() {
        $query = "SELECT p.*, prov.nombre as proveedor_nombre 
                  FROM productos p 
                  LEFT JOIN proveedores prov ON p.id_proveedor = prov.id";
        
        $result = $this->conn->query($query);
        $productos = [];
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
        }
        return $productos;
    }

    // Operación UPDATE (Actualizar Stock)
    public function actualizarStock($id_producto, $nuevo_stock) {
        $query = "UPDATE productos SET stock = $nuevo_stock WHERE id = $id_producto";
        return $this->conn->query($query);
    }
}
?>