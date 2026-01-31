<?php 
require_once "../modelos/ArmadoArticulo.php";

$armadoArticulo=new ArmadoArticulo();  

$Deposito_IdDeposito=isset($_POST["Deposito_IdDeposito"])? limpiarCadena($_POST["Deposito_IdDeposito"]):"";
$comentario=isset($_POST["comentario"])? limpiarCadena($_POST["comentario"]):"";
$fechaTransaccion=isset($_POST["fechaTransaccion"])? limpiarCadena($_POST["fechaTransaccion"]):"";
$costoTotal=isset($_POST["costoTotal"])? limpiarCadena($_POST["costoTotal"]):"";
$cantidadTotal=isset($_POST["cantidadTotal"])? limpiarCadena($_POST["cantidadTotal"]):"";
$idArmadoArticulo=isset($_POST["idArmadoArticulo"])? limpiarCadena($_POST["idArmadoArticulo"]):"";
$idArmadoArticuloDetalle=isset($_POST["idArmadoArticuloDetalle"])? limpiarCadena($_POST["idArmadoArticuloDetalle"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idArmadoArticulo)){
			$rspta=$armadoArticulo->insertar(
				$Deposito_IdDeposito,
				$comentario,
				$fechaTransaccion,
				$costoTotal,
				$cantidadTotal, 
				$nombre, 
				$_POST["Articulo_idArticulo1"],			
				$_POST["Articulo_idArticulo"],
				$_POST["cantidad"],
				$_POST["costo"],
				$_POST["subtotal"]
			);
			echo $rspta ? "Armado registrado" : "Armado no se pudo registrar";
		} 
		else {
			$rspta=$armadoArticulo->editar($idArmadoArticulo,	$Deposito_IdDeposito, $comentario, $nombre) ;
			echo $rspta ? "Armado actualizado" : "Armado no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$armadoArticulo->desactivar($idArmadoArticulo);
 		echo $rspta ? "Armado Desactivado" : "Armado no se puede desactivar";
	break;

	case 'desactivarDetalle':
		$rspta=$armadoArticulo->desactivarDetalle($idArmadoArticuloDetalle);
 		echo $rspta ? "Armado Desactivado" : "Armado no se puede desactivar";
	break;


	case 'activar':
		$rspta=$armadoArticulo->activar($idArmadoArticulo);
 		echo $rspta ? "Armado activado" : "Armado no se puede activar";
	break;

	case 'mostrar':
		$rspta=$armadoArticulo->mostrar($idArmadoArticulo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;



	case 'listarDetalle':
		//Recibimos el idingreso
		$idArmadoArticulo=$_GET['idArmadoArticulo'];

				$rspta = $armadoArticulo->listarDetalle($idArmadoArticulo);
						echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Articulo</th>
                                    <th>Cantidad</th>
				                </thead>';
				        $contT = 0;
						while ($reg = $rspta->fetchObject())
								{
									echo '<tr class="filaT tb_existente" id="filaT'.$contT.'">
									<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleArmadoArticulo(\''.$contT.'\',\''.$reg->idArmadoArticuloDetalle.'\')">X</button></td>
									<td><input type="hidden" name="Articulo_idArticulo[]"  value="'.$reg->Articulo_idArticulo.'">'.$reg->na.'</td>
									</td><td><input type="text" name="cantidad[]" readonly  value="'.$reg->cantidad.'"></td>
									</td>';
									$contT++;															}
					echo 	'<tfoot>
                                    <th>Opciones</th>
                                    <th>Tipo de Telefono</th>
                                    <th>Telefono</th>
                                </tfoot>';

	break;



	case 'listarp':
		$rspta=$armadoArticulo->listarp();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array( 
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idArmadoArticulo.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idArmadoArticulo.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idArmadoArticulo.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idArmadoArticulo.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->descripcion,
 				"2"=>$reg->fechaTransaccion,
 				"3"=>$reg->cantidadTotal,
 				"4"=>$reg->costoTotal,
 				(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case 'listar':
		$rspta=$armadoArticulo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>(!$reg->inactivo)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idArmadoArticulo.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idArmadoArticulo.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idArmadoArticulo.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idArmadoArticulo.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->fechaTransaccion,
 				"2"=>$reg->comentario,
 				(!$reg->inactivo)?'<span class="label bg-green">Activado</span>':
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

	case "selectDeposito":

		$rspta = $armadoArticulo->selectDeposito();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idDeposito. '>' .$reg->descripcion. '</option>';
		}

		break; 
 

	case "selectArticulo":

		$rspta = $armadoArticulo->selectArticulo();

		while ($reg = $rspta->fetchObject()) {
			echo '<option value=' .$reg->idArticulo. '>' .$reg->nombre. '</option>';
		}

		break;  
 

}
?>