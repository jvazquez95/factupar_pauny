<?php

$conexion = new PDO('mysql:host=localhost;dbname=mesaentrada', 'root', 's3guridad2015!A' );
$setnames = $conexion->prepare("SET NAMES 'utf8mb4'");
$setnames->execute();

?>