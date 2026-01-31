<?php 
//Incluímos inicialmente la conexión a la base de datos 
require "../config/Conexion.php";

Class AjusteStock
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
		$Direccion_idDireccion,
		$Cliente_idCliente,
		$imagen,
		$compromisoVenta,
		$Articulo_idArticulo,
		$cantidad,
		$costo,
		$subtotal
		){ 
		session_start();
		$usuario = $_SESSION['login'];

		$sql="
			INSERT INTO `comodato`
			(`Deposito_IdDeposito`,
			`usuario`,
			`comentario`,
			`fechaTransaccion`,
			`costoTotal`,
			`cantidadTotal`,
			`usuarioInsercion`,
			`inactivo`,  
			`nombre`,
			`Direccion_idDireccion`,
			`Cliente_idCliente`,
			`imagen`,
			`compromisoVenta`)  
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
			'$nombre',
			'$Direccion_idDireccion',
			'$Cliente_idCliente',
			'$imagen',
			'$compromisoVenta' 
			)"; 


		$nuevoId = ejecutarConsulta_retornarID($sql);
		$num_elementosTipoPersona=0;
		$sw=true; 
		$ultimo = count($Articulo_idArticulo) - 1;
		
		while ($num_elementosTipoPersona < count($Articulo_idArticulo))
		{


			if ($num_elementosTipoPersona == $ultimo) {


				$sql_detalle = "INSERT INTO `comodatodetalle`
				(`Comodato_idComodato`,
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


				$sql_detalle = "INSERT INTO `comodatodetalle`
				(`Comodato_idComodato`,
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
	public function editar($idComodato,
	$Deposito_IdDeposito,
	$comentario, $nombre, $compromisoVenta)  
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="UPDATE comodato SET  Deposito_IdDeposito='$Deposito_IdDeposito', comentario='$comentario', fechaModificacion = now(), usuarioModificacion='$usuario', compromisoVenta = '$compromisoVenta' WHERE idComodato='$idComodato'";
		return ejecutarConsulta($sql);
	}
	
	//Implementamos un método para enviar a transito 
	public function enviarTransito($idComodato) 
	{
		$sql="UPDATE comodato set estado = 2 WHERE idComodato='$idComodato' and estado=0 and inactivo=0";
		return ejecutarConsulta($sql);  
	}

	//Implementamos un método para eliminar categorías
	public function activar($idComodato)
	{
		$sql="UPDATE comodato set inactivo = 0 WHERE idComodato='$idComodato'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function desactivar($idComodato)
	{
		$sql="UPDATE comodato set inactivo = 1 , estado = 3 WHERE idComodato='$idComodato' and estado= 2";
		return ejecutarConsulta($sql);
	}

	public function desactivarDetalle($idComodatoDetalle)
	{
		$sql="UPDATE comodatodetalle set inactivo = 1 WHERE idComodatoDetalle='$idComodatoDetalle'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idComodato)
	{
		$sql="SELECT * FROM comodato WHERE idComodato='$idComodato'";
		return ejecutarConsultaSimpleFila($sql);
	}


	public function listarDetalle($idComodato)
	{
	

		$sql="SELECT *, F_NOMBRE_ARTICULO(Articulo_idArticulo) as na from comodatodetalle where Comodato_idComodato = '$idComodato' and inactivo = 0";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idComodato,b.descripcion,a.fechaTransaccion,c.direccion,c.razonSocial, a.compromisoVenta,
			(case when a.estado=0 then 'Ingresado' 
				  when a.estado=1 then 'Pre-Aprobado'
				  when a.estado=2 then 'Confirmado' 
				  when a.estado=3 then 'Anulado' 
				  end) as estado_descripcion
			from comodato a, deposito b , persona c, direccion d
			where a.Deposito_IdDeposito=b.idDeposito and c.idPersona= a.Cliente_idCliente and c.idPersona=d.Persona_idPersona
			and a.Direccion_idDireccion = d.idDireccion"; 
		return ejecutarConsulta($sql);		 
	}

	public function selectDeposito()
	{
		$sql="SELECT * from deposito where inactivo=0";
		return ejecutarConsulta($sql);		
	}

	public function selectArticulo() 
	{
		$sql="SELECT * from articulo"; 
		return ejecutarConsulta($sql);		
	}

}

?>