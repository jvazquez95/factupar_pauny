# Migración: Permisos por archivo, categorías y roles

## Qué hace

1. **Columna `usuario.Empleado_idEmpleado`**  
   Permite asociar un empleado al usuario (opcional, para comisiones).

2. **Permisos por archivo**  
   La tabla `permiso` pasa a tener:
   - `descripcion`: texto explicativo del permiso
   - `archivo`: nombre de la ventana (ej. `persona`, `usuario`) para control por archivo
   - `id_categoria`: agrupación para la UI

3. **Categorías**  
   Tabla `permiso_categoria` (Escritorio, Personas, Almacén, Compras, Ventas, etc.) para agrupar permisos en la pantalla de usuarios.

4. **Roles**  
   Tablas `rol` y `rol_permiso`: plantillas (Administrador, Ventas, Compras, etc.) para marcar muchos permisos de una vez; luego se puede ajustar uno a uno.

5. **Nuevos permisos**  
   Se insertan permisos por ventana/CRUD (persona, cliente, articuloDuplicado, recibo, etc.) con descripción y categoría.

## Cómo ejecutar

1. En phpMyAdmin (o cliente MySQL) seleccionar la base **pauny**.
2. Ejecutar el contenido de `permisos_roles_migration.sql` (por partes si hace falta).
3. Si la columna `usuario.Empleado_idEmpleado` ya existe, comentar o omitir la línea que hace `ALTER TABLE usuario ADD COLUMN ...`.

## Uso en cada vista (permiso por archivo)

En cualquier vista que deba comprobar permiso por archivo:

```php
require 'header.php';  // ya define tienePermisoVista()

if (($_SESSION['personas'] ?? 0) == 1 || tienePermisoVista('persona')) {
  // contenido de la vista
} else {
  require 'noacceso.php';
  exit;
}
```

`tienePermisoVista('persona')` corresponde al permiso con `archivo = 'persona'` (ventana `persona.php`).

## Roles

En **Usuarios** > al crear/editar usuario:
- **Aplicar rol**: elegir un rol (ej. Ventas) para marcar en bloque los permisos de ese rol.
- Sigue siendo posible marcar o desmarcar cada permiso a mano.
- Los permisos se muestran agrupados por categoría.
