-- Script para resetear categorías y crear categorías por defecto "General"
-- Fecha: 2026-01-28

-- Eliminar todas las categorías existentes
TRUNCATE TABLE categoria;

-- Insertar categoría padre "General"
-- Categoria_idCategoria = 0 indica que es una categoría padre
INSERT INTO categoria (nombre, Categoria_idCategoria, inactivo, fechaModificacion) 
VALUES ('General', 0, 0, NOW());

-- Insertar categoría hijo "General" 
-- Usa el ID de la categoría padre recién insertada (será 1 después del TRUNCATE)
INSERT INTO categoria (nombre, Categoria_idCategoria, inactivo, fechaModificacion) 
VALUES ('General', 1, 0, NOW());
