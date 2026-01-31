# Pauny - Sistema de Gestión

Sistema de gestión empresarial (ventas, compras, almacén, usuarios, permisos, reportes, etc.) desarrollado en PHP con MySQL.

**Repositorio:** [github.com/jvazquez95/factupar_pauny](https://github.com/jvazquez95/factupar_pauny)

## Requisitos

- PHP 7.4+ (extensiones PDO, pdo_mysql, mbstring, json, session)
- MySQL 5.7+ o MariaDB
- Servidor web (Apache con mod_rewrite o Nginx)

## Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/jvazquez95/factupar_pauny.git
   cd factupar_pauny
   ```

2. **Configurar credenciales con .env**
   - Las contraseñas y datos de BD se configuran en un archivo `.env` que **no se sube a Git**.
   - Copiar la plantilla y editar con tus datos:
   ```bash
   cp .env.example .env
   ```
   - Editar `.env` y completar:
   ```ini
   DB_HOST=localhost
   DB_NAME=pauny
   DB_USERNAME=root
   DB_PASSWORD=tu_contraseña
   ```

3. **Importar la base de datos**
   - Crear la base de datos en MySQL.
   - Importar esquema y datos desde `db/` (ej. `spa.sql`, `permisos_roles_migration.sql`).
   - Ver `db/README_permisos_roles.md` para permisos y roles.

4. **Permisos de escritura**
   - El servidor web debe poder escribir en `files/usuarios`, `files/articulos`, `files/logo`, `files/direcciones`, `files/gif`.

5. **Acceso**
   - Configurar el document root hacia la carpeta del proyecto.
   - Acceder a la aplicación (ej. `https://tudominio.com/pauny/`). Login: `vistas/login.html`.

## Estructura principal

- `ajax/` — Endpoints PHP
- `config/` — Configuración (lee credenciales desde `.env`)
- `db/` — Scripts SQL y migraciones
- `modelos/` — Modelos de datos
- `vistas/` — Vistas, JS y estilos
- `public/` — CSS, JS, librerías
- `reportes/` — Plantillas de reportes
- `files/` — Archivos subidos (contenido ignorado en Git)

## Seguridad

- **Nunca subas el archivo `.env`** a GitHub; contiene contraseñas y está en `.gitignore`.
- Usa siempre `.env.example` como plantilla: copia a `.env` y completa solo en tu entorno local o servidor.
- `config/global.php` y `config/Conexion.php` sí están en el repo y leen los valores desde `.env`.

## Licencia

Uso interno / privado. Ajustar según corresponda.
