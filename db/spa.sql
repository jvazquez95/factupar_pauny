-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 06, 2018 at 04:46 PM
-- Server version: 5.7.21
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spa`
--

DELIMITER $$
--
-- Functions
--
DROP FUNCTION IF EXISTS `F_NOMBRE_ARTICULO`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `F_NOMBRE_ARTICULO` (`ID_ART` INT) RETURNS VARCHAR(250) CHARSET latin1 BEGIN
  DECLARE NOMBREA VARCHAR(50);

    SELECT nombre
 INTO NOMBREA 
 FROM articulo
 WHERE idArticulo = ID_ART;
  RETURN NOMBREA;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `articulo`
--

DROP TABLE IF EXISTS `articulo`;
CREATE TABLE IF NOT EXISTS `articulo` (
  `idArticulo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `codigo` varchar(120) NOT NULL,
  `codigoBarra` varchar(120) DEFAULT NULL,
  `codigoAlternativo` varchar(120) DEFAULT NULL,
  `tipoArticulo` varchar(25) NOT NULL,
  `GrupoArticulo_idGrupoArticulo` int(10) DEFAULT NULL,
  `Categoria_idCategoria` int(10) UNSIGNED DEFAULT NULL,
  `costo` decimal(16,2) DEFAULT '0.00',
  `costoUltimaCompra` decimal(16,2) DEFAULT '0.00',
  `TipoImpuesto_idTipoImpuesto` int(11) DEFAULT NULL,
  `Unidad_idUnidad` int(11) DEFAULT NULL,
  `precioVenta` decimal(16,2) DEFAULT '0.00',
  `imagen` varchar(60) DEFAULT NULL,
  `CuentaContable_idCuentaContable` int(11) DEFAULT NULL,
  `fechaUltimaCompra` datetime DEFAULT NULL,
  `fechaUltimoCosto` datetime DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioInsercion` varchar(120) DEFAULT NULL,
  `usuarioModificacion` varchar(120) DEFAULT NULL,
  `inactivo` tinyint(1) DEFAULT '0',
  `comision` decimal(16,2) DEFAULT '0.00',
  `comisionp` decimal(16,2) DEFAULT '0.00',
  PRIMARY KEY (`idArticulo`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `articulo`
--

INSERT INTO `articulo` (`idArticulo`, `nombre`, `descripcion`, `codigo`, `codigoBarra`, `codigoAlternativo`, `tipoArticulo`, `GrupoArticulo_idGrupoArticulo`, `Categoria_idCategoria`, `costo`, `costoUltimaCompra`, `TipoImpuesto_idTipoImpuesto`, `Unidad_idUnidad`, `precioVenta`, `imagen`, `CuentaContable_idCuentaContable`, `fechaUltimaCompra`, `fechaUltimoCosto`, `fechaModificacion`, `usuarioInsercion`, `usuarioModificacion`, `inactivo`, `comision`, `comisionp`) VALUES
(1, 'SERVICIO DE MASAJE', 'SERVICIO DE MASAJE', '0', '0', '0', 'SERVICIO', 1, 1, '0.00', '0.00', 1, 1, '50000.00', '', NULL, NULL, NULL, '2018-08-24 10:38:34', '', NULL, 0, '5000.00', '10.00'),
(2, 'BAÃ‘O DE LUNA', 'BAÃ‘O DE LUNA', '0', '0', '0', 'SERVICIO', 1, 1, '0.00', '0.00', 1, 1, '250000.00', '', NULL, NULL, NULL, '2018-08-24 10:39:41', '', NULL, 0, '25000.00', '10.00'),
(3, 'PAQUETE PRIMAVERA', 'PAQUETE VERANO - 10 MASAJES + 10 BAÃ‘OS DE LUNA', '1', '1', '', 'PAQUETE', 1, 1, '0.00', '0.00', 1, 1, '500000.00', '', NULL, NULL, NULL, '2018-08-24 10:42:26', '', NULL, 0, '0.00', '0.00');

--
-- Triggers `articulo`
--
DROP TRIGGER IF EXISTS `articulo_AFTER_INSERT`;
DELIMITER $$
CREATE TRIGGER `articulo_AFTER_INSERT` AFTER INSERT ON `articulo` FOR EACH ROW INSERT INTO stock
SELECT New.idArticulo, idDeposito, 0, 0, now() FROM deposito
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `articulo_BEFORE_INSERT`;
DELIMITER $$
CREATE TRIGGER `articulo_BEFORE_INSERT` BEFORE INSERT ON `articulo` FOR EACH ROW SET new.fechaModificacion = now()
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `articulo_BEFORE_UPDATE`;
DELIMITER $$
CREATE TRIGGER `articulo_BEFORE_UPDATE` BEFORE UPDATE ON `articulo` FOR EACH ROW SET new.fechaModificacion = now()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `banco`
--

DROP TABLE IF EXISTS `banco`;
CREATE TABLE IF NOT EXISTS `banco` (
  `IDBANCO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(60) NOT NULL,
  `INACTIVO` tinyint(1) DEFAULT '0',
  `FECHAMODIFICACION` datetime DEFAULT NULL,
  PRIMARY KEY (`IDBANCO`),
  UNIQUE KEY `descripcion` (`DESCRIPCION`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='banco';

--
-- Dumping data for table `banco`
--

INSERT INTO `banco` (`IDBANCO`, `DESCRIPCION`, `INACTIVO`, `FECHAMODIFICACION`) VALUES
(2, 'ATLAS', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `caja`
--

DROP TABLE IF EXISTS `caja`;
CREATE TABLE IF NOT EXISTS `caja` (
  `idcaja` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sucursal_idSucursal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `inactivo` tinyint(4) NOT NULL,
  PRIMARY KEY (`idcaja`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `caja`
--

INSERT INTO `caja` (`idcaja`, `nombre`, `Sucursal_idSucursal`, `inactivo`) VALUES
(1, 'CAJA 1', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `idCategoria` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `Categoria_idCategoria` int(10) UNSIGNED DEFAULT NULL,
  `inactivo` tinyint(1) DEFAULT '0',
  `fechaModificacion` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idCategoria`),
  KEY `Categoria_FKIndex1` (`Categoria_idCategoria`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nombre`, `Categoria_idCategoria`, `inactivo`, `fechaModificacion`) VALUES
(1, 'CATEGORIA PRINCIPAL', 0, 0, '2018-07-02 21:14:00');

-- --------------------------------------------------------

--
-- Table structure for table `categoriacliente`
--

DROP TABLE IF EXISTS `categoriacliente`;
CREATE TABLE IF NOT EXISTS `categoriacliente` (
  `idCategoriaCliente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(60) NOT NULL,
  `CuentaContable_idCuentaContable` int(11) DEFAULT NULL,
  `inactivo` tinyint(1) DEFAULT '0',
  `fechaModificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idCategoriaCliente`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categoriacliente`
--

INSERT INTO `categoriacliente` (`idCategoriaCliente`, `descripcion`, `CuentaContable_idCuentaContable`, `inactivo`, `fechaModificacion`) VALUES
(1, 'editadoo', 2, 0, NULL),
(2, 'mayorista', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categoriaproveedor`
--

DROP TABLE IF EXISTS `categoriaproveedor`;
CREATE TABLE IF NOT EXISTS `categoriaproveedor` (
  `idCategoriaProveedor` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(60) NOT NULL,
  `CuentaContable_idCuentaContable` int(11) DEFAULT NULL,
  `inactivo` tinyint(1) DEFAULT '0',
  `fechaModificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idCategoriaProveedor`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categoriaproveedor`
--

INSERT INTO `categoriaproveedor` (`idCategoriaProveedor`, `descripcion`, `CuentaContable_idCuentaContable`, `inactivo`, `fechaModificacion`) VALUES
(1, 'editado', 2, 0, NULL),
(2, 'mayorista', 2, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `razonSocial` varchar(250) NOT NULL,
  `nombreComercial` varchar(250) DEFAULT NULL,
  `tipoDocumento` int(11) DEFAULT NULL,
  `nroDocumento` varchar(250) NOT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  `telefono` varchar(250) DEFAULT NULL,
  `celular` varchar(250) DEFAULT NULL,
  `mail` varchar(250) DEFAULT NULL,
  `moneda` int(11) DEFAULT NULL,
  `sitioWeb` varchar(250) DEFAULT NULL,
  `idCategoriaCliente` int(11) DEFAULT NULL,
  `terminoPago` int(11) DEFAULT NULL,
  `terminoPagoHabilitado` varchar(50) DEFAULT NULL,
  `inactivo` tinyint(4) NOT NULL DEFAULT '0',
  `nacimiento` date DEFAULT NULL,
  PRIMARY KEY (`idCliente`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='cliente';

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`idCliente`, `razonSocial`, `nombreComercial`, `tipoDocumento`, `nroDocumento`, `direccion`, `telefono`, `celular`, `mail`, `moneda`, `sitioWeb`, `idCategoriaCliente`, `terminoPago`, `terminoPagoHabilitado`, `inactivo`, `nacimiento`) VALUES
(1, 'JUNIOR RODOLFO VAZQUEZ LOPEZ', 'JUNIOR RODOLFO VAZQUEZ LOPEZ', 1, '123', '123', '213', '123', '123@gmail.com', 123, '123', 1, 123, '123', 0, '2018-07-10'),
(2, 'jjjj', 'jjjj', 2, '444', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clientedetalle`
--

DROP TABLE IF EXISTS `clientedetalle`;
CREATE TABLE IF NOT EXISTS `clientedetalle` (
  `idclientedetalle` int(11) NOT NULL AUTO_INCREMENT,
  `Cliente_idCliente` int(11) NOT NULL,
  `Articulo_idArticulo_Servicio` int(11) NOT NULL COMMENT 'Id Servicio',
  `Articulo_idArticulo` int(11) NOT NULL COMMENT 'Id Paquete',
  `cantidad` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idclientedetalle`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clientedetalle`
--

INSERT INTO `clientedetalle` (`idclientedetalle`, `Cliente_idCliente`, `Articulo_idArticulo_Servicio`, `Articulo_idArticulo`, `cantidad`) VALUES
(1, 1, 1, 3, 26),
(2, 1, 2, 3, 31),
(4, 1, 2, 0, 10),
(5, 1, 1, 0, 10);

-- --------------------------------------------------------

--
-- Table structure for table `compra`
--

DROP TABLE IF EXISTS `compra`;
CREATE TABLE IF NOT EXISTS `compra` (
  `idCompra` int(11) NOT NULL AUTO_INCREMENT,
  `Proveedor_idProveedor` int(11) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `Habilitacion_idHabilitacion` int(11) DEFAULT NULL,
  `Deposito_idDeposito` int(11) DEFAULT NULL,
  `TerminoPago_idTerminoPago` int(11) DEFAULT NULL,
  `tipo_comprobante` int(11) DEFAULT NULL,
  `nroFactura` varbinary(25) DEFAULT NULL,
  `fechaTransaccion` datetime DEFAULT NULL,
  `fechaFactura` datetime DEFAULT NULL,
  `fechaVencimiento` datetime DEFAULT NULL,
  `timbrado` double DEFAULT NULL,
  `vtoTimbrado` date DEFAULT NULL,
  `Moneda_idMoneda` int(11) DEFAULT NULL,
  `tasaCambio` decimal(16,2) DEFAULT NULL,
  `tasaCambioBases` decimal(16,2) DEFAULT NULL,
  `totalImpuesto` decimal(16,2) DEFAULT NULL,
  `total` decimal(16,2) DEFAULT NULL,
  `totalNeto` decimal(16,2) DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioInsercion` varchar(25) DEFAULT NULL,
  `usuarioModificacion` varchar(25) DEFAULT NULL,
  `inactivo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idCompra`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='compra';

-- --------------------------------------------------------

--
-- Table structure for table `deposito`
--

DROP TABLE IF EXISTS `deposito`;
CREATE TABLE IF NOT EXISTS `deposito` (
  `idDeposito` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Sucursal_idSucursal` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `inactivo` tinyint(1) DEFAULT '0',
  `fechaModificacion` datetime DEFAULT NULL,
  `princiapl` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idDeposito`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deposito`
--

INSERT INTO `deposito` (`idDeposito`, `Sucursal_idSucursal`, `descripcion`, `inactivo`, `fechaModificacion`, `princiapl`) VALUES
(1, 1, 'DEPOSITO PRINCIPAL', 0, '2018-08-22 09:49:18', 0);

--
-- Triggers `deposito`
--
DROP TRIGGER IF EXISTS `deposito_AFTER_INSERT`;
DELIMITER $$
CREATE TRIGGER `deposito_AFTER_INSERT` AFTER INSERT ON `deposito` FOR EACH ROW INSERT INTO stock
SELECT idArticulo, New.idDeposito, 0, 0, now() FROM articulo
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `deposito_BEFORE_INSERT`;
DELIMITER $$
CREATE TRIGGER `deposito_BEFORE_INSERT` BEFORE INSERT ON `deposito` FOR EACH ROW SET new.fechaModificacion = now()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detallecompra`
--

DROP TABLE IF EXISTS `detallecompra`;
CREATE TABLE IF NOT EXISTS `detallecompra` (
  `idDetalleCompra` int(11) NOT NULL AUTO_INCREMENT,
  `Compra_idCompra` int(11) DEFAULT NULL,
  `Articulo_idArticulo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(16,2) DEFAULT NULL,
  `impuesto` int(11) DEFAULT NULL,
  `totalNeto` decimal(16,2) DEFAULT NULL,
  `total` decimal(16,2) DEFAULT NULL,
  `inactivo` tinyint(1) DEFAULT NULL,
  `fechaModificacione` datetime DEFAULT NULL,
  PRIMARY KEY (`idDetalleCompra`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='detalleCompra';

--
-- Triggers `detallecompra`
--
DROP TRIGGER IF EXISTS `detallecompra_AFTER_INSERT`;
DELIMITER $$
CREATE TRIGGER `detallecompra_AFTER_INSERT` AFTER INSERT ON `detallecompra` FOR EACH ROW BEGIN
SELECT Deposito_idDeposito INTO @deposito
FROM compra
WHERE idCompra = NEW.Compra_idCompra;


Update stock
SET cantidad = cantidad + NEW.cantidad
WHERE Articulo_idArticulo = NEW.Articulo_idArticulo
AND Deposito_idDeposito = @deposito;




END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detallepago`
--

DROP TABLE IF EXISTS `detallepago`;
CREATE TABLE IF NOT EXISTS `detallepago` (
  `IDDETALLEPAGO` int(11) NOT NULL AUTO_INCREMENT,
  `PAGO_IDPAGO` int(11) DEFAULT NULL,
  `FORMAPAGO_IDFORMAPAGO` int(11) DEFAULT NULL,
  `NROCHEQUE` decimal(10,0) DEFAULT NULL,
  `MONTO` decimal(10,0) DEFAULT NULL,
  `FECHAMODIFICACION` datetime DEFAULT NULL,
  `INACTIVO` int(11) DEFAULT NULL,
  `BANCO_IDBANCO` int(11) NOT NULL,
  PRIMARY KEY (`IDDETALLEPAGO`),
  KEY `FK_REFERENCE_43` (`PAGO_IDPAGO`),
  KEY `FK_REFERENCE_45` (`FORMAPAGO_IDFORMAPAGO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='detallePago';

-- --------------------------------------------------------

--
-- Table structure for table `detallerecibo`
--

DROP TABLE IF EXISTS `detallerecibo`;
CREATE TABLE IF NOT EXISTS `detallerecibo` (
  `IDDETALLERECIBO` int(11) NOT NULL AUTO_INCREMENT,
  `RECIBO_IDRECIBO` int(11) DEFAULT NULL,
  `FORMAPAGO_IDFORMAPAGO` int(11) DEFAULT NULL,
  `BANCO_IDBANCO` int(10) DEFAULT NULL,
  `NROCHEQUE` int(11) DEFAULT NULL,
  `MONTO` decimal(10,0) DEFAULT NULL,
  `FECHAMODIFICACION` datetime DEFAULT NULL,
  `INACTIVO` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDDETALLERECIBO`),
  KEY `FK_REFERENCE_40` (`RECIBO_IDRECIBO`),
  KEY `FK_REFERENCE_42` (`FORMAPAGO_IDFORMAPAGO`),
  KEY `FK_REFERENCE_46` (`BANCO_IDBANCO`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='detalleRecibo';

--
-- Dumping data for table `detallerecibo`
--

INSERT INTO `detallerecibo` (`IDDETALLERECIBO`, `RECIBO_IDRECIBO`, `FORMAPAGO_IDFORMAPAGO`, `BANCO_IDBANCO`, `NROCHEQUE`, `MONTO`, `FECHAMODIFICACION`, `INACTIVO`) VALUES
(1, 1, 1, 1, 0, '500000', NULL, 0),
(2, 2, 1, 1, 0, '300000', NULL, 0),
(3, 3, 1, 1, 0, '5750000', NULL, 0),
(4, 4, 1, 1, 0, '3000000', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `detallerecibofacturas`
--

DROP TABLE IF EXISTS `detallerecibofacturas`;
CREATE TABLE IF NOT EXISTS `detallerecibofacturas` (
  `IDDETALLERECIBOFACTURA` int(11) NOT NULL AUTO_INCREMENT,
  `RECIBO_IDRECIBO` int(11) DEFAULT NULL,
  `VENTA_IDVENTA` int(11) DEFAULT NULL,
  `MONTOAPLICADO` decimal(10,0) DEFAULT NULL,
  `FECHAMODIFICACION` datetime DEFAULT NULL,
  `INACTIVO` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDDETALLERECIBOFACTURA`),
  KEY `FK_REFERENCE_41` (`RECIBO_IDRECIBO`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='detalleReciboFacturas';

--
-- Dumping data for table `detallerecibofacturas`
--

INSERT INTO `detallerecibofacturas` (`IDDETALLERECIBOFACTURA`, `RECIBO_IDRECIBO`, `VENTA_IDVENTA`, `MONTOAPLICADO`, `FECHAMODIFICACION`, `INACTIVO`) VALUES
(1, 1, 1, '500000', NULL, 0),
(2, 2, 2, '300000', NULL, 0),
(3, 3, 3, '5750000', NULL, 0),
(4, 4, 4, '3000000', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `detalleventa`
--

DROP TABLE IF EXISTS `detalleventa`;
CREATE TABLE IF NOT EXISTS `detalleventa` (
  `idDetalleVenta` int(11) NOT NULL AUTO_INCREMENT,
  `Venta_idVenta` int(11) DEFAULT NULL,
  `Articulo_idArticulo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(16,2) DEFAULT NULL,
  `impuesto` int(11) DEFAULT NULL,
  `totalNeto` decimal(16,2) DEFAULT NULL,
  `total` decimal(16,2) DEFAULT NULL,
  `inactivo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idDetalleVenta`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='detalleVenta';

--
-- Dumping data for table `detalleventa`
--

INSERT INTO `detalleventa` (`idDetalleVenta`, `Venta_idVenta`, `Articulo_idArticulo`, `cantidad`, `precio`, `impuesto`, `totalNeto`, `total`, `inactivo`) VALUES
(1, 1, 3, 1, '500000.00', 10, '50000.00', '500000.00', 0),
(2, 2, 1, 1, '50000.00', 10, '5000.00', '50000.00', 0),
(3, 2, 2, 1, '250000.00', 10, '25000.00', '250000.00', 0),
(4, 3, 1, 15, '50000.00', 10, '75000.00', '750000.00', 0),
(5, 3, 2, 20, '250000.00', 10, '500000.00', '5000000.00', 0),
(6, 4, 2, 10, '250000.00', 10, '250000.00', '2500000.00', 0),
(7, 4, 1, 10, '50000.00', 10, '50000.00', '500000.00', 0);

--
-- Triggers `detalleventa`
--
DROP TRIGGER IF EXISTS `detalleventa_AFTER_INSERT`;
DELIMITER $$
CREATE TRIGGER `detalleventa_AFTER_INSERT` AFTER INSERT ON `detalleventa` FOR EACH ROW BEGIN

SET @ban = 0;

SELECT Deposito_idDeposito INTO @deposito
FROM venta
WHERE idVenta = NEW.Venta_idVenta;

SELECT Cliente_idCliente INTO @cliente
FROM venta
WHERE idVenta = NEW.Venta_idVenta;

SELECT tipoArticulo INTO @articulo FROM articulo
WHERE idArticulo = NEW.Articulo_idArticulo;

IF @articulo IN ('PRODUCTO') THEN

Update stock
SET cantidad = cantidad - NEW.cantidad
WHERE Articulo_idArticulo = NEW.Articulo_idArticulo 
AND Deposito_idDeposito = @deposito;

END IF;

IF @articulo IN ('SERVICIO') THEN
  SELECT 1 INTO @ban FROM clientedetalle
  WHERE Articulo_idArticulo_Servicio = NEW.Articulo_idArticulo AND Cliente_idCliente = @cliente AND Articulo_idArticulo = 0
    LIMIT 1;
    
    IF @ban = 1 THEN
    UPDATE clientedetalle
        SET cantidad = cantidad + NEW.cantidad
        WHERE Articulo_idArticulo_Servicio = NEW.Articulo_idArticulo AND Cliente_idCliente = @cliente;
    ELSE
    INSERT INTO clientedetalle(Cliente_idCliente, Articulo_idArticulo_Servicio, Articulo_idArticulo, cantidad)
        SELECT @cliente, NEW.Articulo_idArticulo, 0, NEW.cantidad;
  END IF;
END IF;

IF @articulo IN ('PAQUETE') THEN
  
    SELECT 1 INTO @ban FROM clientedetalle
  WHERE Articulo_idArticulo = NEW.Articulo_idArticulo AND Cliente_idCliente = @cliente
    LIMIT 1;
    
    IF @ban = 1 THEN
    
    UPDATE clientedetalle cd
    JOIN paquetedetalle pd 
    ON cd.Articulo_idArticulo_Servicio = pd.Articulo_idArticulo_Servicio AND cd.Articulo_idArticulo = pd.Articulo_idArticulo
    SET cd.cantidad = cd.cantidad + NEW.cantidad*pd.cantidad
    WHERE pd.Articulo_idArticulo = NEW.Articulo_idArticulo AND Cliente_idCliente = @cliente;
  
  ELSE
    
    INSERT INTO clientedetalle(Cliente_idCliente, Articulo_idArticulo_Servicio, Articulo_idArticulo, cantidad)
    SELECT @cliente, Articulo_idArticulo_Servicio, Articulo_idArticulo, NEW.cantidad*cantidad
    FROM paquetedetalle
    WHERE Articulo_idArticulo = NEW.Articulo_idArticulo;
        
  END IF;
    
END IF;

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `detalleventa_AFTER_UPDATE`;
DELIMITER $$
CREATE TRIGGER `detalleventa_AFTER_UPDATE` AFTER UPDATE ON `detalleventa` FOR EACH ROW BEGIN


SET @ban = 0;

SELECT Deposito_idDeposito INTO @deposito
FROM venta
WHERE idVenta = NEW.Venta_idVenta;

SELECT Cliente_idCliente INTO @cliente
FROM venta
WHERE idVenta = NEW.Venta_idVenta;

SELECT tipoArticulo INTO @articulo FROM articulo
WHERE idArticulo = NEW.Articulo_idArticulo;

IF OLD.Inactivo = 0 AND NEW.Inactivo = 1 THEN

  IF @articulo IN ('PRODUCTO') THEN
    Update stock
    SET cantidad = cantidad + NEW.cantidad
    WHERE Articulo_idArticulo = NEW.Articulo_idArticulo
    AND Deposito_idDeposito = @deposito;
  END IF;

  IF @articulo IN ('SERVICIO') THEN
    UPDATE clientedetalle
    SET cantidad = cantidad - NEW.cantidad
    WHERE Articulo_idArticulo_Servicio = NEW.Articulo_idArticulo AND Cliente_idCliente = @cliente;
  END IF;

  IF @articulo IN ('PAQUETE') THEN
    UPDATE clientedetalle cd
    JOIN paquetedetalle pd 
    ON cd.Articulo_idArticulo_Servicio = pd.Articulo_idArticulo_Servicio AND cd.Articulo_idArticulo = pd.Articulo_idArticulo
    SET cd.cantidad = cd.cantidad - NEW.cantidad*pd.cantidad
    WHERE pd.Articulo_idArticulo = NEW.Articulo_idArticulo AND Cliente_idCliente = @cliente;    
  END IF;

ELSE
  IF OLD.Inactivo = 1 AND NEW.Inactivo = 0 THEN
    IF @articulo IN ('PRODUCTO') THEN
      Update stock
      SET cantidad = cantidad - NEW.cantidad
      WHERE Articulo_idArticulo = NEW.Articulo_idArticulo
      AND Deposito_idDeposito = @deposito;
    END IF;

    IF @articulo IN ('SERVICIO') THEN
      UPDATE clientedetalle
      SET cantidad = cantidad + NEW.cantidad
      WHERE Articulo_idArticulo_Servicio = NEW.Articulo_idArticulo AND Cliente_idCliente = @cliente;
    END IF;

    IF @articulo IN ('PAQUETE') THEN
      UPDATE clientedetalle cd
      JOIN paquetedetalle pd 
      ON cd.Articulo_idArticulo_Servicio = pd.Articulo_idArticulo_Servicio AND cd.Articulo_idArticulo = pd.Articulo_idArticulo
      SET cd.cantidad = cd.cantidad + NEW.cantidad*pd.cantidad
      WHERE pd.Articulo_idArticulo = NEW.Articulo_idArticulo AND Cliente_idCliente = @cliente;    
    END IF;
  END IF;
END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detalleventacuotas`
--

DROP TABLE IF EXISTS `detalleventacuotas`;
CREATE TABLE IF NOT EXISTS `detalleventacuotas` (
  `idDetalleVentaCuotas` int(11) NOT NULL AUTO_INCREMENT,
  `Venta_idVenta` int(11) NOT NULL,
  `capital` decimal(16,2) NOT NULL DEFAULT '0.00',
  `interes` decimal(16,2) NOT NULL DEFAULT '0.00',
  `mora` decimal(16,2) NOT NULL DEFAULT '0.00',
  `monto` decimal(16,2) NOT NULL DEFAULT '0.00',
  `fechaVencimiento` date NOT NULL,
  `saldo` decimal(16,2) NOT NULL DEFAULT '0.00',
  `nroCuota` int(11) NOT NULL,
  `inactivo` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idDetalleVentaCuotas`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COMMENT='Tabla de Cuotas';

--
-- Dumping data for table `detalleventacuotas`
--

INSERT INTO `detalleventacuotas` (`idDetalleVentaCuotas`, `Venta_idVenta`, `capital`, `interes`, `mora`, `monto`, `fechaVencimiento`, `saldo`, `nroCuota`, `inactivo`) VALUES
(1, 1, '250000.00', '0.00', '0.00', '250000.00', '2018-08-24', '250000.00', 1, 0),
(2, 1, '250000.00', '0.00', '0.00', '250000.00', '2018-09-24', '250000.00', 2, 0),
(3, 4, '166667.00', '0.00', '0.00', '166667.00', '2018-08-27', '166667.00', 1, 0),
(4, 4, '166667.00', '0.00', '0.00', '166667.00', '2018-09-27', '166667.00', 2, 0),
(5, 4, '166667.00', '0.00', '0.00', '166667.00', '2018-10-27', '166667.00', 3, 0),
(6, 4, '166667.00', '0.00', '0.00', '166667.00', '2018-11-27', '166667.00', 4, 0),
(7, 4, '166667.00', '0.00', '0.00', '166667.00', '2018-12-27', '166667.00', 5, 0),
(8, 4, '166667.00', '0.00', '0.00', '166667.00', '2019-01-27', '166667.00', 6, 0),
(9, 4, '166667.00', '0.00', '0.00', '166667.00', '2019-02-27', '166667.00', 7, 0),
(10, 4, '166667.00', '0.00', '0.00', '166667.00', '2019-03-27', '166667.00', 8, 0),
(11, 4, '166667.00', '0.00', '0.00', '166667.00', '2019-04-27', '166667.00', 9, 0),
(12, 4, '166667.00', '0.00', '0.00', '166667.00', '2019-05-27', '166667.00', 10, 0),
(13, 4, '166667.00', '0.00', '0.00', '166667.00', '2019-06-27', '166667.00', 11, 0),
(14, 4, '166667.00', '0.00', '0.00', '166667.00', '2019-07-27', '166667.00', 12, 0),
(15, 4, '166667.00', '0.00', '0.00', '166667.00', '2019-08-27', '166667.00', 13, 0),
(16, 4, '166667.00', '0.00', '0.00', '166667.00', '2019-09-27', '166667.00', 14, 0),
(17, 4, '166667.00', '0.00', '0.00', '166667.00', '2019-10-27', '166667.00', 15, 0),
(18, 4, '166667.00', '0.00', '0.00', '166667.00', '2019-11-27', '166667.00', 16, 0),
(19, 4, '166667.00', '0.00', '0.00', '166667.00', '2019-12-27', '166667.00', 17, 0),
(20, 4, '166667.00', '0.00', '0.00', '166661.00', '2020-01-27', '166661.00', 18, 0);

-- --------------------------------------------------------

--
-- Table structure for table `documentocajero`
--

DROP TABLE IF EXISTS `documentocajero`;
CREATE TABLE IF NOT EXISTS `documentocajero` (
  `idDocumentoCajero` int(11) NOT NULL AUTO_INCREMENT,
  `Documento_idTipoDocumento` int(11) DEFAULT NULL,
  `Usuario_idUsuario` int(11) DEFAULT NULL,
  `numeroInicial` int(11) DEFAULT NULL,
  `numeroFinal` int(11) DEFAULT NULL,
  `numeroActual` int(11) DEFAULT NULL,
  `fechaEntrega` date DEFAULT NULL,
  `serie` varchar(45) DEFAULT NULL,
  `inactivo` tinyint(4) DEFAULT NULL,
  `timbrado` varchar(50) NOT NULL,
  PRIMARY KEY (`idDocumentoCajero`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `documentocajero`
--

INSERT INTO `documentocajero` (`idDocumentoCajero`, `Documento_idTipoDocumento`, `Usuario_idUsuario`, `numeroInicial`, `numeroFinal`, `numeroActual`, `fechaEntrega`, `serie`, `inactivo`, `timbrado`) VALUES
(1, 1, 1, 0, 0, 0, '2018-01-01', '001-001', 0, '123456');

-- --------------------------------------------------------

--
-- Table structure for table `empleado`
--

DROP TABLE IF EXISTS `empleado`;
CREATE TABLE IF NOT EXISTS `empleado` (
  `idEmpleado` int(11) NOT NULL AUTO_INCREMENT,
  `razonSocial` varchar(250) NOT NULL,
  `nombreComercial` varchar(250) DEFAULT NULL,
  `tipoDocumento` int(11) DEFAULT NULL,
  `nroDocumento` varchar(250) NOT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  `telefono` varchar(250) DEFAULT NULL,
  `celular` varchar(250) DEFAULT NULL,
  `mail` varchar(250) DEFAULT NULL,
  `moneda` int(11) DEFAULT NULL,
  `sitioWeb` varchar(250) DEFAULT NULL,
  `idCategoriaCliente` int(11) DEFAULT NULL,
  `terminoPago` int(11) DEFAULT NULL,
  `terminoPagoHabilitado` varchar(50) DEFAULT NULL,
  `inactivo` tinyint(4) NOT NULL DEFAULT '0',
  `nacimiento` date NOT NULL,
  PRIMARY KEY (`idEmpleado`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='empleado';

--
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`idEmpleado`, `razonSocial`, `nombreComercial`, `tipoDocumento`, `nroDocumento`, `direccion`, `telefono`, `celular`, `mail`, `moneda`, `sitioWeb`, `idCategoriaCliente`, `terminoPago`, `terminoPagoHabilitado`, `inactivo`, `nacimiento`) VALUES
(2, '1', '1', 1, '1', '1', '1', '1', '123@gmail.com', 1, '1', 1, 1, '1', 0, '2018-07-16'),
(3, '2', '2', 1, '2', 'POZO FAVORITO 1657', '1', '1', 'juniorroni.vazquez95@gmail.com', 1, '1', 2, 1, '1', 0, '2018-07-02');

-- --------------------------------------------------------

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
CREATE TABLE IF NOT EXISTS `eventos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `body` text COLLATE utf8_spanish_ci NOT NULL,
  `url` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `class` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'event-important',
  `start` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `end` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `inicio_normal` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `final_normal` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `eventos`
--

INSERT INTO `eventos` (`id`, `title`, `body`, `url`, `class`, `start`, `end`, `inicio_normal`, `final_normal`) VALUES
(5, 'dd', 'dd', 'http://localhost/calendario/descripcion_evento.php?id=5', 'event-info', '1531862880000', '1532640480000', '17/07/2018 17:28', '26/07/2018 17:28'),
(6, 'jdsdewjlkdjewldkj', 'ldjeldjewlewjldkwjdlkwejdlkewdjlk', 'http://localhost/calendario/descripcion_evento.php?id=6', 'event-warning', '1532197200000', '1532629200000', '21/07/2018 14:20', '26/07/2018 14:20');

-- --------------------------------------------------------

--
-- Table structure for table `formapago`
--

DROP TABLE IF EXISTS `formapago`;
CREATE TABLE IF NOT EXISTS `formapago` (
  `IDFORMAPAGO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(60) NOT NULL,
  `TIPOFORMAPAGO` int(11) NOT NULL DEFAULT '0',
  `INACTIVO` tinyint(1) DEFAULT '0',
  `FECHAMODIFICACION` datetime DEFAULT NULL,
  PRIMARY KEY (`IDFORMAPAGO`),
  UNIQUE KEY `descripcion` (`DESCRIPCION`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='formapago';

-- --------------------------------------------------------

--
-- Table structure for table `grupoarticulo`
--

DROP TABLE IF EXISTS `grupoarticulo`;
CREATE TABLE IF NOT EXISTS `grupoarticulo` (
  `idGrupoArticulo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `inactivo` tinyint(1) DEFAULT '0',
  `fechaModificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idGrupoArticulo`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grupoarticulo`
--

INSERT INTO `grupoarticulo` (`idGrupoArticulo`, `nombre`, `inactivo`, `fechaModificacion`) VALUES
(1, 'NINGUNO', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `habilitacion`
--

DROP TABLE IF EXISTS `habilitacion`;
CREATE TABLE IF NOT EXISTS `habilitacion` (
  `idhabilitacion` int(11) NOT NULL AUTO_INCREMENT,
  `Caja_idCaja` int(11) DEFAULT NULL,
  `Usuario_idUsuario` int(11) DEFAULT NULL,
  `fechaApertura` datetime DEFAULT NULL,
  `fechaCierre` datetime DEFAULT NULL,
  `montoApertura` decimal(16,2) DEFAULT NULL,
  `montoCierre` decimal(16,2) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`idhabilitacion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `habilitacion`
--

INSERT INTO `habilitacion` (`idhabilitacion`, `Caja_idCaja`, `Usuario_idUsuario`, `fechaApertura`, `fechaCierre`, `montoApertura`, `montoCierre`, `estado`) VALUES
(1, 1, 1, '2018-08-22 09:45:26', NULL, '0.00', '0.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `moneda`
--

DROP TABLE IF EXISTS `moneda`;
CREATE TABLE IF NOT EXISTS `moneda` (
  `idMoneda` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(60) NOT NULL,
  `inactivo` tinyint(1) DEFAULT '0',
  `fechaModificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idMoneda`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ordenconsumision`
--

DROP TABLE IF EXISTS `ordenconsumision`;
CREATE TABLE IF NOT EXISTS `ordenconsumision` (
  `idOrdenConsumision` int(11) NOT NULL AUTO_INCREMENT,
  `Empleado_idEmpleado` int(11) NOT NULL,
  `fechaConsumision` date NOT NULL,
  `Cliente_idCliente` int(11) NOT NULL,
  `inactivo` int(11) NOT NULL DEFAULT '0',
  `terminado` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idOrdenConsumision`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ordenconsumisiondetalle`
--

DROP TABLE IF EXISTS `ordenconsumisiondetalle`;
CREATE TABLE IF NOT EXISTS `ordenconsumisiondetalle` (
  `idOrdenConsumisionDetalle` int(11) NOT NULL AUTO_INCREMENT,
  `OrdenConsumision_idOrdenConsumision` int(11) NOT NULL,
  `Articulo_idArticulo` int(11) DEFAULT NULL COMMENT 'Paquete',
  `Articulo_idArticulo_Servicio` int(11) DEFAULT NULL COMMENT 'Servicio',
  `Empleado_IdEmpledo` int(11) NOT NULL,
  `cantidad` double NOT NULL DEFAULT '0',
  `cantidadUtilizada` double NOT NULL DEFAULT '0',
  `terminado` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idOrdenConsumisionDetalle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pago`
--

DROP TABLE IF EXISTS `pago`;
CREATE TABLE IF NOT EXISTS `pago` (
  `IDPAGO` int(11) NOT NULL AUTO_INCREMENT,
  `PROVEEDOR_IDPROVEEDOR` int(11) DEFAULT NULL,
  `USUARIO` varchar(20) DEFAULT NULL,
  `HABILITACION_IDHABILITACION` int(11) DEFAULT NULL,
  `NROPAGO` int(11) DEFAULT NULL,
  `FECHATRANSACCION` datetime DEFAULT NULL,
  `FECHAPAGO` date DEFAULT NULL,
  `MONEDA_IDMONEDA` int(11) DEFAULT NULL,
  `TASACAMIBIO` int(11) DEFAULT NULL,
  `TOTAL` decimal(16,2) DEFAULT NULL,
  `FECHAMODIFICACION` datetime DEFAULT NULL,
  `INACTIVO` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDPAGO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='pago';

-- --------------------------------------------------------

--
-- Table structure for table `pagodetallefacturas`
--

DROP TABLE IF EXISTS `pagodetallefacturas`;
CREATE TABLE IF NOT EXISTS `pagodetallefacturas` (
  `IDPAGODETALLEFACTURA` int(11) NOT NULL AUTO_INCREMENT,
  `PAGO_IDPAGO` int(11) DEFAULT NULL,
  `COMPRA_IDCOMPRA` int(11) DEFAULT NULL,
  `MONTOAPLICADO` decimal(10,0) DEFAULT NULL,
  `FECHAMODIFICACION` datetime DEFAULT NULL,
  `INACTIVO` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDPAGODETALLEFACTURA`),
  KEY `FK_REFERENCE_44` (`PAGO_IDPAGO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='PagoDetalleFacturas';

-- --------------------------------------------------------

--
-- Table structure for table `paquetedetalle`
--

DROP TABLE IF EXISTS `paquetedetalle`;
CREATE TABLE IF NOT EXISTS `paquetedetalle` (
  `idpaqueteDetalle` int(11) NOT NULL AUTO_INCREMENT,
  `Articulo_idArticulo` int(11) NOT NULL,
  `Articulo_idArticulo_Servicio` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT '0',
  `comision` decimal(16,2) DEFAULT '0.00',
  `inactivo` int(11) DEFAULT '0',
  `comisionp` int(11) DEFAULT '0',
  PRIMARY KEY (`idpaqueteDetalle`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paquetedetalle`
--

INSERT INTO `paquetedetalle` (`idpaqueteDetalle`, `Articulo_idArticulo`, `Articulo_idArticulo_Servicio`, `nombre`, `cantidad`, `comision`, `inactivo`, `comisionp`) VALUES
(1, 3, 1, 'SERVICIO DE MASAJE', 10, '5000.00', 0, 5),
(2, 3, 2, 'BAÃ‘O DE LUNA', 10, '5000.00', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `permiso`
--

DROP TABLE IF EXISTS `permiso`;
CREATE TABLE IF NOT EXISTS `permiso` (
  `idpermiso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY (`idpermiso`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(1, 'Escritorio'),
(2, 'Almacen'),
(3, 'Compras'),
(4, 'Ventas'),
(5, 'Acceso'),
(6, 'Consulta Compras'),
(7, 'Consulta Ventas'),
(8, 'Habilitaciones'),
(9, 'Parametricas');

-- --------------------------------------------------------

--
-- Table structure for table `precio`
--

DROP TABLE IF EXISTS `precio`;
CREATE TABLE IF NOT EXISTS `precio` (
  `idPrecio` int(11) NOT NULL AUTO_INCREMENT,
  `Articulo_idArticulo` int(10) UNSIGNED NOT NULL,
  `CategoriaCliente_idCategoriaCliente` int(10) UNSIGNED NOT NULL,
  `precio` decimal(16,2) DEFAULT '0.00',
  `inactivo` tinyint(1) DEFAULT '0',
  `fechaModificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idPrecio`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `precio`
--

INSERT INTO `precio` (`idPrecio`, `Articulo_idArticulo`, `CategoriaCliente_idCategoriaCliente`, `precio`, `inactivo`, `fechaModificacion`) VALUES
(1, 1, 1, '9500.00', 1, '2018-01-29 12:20:17'),
(2, 1, 1, '5000.00', 1, NULL),
(3, 2, 1, '80000.00', 1, NULL),
(4, 2, 1, '9000.00', 0, NULL),
(5, 2, 1, '10000.00', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE IF NOT EXISTS `proveedor` (
  `idProveedor` int(11) NOT NULL AUTO_INCREMENT,
  `razonSocial` varchar(250) NOT NULL,
  `nombreComercial` varchar(250) DEFAULT NULL,
  `tipoDocumento` int(11) NOT NULL,
  `nroDocumento` varchar(250) DEFAULT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  `telefono` varchar(250) DEFAULT NULL,
  `celular` varchar(250) DEFAULT NULL,
  `mail` varchar(250) DEFAULT NULL,
  `sitioWeb` varchar(250) DEFAULT NULL,
  `terminoPago` int(11) DEFAULT NULL,
  `moneda` int(11) DEFAULT NULL,
  `idCategoriaProveedor` int(11) DEFAULT NULL,
  `inactivo` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idProveedor`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='proveedor';

--
-- Dumping data for table `proveedor`
--

INSERT INTO `proveedor` (`idProveedor`, `razonSocial`, `nombreComercial`, `tipoDocumento`, `nroDocumento`, `direccion`, `telefono`, `celular`, `mail`, `sitioWeb`, `terminoPago`, `moneda`, `idCategoriaProveedor`, `inactivo`) VALUES
(1, 'proveedor ocasional', 'OCASIONAL', 1, '4831750', 'POZO FAVORITO 1657', '0985726478', '0', 'jrvl@gmail.com', '0', 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `recibo`
--

DROP TABLE IF EXISTS `recibo`;
CREATE TABLE IF NOT EXISTS `recibo` (
  `IDRECIBO` int(11) NOT NULL AUTO_INCREMENT,
  `CLIENTE_IDCLIENTE` int(11) DEFAULT NULL,
  `USUARIO` varchar(20) DEFAULT NULL,
  `HABILITACION_IDHABILITACION` int(11) DEFAULT NULL,
  `NRORECIBO` int(11) DEFAULT NULL,
  `FECHATRANSACCION` datetime DEFAULT NULL,
  `FECHARECIBO` date DEFAULT NULL,
  `MONEDA_IDMONEDA` int(11) DEFAULT NULL,
  `TASACAMBIO` int(11) DEFAULT NULL,
  `TASACAMBIOBASES` int(11) DEFAULT NULL,
  `TOTAL` decimal(10,0) DEFAULT NULL,
  `FECHAMODIFICACION` datetime DEFAULT NULL,
  `USUARIOINSERCION` varchar(20) DEFAULT NULL,
  `USUARIOMODIFICACION` varbinary(20) DEFAULT NULL,
  `INACTIVO` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDRECIBO`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='recibo';

--
-- Dumping data for table `recibo`
--

INSERT INTO `recibo` (`IDRECIBO`, `CLIENTE_IDCLIENTE`, `USUARIO`, `HABILITACION_IDHABILITACION`, `NRORECIBO`, `FECHATRANSACCION`, `FECHARECIBO`, `MONEDA_IDMONEDA`, `TASACAMBIO`, `TASACAMBIOBASES`, `TOTAL`, `FECHAMODIFICACION`, `USUARIOINSERCION`, `USUARIOMODIFICACION`, `INACTIVO`) VALUES
(1, 1, 'admin', 1, 0, '2018-08-24 10:43:04', '2018-08-22', NULL, NULL, NULL, '500000', NULL, 'admin', NULL, 0),
(2, 1, 'admin', 1, 0, '2018-08-24 11:04:46', '2018-08-22', NULL, NULL, NULL, '300000', NULL, 'admin', NULL, 0),
(3, 1, 'admin', 1, 0, '2018-08-25 10:03:04', '2018-08-22', NULL, NULL, NULL, '5750000', NULL, 'admin', NULL, 0),
(4, 1, 'admin', 1, 0, '2018-08-27 11:01:59', '2018-08-22', NULL, NULL, NULL, '3000000', NULL, 'admin', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `Articulo_idArticulo` int(10) UNSIGNED NOT NULL,
  `Deposito_idDeposito` int(10) UNSIGNED NOT NULL,
  `Cantidad` decimal(16,0) DEFAULT NULL,
  `inactivo` tinyint(1) DEFAULT '0',
  `fechaModificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`Articulo_idArticulo`,`Deposito_idDeposito`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`Articulo_idArticulo`, `Deposito_idDeposito`, `Cantidad`, `inactivo`, `fechaModificacion`) VALUES
(1, 1, '-3', 0, '2018-08-22 09:54:20'),
(2, 1, '0', 0, '2018-08-24 10:39:41'),
(3, 1, '0', 0, '2018-08-24 10:42:26');

-- --------------------------------------------------------

--
-- Table structure for table `sucursal`
--

DROP TABLE IF EXISTS `sucursal`;
CREATE TABLE IF NOT EXISTS `sucursal` (
  `idSucursal` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `inactivo` tinyint(1) DEFAULT '0',
  `fechaModificacion` datetime DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `telefono` varchar(200) DEFAULT NULL,
  `correo` varchar(200) DEFAULT NULL,
  `ciudad` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idSucursal`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sucursal`
--

INSERT INTO `sucursal` (`idSucursal`, `nombre`, `inactivo`, `fechaModificacion`, `direccion`, `telefono`, `correo`, `ciudad`) VALUES
(1, 'ROBERT GAMES - CASA MATRIZ', 0, NULL, 'POZO FAVORITO 1657', '0985726478', 'jrvl91@gmail.com', 'a'),
(2, 'ROBERT GAMES - LAMBARE', 0, NULL, '', '', '', ''),
(3, 'Sucursal 2', 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `terminopago`
--

DROP TABLE IF EXISTS `terminopago`;
CREATE TABLE IF NOT EXISTS `terminopago` (
  `idTerminoPago` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(60) NOT NULL,
  `tipo` int(11) NOT NULL DEFAULT '0',
  `inactivo` tinyint(1) DEFAULT '0',
  `fechaModificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idTerminoPago`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `terminopago`
--

INSERT INTO `terminopago` (`idTerminoPago`, `descripcion`, `tipo`, `inactivo`, `fechaModificacion`) VALUES
(1, 'Efectivo', 0, 0, '2018-05-03 08:05:34'),
(2, 'Tarjeta de Credito', 1, 0, NULL),
(3, 'Tarjeta de Debito', 1, 0, NULL),
(4, 'Giros tigo', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tipodocumento`
--

DROP TABLE IF EXISTS `tipodocumento`;
CREATE TABLE IF NOT EXISTS `tipodocumento` (
  `idTipoDocumento` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) DEFAULT NULL,
  `cuentaContable` varchar(100) DEFAULT NULL,
  `inactivo` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`idTipoDocumento`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipodocumento`
--

INSERT INTO `tipodocumento` (`idTipoDocumento`, `descripcion`, `cuentaContable`, `inactivo`) VALUES
(1, 'FACTURA', '1', 0),
(2, 'TICKET', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tipoimpuesto`
--

DROP TABLE IF EXISTS `tipoimpuesto`;
CREATE TABLE IF NOT EXISTS `tipoimpuesto` (
  `idTipoImpuesto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(60) NOT NULL,
  `porcentajeImpuesto` double NOT NULL,
  `inactivo` tinyint(1) DEFAULT '0',
  `fechaModificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idTipoImpuesto`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipoimpuesto`
--

INSERT INTO `tipoimpuesto` (`idTipoImpuesto`, `descripcion`, `porcentajeImpuesto`, `inactivo`, `fechaModificacion`) VALUES
(1, 'I.V.A 10%', 10, 0, NULL),
(2, 'I.V.A 5%', 5, 0, NULL),
(3, 'EXENTAS', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `unidad`
--

DROP TABLE IF EXISTS `unidad`;
CREATE TABLE IF NOT EXISTS `unidad` (
  `idUnidad` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(60) NOT NULL,
  `inactivo` tinyint(1) DEFAULT '0',
  `fechaModificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idUnidad`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unidad`
--

INSERT INTO `unidad` (`idUnidad`, `descripcion`, `inactivo`, `fechaModificacion`) VALUES
(1, 'POR UNIDAD', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `num_documento` varchar(20) NOT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cargo` varchar(20) DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `clave` varchar(64) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `login_UNIQUE` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `cargo`, `login`, `clave`, `imagen`, `condicion`) VALUES
(1, 'JUNIOR RODOLFO VAZQUEZ LOPEZ', 'CEDULA', '4831750', 'POZO FAVORITO 1657', '0985726478', 'jrvl91@gmail.com', 'IT', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '1487132068.jpg', 1),
(9, 'SPA', 'RUC', '123', '-', '-', '', '-', 'spa', '01698ce1dc071ffe29922c335dbf3179df86febd3fdc1114a8817ef2d577274a', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuario_permiso`
--

DROP TABLE IF EXISTS `usuario_permiso`;
CREATE TABLE IF NOT EXISTS `usuario_permiso` (
  `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL,
  PRIMARY KEY (`idusuario_permiso`),
  KEY `fk_usuario_permiso_permiso_idx` (`idpermiso`),
  KEY `fk_usuario_permiso_usuario_idx` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES
(138, 2, 1),
(139, 2, 2),
(140, 2, 3),
(141, 2, 4),
(142, 2, 5),
(143, 2, 6),
(144, 2, 7),
(145, 2, 8),
(146, 2, 9),
(190, 1, 1),
(191, 1, 2),
(192, 1, 3),
(193, 1, 4),
(194, 1, 5),
(195, 1, 6),
(196, 1, 7),
(197, 1, 8),
(198, 1, 9),
(202, 3, 1),
(203, 3, 4),
(204, 3, 8),
(214, 6, 1),
(215, 6, 2),
(216, 6, 3),
(217, 6, 4),
(218, 6, 8),
(219, 6, 9),
(228, 5, 1),
(229, 5, 2),
(230, 5, 3),
(231, 5, 4),
(232, 5, 8),
(233, 5, 9),
(234, 4, 2),
(235, 4, 3),
(236, 4, 4),
(237, 7, 2),
(238, 8, 2),
(239, 9, 1),
(240, 9, 2),
(241, 9, 3),
(242, 9, 4),
(243, 9, 8),
(244, 9, 9);

-- --------------------------------------------------------

--
-- Table structure for table `venta`
--

DROP TABLE IF EXISTS `venta`;
CREATE TABLE IF NOT EXISTS `venta` (
  `idVenta` int(11) NOT NULL AUTO_INCREMENT,
  `Cliente_idCliente` int(11) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `Habilitacion_idHabilitacion` int(11) DEFAULT NULL,
  `Deposito_idDeposito` int(11) DEFAULT NULL,
  `TerminoPago_idTerminoPago` int(11) DEFAULT NULL,
  `tipo_comprobante` int(11) DEFAULT NULL,
  `nroFactura` varchar(25) DEFAULT NULL,
  `fechaTransaccion` datetime DEFAULT NULL,
  `fechaFactura` date DEFAULT NULL,
  `fechaVencimiento` date DEFAULT NULL,
  `timbrado` int(20) DEFAULT NULL,
  `vtoTimbrado` date DEFAULT NULL,
  `Moneda_idMoneda` int(11) DEFAULT NULL,
  `tasaCambio` decimal(16,2) DEFAULT NULL,
  `tasaCambioBases` decimal(16,2) DEFAULT NULL,
  `totalImpuesto` decimal(16,2) DEFAULT NULL,
  `total` decimal(16,2) DEFAULT NULL,
  `totalNeto` decimal(16,2) DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioInsercion` varchar(25) DEFAULT NULL,
  `usuarioModificacion` varchar(25) DEFAULT NULL,
  `inactivo` tinyint(1) DEFAULT NULL,
  `serie` varchar(50) NOT NULL,
  `cuotas` int(11) DEFAULT NULL,
  `fechaPrimeraCuota` date DEFAULT NULL,
  PRIMARY KEY (`idVenta`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='venta';

--
-- Dumping data for table `venta`
--

INSERT INTO `venta` (`idVenta`, `Cliente_idCliente`, `usuario`, `Habilitacion_idHabilitacion`, `Deposito_idDeposito`, `TerminoPago_idTerminoPago`, `tipo_comprobante`, `nroFactura`, `fechaTransaccion`, `fechaFactura`, `fechaVencimiento`, `timbrado`, `vtoTimbrado`, `Moneda_idMoneda`, `tasaCambio`, `tasaCambioBases`, `totalImpuesto`, `total`, `totalNeto`, `fechaModificacion`, `usuarioInsercion`, `usuarioModificacion`, `inactivo`, `serie`, `cuotas`, `fechaPrimeraCuota`) VALUES
(1, 1, 'admin', 1, 1, 2, 1, '000001', '2018-08-24 10:43:04', '2018-08-22', '2018-08-24', 123456, '2018-01-01', NULL, NULL, NULL, '50000.00', '500000.00', '450000.00', '2018-08-24 10:43:04', 'admin', NULL, 0, '001-001', 2, NULL),
(2, 1, 'admin', 1, 1, 0, 1, '000001', '2018-08-24 11:04:46', '2018-08-22', '2018-08-24', 123456, '2018-01-01', NULL, NULL, NULL, '30000.00', '300000.00', '270000.00', '2018-08-24 11:04:46', 'admin', NULL, 0, '001-001', 0, NULL),
(3, 1, 'admin', 1, 1, 0, 1, '000001', '2018-08-25 10:03:04', '2018-08-22', '2018-08-25', 123456, '2018-01-01', NULL, NULL, NULL, '575000.00', '5750000.00', '5175000.00', '2018-08-25 10:03:04', 'admin', NULL, 0, '001-001', 0, NULL),
(4, 1, 'admin', 1, 1, 2, 1, '000001', '2018-08-27 11:01:59', '2018-08-22', '2018-08-27', 123456, '2018-01-01', NULL, NULL, NULL, '300000.00', '3000000.00', '2700000.00', '2018-08-27 11:01:59', 'admin', NULL, 0, '001-001', 18, NULL);

--
-- Triggers `venta`
--
DROP TRIGGER IF EXISTS `venta_AFTER_INSERT`;
DELIMITER $$
CREATE TRIGGER `venta_AFTER_INSERT` AFTER INSERT ON `venta` FOR EACH ROW BEGIN
DECLARE i INT;
SET i = 1;
SET @cuotas = IFNULL(NEW.cuotas,0);
SET @total = NEW.total;

IF @cuotas > 0 THEN
  SET @monto = ROUND(@total/@cuotas);
  SET @vencimiento = NEW.fechaVencimiento;
  SET @interes = 0;
  SET @mora = 0;
  SET @capital = @monto - @interes;
  
    WHILE i<=@cuotas DO
    SET @nroCuota = i;
    IF i < @cuotas THEN
      INSERT INTO detalleventacuotas(Venta_idVenta, capital, interes, mora, monto, fechaVencimiento, saldo, nroCuota)
      SELECT NEW.idVenta, @capital, @interes, @mora, @monto, @vencimiento, @monto, @nroCuota;
            SET @total = @total - @monto;
            SET @vencimiento = DATE_ADD(@vencimiento, INTERVAL 1 MONTH);
    END IF;
        IF i = @cuotas THEN
      INSERT INTO detalleventacuotas(Venta_idVenta, capital, interes, mora, monto, fechaVencimiento, saldo, nroCuota)
      SELECT NEW.idVenta, @capital, @interes, @mora, @total, @vencimiento, @total, @nroCuota;
            SET @total = @total - @monto;
            SET @vencimiento = DATE_ADD(@vencimiento, INTERVAL 1 MONTH);
    END IF;
        
        SET i=i+1;
        
  END WHILE;
    
END IF;

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `venta_AFTER_UPDATE`;
DELIMITER $$
CREATE TRIGGER `venta_AFTER_UPDATE` AFTER UPDATE ON `venta` FOR EACH ROW BEGIN
  
  IF NEW.Inactivo = 1 AND OLD.Inactivo = 0 THEN
        UPDATE detalleventa
        SET Inactivo = 1
        WHERE Venta_idVenta = NEW.idVenta;
        
        UPDATE detalleventacuotas
        SET Inactivo = 1
        WHERE Venta_idVenta = NEW.idVenta;
        
  ELSE
    IF NEW.Inactivo = 0 AND OLD.Inactivo = 1 THEN
      UPDATE detalleventa
      SET Inactivo = 0
      WHERE Venta_idVenta = NEW.idVenta;
            
            UPDATE detalleventa
      SET Inactivo = 0
      WHERE Venta_idVenta = NEW.idVenta;
    END IF;
  END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `venta_BEFORE_INSERT`;
DELIMITER $$
CREATE TRIGGER `venta_BEFORE_INSERT` BEFORE INSERT ON `venta` FOR EACH ROW BEGIN

SET NEW.fechaModificacion = NOW();

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `venta_BEFORE_UPDATE`;
DELIMITER $$
CREATE TRIGGER `venta_BEFORE_UPDATE` BEFORE UPDATE ON `venta` FOR EACH ROW BEGIN

SET NEW.fechaModificacion = NOW();

END
$$
DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
