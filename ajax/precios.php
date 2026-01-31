<?php 
require_once "../modelos/Precios.php";


$precios=new Precios();

 $tasaCambio=isset($_POST["tasaCambio"])? limpiarCadena($_POST["tasaCambio"]):"";
// $preciosFacturacion=isset($_POST["preciosFacturacion"])? limpiarCadena($_POST["preciosFacturacion"]):"";
// $sucursal=isset($_POST["porcentaje"])? limpiarCadena($_POST["porcentaje"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
			$rspta=$precios->editar($_POST["listaPrecios"],$_POST["Articulo_idArticulo"],$_POST["margen"]);
			echo $rspta ? "Se actualizo" : "No se pudo actualizar";
	break;


	case 'listar':
		$GrupoPersona_idGrupoPersona = $_REQUEST['GrupoPersona_idGrupoPersona'];
		$Sucursal_idSucursal = $_REQUEST['Sucursal_idSucursal'];
		$Persona_idPersona = $_REQUEST['Persona_idPersona'];
		$GrupoArticulo_idGrupoArticulo = $_REQUEST['GrupoArticulo_idGrupoArticulo'];
		$Marca_idMarca = $_REQUEST['Marca_idMarca'];
		$Categoria_idCategoria = $_REQUEST['Categoria_idCategoria'];
		$rspta=$precios->listar($GrupoPersona_idGrupoPersona, $Sucursal_idSucursal, $Persona_idPersona,$GrupoArticulo_idGrupoArticulo, $Marca_idMarca, $Categoria_idCategoria);
 		//Vamos a declarar un array
 		$data= Array();                                                                               //  id="TMax'.$reg->internalId.'"
 		$numero = 0;
 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
				"0"=>'<input class="form-control input-sm" type="text" name="listaPrecios[] id="listaPrecios[]" value="'.$reg->listaPrecios.'" readonly>',
 				"1"=>'<input class="form-control input-sm" type="text" name="Articulo_idArticulo[] id="Articulo_idArticulo[]" value="'.$reg->Articulo_idArticulo.'" readonly>',
				"2"=>'<input class="form-control input-sm" type="text" name="descripcion[] id="descripcion[]" value="'.$reg->descripcion.'" readonly>',
 				"3"=>'<input class="form-control input-sm" type="number" onfocus="ajuste(this)" onblur="actualizarIndividual(this)" name="1margen[]" id="1margen'.$numero.'" value="'.$reg->margen.'" readonly>',
 				"4"=>'<input class="form-control input-sm" type="number" onfocus="ajuste(this)" onblur="actualizarIndividual(this)" name="margen[]" id="margen'.$numero.'" value="'.$reg->margen.'" >',
 				//"3"=>'<input class="form-control input-sm" type="number" onfocus="ajuste(this)" onblur="actualizarIndividual(this)" name="1B[]" id="1B'.$numero.'" value="'.$reg->B.'" readonly>',
 				//"4"=>'<input class="form-control input-sm" type="number" onfocus="ajuste(this)" onblur="actualizarIndividual(this)" name="B[]" id="B'.$numero.'" value="'.$reg->B.'">',
 				//"5"=>'<input class="form-control input-sm" type="number" onfocus="ajuste(this)" onblur="actualizarIndividual(this)" name="1C[]" id="1C'.$numero.'" value="'.$reg->C.'" readonly>',
 				//"6"=>'<input class="form-control input-sm" type="number" onfocus="ajuste(this)" onblur="actualizarIndividual(this)" name="C[]" id="C'.$numero.'" value="'.$reg->C.'">',
 				//"7"=>'<input class="form-control input-sm" type="number" onfocus="ajuste(this)" onblur="actualizarIndividual(this)" name="1D[]" id="1D'.$numero.'" value="'.$reg->D.'" readonly>',
 				//"8"=>'<input class="form-control input-sm" type="number" onfocus="ajuste(this)" onblur="actualizarIndividual(this)" name="D[]" id="D'.$numero.'" value="'.$reg->D.'">',
 				"5"=>'<input class="form-control input-sm" type="number" name="P[]" id="P[]" value="'. ($reg->margen) .'" readonly>',
 				//"10"=>'<input class="form-control input-sm" type="number" name="1A[]" id="1A'.$numero.'" value="'.$reg->A.'">',
 				//"11"=>'<input class="form-control input-sm" type="number" name="1B[]" id="1B'.$numero.'" value="'.$reg->B.'">',
 				//"12"=>'<input class="form-control input-sm" type="number" name="1C[]" id="1C'.$numero.'" value="'.$reg->C.'">',
 				//"13"=>'<input class="form-control input-sm" type="number" name="1D[]" id="1D'.$numero.'" value="'.$reg->D.'">',
 				//"14"=>'<input class="form-control input-sm" type="hidden" name="Grupo[]" id="Grupo[]" value="'. $reg->Grupo .'>',
 				);
 		$numero++;
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'actualizarTasa':
		$rspta=$precios->actualizarTasa($tasaCambio);
 		echo $rspta ? "actualizado" : "no se actualizo";
	break;

	case 'mostrarTasa':
		$rspta=$precios->mostrarTasa();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


}
?>