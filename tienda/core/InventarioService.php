<?php
// Archivo: /core/InventarioService.php

// Importamos la capa de datos
require_once __DIR__ . '/../data/pr.php';

class InventarioService {
    private $repository;
    
    // Regla de negocio estricta: si hay menos de 5, hay que reabastecer
    private const STOCK_MINIMO = 5; 

    public function __construct() {
        $this->repository = new ProductoRepository();
    }

    // --------------------------------------------------------
    // REGLA 1: Validar si necesita reabastecimiento
    // --------------------------------------------------------
    public function necesitaReabastecimiento($stockActual) {
        // Devuelve true o false dependiendo del stock
        return $stockActual < self::STOCK_MINIMO;
    }

    // --------------------------------------------------------
    // REGLA 2: Validar el formato de la imagen
    // --------------------------------------------------------
    public function validarFormatoImagen($nombreArchivo) {
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
        
        // Extraemos la extensión del archivo y la pasamos a minúsculas
        $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
        
        return in_array($extension, $extensionesPermitidas);
    }

    // --------------------------------------------------------
    // ORQUESTADOR: Prepara los datos para la interfaz
    // --------------------------------------------------------
    public function obtenerInventarioProcesado() {
        // 1. Pedimos los datos "crudos" a la capa de Datos
        $productosCrudos = $this->repository->obtenerTodos();
        $productosProcesados = [];

        foreach ($productosCrudos as $producto) {
            // 2. Aplicamos la regla de reabastecimiento
            $producto['alerta_stock'] = $this->necesitaReabastecimiento($producto['stock']);
            
            // 3. Validamos si su imagen cumple el formato
            $producto['imagen_valida'] = $this->validarFormatoImagen($producto['imagen_url']);

            $productosProcesados[] = $producto;
        }

        // 3. Devolvemos los datos ya evaluados
        return $productosProcesados;
    }
}
?>