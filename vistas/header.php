<?php
if (strlen(session_id()) < 1) 
  session_start();
ini_set('memory_limit', '-1');
$config_empresa = null;
if (file_exists(__DIR__ . '/../modelos/ConfiguracionEmpresa.php')) {
  require_once __DIR__ . '/../modelos/ConfiguracionEmpresa.php';
  try {
    $conf = new ConfiguracionEmpresa();
    $config_empresa = $conf->obtener();
  } catch (Exception $e) { }
}
$nombre_sistema = ($config_empresa && !empty($config_empresa['nombre_empresa'])) ? $config_empresa['nombre_empresa'] : 'Pauny';
$logo_sistema = ($config_empresa && !empty($config_empresa['logo_ruta'])) ? '../' . $config_empresa['logo_ruta'] : '../files/logo/logo.jpg';
$color_primario = ($config_empresa && !empty($config_empresa['color_primario'])) ? $config_empresa['color_primario'] : '#e5a00d';

/** Verifica si el usuario tiene permiso por archivo (ventana). */
if (!function_exists('tienePermisoVista')) {
  function tienePermisoVista($archivo) {
    return isset($_SESSION[$archivo]) && $_SESSION[$archivo] == 1;
  }
}
/** Exige permiso por archivo; si no tiene, muestra noacceso y termina. Usar en cada vista: requierePermisoVista(basename(__FILE__, '.php')); */
if (!function_exists('requierePermisoVista')) {
  function requierePermisoVista($archivo) {
    if (tienePermisoVista($archivo)) return;
    require __DIR__ . '/noacceso.php';
    exit;
  }
}
?>
<!DOCTYPE html>
<html>
  <head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo htmlspecialchars($nombre_sistema); ?> - Sistema de Gestión</title>
    <link rel="stylesheet" type="text/css" href="../public/css/menu_header.css">
<!--         <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
 -->        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

<!-- Agregar SweetAlert2 desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap3.css">
      <link rel="stylesheet" href="../public/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="stylesheet" href="../public/css/responsive-scroll.css">
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="<?php echo htmlspecialchars($logo_sistema); ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">    
    <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet"/>
    <!-- drawer removido: menú solo en navbar -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


    <style>

    body {
        font-size: 16px; /* Cambia esto al tamaño que prefieras */
    }
  
    #stock-supera, #limite-supera {
      visibility: hidden;
      min-width: 250px;
      margin-left: -125px;
      background-color: red;
      color: #fff;
      text-align: center;
      border-radius: 2px;
      padding: 16px;
      position: fixed;
      z-index: 1;
      left: 50%;
      bottom: 30px;
      font-size: 17px;
    }

    #stock-supera.show, #limite-supera.show {
      visibility: visible;
      -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
      animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    @-webkit-keyframes fadein {
      from {bottom: 0; opacity: 0;} 
      to {bottom: 30px; opacity: 1;}
    }

    @keyframes fadein {
      from {bottom: 0; opacity: 0;}
      to {bottom: 30px; opacity: 1;}
    }

    @-webkit-keyframes fadeout {
      from {bottom: 30px; opacity: 1;} 
      to {bottom: 0; opacity: 0;}
    }

    @keyframes fadeout {
      from {bottom: 30px; opacity: 1;}
      to {bottom: 0; opacity: 0;}
    }

  html, body          { height: 100%; }
  .wrapper            { min-height: 100%; display: flex; flex-direction: column; }
  /* Sin sidebar: contenido a todo el ancho (AdminLTE aplica margin-left por defecto) */
  .content-wrapper    { flex: 1 0 auto; width: 100%; margin-left: 0 !important; padding: 15px 15px 20px; box-sizing: border-box; }
  .main-footer        { flex-shrink: 0; width: 100%; margin-left: 0 !important; background: #f8f8f8; border-top: 1px solid #e5e5e5; padding: 10px 15px; font-size: 13px; }
  /* Pauny: barra superior */
  .navbar-pauny       { background: linear-gradient(90deg, #1a1a1a 0%, #2d2d2d 100%) !important; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
  .navbar-pauny .nombre_empresa,
  .navbar-pauny .nav-link { color: #fff !important; }
  .navbar-pauny .nombre_empresa:hover,
  .navbar-pauny .nav-link:hover { color: <?php echo htmlspecialchars($color_primario); ?> !important; }
  .navbar-pauny .dropdown-menu { border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
  .navbar-pauny .dropdown-item:hover { background: #fffbeb; color: <?php echo htmlspecialchars($color_primario); ?>; }
  :root { --color-primario: <?php echo htmlspecialchars($color_primario); ?>; }
  /* Menú profesional: logo destacado */
  .navbar-pauny .navbar-brand { padding: 8px 16px; margin-right: 24px; font-size: 1.2rem; font-weight: 600; }
  .navbar-pauny .navbar-brand img { height: 40px; width: auto; border-radius: 6px; }
  .navbar-pauny .navbar-nav .nav-link { padding: 12px 14px !important; font-size: 0.95rem; }
  .navbar-pauny .navbar-nav > li { padding: 0 2px !important; }
  /* Usuario activo en navbar */
  .navbar-pauny .user-activo { display: flex; align-items: center; padding: 6px 12px !important; }
  .navbar-pauny .user-activo .user-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; margin-right: 8px; border: 2px solid rgba(255,255,255,0.4); }
  .navbar-pauny .user-activo .user-nombre { max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 0.9rem; }
  .navbar-pauny .dropdown-menu-right { right: 0; left: auto; }
</style>



  </head> 
  <body class="hold-transition skin-blue layout-top-nav">


<nav class="navbar navbar-expand-lg navbar-light navbar-pauny">
  <div class="container-fluid">
    <a class="navbar-brand nombre_empresa d-flex align-items-center" href="escritorio.php" style="color:#fff!important;">
      <img src="<?php echo htmlspecialchars($logo_sistema); ?>" alt="<?php echo htmlspecialchars($nombre_sistema); ?>" class="mr-2 rounded" style="height:40px;width:auto;object-fit:contain;" onerror="this.src='../files/logo/logo.jpg'">
      <span style="color:inherit;font-weight:600;"><?php echo htmlspecialchars($nombre_sistema); ?></span>
    </a>
    <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="navbar-nav">
      <li class="nav-ite n-menu-i"><a class="nav-link" style="color: white;font-weight: bold;" href="escritorio.php">Escritorio</a></li>

        <?php 

            if ($_SESSION['personas']==1) 
            {
                            echo '
                            <li class="nav-ite dropdown n-menu-i">
								<a style="color: white;font-weight: bold;" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Gestion de Personas</a>
							  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item"  href="persona.php">Personas</a>
                <a class="dropdown-item"  href="cliente.php">Clientes</a>
                <a class="dropdown-item"  href="clienteDireccionesVehiculo.php">Clientes x Direcciones</a>
                <a class="dropdown-item"  href="proveedor.php">Proveedores</a>
							  <a class="dropdown-item"  href="empleado.php">Empleados</a>
							  <a class="dropdown-item" href="tipoPersona.php">Tipo Persona</a>
							  <div class="dropdown-divider"></div>
							  <a class="dropdown-item" href="tipoDireccionTelefono.php">Tipo de Direcciones y Telefonos</a>
							  <a class="dropdown-item" href="pais.php">Pais</a>
                <a class="dropdown-item" href="ciudad.php">Ciudad</a>
							  <a class="dropdown-item" href="barrio.php">Barrio</a>
							  <a class="dropdown-item" href="grupoPersona.php">Grupo</a>
							  </div>
							</li>
							';
            }

            if ($_SESSION['almacen']==1)
            {
                echo '
                <li class="nav-ite dropdown n-menu-i">
				  <a  style="color: white;font-weight: bold;" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  Almacen</a>
				  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="articuloDuplicado.php"><i class="fa fa-circle-o"></i> Artículos</a>
					  			  <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="marca.php"><i class="fa fa-circle-o"></i> Marcas</a>   
					  <a class="dropdown-item" href="categoria.php"><i class="fa fa-circle-o"></i> Categorías</a>
					  <a class="dropdown-item" href="deposito.php"><i class="fa fa-circle-o"></i> Depositos</a>
					  <a class="dropdown-item" href="grupoArticulo.php"><i class="fa fa-circle-o"></i> Grupo Articulo</a>
            <a class="dropdown-item" href="unidad.php"><i class="fa fa-circle-o"></i>  Unidad de medida</a>
					  <a class="dropdown-item" href="tipoImpuesto.php"><i class="fa fa-circle-o"></i> Tipo de Impuesto</a>
				  </div>
				</li>';
            }


            if ($_SESSION['compras']==1)
            {
                echo '
                <li class="nav-ite dropdown n-menu-i"><a style="color: white;font-weight: bold;" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Compras</a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="hacerPedido.php"><i class="fa fa-circle-o"></i> Pedido de compra </a>
                    <a class="dropdown-item"  href="ordenCompra.php"><i class="fa fa-circle-o"></i> Orden de Compra </a>
                    <a class="dropdown-item"  href="recepcionMercaderias.php"><i class="fa fa-circle-o"></i> Recepcion de pedido </a>
                    <a class="dropdown-item"  href="cierreRecepcion.php"><i class="fa fa-circle-o"></i> Cierre de pedido </a>
                    <a class="dropdown-item"  href="compra.php"><i class="fa fa-circle-o"></i> Alta de Compra desde O.C</a>
                    <a class="dropdown-item"  href="compraDirecta.php"><i class="fa fa-circle-o"></i> Alta de Compra Directa</a>
                    <a class="dropdown-item"  href="cierreCosto.php"><i class="fa fa-circle-o"></i> Analisis de Centro de Costos </a>
                    <a class="dropdown-item"  href="autorizacionCompraMercaderia.php"><i class="fa fa-circle-o"></i> Confirmacion de compra ( Mercaderias )</a>
                    <a class="dropdown-item"  href="autorizacionCompraGastos.php"><i class="fa fa-circle-o"></i> Confirmacion de compra ( Gastos )</a>
                    <a class="dropdown-item"  href="pago.php"><i class="fa fa-circle-o"></i> Pago a proveedores </a>
                    <a class="dropdown-item"  href="notaCreditoCompra.php"><i class="fa fa-circle-o"></i> Nota de Credito</a>
                    <a class="dropdown-item"  href="cuentasAPagar.php"><i class="fa fa-circle-o"></i> Cuentas a pagar</a>
                    <a class="dropdown-item"  href="cuentasAPagarAvanzado.php"><i class="fa fa-circle-o"></i> Cuentas a pagar - Avanzado</a>
                    <a class="dropdown-item"  href="conciliacionCuentasCompra.php"><i class="fa fa-circle-o"></i> Conciliacion de Cuentas</a>
                    <a class="dropdown-item" href="persona.php"><i class="fa fa-circle-o"></i> Personas</a>
                    <a class="dropdown-item" href="hechaukaCompras.php"><i class="fa fa-circle-o"></i> Hechauka Compras</a>
                    <a class="dropdown-item" href="cabeceraCompra.php"><i class="fa fa-circle-o"></i> Cabecera Compras</a>
                    <a class="dropdown-item" href="generacionCheque.php"><i class="fa fa-circle-o"></i> Generar cheques</a>
                    <a class="dropdown-item" href="rpt_cheques_fecha.php"><i class="fa fa-circle-o"></i> Reporte de cheques propios</a>
                 </div>
                </li>';
            }


            if ($_SESSION['ventas']==1)
            {
              echo '
              <li class="nav-ite dropdown n-menu-i">

              <a style="color: white;font-weight: bold;" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Ventas</a>


            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="habilitacion.php"><i class="fa fa-circle-o"></i> Habilitacion</a>
                <a class="dropdown-item" href="rpt-habilitaciones.php"><i class="fa fa-circle-o"></i> Habilitacion por Fecha</a>
                <a class="dropdown-item" href="personaAgenda.php"><i class="fa fa-circle-o"></i> Agenda a clientes</a>
                <a class="dropdown-item" href="ordenVenta.php"><i class="fa fa-circle-o"></i> Ordenes de Venta</a>
                <a class="dropdown-item" href="ordenVentaAFacturar.php"><i class="fa fa-circle-o"></i> Ordenes de Ventas a Facturar</a>
                <a class="dropdown-item" href="ordenRemision.php"><i class="fa fa-circle-o"></i> Remisiones</a>
                <!--<a class="dropdown-item" href="venta.php"><i class="fa fa-circle-o"></i> Ventas</a>-->
                <a class="dropdown-item" href="recibo.php"><i class="fa fa-circle-o"></i> Recibos</a>
                <a class="dropdown-item" href="notaCreditoVenta.php"><i class="fa fa-circle-o"></i> Nota de Credito</a>
				<a class="dropdown-item"  href="cuentasACobrar.php"><i class="fa fa-circle-o"></i> Cuentas a cobrar</a>
                <a class="dropdown-item" href="persona.php"><i class="fa fa-circle-o"></i> Personas</a>
                <a class="dropdown-item" href="hechaukaVentas.php"><i class="fa fa-circle-o"></i> Hechauka Ventas</a>
				<a class="dropdown-item" href="precios.php"><i class="fa fa-circle-o"></i> Actualizar precios</a>
				<a class="dropdown-item" href="arqueo.php"><i class="fa fa-circle-o"></i> Arqueo de Caja por Habilitacion</a>
        <a class="dropdown-item" href="rpt-ventas.php"><i class="fa fa-circle-o"></i> Lista de Ventas</a>
        <a class="dropdown-item" href="rpt-ventasArticulo.php"><i class="fa fa-circle-o"></i> Lista de Ventas por Articulo</a>
        <a class="dropdown-item" href="rpt_articulos_fecha.php"><i class="fa fa-circle-o"></i> Lista de Articulos por Fecha</a>
        <a class="dropdown-item" href="rpt-recibos.php"><i class="fa fa-circle-o"></i> Lista de Recibos</a>
        <a class="dropdown-item" href="rpt-recibosDetalle.php"><i class="fa fa-circle-o"></i> Lista de Recibos Detallado</a>

            <a class="dropdown-item" href="rpt_recaudaciones_gastos.php"><i class="fa fa-circle-o"></i> Ingresos VS Egresos</a>
            <a class="dropdown-item" href="rpt-remisionArticuloGentileza.php"><i class="fa fa-circle-o"></i> Remisiones Gentilezas</a>

        
        <a class="dropdown-item" href="rpt-ncventas.php"><i class="fa fa-circle-o"></i> Lista de Notas de Credito</a>
        <a class="dropdown-item" href="movimiento.php"><i class="fa fa-circle-o"></i> Movimientos de Ingresos y Egresos</a>
        <a class="dropdown-item" href="rpt-movimientos.php"><i class="fa fa-circle-o"></i> Reporte de ingresos y egresos</a>
				<a class="dropdown-item" href="concepto.php"><i class="fa fa-circle-o"></i> Conceptos de Ingreso y Egreso</a>
        <a class="dropdown-item" href="rpttapasVentas.php"><i class="fa fa-circle-o"></i> Tapas Antiderrame vs Ventas</a>
              </div>
            </li>';
            }


            if ($_SESSION['ventas']==1)  
            {
              echo '
              <li class="nav-ite dropdown n-menu-i">

              <a style="color: white;font-weight: bold;" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Hoja de ruta</a>


            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="direcciones_hojaruta.html" target="_blank"><i class="fa fa-circle-o"></i> Hoja de Ruta por Camion</a>
                <a class="dropdown-item" href="direcciones_usuario.html" target="_blank"><i class="fa fa-circle-o"></i> Hoja de Ruta por seguimiento de Ventas</a>
                <a class="dropdown-item" href="habilitacion.php"><i class="fa fa-circle-o"></i> Habilitacion</a>
                <a class="dropdown-item" href="personaAgenda.php"><i class="fa fa-circle-o"></i> Agenda a clientes</a>
                <a class="dropdown-item" href="rpt-hojaruta.php"><i class="fa fa-circle-o"></i> Reporte hoja de ruta</a> 
                <a class="dropdown-item" href="importarArchivoNew.php"><i class="fa fa-circle-o"></i> Importar archivo</a> 
              </div>
            </li>';
            }
            
            if ($_SESSION['stock']==1) 
            {
                echo '
                <li class="nav-ite dropdown n-menu-i">
				  <a  style="color: white;font-weight: bold;" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  Stock</a>
				  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="comodato.php"><i class="fa fa-circle-o"></i>Comodato</a>
                    <a class="dropdown-item" href="ajusteStock.php"><i class="fa fa-circle-o"></i> Ajustes de Stock</a>
					         <a class="dropdown-item" href="inventarioStock.php"><i class="fa fa-circle-o"></i> Inventario de Stock</a>
                      <a class="dropdown-item" href="movimientoStock.php"><i class="fa fa-circle-o"></i> Movimiento de Stock</a>   
                      <a class="dropdown-item" href="movimientoStockHabilitacion.php"><i class="fa fa-circle-o"></i> Movimiento de Stock por Habilitacion</a> 
                      <a class="dropdown-item" href="produccion.php"><i class="fa fa-circle-o"></i> Produccion</a>
                      <a class="dropdown-item" href="listadoProduccion.php"><i class="fa fa-circle-o"></i> Listado de Produccion</a>
                      <a class="dropdown-item" href="autorizacionProduccion.php"><i class="fa fa-circle-o"></i> Autorizacion de Produccion</a>  
                      <a class="dropdown-item" href="armadoArticulo.php"><i class="fa fa-circle-o"></i> Armado de Articulo</a>                        
                      <a class="dropdown-item" href="inventarioDeposito.php"><i class="fa fa-circle-o"></i> Consulta de inventario por deposito</a>
                      <a class="dropdown-item" href="inventarioAjusteApp.php"><i class="fa fa-circle-o"></i> Ajuste de Inventario</a>
                      <a class="dropdown-item" href="autorizacionInventarioAjuste.php"><i class="fa fa-circle-o"></i> Autorizacion de inventario por deposito</a>

				  </div>
				</li>';
            }


            if ($_SESSION['logistica']==1)
            {
                echo '
                <li class="nav-ite dropdown n-menu-i">
                  <a  style="color: white;font-weight: bold;" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Logistica</a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                      <a class="dropdown-item" href="hojaRuta.php"><i class="fa fa-circle-o"></i> Registro por Repartidor</a>

                  </div>
                </li>';
            }


            if ($_SESSION['promociones']==1)
            {
                echo '
                <li class="nav-ite dropdown n-menu-i">
				  <a  style="color: white;font-weight: bold;" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  Promociones</a>
				  <div class="dropdown-menu" aria-labelledby="navbarDropdown">

					  <a class="dropdown-item" href="promocion.php"><i class="fa fa-circle-o"></i> Promociones</a>

				  </div>
				</li>';
            }




            if ($_SESSION['contabilidad']==1)    
            {
                echo '
                <li class="nav-ite dropdown n-menu-i">

                <a style="color: white;font-weight: bold;" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Contabilidad</a>

                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="concepto.php"><i class="fa fa-circle-o"></i> Conceptos</a>
                    <a class="dropdown-item" href="banco.php"><i class="fa fa-circle-o"></i> Bancos</a>
                    <a class="dropdown-item" href="moneda.php"><i class="fa fa-circle-o"></i> Monedas</a>
                    <a class="dropdown-item" href="centroDeCostos.php"><i class="fa fa-circle-o"></i> Centro de Costos</a>
                    <a class="dropdown-item" href="tiposDocumentos.php"><i class="fa fa-circle-o"></i> Tipos de Documentos</a>
                    <a class="dropdown-item" href="cotizacionDiaria.php"><i class="fa fa-circle-o"></i> Cotizacion Diaria</a>  
                    <a class="dropdown-item" href="cuentaContable.php"><i class="fa fa-circle-o"></i> Cuentas Contables</a>
                    <a class="dropdown-item" href="cuentaCorriente.php"><i class="fa fa-circle-o"></i> Cuentas Corrientes</a>
                    <a class="dropdown-item" href="proceso.php"><i class="fa fa-circle-o"></i> Procesos</a>
                    <a class="dropdown-item" href="asiento.php"><i class="fa fa-circle-o"></i> Asientos</a>
                    <a class="dropdown-item" href="notaCreditoCompra.php"><i class="fa fa-circle-o"></i> Notas de Credito Compras</a>
                    <a class="dropdown-item" href="notaCreditoVenta.php"><i class="fa fa-circle-o"></i> Notas de Credito Ventas</a>         
                    <a class="dropdown-item" href="libroDiario.php"><i class="fa fa-circle-o"></i> Libro Diario</a> 
                    <a class="dropdown-item" href="libroMayor.php"><i class="fa fa-circle-o"></i> Libro Mayor</a>  
                    <a class="dropdown-item" href="agrupacionCuentasContables.php"><i class="fa fa-circle-o"></i> Agrupacion de Cuentas</a>
                    <a class="dropdown-item" href="maestroSaldos.php"><i class="fa fa-circle-o"></i> Maestro de Saldos</a>
                    <a class="dropdown-item" href="balance.php"><i class="fa fa-circle-o"></i> Balance Contable</a>                       
                    <a class="dropdown-item" href="rpt_libro_compras_avanzado1.php"><i class="fa fa-circle-o"></i> Libro Compras</a>                         
                    <a class="dropdown-item" href="rpt_libro_ventas_avanzado1.php"><i class="fa fa-circle-o"></i> Libro Ventas</a>                                              
                  </div> 
                </li>';
            }
			

            if ($_SESSION['contabilidad']==1)    
            {
                echo '
                <li class="nav-ite dropdown n-menu-i">

                <a style="color: white;font-weight: bold;" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">RR-HH</a>

                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <i class="fa fa-circle"></i> Personal
				    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="legajo.php"><i class="fa fa-circle-o"></i> Personas - Legajo</a>
                    <a class="dropdown-item" href="departamento.php"><i class="fa fa-circle-o"></i> Departamento</a>
                    <a class="dropdown-item" href="cargo.php"><i class="fa fa-circle-o"></i> Cargo</a>
                    <a class="dropdown-item" href="estadoCivil.php"><i class="fa fa-circle-o"></i> Estado Civil</a>
                    <a class="dropdown-item" href="profesion.php"><i class="fa fa-circle-o"></i> Profesion</a>
                    <a class="dropdown-item" href="clase.php"><i class="fa fa-circle-o"></i> Clase</a>
                    <a class="dropdown-item" href="tipoSalario.php"><i class="fa fa-circle-o"></i> Tipo de Salario</a>
                    <a class="dropdown-item" href="medioCobro.php"><i class="fa fa-circle-o"></i> Medio de cobro</a>
                    <a class="dropdown-item" href="tipoContrato.php"><i class="fa fa-circle-o"></i> Tipo de contrato</a>
                    <a class="dropdown-item" href="movimientoPersonal.php"><i class="fa fa-circle-o"></i> Movimientos Personal</a>
                    <a class="dropdown-item" href="comunicacionPersonal.php"><i class="fa fa-circle-o"></i> Comunicacion Personal</a>
                    <a class="dropdown-item" href="salario.php"><i class="fa fa-circle-o"></i> Salario</a>  
                    <i class="fa fa-circle"></i> Salario
                    <a class="dropdown-item" href="conceptoSalario.php"><i class="fa fa-circle-o"></i> Concepto Salario</a>
                    <a class="dropdown-item" href="movimientoSalarial.php"><i class="fa fa-circle-o"></i> Movimiento Salarial</a>

                    <i class="fa fa-circle"></i> Liquidacion
                    <a class="dropdown-item" href="liquidacion.php"><i class="fa fa-circle-o"></i> Liquidacion</a>                       
                    <a class="dropdown-item" href="liquidacion.php"><i class="fa fa-circle-o"></i> Resumen de Salarios</a>                       
                    <a class="dropdown-item" href="liquidacion.php"><i class="fa fa-circle-o"></i> Detalle de Salarios</a> 
                    <a class="dropdown-item" href="cierreLiquidacion.php"><i class="fa fa-circle-o"></i> Cierre de liquidacion</a>                       
                  </div> 
                </li>';
            }


			echo '
                <li class="nav-ite dropdown n-menu-i">

                <a style="color: white;font-weight: bold;" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Acceso</a>

                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
			if ($_SESSION['acceso']==1)    
            {
				echo '
                    <a class="dropdown-item" href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a>';
			}
				echo '
                    <a class="dropdown-item" href="cambiarPass.php"><i class="fa fa-circle-o"></i> Gestion de contraseña</a>                
                  </div> 
                </li>';


            if ($_SESSION['parametricas']==1)
            {
              echo '
              <li class="nav-ite dropdown n-menu-i">

              <a style="color: white;font-weight: bold;" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Parametricas</a>


            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="documentoCajero.php"><i class="fa fa-circle-o"></i> Documentos por cajero</a>
                <a class="dropdown-item" href="caja.php.php"><i class="fa fa-circle-o"></i> Cajas</a>
                <a class="dropdown-item" href="sucursal.php"><i class="fa fa-circle-o"></i> Sucursales</a>
                <a class="dropdown-item" href="proveedor.php"><i class="fa fa-circle-o"></i> Proveedores</a>
                <a class="dropdown-item" href="terminoPago.php"><i class="fa fa-circle-o"></i> Termino de pagos</a>
                <a class="dropdown-item" href="banco.php"><i class="fa fa-circle-o"></i> Bancos</a>
                <a class="dropdown-item" href="estado.php"><i class="fa fa-circle-o"></i> Estados</a>
                <a class="dropdown-item" href="moneda.php"><i class="fa fa-circle-o"></i> Monedas</a>
                <a class="dropdown-item" href="configuracionEmpresa.php"><i class="fa fa-circle-o"></i> Configuracion de la Empresa</a>
              </div>
            </li>';
            }


            if ($_SESSION['acceso']==1)
            {
              echo '
              <li class="nav-ite dropdown n-menu-i">

              <a style="color: white;font-weight: bold;" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Control</a>


            <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                <a class="dropdown-item" href="anularOV.php"><i class="fa fa-circle-o"></i> Anular Orden de Venta</a>             
                <a class="dropdown-item" href="anularVenta.php"><i class="fa fa-circle-o"></i> Anular venta por numero de venta</a>              
                <a class="dropdown-item" href="anularRecibo.php"><i class="fa fa-circle-o"></i> Anular recibo por numero de recibo</a>  
				<a class="dropdown-item" href="anularCompra.php"><i class="fa fa-circle-o"></i> Anular compra por numero de compra</a>              
                <a class="dropdown-item" href="anularPago.php"><i class="fa fa-circle-o"></i> Anular pago por numero de pago</a>        
                <a class="dropdown-item" href="anularNotaCreditoVenta.php"><i class="fa fa-circle-o"></i> Anular Nota Credito Venta</a> 				
                <a class="dropdown-item" href="volverHabilitar.php"><i class="fa fa-circle-o"></i> Volver a habilitar</a> 
                <a class="dropdown-item" href="rpt-ventasAnuladas.php"><i class="fa fa-circle-o"></i> Reporte de Ventas Anuladas</a> 
                <a class="dropdown-item" href="rpt-recibosAnulados.php"><i class="fa fa-circle-o"></i> Reporte de Recibos Anulados</a> 
              </div>
            </li>';            }


          /*  if ($_SESSION['ordenes']==1)
            {
                echo '
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">RR-HH <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="empleado.php"><i class="fa fa-circle-o"></i> Empleados</a></li>
                    <li><a href="articuloEmpleado.php"><i class="fa fa-circle-o"></i> Entregar productos a empleados</a></li>
                    <li><a href="rpt_comisiones_empleado.php"><i class="fa fa-circle-o"></i> Comisiones a empleados</a></li>
                    <li><a href="rpt_comisiones_empleadoa.php"><i class="fa fa-circle-o"></i> Comisiones a empleados por nombre</a></li>
                  </ul>
                </li>';
            }
            ?>



            <?php 
            if ($_SESSION['almacen']==1)
            {
                echo '
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Almacen <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="articulo.php"><i class="fa fa-circle-o"></i> Artículos</a></li>
                    <li><a href="categoria.php"><i class="fa fa-circle-o"></i> Categorías</a></li>
                    <li><a href="deposito.php"><i class="fa fa-circle-o"></i> Depositos</a></li>
                    <li><a href="grupoArticulo.php"><i class="fa fa-circle-o"></i> Grupo Articulo</a></li>
                        <li><a href="unidad.php"><i class="fa fa-circle-o"></i> Unidad de medida</a></li>
                    <li><a href="inventarioDepositoAjuste.php"><i class="fa fa-circle-o"></i> Ajuste masivo por deposito</a></li>
                  <li><a href="inventarioDeposito.php"><i class="fa fa-circle-o"></i> Consulta de inventario por deposito</a></li>

                    </ul>
                </li>';
            }
            ?>



            <?php 
            if ($_SESSION['compras']==1)
            {
              echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Compras <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="habilitacion.php"><i class="fa fa-circle-o"></i> Habilitaciones</a></li>
                <li><a href="compra.php"><i class="fa fa-circle-o"></i> Compras</a></li>
                <li><a href="proveedor.php"><i class="fa fa-circle-o"></i> Proveedores</a></li>
                <li><a href="documentoCajero.php"><i class="fa fa-circle-o"></i> Documentos por cajero</a></li>
                <li><a href="caja.php"><i class="fa fa-circle-o"></i> Cajas</a></li>
                <li><a href="sucursal.php"><i class="fa fa-circle-o"></i> Sucursales</a></li>
                <li><a href="proveedor.php"><i class="fa fa-circle-o"></i> Proveedores</a></li>
                <li><a href="terminoPago.php"><i class="fa fa-circle-o"></i> Termino de pagos</a></li>
                <li><a href="banco.php"><i class="fa fa-circle-o"></i> Bancos</a></li>
              </ul>
            </li>';
            }
            ?>



            <?php 
            if ($_SESSION['ventas']==1)
            {
              echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Ventas <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="habilitacion.php"><i class="fa fa-circle-o"></i> Habilitacion</a></li>
                <li><a href="venta.php"><i class="fa fa-circle-o"></i> Ventas</a></li>
                <li><a href="recibo.php"><i class="fa fa-circle-o"></i> Recibos</a></li>
                <li><a href="cliente.php"><i class="fa fa-circle-o"></i> Clientes</a></li>
                <li><a href="documentoCajero.php"><i class="fa fa-circle-o"></i> Documentos por cajero</a></li>
                <li><a href="caja.php.php"><i class="fa fa-circle-o"></i> Cajas</a></li>
                <li><a href="sucursal.php"><i class="fa fa-circle-o"></i> Sucursales</a></li>
                <li><a href="proveedor.php"><i class="fa fa-circle-o"></i> Proveedores</a></li>
                <li><a href="terminoPago.php"><i class="fa fa-circle-o"></i> Termino de pagos</a></li>
                <li><a href="banco.php"><i class="fa fa-circle-o"></i> Bancos</a></li>
              </ul>
            </li>';
            }
            ?>
             
            <?php 
            if ($_SESSION['ventas']==1)
            {
              echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Recibos <span class="caret"></span></a>
          <ul class="dropdown-menu">
                <li><a href="habilitacion.php"><i class="fa fa-circle-o"></i> Habilitacion</a></li>
                <li><a href="recibo.php"><i class="fa fa-circle-o"></i> Recibos</a></li>
                <li><a href="rpt_cuotas_cliente.php"><i class="fa fa-circle-o"></i> Extracto de credito por Cliente</a></li>
                <li><a href="../reportes/rptDeudas.php"><i class="fa fa-circle-o"></i> Deudas pendientes</a></li>
              </ul>
            </li>';
            }
            ?>

            <?php 
            if ($_SESSION['movimientos']==1)
            {
              echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Movimientos de caja <span class="caret"></span></a>
          <ul class="dropdown-menu">
                <li><a href="concepto.php" ><i class="fa fa-circle-o"></i> Conceptos de ingreso y egreso</a></li>                
                <li><a href="movimiento.php"><i class="fa fa-circle-o"></i> Movimiento de caja</a></li>                
              </ul>
            </li>';
            }
            ?>


            <?php 
            if ($_SESSION['ordenes']==1)
            {
              echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Consumision de servicios<span class="caret"></span></a>
          <ul class="dropdown-menu">
                <li><a href="calendariospa" target="_blank"><i class="fa fa-circle-o"></i> Orden de Consumision por calendario</a></li>
                <li><a href="ordenConsumision.php"><i class="fa fa-circle-o"></i> Orden de Consumision</a></li>
                <li><a href="consumirOrden.php"><i class="fa fa-circle-o"></i> Atender Consumision</a></li>
                <li><a href="rpt_ordenConsumisionDetalle_d.php"><i class="fa fa-circle-o"></i> Ordenes de consumision con detalle</a></li>                
              </ul>
            </li>';
            }
            ?>

            <?php 
            if ($_SESSION['acceso']==1)
            {
              echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Acceso <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>                      
                <a class="dropdown-item" href="cambiarPass.php"><i class="fa fa-circle-o"></i> Gestion de contraseña</a>
                <li><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
                
              </ul>
            </li>';
            }
            ?>

            <?php 
            if ($_SESSION['acceso']==1)
            {
              echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Control <span class="caret"></span></a>
          <ul class="dropdown-menu">
                <li><a href="anularVenta.php"><i class="fa fa-circle-o"></i> Anular venta por numero de venta</a></li>              
                <li><a href="anularRecibo.php"><i class="fa fa-circle-o"></i> Anular recibo por numero de recibo</a></li>              
                <li><a href="volverHabilitar.php"><i class="fa fa-circle-o"></i> Volver a habilitar</a></li> 
                <li><a href="cambiarGiftCard.php"><i class="fa fa-circle-o"></i> Cambiar persona a GiftCard</a></li>   
                <li><a href="rpt_clientedetalle_ajuste.php"><i class="fa fa-circle-o"></i> Ajustar Servicios a clientes</a></li>                
                <li><a href="consumisionCliente.php"><i class="fa fa-circle-o"></i> Consumisiones de clientes</a></li>                
                <li><a href="rpt_ordenConsumisionDetalle_d.php"><i class="fa fa-circle-o"></i> Ordenes de consumision con detalle</a></li>                
              </ul>
            </li>';
            }
            ?>
            
            <?php 
            if ($_SESSION['consultac']==1)
            {
              echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Consultas compras <span class="caret"></span></a>
          <ul class="dropdown-menu">
                <li><a href="comprasHabilitacion.php"><i class="fa fa-circle-o"></i> Consulta Compras por habilitacion</a></li>               
                <li><a href="comprasFecha.php"><i class="fa fa-circle-o"></i> Consulta Compras por rango de fechas</a></li>               
                <li><a href="inventarioDeposito.php"><i class="fa fa-circle-o"></i> Consulta de inventario por deposito</a></li>               
              </ul>
            </li>';
            }
            ?>
             <?php 
            if ($_SESSION['consultav']==1)
            {
              echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Consultas ventas <span class="caret"></span></a>
          <ul class="dropdown-menu">
                <li><a href="ventasHabilitacion.php"><i class="fa fa-circle-o"></i> Consulta Ventas por habilitacion</a></li>                
                <li><a href="recibosHabilitacion.php"><i class="fa fa-circle-o"></i> Consulta recibos por habilitacion</a></li>                
                <li><a href="recibosFecha.php"><i class="fa fa-circle-o"></i> Consulta recibos por fecha</a></li>                
                <li><a href="cobrosFecha.php"><i class="fa fa-circle-o"></i> Consulta detalle de cobros por fecha</a></li>                
                <li><a href="arqueo.php"><i class="fa fa-circle-o"></i> Arqueo de caja por habilitacion</a></li>                
                <li><a href="ventasFecha.php"><i class="fa fa-circle-o"></i> Consulta Ventas por rango de fechas</a></li>                
                <li><a href="ventasFechaActivos.php"><i class="fa fa-circle-o"></i> Consulta Ventas por rango de fechas(Solo Activos)</a></li>                
                <li><a href="ventasFechaGift.php"><i class="fa fa-circle-o"></i> Consulta Ventas por rango de fechas(Solo GiftCard)</a></li>                
                <li><a href="ventasFechaSucursal.php"><i class="fa fa-circle-o"></i> Consulta Ventas por rango de fechas y Sucursal</a></li>                
                <li><a href="inventarioDeposito.php"><i class="fa fa-circle-o"></i> Consulta de inventario por deposito</a></li>                
                <li><a href="rpt_articulos_fecha.php"><i class="fa fa-circle-o"></i> Articulos mas vendidos por fecha</a></li>                
                <li><a href="movimientosFechaEgreso.php"><i class="fa fa-circle-o"></i> Consultar de movimientos de egresos por fecha y concepto</a></li>                
                <li><a href="movimientosFechaIngreso.php"><i class="fa fa-circle-o"></i> Consultar de movimientos de ingresos por fecha y concepto</a></li>              
                <li><a href="rpt_producto_x_fecha_x_orden.php"><i class="fa fa-circle-o"></i> Consultar Productos por fecha</a></li>                        
                <li><a href="rpt_producto_x_fecha_x_orden_d.php"><i class="fa fa-circle-o"></i> Consultar Productos por fecha(Detalle)</a></li>                        
              </ul>
            </li>';
            }
             ?>

             <?php 
            if ($_SESSION['consultav']==1)
            {
              echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes <span class="caret"></span></a>
          <ul class="dropdown-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Recaudacion - Gastos</a></li>                
                <li><a href="rpt_cliente_paquetes_servicios.php"><i class="fa fa-circle-o"></i> Paquete por personas</a></li>                
                <li><a href="#"><i class="fa fa-circle-o"></i> Grafico - Paquetes por personas</a></li>                
                <li><a href="#"><i class="fa fa-circle-o"></i> Detalle de gastos</a></li>                
                <li><a href="#"><i class="fa fa-circle-o"></i> Recaudacion - Costos(Comisiones)</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Recaudacion - Detallada</a></li>                
                <li><a href="../reportes/rptArticulosVendidos.php"><i class="fa fa-circle-o"></i> Ventas(Lo mas vendido)</a></li>                
                <li><a href="#"><i class="fa fa-circle-o"></i> Informe de Stock</a></li>                
                <li><a href="#"><i class="fa fa-circle-o"></i> Objetivos de masajista</a></li>                

              </ul>
            </li>';
            }
*/

            ?>

    <ul class="navbar-nav ml-auto">
      <li class="nav-ite n-menu-i">
        <a class="nav-link" style="color: white;font-weight: bold;" href="#">Ayuda</a>
      </li>
      <li class="nav-ite n-menu-i">
        <a class="nav-link" style="color: white;font-weight: bold;" href="#">Acerca de..</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link user-activo dropdown-toggle" href="#" id="navbarUsuario" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white; font-weight: bold;">
          <?php
          $img_usuario = isset($_SESSION['imagen']) && $_SESSION['imagen'] !== '' ? htmlspecialchars($_SESSION['imagen']) : '';
          $ruta_img = $img_usuario !== '' ? '../files/usuarios/' . $img_usuario : '';
          if ($ruta_img !== ''): ?>
            <img src="<?php echo $ruta_img; ?>" alt="" class="user-avatar" onerror="this.onerror=null; this.src='../files/logo/logo.jpg';">
          <?php else: ?>
            <span class="user-avatar fa fa-user" style="width:32px;height:32px;margin-right:8px;display:inline-flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.2);border-radius:50%;font-size:1rem;"></span>
          <?php endif; ?>
          <span class="user-nombre"><?php echo htmlspecialchars(isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario'); ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarUsuario">
          <div class="px-3 py-2 text-muted small border-bottom">
            <strong><?php echo htmlspecialchars(isset($_SESSION['nombre']) ? $_SESSION['nombre'] : ''); ?></strong><br>
            <span><?php echo htmlspecialchars(isset($_SESSION['login']) ? $_SESSION['login'] : ''); ?></span>
          </div>
          <a class="dropdown-item" href="cambiarPass.php"><i class="fa fa-key"></i> Cambiar contraseña</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="../ajax/usuario.php?op=salir"><i class="fa fa-sign-out"></i> Cerrar sesión</a>
        </div>
      </li>
    </ul>
  </div>
  </div><!-- /.container-fluid -->
</nav>

<div class="wrapper">

  