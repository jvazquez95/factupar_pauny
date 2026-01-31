<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();

Class Orden
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Empleado_idEmpleado, $fechaConsumision, $Cliente_idCliente, $paquete, $servicio, $cantidad, $cantidad_utilizada, $empleado, $fi,$ff,$sala)
	{
		$usuario = $_SESSION['login'];

		$sql="INSERT INTO `ordenconsumision`
							(
							`Empleado_idEmpleado`,
							`fechaConsumision`,
							`Cliente_idCliente`,
							`inactivo`,
							`terminado`,
							`usuarioIns`)
							VALUES
							('$Empleado_idEmpleado', '$fechaConsumision', '$Cliente_idCliente', 0, 0,'$usuario');";

		//return ejecutarConsulta($sql);

		 $idOrden=ejecutarConsulta_retornarID($sql);

		 $num_elementos=0;
		 $sw=true;

		 while ($num_elementos < count($paquete))
		 {
		 	//$comision_a_gs = ($comisionp[$num_elementos] * ) / $precioVenta[$num_elementos];
		   //$netov = ( $totalv * $impuesto[$num_elementos] ) / 100;
		 	$sql_detalle = "INSERT INTO `ordenconsumisiondetalle`(`OrdenConsumision_idOrdenConsumision`, `Articulo_idArticulo`, `Articulo_idArticulo_Servicio`, `Empleado_IdEmpleado`, `cantidad`,	`cantidadUtilizada`, `terminado`,`inactivo`,`fecha_inicial`,`fecha_final`,`sala`)
		 					VALUES	('$idOrden', '$paquete[$num_elementos]', '$servicio[$num_elementos]', '$empleado[$num_elementos]', '$cantidad[$num_elementos]', 0, 0, 0, '$fi[$num_elementos]','$ff[$num_elementos]','$sala[$num_elementos]')";
		 	ejecutarConsulta($sql_detalle) or $sw = false;
		 	$num_elementos=$num_elementos + 1;
		 }

		 return $sw;


	}

	//Implementamos un método para editar registros
	// public function editar($idArticulo, $nombre,$descripcion,$codigo,$codigoBarra,$codigoAlternativo,$tipoArticulo,$GrupoArticulo_idGrupoArticulo,$Categoria_idCategoria,$TipoImpuesto_idTipoImpuesto,$Unidad_idUnidad,$precioVenta,$usuarioModificacion,$imagen)
	// { 
	// 	$sql="UPDATE `articulo`
	// 								SET
	// 								`nombre` = '$nombre',
	// 								`descripcion` = '$descripcion',
	// 								`codigo` = '$codigo',
	// 								`codigoBarra` = '$codigoBarra',
	// 								`codigoAlternativo` = '$codigoAlternativo',
	// 								`tipoArticulo` = '$tipoArticulo',
	// 								`GrupoArticulo_idGrupoArticulo` = '$GrupoArticulo_idGrupoArticulo',
	// 								`Categoria_idCategoria` = '$Categoria_idCategoria',
	// 								`TipoImpuesto_idTipoImpuesto` = '$TipoImpuesto_idTipoImpuesto',
	// 								`Unidad_idUnidad` = '$Unidad_idUnidad',
	// 								`precioVenta` = '$precioVenta',
	// 								`fechaModificacion` = now(),
	// 								`usuarioModificacion` = 'jvazquez',
	// 								`imagen` = '$imagen'
	// 								WHERE `idArticulo` = '$idArticulo';
	// 								";
	// 	return ejecutarConsulta($sql);
	// }

	//Implementamos un método para desactivar registros
	public function desactivar($idOrdenConsumision)
	{
		$sql="UPDATE ordenConsumision SET inactivo='1' WHERE idOrdenConsumision='$idOrdenConsumision'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idArticulo)
	{
		$sql="UPDATE articulo SET inactivo='0' WHERE idArticulo='$idArticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idArticulo)
	{
		$sql="SELECT * FROM articulo WHERE idArticulo='$idArticulo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT *, ordenconsumision.inactivo as estado,
cliente.nombreComercial as nc, DATE_FORMAT((select fecha_inicial from ordenconsumisiondetalle where OrdenConsumision_idOrdenConsumision = idOrdenConsumision limit 1), '%d/%m/%Y %hh %mm %ss') as fechaInicial
FROM ordenconsumision, cliente 
where cliente.idCliente = ordenconsumision.Cliente_idCliente order by 1 desc;";
		return ejecutarConsulta($sql);		
	}


	function listarDetalle($id){

		$sql = "SELECT DATE_FORMAT(fecha_final, '%d/%m/%Y %hh %mm %ss') as fecha_final,DATE_FORMAT(fecha_inicial, '%d/%m/%Y %hh %mm %ss') as fecha_inicial, OrdenConsumision_idOrdenConsumision as id, ordenconsumisiondetalle.idOrdenConsumisionDetalle as id2,
		F_NOMBRE_ARTICULO(ordenconsumisiondetalle.Articulo_idARticulo) as paquete, 
		F_NOMBRE_SERVICIO(clientedetalle.Articulo_idArticulo_Servicio) as servicio, 
		empleado.nombreComercial ne, ordenconsumisiondetalle.cantidad, cantidadUtilizada,
		ordenconsumisiondetalle.inactivo as inactivo
		from ordenconsumisiondetalle, empleado, clientedetalle
		where ordenconsumisiondetalle.Empleado_IdEmpleado = empleado.idEmpleado and ordenconsumisiondetalle.OrdenConsumision_idOrdenConsumision = '$id' and clientedetalle.idclientedetalle = ordenconsumisiondetalle.Articulo_idArticulo_Servicio;"; 

		return ejecutarConsulta($sql);		


	}


	//Implementar un método para listar los registros
	public function listar_reporte()
	{
		$sql="SELECT *,articulo.nombre as na, categoria.nombre as nc  FROM articulo, categoria, stock where articulo.Categoria_idCategoria = categoria.idCategoria and articulo.idArticulo = stock.Articulo_idArticulo";

		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros activos
	public function listarActivos()
	{
		$sql="SELECT * FROM articulo WHERE inactivo=0";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_ingreso)
	public function listarActivosCompra()
	{
		$sql="SELECT *,Articulo.nombre as na, Articulo.descripcion as ad , categoria.nombre as cn, TipoImpuesto.porcentajeImpuesto as pi FROM articulo, categoria, TipoImpuesto WHERE articulo.Categoria_idCategoria = categoria.idCAtegoria and articulo.TipoImpuesto_idTipoImpuesto = TipoImpuesto.idTipoImpuesto";
		return ejecutarConsulta($sql);		
	}


	public function listarActivosVenta()
	{
		$sql="SELECT *,Articulo.nombre as na, Articulo.descripcion as ad , categoria.nombre as cn, TipoImpuesto.porcentajeImpuesto as pi FROM articulo, categoria, TipoImpuesto WHERE articulo.Categoria_idCategoria = categoria.idCAtegoria and articulo.TipoImpuesto_idTipoImpuesto = TipoImpuesto.idTipoImpuesto";
		return ejecutarConsulta($sql);		
	}

	public function listarServicios()
	{
		$sql="SELECT clientedetalle.idclientedetalle as id, cliente.idCliente as idClientep, razonSocial, nroDocumento, celular, Articulo_idArticulo_Servicio, articulo.descripcion AS SERVICIO , Articulo_idArticulo, F_NOMBRE_ARTICULO(Articulo_idArticulo) AS PAQUETE, clientedetalle.cantidad
			from clientedetalle, cliente, articulo
			where clientedetalle.Cliente_idCliente = cliente.idCliente and
			articulo.idArticulo = clientedetalle.Articulo_idArticulo and cliente.idCliente = 1 and Articulo_idArticulo";
		return ejecutarConsulta($sql);		
	}
	public function listarServiciosCliente($lcliente)
	{
		$sql="SELECT *, clientedetalle.idclientedetalle as id, Cliente_idCliente as idCliente, razonSocial, nroDocumento, celular, Articulo_idArticulo_Servicio, articulo.nombre AS NS, cantidad 
			from clientedetalle, cliente, articulo 
			where Articulo_idArticulo = 0 and 
			clientedetalle.Cliente_idCliente = cliente.idCliente and 
			Articulo_idArticulo_Servicio = articulo.idArticulo and Cliente_idCliente = '$lcliente' and clientedetalle.inactivo = 0 and cantidad > 0";
		return ejecutarConsulta($sql);
	}


	public function listarServiciosClientePaquete($lcliente,$lpaquete)
	{
		$sql="SELECT *, F_NOMBRE_SERVICIO(Articulo_idArticulo_Servicio) AS NNN, clientedetalle.idclientedetalle as id, cliente.idCliente as idClientep, razonSocial, nroDocumento, celular, Articulo_idArticulo_Servicio, articulo.descripcion AS SERVICIO , Articulo_idArticulo, F_NOMBRE_ARTICULO(Articulo_idArticulo) AS PAQUETE, clientedetalle.cantidad
from clientedetalle, cliente, articulo
where clientedetalle.Cliente_idCliente = cliente.idCliente and
articulo.idArticulo = clientedetalle.Articulo_idArticulo and cliente.idCliente = '$lcliente' and Articulo_idArticulo = '$lpaquete' and clientedetalle.inactivo = 0 and clientedetalle.cantidad > 0";
		return ejecutarConsulta($sql);
	}

	public function listarPaquetes()
	{
		$sql="SELECT clientedetalle.idclientedetalle as id, cliente.idCliente as idClientep, razonSocial, nroDocumento, celular, Articulo_idArticulo_Servicio, articulo.descripcion AS SERVICIO , Articulo_idArticulo, F_NOMBRE_ARTICULO(Articulo_idArticulo) AS PAQUETE, clientedetalle.cantidad
			from clientedetalle, cliente, articulo
			where clientedetalle.Cliente_idCliente = cliente.idCliente and
			articulo.idArticulo = clientedetalle.Articulo_idArticulo and cliente.idCliente = 1 and Articulo_idArticulo group by Articulo_idArticulo";
		return ejecutarConsulta($sql);		
	}

	public function listarPaquetesCliente($lcliente)
	{
		$sql="SELECT clientedetalle.idclientedetalle as id, cliente.idCliente as idClientep, razonSocial, nroDocumento, celular, Articulo_idArticulo_Servicio, articulo.descripcion AS SERVICIO , Articulo_idArticulo, F_NOMBRE_ARTICULO(Articulo_idArticulo) AS PAQUETE, clientedetalle.cantidad
			from clientedetalle, cliente, articulo
			where clientedetalle.Cliente_idCliente = cliente.idCliente and
			articulo.idArticulo = clientedetalle.Articulo_idArticulo and cliente.idCliente = '$lcliente' and clientedetalle.inactivo = 0 and clientedetalle.cantidad > 0 group by Articulo_idArticulo;";
		return ejecutarConsulta($sql);
	
	}
	


	public function calendario($fi,$ff,$sala)
	{
		$sql="SELECT *, 
		F_NOMBRE_CLIENTE(clientedetalle.Cliente_idCliente) AS nc,
		F_NOMBRE_ARTICULO(ordenconsumisiondetalle.Articulo_idArticulo) as na, 
		F_NOMBRE_SERVICIO(clientedetalle.Articulo_idArticulo_Servicio) as ns 
		from ordenconsumisiondetalle, clientedetalle
		where 
		clientedetalle.idclientedetalle = ordenconsumisiondetalle.Articulo_idArticulo_Servicio and
		date(fecha_inicial) between '$fi' and '$ff' 
		and sala like '%%';";
		return ejecutarConsulta($sql);
	}


}

?>