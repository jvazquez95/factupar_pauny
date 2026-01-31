<?php 
require_once "../modelos/DocumentoCajero.php";

$documentoCajero=new DocumentoCajero();

$idDocumentoCajero=isset($_POST["idDocumentoCajero"])? limpiarCadena($_POST["idDocumentoCajero"]):"";
$Documento_idTipoDocumento=isset($_POST["Documento_idTipoDocumento"])? limpiarCadena($_POST["Documento_idTipoDocumento"]):"";
$Usuario_idUsuario=isset($_POST["Usuario_idUsuario"])? limpiarCadena($_POST["Usuario_idUsuario"]):"";
$numeroInicial=isset($_POST["numeroInicial"])? limpiarCadena($_POST["numeroInicial"]):"";
$numeroFinal=isset($_POST["numeroFinal"])? limpiarCadena($_POST["numeroFinal"]):"";
$numeroActual=isset($_POST["numeroActual"])? limpiarCadena($_POST["numeroActual"]):"";
$fechaEntrega=isset($_POST["fechaEntrega"])? limpiarCadena($_POST["fechaEntrega"]):"";
$serie=isset($_POST["serie"])? limpiarCadena($_POST["serie"]):"";
$timbrado=isset($_POST["timbrado"])? limpiarCadena($_POST["timbrado"]):"";
$nroAutorizacion=isset($_POST["nroAutorizacion"])? limpiarCadena($_POST["nroAutorizacion"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idDocumentoCajero)){
			$rspta=$documentoCajero->insertar($Documento_idTipoDocumento,$Usuario_idUsuario,$numeroInicial,$numeroFinal,$numeroActual,$fechaEntrega,$serie,$timbrado, $nroAutorizacion);
			echo $rspta ? "Categoría registrada" : "Categoría no se pudo registrar";
		}
		else {
			$rspta=$documentoCajero->editar($idDocumentoCajero,$Documento_idTipoDocumento,$Usuario_idUsuario,$numeroInicial,$numeroFinal,$numeroActual,$fechaEntrega,$serie,$timbrado, $nroAutorizacion);
			echo $rspta ? "Categoría actualizada" : "Categoría no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$documentoCajero->desactivar($idDocumentoCajero);
 		echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
	break;

	case 'activar':
		$rspta=$documentoCajero->activar($idDocumentoCajero);
 		echo $rspta ? "Categoría activada" : "Categoría no se puede activar";
	break;

	case 'mostrar':
		$rspta=$documentoCajero->mostrar($idDocumentoCajero);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$documentoCajero->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->i)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idDocumentoCajero.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idDocumentoCajero.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idDocumentoCajero.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idDocumentoCajero.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->idDocumentoCajero,
 				"2"=>$reg->td,
 				"3"=>$reg->nu,
 				"4"=>$reg->numeroInicial,
 				"5"=>$reg->numeroFinal,
 				"6"=>$reg->numeroActual,
 				"7"=>$reg->fechaEntrega,
 				"8"=>$reg->serie,
 				"9"=>$reg->timbrado,
 				"10"=>$reg->nroAutorizacion,
 				"11"=>(!$reg->i)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "selectUsuario":
		require_once "../modelos/Usuario.php";
		$usuario = new Usuario();

		$rspta = $usuario->selectUsuario();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idusuario . '>' . $reg->nombre . '</option>';
				}
	break;

	case "selectTipoDocumento":
		require_once "../modelos/TipoDocumento.php";
		$tipo = new TipoDocumento();

		$rspta = $tipo->select();

		while ($reg = $rspta->fetchObject())
				{
					echo '<option value=' . $reg->idTipoDocumento . '>' . $reg->descripcion . '</option>';
				}
	break;

}
?>