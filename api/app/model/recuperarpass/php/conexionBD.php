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
	// Se conecta con exito
	$dbh = new PDO('mysql:host=localhost;dbname=c1fastmer_new','root', 's3guridad2015!A');
	
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