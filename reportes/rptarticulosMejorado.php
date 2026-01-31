<?php
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

function salidaNoAutorizado($mensaje, $esLogin = false) {
  $loginUrl = '../vistas/login.html';
  header('Content-Type: text/html; charset=utf-8');
  ob_end_clean();
  echo '<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">';
  echo '<title>Acceso requerido</title>';
  echo '<style>body{font-family:sans-serif;max-width:500px;margin:3em auto;padding:2em;text-align:center;} .btn{display:inline-block;margin-top:1em;padding:10px 20px;background:#3c8dbc;color:#fff;text-decoration:none;border-radius:4px;} .btn:hover{background:#2e6da4;}</style></head><body>';
  echo '<p>' . htmlspecialchars($mensaje) . '</p>';
  echo '<a class="btn" href="' . htmlspecialchars($loginUrl) . '">Ir al inicio de sesión</a>';
  echo '</body></html>';
  exit;
}

if (!isset($_SESSION["nombre"])) {
  salidaNoAutorizado('Debe ingresar al sistema correctamente para visualizar el reporte.');
}
if (empty($_SESSION['almacen']) || $_SESSION['almacen'] != 1) {
  salidaNoAutorizado('No tiene permiso para visualizar el reporte.');
}
if (ob_get_length()) ob_clean();

function errorReporte($mensaje) {
	header('Content-Type: text/html; charset=utf-8');
	if (ob_get_length()) ob_end_clean();
	echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Error</title></head><body style="font-family:sans-serif;padding:2em;">';
	echo '<p style="color:#c00;">' . htmlspecialchars($mensaje) . '</p>';
	echo '<a href="../vistas/login.html">Ir al inicio de sesión</a></body></html>';
	exit;
}

try {
	require_once __DIR__ . "/../config/Conexion.php";
	require_once __DIR__ . "/../modelos/Articulo.php";
	require_once __DIR__ . "/../modelos/Consultas.php";
	require_once __DIR__ . "/../modelos/ConfiguracionEmpresa.php";
	require __DIR__ . '/PDF_ReporteBase.php';
} catch (Throwable $e) {
	errorReporte('Error al cargar el reporte: ' . $e->getMessage());
}

// Clase extendida (usa cabecera/pie de PDF_ReporteBase: logo empresa + Factupar)
class PDF_Articulos extends PDF_ReporteBase
{
  function __construct($orientation = 'L') {
    parent::__construct($orientation);
  }
  
  function TituloSeccion($titulo, $fill_color = array(60, 141, 188))
  {
    $this->SetFillColor($fill_color[0], $fill_color[1], $fill_color[2]);
    $this->SetTextColor(255, 255, 255);
    $this->SetFont('Arial','B',12);
    $this->Cell(0, 8, utf8_decode($titulo), 0, 0, 'L', true);
    $this->Ln(8);
    $this->SetTextColor(0, 0, 0);
  }
  
  function KPIBox($label, $value, $width = 47)
  {
    $this->SetFillColor(245, 245, 245);
    $this->SetFont('Arial','B',10);
    $this->Cell($width, 6, utf8_decode($label), 1, 0, 'L', true);
    $this->SetFont('Arial','',10);
    $this->Cell($width, 6, utf8_decode($value), 1, 0, 'L', true);
  }
}

// Instanciamos la clase (logo y pie vienen de PDF_ReporteBase)
try {
	$pdf = new PDF_Articulos('L');
$pdf->AliasNbPages();
$pdf->AddPage('L'); // Landscape para más espacio

$articulo = new Articulo();
$consultas = new Consultas();

// ========== SECCIÓN 1: RESUMEN EJECUTIVO Y KPIs ==========
$pdf->TituloSeccion('RESUMEN EJECUTIVO - INDICADORES CLAVE (KPIs)');

// Calcular KPIs (todos los artículos para totales correctos)
$rspta_total = @ejecutarConsulta("SELECT idArticulo, inactivo, tipoArticulo FROM articulo");
$total_articulos = 0;
$total_activos = 0;
$total_inactivos = 0;
$total_productos = 0;
$total_servicios = 0;
$valor_inventario = 0;

if ($rspta_total) {
  while ($reg = $rspta_total->fetchObject()) {
    $total_articulos++;
    if (isset($reg->inactivo) && $reg->inactivo == 0) {
      $total_activos++;
      $tipo = isset($reg->tipoArticulo) ? $reg->tipoArticulo : '';
      if ($tipo == 'PRODUCTO' || $tipo == 'PRODUCTO_INTERNO') {
        $total_productos++;
      } elseif ($tipo == 'SERVICIO') {
        $total_servicios++;
      }
    } else {
      $total_inactivos++;
    }
  }
}

// Stock total y valor de inventario
$rspta_stock = @ejecutarConsulta("
  SELECT 
    SUM(s.cantidad) as total_stock,
    SUM(s.cantidad * COALESCE(a.precioVenta, 0)) as valor_inventario
  FROM stock s
  JOIN articulo a ON s.Articulo_idArticulo = a.idArticulo
  WHERE a.inactivo = 0
");
$stock_total = 0;
if ($rspta_stock && ($reg_stock = $rspta_stock->fetchObject())) {
  $stock_total = $reg_stock->total_stock ? $reg_stock->total_stock : 0;
  $valor_inventario = $reg_stock->valor_inventario ? $reg_stock->valor_inventario : 0;
}

// Artículos sin stock (sin filas en stock o suma = 0)
$rspta_sin_stock = @ejecutarConsulta("
  SELECT COUNT(*) as total FROM (
    SELECT a.idArticulo
    FROM articulo a
    LEFT JOIN stock s ON a.idArticulo = s.Articulo_idArticulo
    WHERE a.inactivo = 0
    GROUP BY a.idArticulo
    HAVING COALESCE(SUM(s.cantidad), 0) = 0
  ) AS sub
");
$sin_stock = 0;
if ($rspta_sin_stock && $reg_sin = $rspta_sin_stock->fetchObject()) {
  $sin_stock = (int)$reg_sin->total;
}

// Artículos con bajo stock (< 10 unidades): contar con subconsulta
$rspta_bajo_stock = @ejecutarConsulta("
  SELECT COUNT(*) as total FROM (
    SELECT a.idArticulo
    FROM articulo a
    LEFT JOIN stock s ON a.idArticulo = s.Articulo_idArticulo
    WHERE a.inactivo = 0
    GROUP BY a.idArticulo
    HAVING COALESCE(SUM(s.cantidad), 0) < 10 AND COALESCE(SUM(s.cantidad), 0) > 0
  ) AS sub
");
$bajo_stock = 0;
if ($rspta_bajo_stock && $reg_bajo = $rspta_bajo_stock->fetchObject()) {
  $bajo_stock = (int)$reg_bajo->total;
}

// Mostrar KPIs en cuadros
$pdf->SetFont('Arial','',9);
$pdf->KPIBox('Total de Artículos:', number_format($total_articulos, 0, ',', '.'), 47);
$pdf->KPIBox('Artículos Activos:', number_format($total_activos, 0, ',', '.'), 47);
$pdf->Ln(6);
$pdf->KPIBox('Artículos Inactivos:', number_format($total_inactivos, 0, ',', '.'), 47);
$pdf->KPIBox('Productos:', number_format($total_productos, 0, ',', '.'), 47);
$pdf->Ln(6);
$pdf->KPIBox('Servicios:', number_format($total_servicios, 0, ',', '.'), 47);
$pdf->KPIBox('Stock Total (Unidades):', number_format($stock_total, 2, ',', '.'), 47);
$pdf->Ln(6);
$pdf->KPIBox('Valor Inventario (Gs.):', number_format($valor_inventario, 0, ',', '.'), 47);
$pdf->KPIBox('Sin Stock:', number_format($sin_stock, 0, ',', '.'), 47);
$pdf->Ln(6);
$pdf->KPIBox('Bajo Stock (< 10 unidades):', number_format($bajo_stock, 0, ',', '.'), 47);
$pdf->KPIBox('Tasa de Activos:', number_format($total_articulos > 0 ? ($total_activos / $total_articulos * 100) : 0, 2, ',', '.') . '%', 47);
$pdf->Ln(10);

// ========== SECCIÓN 2: TOP 10 ARTÍCULOS MÁS VENDIDOS ==========
$rspta_vendidos = @ejecutarConsulta("
  SELECT 
    a.idArticulo,
    a.nombre,
    a.codigo,
    SUM(dv.cantidad) as cantidad_vendida,
    SUM(dv.total) as total_vendido,
    COUNT(DISTINCT v.idVenta) as num_ventas
  FROM detalleventa dv
  JOIN venta v ON dv.Venta_idVenta = v.idVenta
  JOIN articulo a ON dv.Articulo_idArticulo = a.idArticulo
  WHERE v.fecha_hora >= DATE_SUB(NOW(), INTERVAL 90 DAY)
  GROUP BY a.idArticulo, a.nombre, a.codigo
  ORDER BY cantidad_vendida DESC
  LIMIT 10
");

$hay_vendidos = false;
$cont_vendidos = 0;
if ($rspta_vendidos) {
while($reg = $rspta_vendidos->fetchObject()) {
  if (!$hay_vendidos) {
    $pdf->TituloSeccion('TOP 10 ARTÍCULOS MÁS VENDIDOS (Últimos 90 días)', array(0, 166, 90));
    $pdf->SetFillColor(232, 232, 232);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(10, 6, '#', 1, 0, 'C', true);
    $pdf->Cell(15, 6, 'ID', 1, 0, 'C', true);
    $pdf->Cell(80, 6, 'Artículo', 1, 0, 'C', true);
    $pdf->Cell(25, 6, 'Código', 1, 0, 'C', true);
    $pdf->Cell(30, 6, 'Cant. Vendida', 1, 0, 'C', true);
    $pdf->Cell(35, 6, 'Total Vendido', 1, 0, 'C', true);
    $pdf->Cell(20, 6, 'N° Ventas', 1, 0, 'C', true);
    $pdf->Ln(6);
    $hay_vendidos = true;
  }
  
  $cont_vendidos++;
  $pdf->SetFont('Arial','',8);
  $pdf->SetFillColor(255, 255, 255);
  $pdf->Cell(10, 6, $cont_vendidos, 1, 0, 'C');
  $pdf->Cell(15, 6, $reg->idArticulo, 1, 0, 'C');
  $pdf->Cell(80, 6, utf8_decode(substr($reg->nombre, 0, 40)), 1, 0, 'L');
  $pdf->Cell(25, 6, utf8_decode($reg->codigo), 1, 0, 'C');
  $pdf->Cell(30, 6, number_format($reg->cantidad_vendida, 2, ',', '.'), 1, 0, 'R');
  $pdf->Cell(35, 6, number_format($reg->total_vendido, 0, ',', '.'), 1, 0, 'R');
  $pdf->Cell(20, 6, $reg->num_ventas, 1, 0, 'C');
  $pdf->Ln(6);
}
}

if ($hay_vendidos) {
  $pdf->Ln(5);
}

// ========== SECCIÓN 3: DISTRIBUCIÓN POR CATEGORÍA ==========
$rspta_cat = @ejecutarConsulta("
  SELECT 
    c.nombre as categoria,
    COUNT(a.idArticulo) as cantidad,
    SUM(COALESCE(s.cantidad, 0)) as stock_total,
    AVG(COALESCE(a.precioVenta, 0)) as precio_promedio
  FROM categoria c
  LEFT JOIN articulo a ON c.idCategoria = a.Categoria_idCategoria AND a.inactivo = 0
  LEFT JOIN stock s ON a.idArticulo = s.Articulo_idArticulo
  WHERE c.inactivo = 0
  GROUP BY c.idCategoria, c.nombre
  HAVING cantidad > 0
  ORDER BY cantidad DESC
");

$pdf->TituloSeccion('DISTRIBUCIÓN POR CATEGORÍA', array(255, 152, 0));
$pdf->SetFillColor(232, 232, 232);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(60, 6, 'Categoría', 1, 0, 'C', true);
$pdf->Cell(30, 6, 'Cant. Artículos', 1, 0, 'C', true);
$pdf->Cell(30, 6, 'Stock Total', 1, 0, 'C', true);
$pdf->Cell(40, 6, 'Precio Promedio', 1, 0, 'C', true);
$pdf->Cell(30, 6, '% del Total', 1, 0, 'C', true);
$pdf->Ln(6);

$total_cat = 0;
$categorias_array = array();
if ($rspta_cat) {
  while($reg_cat = $rspta_cat->fetchObject()) {
    $categorias_array[] = $reg_cat;
    $total_cat += $reg_cat->cantidad;
  }
}

$pdf->SetFont('Arial','',8);
foreach($categorias_array as $cat) {
  $porcentaje = $total_cat > 0 ? ($cat->cantidad / $total_cat * 100) : 0;
  $pdf->SetFillColor(255, 255, 255);
  $pdf->Cell(60, 6, utf8_decode(substr($cat->categoria, 0, 30)), 1, 0, 'L');
  $pdf->Cell(30, 6, number_format($cat->cantidad, 0, ',', '.'), 1, 0, 'R');
  $pdf->Cell(30, 6, number_format($cat->stock_total, 2, ',', '.'), 1, 0, 'R');
  $pdf->Cell(40, 6, number_format($cat->precio_promedio, 0, ',', '.'), 1, 0, 'R');
  $pdf->Cell(30, 6, number_format($porcentaje, 2, ',', '.') . '%', 1, 0, 'R');
  $pdf->Ln(6);
}
$pdf->Ln(5);

// ========== SECCIÓN 4: LISTADO COMPLETO DE ARTÍCULOS ==========
$pdf->TituloSeccion('LISTADO COMPLETO DE ARTÍCULOS', array(60, 141, 188));

// Encabezados de tabla
$pdf->SetFillColor(60, 141, 188);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(12, 6, 'ID', 1, 0, 'C', true);
$pdf->Cell(50, 6, 'Nombre', 1, 0, 'C', true);
$pdf->Cell(30, 6, 'Categoría', 1, 0, 'C', true);
$pdf->Cell(20, 6, 'Código', 1, 0, 'C', true);
$pdf->Cell(15, 6, 'Tipo', 1, 0, 'C', true);
$pdf->Cell(20, 6, 'Stock', 1, 0, 'C', true);
$pdf->Cell(25, 6, 'Precio Venta', 1, 0, 'C', true);
$pdf->Cell(25, 6, 'Valor Stock', 1, 0, 'C', true);
$pdf->Cell(20, 6, 'Proveedor', 1, 0, 'C', true);
$pdf->Cell(15, 6, 'Estado', 1, 0, 'C', true);
$pdf->Ln(6);
$pdf->SetTextColor(0, 0, 0);

// Datos de artículos (proveedor por ID para compatibilidad con cualquier BD)
$rspta = @ejecutarConsulta("
  SELECT 
    a.idArticulo,
    a.nombre,
    a.descripcion,
    a.codigo,
    a.codigoBarra,
    a.tipoArticulo,
    a.precioVenta,
    a.inactivo,
    c.nombre as categoria,
    COALESCE(SUM(s.cantidad), 0) as stock,
    a.Persona_idPersona as proveedor_id
  FROM articulo a
  LEFT JOIN categoria c ON a.Categoria_idCategoria = c.idCategoria
  LEFT JOIN stock s ON a.idArticulo = s.Articulo_idArticulo
  GROUP BY a.idArticulo, a.nombre, a.descripcion, a.codigo, a.codigoBarra, 
           a.tipoArticulo, a.precioVenta, a.inactivo, c.nombre, a.Persona_idPersona
  ORDER BY a.inactivo ASC, a.idArticulo DESC
");
if (!$rspta) {
  $rspta = ejecutarConsulta("
    SELECT a.idArticulo, a.nombre, a.descripcion, a.codigo, a.codigoBarra, a.tipoArticulo,
           a.precioVenta, a.inactivo, c.nombre as categoria,
           (SELECT COALESCE(SUM(cantidad),0) FROM stock WHERE Articulo_idArticulo = a.idArticulo) as stock,
           a.Persona_idPersona as proveedor_id
    FROM articulo a
    LEFT JOIN categoria c ON a.Categoria_idCategoria = c.idCategoria
    ORDER BY a.inactivo ASC, a.idArticulo DESC
  ");
}

$pdf->SetWidths(array(12, 50, 30, 20, 15, 20, 25, 25, 20, 15));
$pdf->SetAligns(array('C', 'L', 'L', 'C', 'C', 'R', 'R', 'R', 'L', 'C'));

$pdf->SetFont('Arial','',7);
if ($rspta) {
while($reg = $rspta->fetchObject()) {
  $nombre = utf8_decode(substr($reg->nombre, 0, 35));
  $categoria = utf8_decode(substr($reg->categoria, 0, 20));
  $codigo = utf8_decode(substr($reg->codigo, 0, 15));
  $tipo = utf8_decode($reg->tipoArticulo == 'PRODUCTO' ? 'PROD' : ($reg->tipoArticulo == 'SERVICIO' ? 'SERV' : 'INT'));
  $stock = $reg->stock ? $reg->stock : 0;
  $precio = $reg->precioVenta ? $reg->precioVenta : 0;
  $valor_stock = $stock * $precio;
  $proveedor = isset($reg->proveedor_id) && $reg->proveedor_id ? ('#'.$reg->proveedor_id) : '-';
  $estado = $reg->inactivo == 0 ? 'ACTIVO' : 'INACTIVO';
  
  // Color de fondo según estado
  if ($reg->inactivo == 1) {
    $pdf->SetFillColor(255, 200, 200);
  } else {
    $pdf->SetFillColor(255, 255, 255);
  }
  
  $pdf->Row(array(
    $reg->idArticulo,
    $nombre,
    $categoria,
    $codigo,
    $tipo,
    number_format($stock, 2, ',', '.'),
    number_format($precio, 0, ',', '.'),
    number_format($valor_stock, 0, ',', '.'),
    $proveedor,
    $estado
  ));
}
}

// ========== SECCIÓN 5: ARTÍCULOS CON BAJO STOCK ==========
$rspta_bajo = @ejecutarConsulta("
  SELECT 
    a.idArticulo,
    a.nombre,
    a.codigo,
    COALESCE(SUM(s.cantidad), 0) as stock,
    a.precioVenta
  FROM articulo a
  LEFT JOIN stock s ON a.idArticulo = s.Articulo_idArticulo
  WHERE a.inactivo = 0
  GROUP BY a.idArticulo, a.nombre, a.codigo, a.precioVenta
  HAVING stock < 10 AND stock > 0
  ORDER BY stock ASC
  LIMIT 20
");

$hay_bajo = false;
$cont_bajo = 0;
if ($rspta_bajo) {
while($reg = $rspta_bajo->fetchObject()) {
  if (!$hay_bajo) {
    $pdf->AddPage('L');
    $pdf->TituloSeccion('ARTÍCULOS CON BAJO STOCK (< 10 unidades)', array(255, 87, 34));
    $pdf->SetFillColor(232, 232, 232);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(12, 6, 'ID', 1, 0, 'C', true);
    $pdf->Cell(80, 6, 'Artículo', 1, 0, 'C', true);
    $pdf->Cell(30, 6, 'Código', 1, 0, 'C', true);
    $pdf->Cell(25, 6, 'Stock Actual', 1, 0, 'C', true);
    $pdf->Cell(30, 6, 'Precio Venta', 1, 0, 'C', true);
    $pdf->Cell(30, 6, 'Valor Stock', 1, 0, 'C', true);
    $pdf->Cell(30, 6, 'Recomendación', 1, 0, 'C', true);
    $pdf->Ln(6);
    $hay_bajo = true;
  }
  
  $cont_bajo++;
  $pdf->SetFont('Arial','',8);
  $pdf->SetFillColor(255, 255, 200);
  $recomendacion = $reg->stock == 0 ? 'URGENTE' : 'REPOSICIÓN';
  $pdf->Cell(12, 6, $reg->idArticulo, 1, 0, 'C');
  $pdf->Cell(80, 6, utf8_decode(substr($reg->nombre, 0, 40)), 1, 0, 'L');
  $pdf->Cell(30, 6, utf8_decode($reg->codigo), 1, 0, 'C');
  $pdf->Cell(25, 6, number_format($reg->stock, 2, ',', '.'), 1, 0, 'R');
  $pdf->Cell(30, 6, number_format($reg->precioVenta, 0, ',', '.'), 1, 0, 'R');
  $pdf->Cell(30, 6, number_format($reg->stock * $reg->precioVenta, 0, ',', '.'), 1, 0, 'R');
  $pdf->Cell(30, 6, utf8_decode($recomendacion), 1, 0, 'C');
  $pdf->Ln(6);
}
}

	// Mostramos el documento PDF (sin salida previa para no corromper el binario)
	if (ob_get_length()) ob_clean();
	$pdf->Output('I', 'Reporte_Articulos_' . date('Y-m-d') . '.pdf');
} catch (Throwable $e) {
	errorReporte('Error al generar el reporte: ' . $e->getMessage());
}
ob_end_flush();
?>
