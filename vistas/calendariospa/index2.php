<?php
session_start();
include("database.php");


if(!isset($_SESSION['user'])){$_SESSION['user'] = session_id();}
if (!isset($_SESSION["nombre"])){header("Location: ../spa");}



else{
$uid = $_SESSION['user'];  // set your user id settings
$datetime_string = date('c',time());    
if(isset($_POST['action']) or isset($_GET['view']) or isset($_GET['empleados']) or isset($_GET['action']))
{
    if(isset($_GET['view'])){
        
        $getidurl = $_GET['cant'];
        $getempleado = $_GET['empleado'];



        $result = mysqli_query($connection,"SELECT ordenconsumisiondetalle.idOrdenConsumisionDetalle as id, F_NOMBRE_CLIENTE(ordenconsumision.Cliente_idCliente) as title, F_NOMBRE_ARTICULO(ordenconsumisiondetalle.Articulo_idArticulo) as body, ordenconsumisiondetalle.Articulo_idArticulo as idarticulo, F_NOMBRE_SERVICIO( clientedetalle.Articulo_idArticulo_Servicio ) as servicio, (select nombre from paquetedetalle where idpaqueteDetalle = ordenconsumisiondetalle.Articulo_idArticulo_Servicio) as paquete, 'event-danger' as class, ordenconsumisiondetalle.Empleado_IdEmpleado as empleadoactual,  fecha_inicial as start, fecha_final as end 

            from ordenconsumision, ordenconsumisiondetalle, clientedetalle 

            where ordenconsumision.idOrdenConsumision = ordenconsumisiondetalle.OrdenConsumision_idOrdenConsumision AND clientedetalle.idclientedetalle = ordenconsumisiondetalle.articulo_idarticulo_servicio  AND ordenconsumisiondetalle.Empleado_IdEmpleado = ".$getempleado."  and ordenconsumision.inactivo = 0 and ordenconsumisiondetalle.inactivo = 0 ORDER BY id DESC LIMIT ".$getidurl.";    ");
        while($row = mysqli_fetch_assoc($result))
        {
            $events[] = $row; 
        }
        header('Content-Type: application/json');
        echo json_encode($events); 
        exit;




    }
    elseif(isset($_GET['empleados'])){
        header('Content-Type: application/json');
        $getidempleado = $_GET['empleados'];
        $result = mysqli_query($connection,"   SELECT nombreComercial FROM empleado WHERE idEmpleado = ".$getidempleado." AND inactivo=0");
        if (mysqli_num_rows($result)>0) {
        while($row = mysqli_fetch_assoc($result))
                {
                    $events[] = $row; 
                }
                echo json_encode($events); 
        }
        else{
          echo "1";
        }
        
        exit;
    }
    elseif($_POST['action'] == "add")
    {   
    if (isset($_POST["empleadoid"])) {
      $empleadoid = $_POST["empleadoid"];
      $idempleado = substr($empleadoid, 3);
    }
    else{
      $idempleado = $_POST['idempleado'];
    }
    $cliente_id = $_POST['idcliente'];
    $articulo_id = $_POST['articulo_idarticulo'];
    $servicio = $_POST['articulo_idarticulo_servicio'];
    $sala =  $_POST['sala'];
    $cantidad =  $_POST['cantidad'];
    if (!empty($servicio)) {

    
        mysqli_query($connection, "INSERT INTO ordenconsumision (`idOrdenConsumision`, `Empleado_idEmpleado`, `fechaConsumision`, `Cliente_idCliente`, `inactivo`, `terminado`, `usuarioIns`) VALUES (NULL, '$idempleado', now(), '$cliente_id', '0', '0', 'MARINA');");
        $addid = mysqli_insert_id($connection);
        mysqli_query($connection, "INSERT INTO `ordenconsumisiondetalle` VALUES (NULL, '$addid', '$articulo_id', '$servicio', '$idempleado', '$cantidad','0', '0', NULL, '".mysqli_real_escape_string($connection,date('Y-m-d H:i:s',strtotime($_POST["start"])))."',  '".mysqli_real_escape_string($connection,date('Y-m-d H:i:s',strtotime($_POST["end"])))."', '$sala');");
        $addid = mysqli_insert_id($connection);
        header('Content-Type: application/json');
        $q = mysqli_query($connection,"SELECT cliente.nombreComercial as cliente, '$addid' as ultimoid, (select nombre from articulo where idArticulo = ".$articulo_id.") as articulo FROM cliente WHERE idCliente = ".$cliente_id."");
        while($row = mysqli_fetch_assoc($q))
        {
            $clientenombre[] = $row; 
        }
        echo json_encode($clientenombre);
        exit;
    }
    else
    {
        header('Content-Type: application/json');
        echo "error";
    }



    }
    elseif($_POST['action'] == "update")
    {
        mysqli_query($connection,"UPDATE ordenconsumisiondetalle SET `fecha_inicial` = '".mysqli_real_escape_string($connection,date('Y-m-d H:i:s',strtotime($_POST["start"])))."', `fecha_final` = '".mysqli_real_escape_string($connection,date('Y-m-d H:i:s',strtotime($_POST["end"])))."' WHERE idOrdenConsumisionDetalle = '".mysqli_real_escape_string($connection,$_POST["id"])."' and terminado = 0");
        exit;
    }

    elseif ($_POST['action'] == "actualizar_empleado") {
    $eventoid = $_POST['id'];
    $idempleado = $_POST['idempleado'];
    $idarticulo = $_POST['idarticulo'];
    $idcliente =  $_POST['idcliente'];
     mysqli_query($connection,"UPDATE `ordenconsumisiondetalle` SET `Empleado_IdEmpleado` = '".$idempleado."' WHERE `idOrdenConsumisionDetalle` = " .$_POST['id']. " AND terminado = 0;");
    header('Content-Type: application/json');
    $result = mysqli_query($connection,"    SELECT ordenconsumisiondetalle.idOrdenConsumisionDetalle as id,  F_NOMBRE_CLIENTE(ordenconsumision.Cliente_idCliente) as title, F_NOMBRE_ARTICULO(ordenconsumisiondetalle.Articulo_idArticulo) as body, ordenconsumisiondetalle.Articulo_idArticulo as idarticulo, (select nombre from paquetedetalle where idpaqueteDetalle = ordenconsumisiondetalle.Articulo_idArticulo_Servicio ) as paquete, 'event-info' as class, ordenconsumisiondetalle.Empleado_IdEmpleado as empleadoactual,  fecha_inicial as start,  fecha_final as end from ordenconsumision, ordenconsumisiondetalle where ordenconsumision.idOrdenConsumision = ordenconsumisiondetalle.OrdenConsumision_idOrdenConsumision AND ordenconsumisiondetalle.Empleado_IdEmpleado = ".$idempleado."  and ordenconsumision.inactivo = 0 and ordenconsumisiondetalle.inactivo = 0 ORDER BY id DESC LIMIT 1;    ");
        while($row = mysqli_fetch_assoc($result))
        {
            $events[] = $row; 
        }
        echo json_encode($events); 
        exit;
    }










}

?>
<?php

}
?>