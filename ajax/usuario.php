<?php
session_start(); 
require_once "../modelos/Usuario.php";

$usuario=new Usuario();

$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$cargo=isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$Empleado_idEmpleado=isset($_POST["Empleado_idEmpleado"])? limpiarCadena($_POST["Empleado_idEmpleado"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
			}
		}
		//Hash SHA256 en la contraseña (en edición, si viene vacía no se cambia)
		$clavehash = ($clave !== '' && $clave !== null) ? hash("SHA256", $clave) : '';

		if (empty($idusuario) && ($clave === '' || $clave === null)) {
			echo "Debe ingresar la clave para nuevo usuario";
			break;
		}

		$permisos = isset($_POST['permiso']) && is_array($_POST['permiso']) ? $_POST['permiso'] : array();
		if (empty($idusuario)){
			$rspta=$usuario->insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$Empleado_idEmpleado,$permisos);
			echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
		}
		else {
			$rspta=$usuario->editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$Empleado_idEmpleado,$permisos);
			echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
		}
	break;

	case 'editarPass':

		//Hash SHA256 en la contraseña
		$clavehash=hash("SHA256",$clave);

		$rspta=$usuario->editarPass($_SESSION['idusuario'], $clavehash);
 		echo $rspta ? "Contraseña actualizada" : "Contraseña no se pudo modificar";
	break;


	case 'desactivar':
		$rspta=$usuario->desactivar($idusuario);
 		echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
	break;

	case 'activar':
		$rspta=$usuario->activar($idusuario);
 		echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
	break;

	case 'mostrar':
		$rspta=$usuario->mostrar($idusuario);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$usuario->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetchObject()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->tipo_documento,
 				"3"=>$reg->num_documento,
 				"4"=>$reg->telefono,
 				"5"=>$reg->email,
 				"6"=>$reg->login,
 				"7"=>"<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px' >",
 				"8"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
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

	case 'permisos':
		require_once "../modelos/Permiso.php";
		$permisoModel = new Permiso();
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$marcados = $usuario->listarmarcados($id);
		$valores = array();
		while ($per = $marcados->fetchObject()) {
			$valores[] = (int)$per->idpermiso;
		}
		$rspta = @$permisoModel->listarPorCategoria();
		if ($rspta) {
			$cat_actual = '';
			$cat_id = 0;
			while ($reg = $rspta->fetchObject()) {
				$categoria_nombre = isset($reg->categoria_nombre) && $reg->categoria_nombre ? $reg->categoria_nombre : 'Otros';
				if ($categoria_nombre !== $cat_actual) {
					if ($cat_actual !== '') echo '</ul></div></div>';
					$cat_actual = $categoria_nombre;
					$cat_id++;
					$cid = 'perm-cat-' . $cat_id;
					echo '<div class="panel panel-default permiso-categoria-panel" data-cat-id="' . $cid . '">';
					echo '<div class="panel-heading panel-heading-permiso">';
					echo '<span class="permiso-cat-title">' . htmlspecialchars($categoria_nombre) . '</span>';
					echo ' <a href="#" class="permiso-link permiso-marcar-todos" data-target=".' . $cid . '-checks">Marcar todos</a>';
					echo ' <span class="text-muted">|</span> ';
					echo '<a href="#" class="permiso-link permiso-desmarcar-todos" data-target=".' . $cid . '-checks">Desmarcar</a>';
					echo '</div><div class="panel-body"><ul class="list-unstyled permiso-list ' . $cid . '-checks">';
				}
				$sw = in_array((int)$reg->idpermiso, $valores) ? 'checked' : '';
				$desc = isset($reg->descripcion) && $reg->descripcion ? ' title="' . htmlspecialchars($reg->descripcion) . '"' : '';
				echo '<li class="permiso-item"><label class="permiso-label"><input type="checkbox" ' . $sw . ' name="permiso[]" value="' . (int)$reg->idpermiso . '" class="permiso-check"' . $desc . '> <span>' . htmlspecialchars($reg->nombre) . '</span></label></li>';
			}
			if ($cat_actual !== '') echo '</ul></div></div>';
		} else {
			echo '<div class="panel panel-default permiso-categoria-panel"><div class="panel-body"><ul class="list-unstyled permiso-list perm-cat-0-checks">';
			$rspta = $permisoModel->listar();
			while ($reg = $rspta->fetchObject()) {
				$sw = in_array((int)$reg->idpermiso, $valores) ? 'checked' : '';
				echo '<li class="permiso-item"><label class="permiso-label"><input type="checkbox" ' . $sw . ' name="permiso[]" value="' . (int)$reg->idpermiso . '" class="permiso-check"> <span>' . htmlspecialchars($reg->nombre) . '</span></label></li>';
			}
			echo '</ul></div></div>';
		}
	break;

	case 'permisosJson':
		header('Content-Type: application/json; charset=utf-8');
		require_once "../modelos/Permiso.php";
		require_once "../modelos/Rol.php";
		$permisoModel = new Permiso();
		$rolModel = new Rol();
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$marcados = $usuario->listarmarcados($id);
		$valores = array();
		while ($per = $marcados->fetchObject()) { $valores[] = (int)$per->idpermiso; }
		$categorias = array();
		$rspta = @$permisoModel->listarPorCategoria();
		if ($rspta) {
			$cat_actual = '';
			$idx = -1;
			while ($reg = $rspta->fetchObject()) {
				$cat_nombre = isset($reg->categoria_nombre) && $reg->categoria_nombre ? $reg->categoria_nombre : 'Otros';
				if ($cat_nombre !== $cat_actual) {
					$cat_actual = $cat_nombre;
					$categorias[] = array('nombre' => $cat_nombre, 'permisos' => array());
					$idx = count($categorias) - 1;
				}
				$categorias[$idx]['permisos'][] = array(
					'idpermiso' => (int)$reg->idpermiso,
					'nombre' => $reg->nombre,
					'descripcion' => isset($reg->descripcion) ? $reg->descripcion : ''
				);
			}
		} else {
			$rspta = $permisoModel->listar();
			$permisos = array();
			while ($reg = $rspta->fetchObject()) {
				$permisos[] = array('idpermiso' => (int)$reg->idpermiso, 'nombre' => $reg->nombre, 'descripcion' => '');
			}
			$categorias = array(array('nombre' => 'Permisos', 'permisos' => $permisos));
		}
		echo json_encode(array('categorias' => $categorias, 'marcados' => $valores));
	break;

	case 'roles':
		header('Content-Type: application/json; charset=utf-8');
		if (!file_exists("../modelos/Rol.php")) { echo json_encode(array()); break; }
		require_once "../modelos/Rol.php";
		$rolModel = new Rol();
		$rs = @$rolModel->listar();
		$lista = array();
		if ($rs) while ($r = $rs->fetchObject()) { $lista[] = array('id' => (int)$r->id, 'nombre' => $r->nombre, 'descripcion' => isset($r->descripcion) ? $r->descripcion : ''); }
		echo json_encode($lista);
	break;

	case 'permisosPorRol':
		header('Content-Type: application/json; charset=utf-8');
		$id_rol = isset($_GET['id_rol']) ? (int)$_GET['id_rol'] : 0;
		if ($id_rol <= 0 || !file_exists("../modelos/Rol.php")) { echo json_encode(array()); break; }
		require_once "../modelos/Rol.php";
		$rolModel = new Rol();
		$ids = @$rolModel->listarIdPermisosPorRol($id_rol);
		echo json_encode($ids ? $ids : array());
	break;

	case 'verificar':
		header('Content-Type: application/json; charset=utf-8');
		$logina = isset($_POST['logina']) ? trim($_POST['logina']) : '';
		$clavea = isset($_POST['clavea']) ? $_POST['clavea'] : '';

		if ($logina === '' || $clavea === '') {
			echo json_encode(array('ok' => false, 'mensaje' => 'Ingrese usuario y contraseña.'));
			break;
		}

		$clavehash = hash("SHA256", $clavea);
		$rspta = $usuario->verificar($logina, $clavehash);
		$fetch = $rspta->fetchObject();

		if ($fetch)
		{
			$_SESSION['idusuario'] = $fetch->idusuario;
			$_SESSION['nombre'] = $fetch->nombre;
			$_SESSION['imagen'] = $fetch->imagen;
			$_SESSION['login'] = $fetch->login;
			$_SESSION['idEmpleado'] = $fetch->Empleado_idEmpleado;
			$_SESSION['ne'] = isset($fetch->ne) ? $fetch->ne : '';

			$marcados = $usuario->listarmarcados($fetch->idusuario);
			$valores = array();
			while ($per = $marcados->fetchObject()) {
				$valores[] = (int)$per->idpermiso;
			}

			// Claves de sesión por idpermiso (compatibilidad)
			$keys = array(1=>'escritorio',2=>'almacen',3=>'compras',4=>'ventas',5=>'acceso',6=>'consultac',7=>'consultav',8=>'habilitaciones',9=>'parametricas',10=>'movimientos',11=>'personas',12=>'cargarorden',13=>'contabilidad',14=>'stock',15=>'logistica',16=>'promociones',17=>'clientes',18=>'creditos');
			foreach ($keys as $id => $key) {
				$_SESSION[$key] = in_array($id, $valores) ? 1 : 0;
			}

			// Sesión por archivo (permiso por ventana) (permiso por ventana): SELECT archivo desde permiso + usuario_permiso
			$sql_archivos = "SELECT p.archivo FROM usuario_permiso up INNER JOIN permiso p ON p.idpermiso = up.idpermiso WHERE up.idusuario = '" . (int)$fetch->idusuario . "' AND p.archivo IS NOT NULL AND p.archivo != ''";
			$rs_arch = ejecutarConsulta($sql_archivos);
			if ($rs_arch) {
				while ($row = $rs_arch->fetch(PDO::FETCH_ASSOC)) {
					if (!empty($row['archivo'])) $_SESSION[$row['archivo']] = 1;
				}
			}

			echo json_encode(array('ok' => true, 'usuario' => $fetch));
		}
		else
		{
			echo json_encode(array('ok' => false, 'mensaje' => 'Usuario o contraseña incorrectos. Verifique sus datos e intente nuevamente.'));
		}
	break;

	case 'selectEmpleado':
		require_once "../modelos/Empleado.php";
		$empleado = new Empleado();
		$rspta = $empleado->listarActivos();
		echo '<option value="">Ninguno</option>';
		while ($reg = $rspta->fetchObject()) {
			echo '<option value="' . (int)$reg->idEmpleado . '">' . htmlspecialchars($reg->razonSocial) . '</option>';
		}
	break;

	case 'salir':
		//Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");

	break;
}
?>