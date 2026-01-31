<?php
session_start();
error_reporting(0);
include('conexionBD.php');
$pas = hash("SHA256",  $_POST['password2'] );
$codigo = $_POST['codigo'];



$sth = $dbh->query("UPDATE usuario set clave = '$pas', codigo = null where Codigo = '$codigo'");
$sth->execute();
echo "<script type=\"text/javascript\">window.location.href='https://fastmer.com'</script>";

?>