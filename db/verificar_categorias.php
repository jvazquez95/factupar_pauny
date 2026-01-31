<?php
/**
 * Script para verificar las categorías creadas
 */

require_once __DIR__ . "/../config/Conexion.php";

try {
    $sql = "SELECT idCategoria, nombre, Categoria_idCategoria, inactivo 
            FROM categoria 
            ORDER BY idCategoria";
    $resultado = ejecutarConsulta($sql);
    
    echo "📋 Categorías en la base de datos:\n\n";
    echo str_pad("ID", 5) . str_pad("Nombre", 20) . str_pad("Padre ID", 10) . "Estado\n";
    echo str_repeat("-", 50) . "\n";
    
    while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $estado = $row['inactivo'] == 0 ? 'Activo' : 'Inactivo';
        $padreId = $row['Categoria_idCategoria'] == 0 ? 'Padre' : $row['Categoria_idCategoria'];
        echo str_pad($row['idCategoria'], 5) . 
             str_pad($row['nombre'], 20) . 
             str_pad($padreId, 10) . 
             $estado . "\n";
    }
    
    echo "\n✅ Verificación completada\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

?>
