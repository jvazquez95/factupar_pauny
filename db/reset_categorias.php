<?php
/**
 * Script para resetear categorías y crear categorías por defecto "General"
 * Fecha: 2026-01-28
 * 
 * Este script:
 * 1. Elimina todas las categorías existentes (TRUNCATE)
 * 2. Crea una categoría padre "General"
 * 3. Crea una categoría hijo "General" asociada a la categoría padre
 */

require_once __DIR__ . "/../config/Conexion.php";

try {
    // 1. Eliminar todas las categorías existentes
    // NOTA: TRUNCATE hace commit automático, no puede estar en transacción
    $sql1 = "TRUNCATE TABLE categoria";
    ejecutarConsulta($sql1);
    echo "✓ Tabla categoria truncada exitosamente\n";
    
    // 2. Insertar categoría padre "General"
    // Categoria_idCategoria = 0 indica que es una categoría padre
    $sql2 = "INSERT INTO categoria (nombre, Categoria_idCategoria, inactivo, fechaModificacion) 
             VALUES ('General', 0, 0, NOW())";
    ejecutarConsulta($sql2);
    $idPadre = $conexion->lastInsertId();
    echo "✓ Categoría padre 'General' creada con ID: $idPadre\n";
    
    // 3. Insertar categoría hijo "General" asociada a la categoría padre
    $sql3 = "INSERT INTO categoria (nombre, Categoria_idCategoria, inactivo, fechaModificacion) 
             VALUES ('General', $idPadre, 0, NOW())";
    ejecutarConsulta($sql3);
    $idHijo = $conexion->lastInsertId();
    echo "✓ Categoría hijo 'General' creada con ID: $idHijo (padre: $idPadre)\n";
    
    echo "\n✅ Proceso completado exitosamente!\n";
    echo "   - Categoría padre 'General' (ID: $idPadre)\n";
    echo "   - Categoría hijo 'General' (ID: $idHijo)\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

?>
