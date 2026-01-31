<?php
// Se abre un archivo .inc en donde se encientran todos los datos para conectarse a una BD.
$pathArchivoConexion="configodbc.inc";
$manejador = fopen($pathArchivoConexion, "r");
$paramConexion = file($pathArchivoConexion);
$cierreArch = fclose($manejador);
// se recorre el archivo y se se asigna a cada varible local definida abajo.
foreach ($paramConexion as $p) 
{
    list($param, $valor) = explode("=", $p);
	$$param = $valor;
}
	$host     = trim($host);
	$usuario  = trim($usuario);
	$password = trim($password);

try{
	if (file_exists(__DIR__ . '/../../../../../config/load_env.php')) { require __DIR__ . '/../../../../../config/load_env.php'; }
	$dbHost = getenv('DB_HOST') ?: 'localhost';
	$dbName = getenv('DB_NAME_FASTMER') ?: 'c1fastmer_new';
	$dbUser = getenv('DB_USERNAME') ?: 'root';
	$dbPass = getenv('DB_PASSWORD') ?: '';
	$dbh = new PDO('mysql:host='.$dbHost.';dbname='.$dbName, $dbUser, $dbPass);
	
	}catch(PDOException $e)
	{ //se encontro un error y no se logro conectar a la base de datos.
		echo "Coneccion Fallida ".$e->getMessage();
		
	}
/*	$user = $_POST['usuario'];
	$pass = $_POST['pass'];
//error_reporting(0);
	$sth = $dbh->query("SELECT * FROM usuarios where usuario = '$user' and password = '$pass'" );
	$sth->execute();
	while ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
		session_start();
		$_SESSION['nro_socio'] = $result['nro_socio'];
		header('Location: fca/../../pages/principal.html');
	}
*/
?>