<?php 
//Incluímos inicialmente la conexión a la base de datos 
require "../config/Conexion.php";

Class Produccion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	} 

	//Implementamos un método para insertar registros
	public function insertar(
		$Deposito_IdDeposito,
		$comentario,
		$fechaTransaccion,
		$costoTotal,
		$cantidadTotal,
		$nombre,
		
		$Articulo_idArticulo,
		$cantidad,
		$costo,
		$subtotal
		){ 
		session_start();
		$usuario = $_SESSION['login'];

		$sql="
			INSERT INTO `produccion`
			(`Deposito_IdDeposito`,
			`usuario`,
			`comentario`,
			`fechaTransaccion`,
			`costoTotal`,
			`cantidadTotal`,
			`usuarioInsercion`,
			`inactivo`,  
			`nombre`)  
			VALUES
			(
			'$Deposito_IdDeposito', 
			'$usuario',
			'$comentario',
			now(),
			'$costoTotal',
			'$cantidadTotal',
			'$usuario',    
			0, 
			'$nombre'
			)";


		$nuevoId = ejecutarConsulta_retornarID($sql);
		$num_elementosTipoPersona=0;
		$sw=true; 
		$ultimo = count($Articulo_idArticulo) - 1;
		
		while ($num_elementosTipoPersona < count($Articulo_idArticulo))
		{


			if ($num_elementosTipoPersona == $ultimo) {


				$sql_detalle = "INSERT INTO `producciondetalle`
				(`Produccion_idProduccion`,
				`Articulo_idArticulo`,
				`cantidad`,
				`costo`,
				`subtotal`,
				`inactivo`,
				`Deposito_IdDeposito`,
				`ultimo`
				) 
				VALUES 
				(
				'$nuevoId',
				'$Articulo_idArticulo[$num_elementosTipoPersona]',
				'$cantidad[$num_elementosTipoPersona]',
				'$costo[$num_elementosTipoPersona]',
				'$subtotal[$num_elementosTipoPersona]',
				0,
				'$Deposito_IdDeposito',
				1
				)"; 

				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementosTipoPersona=$num_elementosTipoPersona + 1;				
			}else{


				$sql_detalle = "INSERT INTO `producciondetalle`
				(`Produccion_idProduccion`,
				`Articulo_idArticulo`,
				`cantidad`,
				`costo`,
				`subtotal`,
				`inactivo`,
				`Deposito_IdDeposito`,
				`ultimo`
				) 
				VALUES 
				(
				'$nuevoId',
				'$Articulo_idArticulo[$num_elementosTipoPersona]',
				'$cantidad[$num_elementosTipoPersona]',
				'$costo[$num_elementosTipoPersona]',
				'$subtotal[$num_elementosTipoPersona]',
				0,
				'$Deposito_IdDeposito',
				0
				)"; 

				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementosTipoPersona=$num_elementosTipoPersona + 1;

			}

		}

		return $sw;

	}

	//Implementamos un método para editar registros
	public function editar($idProduccion,
	$Deposito_IdDeposito,
	$comentario, $nombre)  
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="UPDATE produccion SET  Deposito_IdDeposito='$Deposito_IdDeposito', comentario='$comentario', fechaModificacion = now(), usuarioModificacion='$usuario' WHERE idProduccion='$idProduccion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function activar($idProduccion)
	{
		$sql="UPDATE produccion set inactivo = 0 WHERE idProduccion='$idProduccion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function desactivar($idProduccion)
	{
		$sql="UPDATE produccion set inactivo = 1 WHERE idProduccion='$idProduccion'";
		return ejecutarConsulta($sql);
	}

	public function desactivarDetalle($idProduccionDetalle)
	{
		$sql="UPDATE producciondetalle set inactivo = 1 WHERE idProduccionDetalle='$idProduccionDetalle'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idProduccion)
	{
		$sql="SELECT * FROM produccion WHERE idProduccion='$idProduccion'";
		return ejecutarConsultaSimpleFila($sql);
	}


	public function listarDetalle($idProduccion)
	{
	

		$sql="SELECT *, F_NOMBRE_ARTICULO(Articulo_idArticulo) as na from producciondetalle where Produccion_idProduccion = '$idProduccion' and inactivo = 0";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idProduccion,a.comentario as nombre,b.descripcion,a.fechaTransaccion,a.cantidadTotal,a.costoTotal,a.inactivo
			from produccion a, deposito b
			where a.Deposito_IdDeposito=b.idDeposito";
		return ejecutarConsulta($sql);		 
	}

	public function selectDeposito()
	{
		$sql="SELECT * from deposito";
		return ejecutarConsulta($sql);		
	}

	public function selectArticulo() 
	{
		$sql="SELECT * from articulo"; 
		return ejecutarConsulta($sql);		
	}

}

?>