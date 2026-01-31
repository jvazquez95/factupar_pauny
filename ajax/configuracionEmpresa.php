<?php
require_once "../config/Conexion.php";
require_once "../modelos/ConfiguracionEmpresa.php";

$config = new ConfiguracionEmpresa();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$nombre_empresa = isset($_POST["nombre_empresa"]) ? limpiarCadena($_POST["nombre_empresa"]) : "";
$ruc = isset($_POST["ruc"]) ? limpiarCadena($_POST["ruc"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$color_primario = isset($_POST["color_primario"]) ? limpiarCadena($_POST["color_primario"]) : "#007bff";
$logo_ruta = isset($_POST["logo_ruta"]) ? limpiarCadena($_POST["logo_ruta"]) : "";
// Empresa: solo nombre, RUC, logo, color (direccion/telefono/email por sucursal)

switch ($_GET["op"]) {
	case 'obtener':
		try {
			$rspta = $config->obtener();
			echo json_encode($rspta !== false ? $rspta : array());
		} catch (Exception $e) {
			echo json_encode(array('error' => $e->getMessage()));
		}
		break;

	case 'guardaryeditar':
		try {
			if (isset($_FILES['logo']) && file_exists($_FILES['logo']['tmp_name']) && is_uploaded_file($_FILES['logo']['tmp_name'])) {
				$ext = explode(".", $_FILES["logo"]["name"]);
				$tipos = array("image/jpg", "image/jpeg", "image/png", "image/gif");
				if (in_array($_FILES['logo']['type'], $tipos)) {
					$logo_ruta = "files/logo/" . round(microtime(true)) . '.' . end($ext);
					$ruta_destino = "../" . $logo_ruta;
					if (!is_dir("../files/logo")) {
						mkdir("../files/logo", 0755, true);
					}
					move_uploaded_file($_FILES["logo"]["tmp_name"], $ruta_destino);
				} else {
					$actual = $config->obtener();
					$logo_ruta = ($actual && isset($actual['logo_ruta'])) ? $actual['logo_ruta'] : '';
				}
			} else {
				$logo_actual = isset($_POST["logo_actual"]) ? limpiarCadena($_POST["logo_actual"]) : "";
				$logo_ruta = $logo_actual;
			}
			$rspta = $config->actualizar($nombre_empresa, $ruc, $direccion, $telefono, $email, $logo_ruta, $color_primario);
			echo $rspta ? "Configuracion actualizada" : "No se pudo actualizar la configuracion";
		} catch (Exception $e) {
			echo "Error al guardar: " . $e->getMessage();
		} catch (Throwable $e) {
			echo "Error al guardar: " . $e->getMessage();
		}
		break;
}
