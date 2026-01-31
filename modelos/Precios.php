<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Precios
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para editar registros
	public function editar($listaPrecios,$Articulo_idArticulo,$margen)
	{
		$sw=true;
		$num_elementos = 0;
		while ($num_elementos < count($margen))
		{
			$sql="call SP_ActualizarPrecios('$listaPrecios[$num_elementos]','$Articulo_idArticulo[$num_elementos]' ,'$margen[$num_elementos]');";
			ejecutarConsulta($sql) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}
		return $sw;
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function listar($GrupoPersona_idGrupoPersona, $Sucursal_idSucursal, $Persona_idPersona,$GrupoArticulo_idGrupoArticulo, $Marca_idMarca, $Categoria_idCategoria)
	{
		$sql="call SP_ListarPreciosActualizar('$GrupoPersona_idGrupoPersona', '%%', '$Persona_idPersona', '$GrupoArticulo_idGrupoArticulo', '$Marca_idMarca', '$Categoria_idCategoria')";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function actualizarTasa($tasaCambio)
	{
		$sql="call SP_ActualizarTasaCambio('$tasaCambio')";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrarTasa()
	{
		$sql="SELECT MAX(Adjust)/100 as tasa1 FROM PriceFormulaRow
		WHERE FieldName = 'T'";
		return ejecutarConsultaSimpleFila($sql);
	}


}

?>