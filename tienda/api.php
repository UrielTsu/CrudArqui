<?php
// Archivo: /api.php

// 1. Configuramos las cabeceras para que el navegador sepa que responderemos con JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// 2. Importamos nuestra capa de negocio (El Core)
require_once __DIR__ . '/core/InventarioService.php';

try {
    // 3. Instanciamos el servicio
    $servicio = new InventarioService();
    
    // 4. Obtenemos el inventario ya procesado por las reglas de negocio
    $datos = $servicio->obtenerInventarioProcesado();
    
    // 5. Convertimos el arreglo de PHP a formato JSON y lo enviamos
    echo json_encode([
        "status" => "success",
        "data" => $datos
    ]);

} catch (Exception $e) {
    // Manejo de errores elegante
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Hubo un problema al obtener el inventario."
    ]);
}
?>