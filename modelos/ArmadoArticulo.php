<?php 
//Incluímos inicialmente la conexión a la base de datos 
require "../config/Conexion.php";

Class ArmadoArticulo
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
		$Articulo_idArticulo1,
		$Articulo_idArticulo,
		$cantidad,
		$costo,
		$subtotal
		){ 
		session_start();
		$usuario = $_SESSION['login'];

		$sql="
			INSERT INTO `armadoArticulo`
			(`Deposito_IdDeposito`,
			`usuario`,
			`comentario`,
			`fechaTransaccion`,
			`costoTotal`,
			`cantidadTotal`,
			`usuarioInsercion`,
			`Articulo_idArticulo`,
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
			'$Articulo_idArticulo1[0]',  
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


				$sql_detalle = "INSERT INTO `armadoarticulodetalle`
				(`ArmadoArticulo_idArmadoArticulo`,
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


				$sql_detalle = "INSERT INTO `armadoarticulodetalle`
				(`ArmadoArticulo_idArmadoArticulo`,
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
	public function editar($idArmadoArticulo,
	$Deposito_IdDeposito,
	$comentario, $nombre)  
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="UPDATE armadoArticulo SET  Deposito_IdDeposito='$Deposito_IdDeposito', comentario='$comentario', fechaModificacion = now(), usuarioModificacion='$usuario' WHERE idArmadoArticulo='$idArmadoArticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function activar($idArmadoArticulo)
	{
		$sql="UPDATE armadoArticulo set inactivo = 0 WHERE idArmadoArticulo='$idArmadoArticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function desactivar($idArmadoArticulo)
	{
		$sql="UPDATE armadoArticulo set inactivo = 1 WHERE idArmadoArticulo='$idArmadoArticulo'";
		return ejecutarConsulta($sql);
	}

	public function desactivarDetalle($idArmadoArticuloDetalle)
	{
		$sql="UPDATE armadoarticulodetalle set inactivo = 1 WHERE idArmadoArticuloDetalle='$idArmadoArticuloDetalle'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idArmadoArticulo)
	{
		$sql="SELECT * FROM armadoArticulo WHERE idArmadoArticulo='$idArmadoArticulo'";
		return ejecutarConsultaSimpleFila($sql);
	}


	public function listarDetalle($idArmadoArticulo)
	{
	

		$sql="SELECT *, F_NOMBRE_ARTICULO(Articulo_idArticulo) as na from armadoarticulodetalle where ArmadoArticulo_idArmadoArticulo = '$idArmadoArticulo' and inactivo = 0";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idArmadoArticulo ,a.fechaTransaccion,a.cantidadTotal,a.costoTotal,a.comentario,a.inactivo
			from armadoArticulo a  ";
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