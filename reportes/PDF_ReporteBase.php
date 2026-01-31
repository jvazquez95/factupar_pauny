<?php
/**
 * Clase base para todos los reportes PDF del sistema.
 * Muestra en cabecera: logo de la empresa cliente y datos de la empresa.
 * Muestra en pie: datos de Factupar Software con su leyenda.
 */
require_once __DIR__ . '/PDF_MC_Table.php';

class PDF_ReporteBase extends PDF_MC_Table
{
	protected $nombre_empresa;
	protected $ruc_empresa;
	protected $logo_ruta;
	protected $orientacion;

	public function __construct($orientation = '', $unit = 'mm', $size = 'A4')
	{
		parent::__construct($orientation, $unit, $size);
		$this->orientacion = $orientation;
		$this->nombre_empresa = 'Empresa';
		$this->ruc_empresa = '';
		$this->logo_ruta = '';
		// Cargar configuración de la empresa cliente (logo y datos)
		if (file_exists(__DIR__ . '/../config/Conexion.php')) {
			require_once __DIR__ . '/../config/Conexion.php';
			if (file_exists(__DIR__ . '/../modelos/ConfiguracionEmpresa.php')) {
				require_once __DIR__ . '/../modelos/ConfiguracionEmpresa.php';
				try {
					$conf = new ConfiguracionEmpresa();
					$empresa = $conf->obtener();
					if ($empresa && is_array($empresa)) {
						$this->nombre_empresa = !empty($empresa['nombre_empresa']) ? $empresa['nombre_empresa'] : 'Empresa';
						$this->ruc_empresa = !empty($empresa['ruc']) ? $empresa['ruc'] : '';
						$this->logo_ruta = !empty($empresa['logo_ruta']) ? $empresa['logo_ruta'] : '';
					}
				} catch (Exception $e) {
					// Mantener valores por defecto
				}
			}
		}
	}

	/**
	 * Cabecera: logo de la empresa cliente + nombre, RUC, fecha, usuario.
	 */
	function Header()
	{
		$logo_path = $this->logo_ruta !== '' ? __DIR__ . '/../' . $this->logo_ruta : '';
		if ($logo_path !== '' && file_exists($logo_path)) {
			$this->Image($logo_path, 10, 8, 30);
		}
		$this->SetFont('Arial', 'B', 14);
		$this->SetXY(45, 10);
		$this->Cell(0, 8, utf8_decode($this->nombre_empresa), 0, 0, 'L');
		$this->SetFont('Arial', '', 9);
		$this->SetXY(45, 18);
		if ($this->ruc_empresa !== '') {
			$this->Cell(0, 6, 'RUC: ' . $this->ruc_empresa, 0, 0, 'L');
		}
		$this->SetXY(45, 24);
		$this->Cell(0, 6, 'Fecha: ' . date('d/m/Y H:i:s'), 0, 0, 'L');
		$this->SetXY(45, 30);
		$usuario = (isset($_SESSION['login']) ? $_SESSION['login'] : 'Sistema');
		$this->Cell(0, 6, 'Usuario: ' . $usuario, 0, 0, 'L');
		$this->SetLineWidth(0.4);
		$this->Line(10, 38, $this->GetPageWidth() - 10, 38);
		$this->Ln(12);
	}

	/**
	 * Pie: página actual y leyenda de Factupar Software.
	 */
	function Footer()
	{
		$this->SetY(-18);
		$this->SetFont('Arial', 'I', 8);
		$this->SetTextColor(100, 100, 100);
		$this->Cell(0, 6, utf8_decode('Página ') . $this->PageNo() . ' / {nb}', 0, 0, 'C');
		$this->Ln(5);
		$this->SetFont('Arial', '', 7);
		$this->Cell(0, 5, utf8_decode('Desarrollado por Factupar Software - Sistema de Gestión | factupar.com.py'), 0, 0, 'C');
		$this->SetTextColor(0, 0, 0);
	}
}

