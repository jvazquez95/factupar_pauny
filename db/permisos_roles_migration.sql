-- ============================================================
-- Migración: Permisos por archivo, categorías y roles
-- Ejecutar en la BD pauny (ej.: desde phpMyAdmin o mysql)
-- ============================================================

-- 1) Columna Empleado_idEmpleado en usuario (si no existe)
ALTER TABLE usuario ADD COLUMN Empleado_idEmpleado INT NULL DEFAULT NULL AFTER condicion;

-- 2) Nuevas columnas en permiso
ALTER TABLE permiso 
  ADD COLUMN descripcion VARCHAR(255) NULL DEFAULT NULL AFTER nombre,
  ADD COLUMN archivo VARCHAR(100) NULL DEFAULT NULL AFTER descripcion,
  ADD COLUMN id_categoria INT NULL DEFAULT NULL AFTER archivo;

-- 3) Tabla de categorías de permisos
CREATE TABLE IF NOT EXISTS permiso_categoria (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(80) NOT NULL,
  orden INT NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 4) Tabla de roles (plantillas para aplicar permisos rápido)
CREATE TABLE IF NOT EXISTS rol (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(80) NOT NULL,
  descripcion VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 5) Relación rol - permiso
CREATE TABLE IF NOT EXISTS rol_permiso (
  id_rol INT NOT NULL,
  id_permiso INT NOT NULL,
  PRIMARY KEY (id_rol, id_permiso),
  KEY fk_rol_permiso_rol (id_rol),
  KEY fk_rol_permiso_permiso (id_permiso)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 6) Insertar categorías
INSERT IGNORE INTO permiso_categoria (id, nombre, orden) VALUES
(1, 'Escritorio', 1),
(2, 'Personas', 2),
(3, 'Almacén', 3),
(4, 'Compras', 4),
(5, 'Ventas', 5),
(6, 'Stock', 6),
(7, 'Logística', 7),
(8, 'Promociones', 8),
(9, 'Contabilidad', 9),
(10, 'RR-HH', 10),
(11, 'Acceso y control', 11),
(12, 'Paramétricas', 12),
(13, 'Control / Anulaciones', 13),
(14, 'Consultas y reportes', 14),
(15, 'Hoja de ruta', 15);

-- 7) Actualizar permisos existentes (id 1-9) con descripción y archivo
UPDATE permiso SET descripcion='Acceso al escritorio principal', archivo='escritorio', id_categoria=1 WHERE idpermiso=1;
UPDATE permiso SET descripcion='Menú y acceso a módulo Almacén', archivo='almacen', id_categoria=3 WHERE idpermiso=2;
UPDATE permiso SET descripcion='Menú y acceso a módulo Compras', archivo='compras', id_categoria=4 WHERE idpermiso=3;
UPDATE permiso SET descripcion='Menú y acceso a módulo Ventas', archivo='ventas', id_categoria=5 WHERE idpermiso=4;
UPDATE permiso SET descripcion='Gestión de usuarios y permisos (Acceso)', archivo='acceso', id_categoria=11 WHERE idpermiso=5;
UPDATE permiso SET descripcion='Consultas de compras', archivo='consultac', id_categoria=14 WHERE idpermiso=6;
UPDATE permiso SET descripcion='Consultas de ventas', archivo='consultav', id_categoria=14 WHERE idpermiso=7;
UPDATE permiso SET descripcion='Habilitaciones', archivo='habilitaciones', id_categoria=5 WHERE idpermiso=8;
UPDATE permiso SET descripcion='Menú Paramétricas', archivo='parametricas', id_categoria=12 WHERE idpermiso=9;

-- 8) Insertar permisos 10-18 si no existen (compatibilidad con sesión actual)
INSERT IGNORE INTO permiso (idpermiso, nombre, descripcion, archivo, id_categoria) VALUES
(10, 'Movimientos', 'Movimientos de ingresos y egresos', 'movimientos', 14),
(11, 'Personas', 'Gestión de personas, clientes, proveedores, empleados', 'personas', 2),
(12, 'Cargar orden', 'Cargar orden de venta', 'cargarorden', 5),
(13, 'Contabilidad', 'Módulo contabilidad', 'contabilidad', 9),
(14, 'Stock', 'Módulo stock e inventarios', 'stock', 6),
(15, 'Logística', 'Módulo logística y repartidores', 'logistica', 7),
(16, 'Promociones', 'Gestión de promociones', 'promociones', 8),
(17, 'Clientes', 'Gestión de clientes', 'clientes', 2),
(18, 'Créditos', 'Cuentas a cobrar / créditos', 'creditos', 5);

-- 9) Actualizar descripción/archivo/categoria para 10-18
UPDATE permiso SET descripcion='Movimientos de ingresos y egresos', archivo='movimientos', id_categoria=14 WHERE idpermiso=10;
UPDATE permiso SET descripcion='Gestión de personas, clientes, proveedores', archivo='personas', id_categoria=2 WHERE idpermiso=11;
UPDATE permiso SET descripcion='Cargar orden de venta', archivo='cargarorden', id_categoria=5 WHERE idpermiso=12;
UPDATE permiso SET descripcion='Módulo contabilidad', archivo='contabilidad', id_categoria=9 WHERE idpermiso=13;
UPDATE permiso SET descripcion='Módulo stock e inventarios', archivo='stock', id_categoria=6 WHERE idpermiso=14;
UPDATE permiso SET descripcion='Módulo logística', archivo='logistica', id_categoria=7 WHERE idpermiso=15;
UPDATE permiso SET descripcion='Gestión de promociones', archivo='promociones', id_categoria=8 WHERE idpermiso=16;
UPDATE permiso SET descripcion='Gestión de clientes', archivo='clientes', id_categoria=2 WHERE idpermiso=17;
UPDATE permiso SET descripcion='Cuentas a cobrar y créditos', archivo='creditos', id_categoria=5 WHERE idpermiso=18;

-- 10) Permisos por archivo (una entrada por ventana/CRUD)
-- Se insertan con id >= 19 para no pisar los 18 existentes
INSERT INTO permiso (nombre, descripcion, archivo, id_categoria) VALUES
('Personas', 'CRUD Personas (proveedores/clientes/empleados base)', 'persona', 2),
('Clientes', 'CRUD Clientes', 'cliente', 2),
('Clientes x Direcciones', 'Clientes por direcciones y vehículos', 'clienteDireccionesVehiculo', 2),
('Proveedores', 'CRUD Proveedores', 'proveedor', 2),
('Empleados', 'CRUD Empleados', 'empleado', 2),
('Tipo Persona', 'Tipos de persona', 'tipoPersona', 2),
('Tipo Dirección/Teléfono', 'Tipos de dirección y teléfono', 'tipoDireccionTelefono', 2),
('País', 'CRUD Países', 'pais', 2),
('Ciudad', 'CRUD Ciudades', 'ciudad', 2),
('Barrio', 'CRUD Barrios', 'barrio', 2),
('Grupo Persona', 'Grupos de persona', 'grupoPersona', 2),
('Artículos', 'CRUD Artículos (almacén)', 'articuloDuplicado', 3),
('Marcas', 'CRUD Marcas', 'marca', 3),
('Categorías', 'CRUD Categorías de artículo', 'categoria', 3),
('Depósitos', 'CRUD Depósitos', 'deposito', 3),
('Grupo Artículo', 'Grupos de artículo', 'grupoArticulo', 3),
('Unidad de medida', 'Unidades de medida', 'unidad', 3),
('Tipo Impuesto', 'Tipos de impuesto', 'tipoImpuesto', 3),
('Pedido de compra', 'Pedidos de compra', 'hacerPedido', 4),
('Orden de compra', 'Órdenes de compra', 'ordenCompra', 4),
('Recepción mercaderías', 'Recepción de pedidos', 'recepcionMercaderias', 4),
('Cierre recepción', 'Cierre de pedido', 'cierreRecepcion', 4),
('Alta compra desde O.C.', 'Alta de compra desde orden', 'compra', 4),
('Compra directa', 'Alta de compra directa', 'compraDirecta', 4),
('Cierre costo', 'Análisis centro de costos', 'cierreCosto', 4),
('Autorización compra mercaderías', 'Confirmación compra mercaderías', 'autorizacionCompraMercaderia', 4),
('Autorización compra gastos', 'Confirmación compra gastos', 'autorizacionCompraGastos', 4),
('Pago a proveedores', 'Pagos a proveedores', 'pago', 4),
('Nota de crédito compra', 'Notas de crédito compras', 'notaCreditoCompra', 4),
('Cuentas a pagar', 'Cuentas a pagar', 'cuentasAPagar', 4),
('Cuentas a pagar avanzado', 'Cuentas a pagar avanzado', 'cuentasAPagarAvanzado', 4),
('Conciliación cuentas compra', 'Conciliación de cuentas compra', 'conciliacionCuentasCompra', 4),
('Cabecera compras', 'Cabecera de compras', 'cabeceraCompra', 4),
('Generar cheques', 'Generación de cheques', 'generacionCheque', 4),
('Reporte cheques', 'Reporte de cheques propios', 'rpt_cheques_fecha', 4),
('Hechauka Compras', 'Hechauka compras', 'hechaukaCompras', 4),
('Habilitación', 'Habilitaciones de venta', 'habilitacion', 5),
('Habilitación por fecha', 'Reporte habilitaciones por fecha', 'rpt-habilitaciones', 5),
('Agenda clientes', 'Agenda a clientes', 'personaAgenda', 5),
('Órdenes de venta', 'Órdenes de venta', 'ordenVenta', 5),
('Órdenes a facturar', 'Órdenes de venta a facturar', 'ordenVentaAFacturar', 5),
('Remisiones', 'Remisiones', 'ordenRemision', 5),
('Recibos', 'Recibos de cobro', 'recibo', 5),
('Nota de crédito venta', 'Notas de crédito ventas', 'notaCreditoVenta', 5),
('Cuentas a cobrar', 'Cuentas a cobrar', 'cuentasACobrar', 5),
('Hechauka Ventas', 'Hechauka ventas', 'hechaukaVentas', 5),
('Actualizar precios', 'Actualización de precios', 'precios', 5),
('Arqueo de caja', 'Arqueo de caja por habilitación', 'arqueo', 5),
('Lista de ventas', 'Reporte lista de ventas', 'rpt-ventas', 14),
('Ventas por artículo', 'Reporte ventas por artículo', 'rpt-ventasArticulo', 14),
('Artículos por fecha', 'Lista artículos por fecha', 'rpt_articulos_fecha', 14),
('Lista de recibos', 'Reporte lista de recibos', 'rpt-recibos', 14),
('Recibos detallado', 'Lista de recibos detallado', 'rpt-recibosDetalle', 14),
('Ingresos vs Egresos', 'Recaudaciones y gastos', 'rpt_recaudaciones_gastos', 14),
('Remisiones gentilezas', 'Reporte remisiones gentilezas', 'rpt-remisionArticuloGentileza', 14),
('Lista NC ventas', 'Lista de notas de crédito ventas', 'rpt-ncventas', 14),
('Movimientos ingreso/egreso', 'Movimientos de ingresos y egresos', 'movimiento', 14),
('Reporte movimientos', 'Reporte ingresos y egresos', 'rpt-movimientos', 14),
('Conceptos ingreso/egreso', 'Conceptos de ingreso y egreso', 'concepto', 14),
('Tapas vs Ventas', 'Tapas antiderrame vs ventas', 'rpttapasVentas', 14),
('Hoja de ruta camión', 'Hoja de ruta por camión', 'direcciones_hojaruta', 15),
('Hoja de ruta seguimiento', 'Hoja de ruta por seguimiento', 'direcciones_usuario', 15),
('Reporte hoja de ruta', 'Reporte hoja de ruta', 'rpt-hojaruta', 15),
('Importar archivo', 'Importar archivo', 'importarArchivoNew', 15),
('Comodato', 'Comodato', 'comodato', 6),
('Ajuste de stock', 'Ajustes de stock', 'ajusteStock', 6),
('Inventario de stock', 'Inventario de stock', 'inventarioStock', 6),
('Movimiento de stock', 'Movimiento de stock', 'movimientoStock', 6),
('Movimiento stock habilitación', 'Movimiento stock por habilitación', 'movimientoStockHabilitacion', 6),
('Producción', 'Producción', 'produccion', 6),
('Listado producción', 'Listado de producción', 'listadoProduccion', 6),
('Autorización producción', 'Autorización de producción', 'autorizacionProduccion', 6),
('Armado de artículo', 'Armado de artículo', 'armadoArticulo', 6),
('Inventario por depósito', 'Consulta inventario por depósito', 'inventarioDeposito', 6),
('Ajuste inventario', 'Ajuste de inventario', 'inventarioAjusteApp', 6),
('Autorización inventario ajuste', 'Autorización inventario por depósito', 'autorizacionInventarioAjuste', 6),
('Registro repartidor', 'Registro por repartidor (logística)', 'hojaRuta', 7),
('Promociones', 'CRUD Promociones', 'promocion', 8),
('Conceptos contables', 'Conceptos contables', 'concepto', 9),
('Bancos', 'CRUD Bancos', 'banco', 9),
('Monedas', 'CRUD Monedas', 'moneda', 9),
('Centro de costos', 'Centros de costo', 'centroDeCostos', 9),
('Tipos documentos', 'Tipos de documentos', 'tiposDocumentos', 9),
('Cotización diaria', 'Cotización diaria', 'cotizacionDiaria', 9),
('Cuentas contables', 'Cuentas contables', 'cuentaContable', 9),
('Cuentas corrientes', 'Cuentas corrientes', 'cuentaCorriente', 9),
('Procesos', 'Procesos contables', 'proceso', 9),
('Asientos', 'Asientos contables', 'asiento', 9),
('Libro diario', 'Libro diario', 'libroDiario', 9),
('Libro mayor', 'Libro mayor', 'libroMayor', 9),
('Agrupación cuentas', 'Agrupación de cuentas contables', 'agrupacionCuentasContables', 9),
('Maestro de saldos', 'Maestro de saldos', 'maestroSaldos', 9),
('Balance', 'Balance contable', 'balance', 9),
('Libro compras', 'Libro de compras', 'rpt_libro_compras_avanzado1', 9),
('Libro ventas', 'Libro de ventas', 'rpt_libro_ventas_avanzado1', 9),
('Legajo', 'Personas - Legajo (RR-HH)', 'legajo', 10),
('Departamento', 'Departamentos', 'departamento', 10),
('Cargo', 'Cargos', 'cargo', 10),
('Estado civil', 'Estados civiles', 'estadoCivil', 10),
('Profesión', 'Profesiones', 'profesion', 10),
('Clase', 'Clases', 'clase', 10),
('Tipo salario', 'Tipos de salario', 'tipoSalario', 10),
('Medio de cobro', 'Medios de cobro', 'medioCobro', 10),
('Tipo contrato', 'Tipos de contrato', 'tipoContrato', 10),
('Movimiento personal', 'Movimientos de personal', 'movimientoPersonal', 10),
('Comunicación personal', 'Comunicación personal', 'comunicacionPersonal', 10),
('Salario', 'Salarios', 'salario', 10),
('Concepto salario', 'Conceptos de salario', 'conceptoSalario', 10),
('Movimiento salarial', 'Movimientos salariales', 'movimientoSalarial', 10),
('Liquidación', 'Liquidaciones', 'liquidacion', 10),
('Cierre liquidación', 'Cierre de liquidación', 'cierreLiquidacion', 10),
('Usuarios', 'CRUD Usuarios del sistema', 'usuario', 11),
('Permisos', 'Ver lista de permisos (admin)', 'permiso', 11),
('Anular orden venta', 'Anular orden de venta', 'anularOV', 13),
('Anular venta', 'Anular venta por número', 'anularVenta', 13),
('Anular recibo', 'Anular recibo por número', 'anularRecibo', 13),
('Anular compra', 'Anular compra por número', 'anularCompra', 13),
('Anular pago', 'Anular pago por número', 'anularPago', 13),
('Anular NC venta', 'Anular nota de crédito venta', 'anularNotaCreditoVenta', 13),
('Volver a habilitar', 'Volver a habilitar', 'volverHabilitar', 13),
('Reporte ventas anuladas', 'Reporte ventas anuladas', 'rpt-ventasAnuladas', 13),
('Reporte recibos anulados', 'Reporte recibos anulados', 'rpt-recibosAnulados', 13),
('Documentos por cajero', 'Documentos por cajero', 'documentoCajero', 12),
('Cajas', 'Cajas', 'caja', 12),
('Sucursales', 'Sucursales', 'sucursal', 12),
('Término de pagos', 'Términos de pago', 'terminoPago', 12),
('Estados', 'Estados', 'estado', 12),
('Configuración empresa', 'Configuración de la empresa', 'configuracionEmpresa', 12);

-- 11) Roles de ejemplo (selección rápida)
INSERT IGNORE INTO rol (id, nombre, descripcion) VALUES
(1, 'Administrador', 'Todos los permisos'),
(2, 'Ventas', 'Ventas, recibos, clientes, habilitaciones'),
(3, 'Compras', 'Compras, proveedores, cuentas a pagar'),
(4, 'Almacén', 'Artículos, depósitos, stock'),
(5, 'Consulta', 'Solo consultas y reportes');

-- 12) Asignar todos los permisos al rol Administrador (id_rol=1)
INSERT IGNORE INTO rol_permiso (id_rol, id_permiso) SELECT 1, idpermiso FROM permiso;

-- NOTA: Si la columna usuario.Empleado_idEmpleado ya existe, omitir el paso 1 o comentarlo.
