CREATE TABLE IF NOT EXISTS configuracion_empresa (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre_empresa varchar(200) DEFAULT NULL,
  ruc varchar(50) DEFAULT NULL,
  direccion varchar(255) DEFAULT NULL,
  telefono varchar(50) DEFAULT NULL,
  email varchar(100) DEFAULT NULL,
  logo_ruta varchar(255) DEFAULT NULL,
  color_primario varchar(20) DEFAULT '#007bff',
  fecha_modificacion datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO configuracion_empresa (id, nombre_empresa, ruc, direccion, telefono, email, logo_ruta, color_primario) VALUES
(1, 'Mi Empresa', NULL, NULL, NULL, NULL, 'files/logo/logo.png', '#007bff')
ON DUPLICATE KEY UPDATE id=id;
