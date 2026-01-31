<?php

namespace App\Model;

use App\Lib\Response;

use App\Lib\Auth;







class AuthModel

{

    private $db;

    private $table = 'usuario';

    private $table_id = 'idUsuario';

    private $response;

    PRIVATE $nvo_nombre;

    PRIVATE $cadena;

    public function __CONSTRUCT($db)

    {

        $this->db = $db;

        $this->response = new Response();

    }

   

    public function autenticar($email,$clave){

          $email = strtolower($email);

          $sql2 = "SELECT * FROM usuario,vehiculo WHERE usuario.Vehiculo_idVehiculo = vehiculo.idVehiculo and usuario.login =:email and clave=:clave";   

          $stmt = $this->db->prepare($sql2);
          $stmt->bindParam(':email', $email);
          $stmt->bindParam(':clave', hash("SHA256",$clave));
          $stmt->execute();

          $detalle = $stmt->fetch();          

    

          if (is_object($detalle)) {


              $token = Auth::SignIn([
                'id'=>$detalle->idusuario,
                'login'=>$detalle->login,
                'nombre'=>$detalle->nombre,
                'usuario'=>$detalle->email,
                'vehiculo'=>$detalle->Vehiculo_idVehiculo,
                'referencia'=>$detalle->idusuario . '_' .$detalle->login . '_' .$detalle->nombreReferencia
              ]);

              
            $this->response->result = $token;
            $this->response->idUsuario = $detalle->idusuario . '_' .$detalle->login . '_' .$detalle->nombreReferencia;
            return $this->response->setResponse(true);



          }else{

            return $this->response->setResponse(false, 'Credenciales no valida');

          }

    

         return $this->response->setResponse(false, 'Credenciales no valida');      



    }


    public function obtenerDatos($token){ 
          $token = Auth::getData( $token );

          if( is_object( $token ) ) {

            $this->response->result = $token->usuario;
            return $this->response->setResponse(true);
          
          }else{
            return $this->response->setResponse(false, 'Credenciales no valida');      
          }

    }




}





