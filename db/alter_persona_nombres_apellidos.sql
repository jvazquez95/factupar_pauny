-- ============================================================
-- Agregar columnas apellidos, nombres y nombreFantasia en persona
-- Ejecutar UNA SOLA VEZ en la base de datos (phpMyAdmin, MySQL, etc.)
-- ============================================================

-- Opción 1: Con AFTER (si tu tabla tiene nombreComercial)
ALTER TABLE `persona`
  ADD COLUMN `apellidos` VARCHAR(250) DEFAULT NULL COMMENT 'Apellidos' AFTER `nombreComercial`,
  ADD COLUMN `nombres` VARCHAR(250) DEFAULT NULL COMMENT 'Nombres' AFTER `apellidos`,
  ADD COLUMN `nombreFantasia` VARCHAR(250) DEFAULT NULL COMMENT 'Nombre fantasía' AFTER `nombres`;

-- Si la opción 1 falla (ej: columna ya existe o no existe nombreComercial), usa la opción 2:
-- Opción 2: Sin AFTER (agrega al final de la tabla)
-- ALTER TABLE `persona` ADD COLUMN `apellidos` VARCHAR(250) DEFAULT NULL;
-- ALTER TABLE `persona` ADD COLUMN `nombres` VARCHAR(250) DEFAULT NULL;
-- ALTER TABLE `persona` ADD COLUMN `nombreFantasia` VARCHAR(250) DEFAULT NULL;
