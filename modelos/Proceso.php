<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Proceso
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Persona_idPersonaProveedor,$ano,$Persona_idPersonaDirectivo1,$cargo1,$Persona_idPersonaDirectivo2,$cargo2,$rucContador,$Proceso_idProcesoApertura,$fechaEjecucion,$Asiento_idAsientoCierre,$fechaCierre)
	{
		session_start();
		$usuario = $_SESSION['login'];
		$sql="INSERT INTO 
		`proceso`(`Persona_idPersonaProveedor`,`ano`,`Persona_idPersonaDirectivo1`,`cargo1`,`Persona_idPersonaDirectivo2`,`cargo2`,`rucContador`,`Proceso_idProcesoApertura`,`fechaEjecucion`,`Asiento_idAsientoCierre`,`fechaCierre`,`usuarioInsercion`,`fechaInsercion`,`inactivo`)
		VALUES ('$Persona_idPersonaProveedor','$ano','$Persona_idPersonaDirectivo1','$cargo1','$Persona_idPersonaDirectivo2','$cargo2','$rucContador','$Proceso_idProcesoApertura','$fechaEjecucion','$Asiento_idAsientoCierre','$fechaCierre','$usuario',now(),0)";


		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idProceso,$Persona_idPersonaProveedor,$ano,$Persona_idPersonaDirectivo1,$cargo1,$Persona_idPersonaDirectivo2,$cargo2,$rucContador,$Proceso_idProcesoApertura,$fechaEjecucion,$Asiento_idAsientoCierre,$fechaCierre)
	{ 
		session_start();
		$usuario = $_SESSION['login'];		
		$sql="UPDATE `proceso` SET `Persona_idPersonaProveedor`='$Persona_idPersonaProveedor',`ano`='$ano',`Persona_idPersonaDirectivo1`='$Persona_idPersonaDirectivo1',`cargo1`='$cargo1',`Persona_idPersonaDirectivo2`='$Persona_idPersonaDirectivo2',`cargo2`='$cargo2',`rucContador`='$rucContador',`Proceso_idProcesoApertura`='$Proceso_idProcesoApertura',`fechaEjecucion`='$fechaEjecucion',`Asiento_idAsientoCierre`='$Asiento_idAsientoCierre',`fechaCierre`='$fechaCierre',`usuarioModificacion`='$usuario',`fechaModificacion`= now()
		WHERE idProceso = '$idProceso'"; 
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idProceso)
	{
		$sql="UPDATE proceso SET inactivo='1' WHERE idProceso='$idProceso'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idProceso)
	{
		$sql="UPDATE proceso SET inactivo='0' WHERE idProceso='$idProceso'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idProceso)
	{
		$sql="SELECT * FROM proceso WHERE idProceso='$idProceso'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		/*$sql="SELECT a.idProceso,a.ano,a.rucContador,a.Proceso_idProcesoApertura as procesoApertura,a.fechaCierre,a.fechaEjecucion,f.idAsiento as AsientoCierre,a.inactivo
			  from proceso a, persona b, persona c, persona d, proceso e, asiento f
			  where a.Persona_idPersonaProveedor = b.idPersona and a.Persona_idPersonaDirectivo1 = c.idPersona and a.Persona_idPersonaDirectivo2 = d.idPersona
				and a.Proceso_idProcesoApertura = e.idProceso and a.Asiento_idAsientoCierre = f.idAsiento";
		return ejecutarConsulta($sql);		*/
		$sql="SELECT *
			  from proceso 
			  where IFNULL(inactivo,0) = 0";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
/*	public function listar_reporte()
	{
		$sql="SELECT *,articulo.nombre as na, categoria.nombre as nc FROM stock,articulo, categoria where articulo.Categoria_idCategoria = categoria.Categoria_idCategoria and stock.Articulo_idArticulo = articulo.idArticulo";
		return ejecutarConsulta($sql);		
	}*/

	//Implementar un método para listar los registros activos
	public function listarActivos()
	{
		$sql="SELECT * FROM proceso";
		return ejecutarConsulta($sql);		
	}

}

?>