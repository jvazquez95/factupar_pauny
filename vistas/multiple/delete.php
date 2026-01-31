<?php

if (isset($_POST["id"])) {
    require("db.php");
    
    $id = $_POST["id"];
    
    $getImageName = $conexion->prepare("SELECT imagen FROM mesaEntradaImagen WHERE idMesaEntradaImagen = :id;");
    $obtuvo_la_imagen = $getImageName->execute(array(
        ":id" => $id
    ));

    if ($obtuvo_la_imagen) {
        $image = $getImageName->fetch(PDO::FETCH_ASSOC);
        $image = $image["imagen"];
    
        //Lo eliminamos de la base de datos
        $deleteImage = $conexion->prepare("DELETE FROM mesaEntradaImagen WHERE idMesaEntradaImagen = :id");
        $eliminoImagen = $deleteImage->execute(array(
            ":id" => $id
        ));

        if ($eliminoImagen) {
            //Lo eliminamos del servidor
            if(unlink("images/$image")) {
                die("true");
            }
            else {
                die("Hubo un error, por favor, contacta al administrador.1");
            }
        }
        else {
            die("Hubo un error, por favor, contacta al administrador.2");
        }
    }
    else {
        die("Hubo un error, por favor, contacta al administrador.3");
    }


}

header("location: ./");

?>