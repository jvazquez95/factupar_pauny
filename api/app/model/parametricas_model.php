<?php
namespace App\Model;
use App\Lib\Response;
use App\Lib\Auth;

class ParametricaModel
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
    

    public function  getVersion()
    {    
        $sql = "SELECT * from version where idVersion in (select max(idVersion) from version)";   
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $version = $stmt->fetchAll(); 

        $json = array('version' =>  $version);
      
        return $json;
    }



    public function  getMarcas()
    {    
        $sql = "SELECT * from marca ORDER BY  idMarca desc;";   
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $marcas = $stmt->fetchAll(); 

        $json = array('marcas' =>  $marcas);
      
        return $json;
    }


 


    public function  getModelos()
    {    
        $sql = "SELECT * from modelo ORDER BY  idModelo desc;";   
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $modelos = $stmt->fetchAll(); 

        $json = array('modelos' =>  $modelos);
      
        return $json;
    }


    public function  getModelosMarcas($data)
    {    
        $sql = "SELECT * from modelo where Marca_idMarca = :Marca_idMarca";   
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':Marca_idMarca', $data['Marca_idMarca']);
            $stmt->execute();
            $modelos = $stmt->fetchAll(); 

        $json = array('modelos' =>  $modelos);
      
        return $json;
    }



    public function  getPaises()
    {    
        $sql = "SELECT * from paises";   
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $paises = $stmt->fetchAll(); 

        $json = array('paises' =>  $paises);
      
        return $json;
    }


    public function getCiudades($data)
    {
        $filtro = $data['keyword'];
        $keyword = "%".$filtro."%";
    
        $sql = "SELECT code, descripcion
                FROM ciudad2
                WHERE descripcion LIKE :keyword
                LIMIT 20";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        $result = $stmt->fetchAll();
    
        // Si no se encontró ninguna ciudad, retornamos la entrada "Ciudad no encontrada"
        if (empty($result)) {
            $result[] = [
                "code"        => 0,
                "descripcion" => "Ciudad no encontrada"
            ];
        }
    
        return $result;
    }
    



    public function  getCiudadesPais( $data )
    {    
        $sql = "SELECT * from ciudad where Pais_idPais = :Pais_idPais";   
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':Pais_idPais', $data['Pais_idPais']);
            $stmt->execute();
            $ciudades = $stmt->fetchAll(); 

        $json = array('ciudades' =>  $ciudades);
      
        return $json;
    }



    public function consulta($data)
    {

            $sql2 = "SELECT idPersona, persona.razonSocial, persona.tipoDocumento, nroDocumento, email, usuario.imagen FROM usuario, persona WHERE persona.idPersona = Persona_idPersona and email=:email and persona.inactivo = 0 limit 1";   
            $stmt = $this->db->prepare($sql2);
            $stmt->bindParam(':email', $data['email']);
            $stmt->execute();
            $usuario = $stmt->fetchAll(); 


            $profile = [];
            $i = 0;

          // //Agregar detalle al producto.
           foreach ($usuario as $e) {
              //direccion por usuario.
              $sql = "SELECT
                      Persona_idPersona,
                      idDireccion, 
                      direccion, 
                      callePrincipal, 
                      calleTransversal, 
                      nroCasa, 
                      direccion.Ciudad_idCiudad, 
                      Barrio_idBarrio, 
                      tipodireccion_telefono.descripcion as tipoDireccion, 
                      ciudad.descripcion as nombreCiudad,
                      barrio.descripcion as nombreBarrio,
                      latitud, 
                      longitud
                      from direccion, tipodireccion_telefono, ciudad,  barrio
                      where ciudad.idCiudad = direccion.Ciudad_idCiudad and 
                      barrio.idBarrio = direccion.Barrio_idBarrio  and 
                      tipodireccion_telefono.idTipoDireccion_Telefono = direccion.TipoDireccion_Telefono_idTipoDireccion_Telefono and 
                      Persona_idPersona = :id";
             $stmt2 = $this->db->prepare($sql);
             $stmt2->bindParam(':id', $usuario[0]->idPersona);
             $stmt2->execute();

             $direcciones = $stmt2->fetchAll();


             $detalles = [];
             $k = 0;


             foreach ($direcciones as $det ) {
              //if ($det->Articulo_idArticulo ==  $e->id) {
                $detalles[$k++] = $det;
              //}
             }

             $e->direcciones = $detalles;
           }

             $profile[$i++] = $e;

          // // //Agregar detalle al producto.
          // //Agregar detalle al producto.
           foreach ($usuario as $e) {
              //direccion por usuario.
              $sql = "SELECT idTelefono, telefono, descripcion as tipoTelefono 
                      from telefono, tipodireccion_telefono 
                      where telefono.TipoDireccion_Telefono_idTipoDireccion_Telefono = tipodireccion_telefono.idTipoDireccion_Telefono and Persona_idPersona = :id ";
             $stmt2 = $this->db->prepare($sql);
             $stmt2->bindParam(':id', $usuario[0]->idPersona);
             $stmt2->execute();

             $telefonos = $stmt2->fetchAll();


             $detalles = [];
             $k = 0;


             foreach ($telefonos as $det ) {
              //if ($det->Articulo_idArticulo ==  $e->id) {
                $detalles[$k++] = $det;
              //}
             }

             $e->telefonos = $detalles;
           }




           foreach ($usuario as $e) {
              //direccion por usuario.
              $sql = "SELECT *,
                      F_NOMBRE_ESTADO( estadoCi ) as comentarioCi_e, 
                      F_NOMBRE_ESTADO( estadoCiReverso ) as comentarioCiReverso_e, 
                      F_NOMBRE_ESTADO( estadoLicenciaConducir ) as comentarioLicenciaConducir_e, 
                      F_NOMBRE_ESTADO( estadoLicenciaReverso ) as comentarioLicenciaReverso_e, 
                      F_NOMBRE_ESTADO( estadoAntecedente ) as comentarioAntecedente_e,
                      F_NOMBRE_ESTADO( estadoConstanciaRuc ) as comentarioConstanciaRuc_e   from documentopersonal where Persona_idPersona = :id limit 1";
             $stmt2 = $this->db->prepare($sql);
             $stmt2->bindParam(':id', $usuario[0]->idPersona);
             $stmt2->execute();

             $documentos = $stmt2->fetchAll();


             $detalles = [];
             $k = 0;


             foreach ($documentos as $det ) {
              //if ($det->Articulo_idArticulo ==  $e->id) {
                $detalles[$k++] = $det;
              //}
             }

             $e->documentos = $detalles;
           }


           foreach ($usuario as $e) {
              //direccion por usuario.
              $sql = "SELECT *, 
                    F_NOMBRE_ESTADO( estadoHabilitacion ) as comentarioHabilitacion_e, 
                    F_NOMBRE_ESTADO( estadoHabilitacionReverso ) as comentarioHabilitacionReverso, 
                    F_NOMBRE_ESTADO( estadoSeguro ) as comentarioSeguro_e
                    from vehiculo where Persona_idPersona = 1;";
             $stmt2 = $this->db->prepare($sql);
             $stmt2->bindParam(':id', $usuario[0]->idPersona);
             $stmt2->execute();

             $vehiculos = $stmt2->fetchAll();


             $detalles = [];
             $k = 0;


             foreach ($vehiculos as $det ) {
              //if ($det->Articulo_idArticulo ==  $e->id) {
                $detalles[$k++] = $det;
              //}
             }

             $e->vehiculos = $detalles;
           }




             $profile[$i++] = $e;










      $json = array('usuario' =>  $profile[0]);

        
      return $json;


    }
    

    public function recuperarPassword($data)
    {


	    $email = $data['email'];
	    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
	    srand((double)microtime()*1000000);
	    $i = 0;
	    $pass = '' ;
	   
	    while ($i <= 7) {
	        $num = rand() % 33;
	        $tmp = substr($chars, $num, 1);
	        $pass = $pass . $tmp;
	        $i++;
	    }
	  	//se genera el codigo unido.
	    $codigo = time().$pass;
	    //Damos 24 horas para poder recuperar el password.
	    $fechaRecuperacion = date("Y-m-d H:i:s", strtotime('+24 hours'));

	    //verificamos si existe algun usuario con ese correo
	   	$sql = "SELECT nombre FROM usuario WHERE email=:email";   
		$stmt = $this->db->prepare($sql);	
	    $stmt->bindParam(':email', $email);
	    $stmt->execute();
	    $resultado = $stmt->fetch(); 



	    if ($resultado) {
	    	$sql2 = "UPDATE usuario SET codigo = :p_codigo, fechaRecuperacion = :p_fechaRecuperacion WHERE email = :p_correoElectronico";
	    	$stmt = $this->db->prepare($sql2);	
		    $stmt->bindParam(':p_codigo', $codigo);
		    $stmt->bindParam(':p_fechaRecuperacion', $fechaRecuperacion);
		    $stmt->bindParam(':p_correoElectronico', $email);
		    $estado = $stmt->execute();
		    if ($estado) {
	  			$d = array(
	  				"estado" => true,
	  				"codigo" => $codigo,
	  				"email" => $email,
	  				"nombre" => $resultado->nombre
	  			);
		    }else{
	  			$d = array("estado" => false);
		    }
	    }else{
	    	$d = array("estado" => false);
	    }


	    return $d;

    }



    function insertar($data){

      //PARTE 1 - TABLA USUARIO - PERSONA
      $nombre = $data['nombre'];
      $direccion = $data['direccion'];
      $telefonoMovil = $data['telefonoMovil'];
      $tipo_documento = $data['tipo_documento'];
      $num_documento = $data['num_documento'];
      $sexo = $data['sexo'];
      $email = $data['email'];
      $clave = hash("SHA256",  $data['clave'] );
      $codigoConfirmado = rand(0 , 9999 );
      

      //PARTE 2 - TABLA DOCUMENTOS PERSONALES
      $imagen = $data['foto']; //perfil
      $imagenCIFrontal = $data['foto2']; //ci frontal
      $imagenCITrasera = $data['foto3']; // ci reverso
      $imagenLicenciaConducirFrontal = $data['foto4']; //licencia frontal
      $imagenLicenciaConducirTrasera = $data['foto5']; //licencia reverso
      $imagenAntecedentePolicial = $data['foto6']; // AJ
      $imagenConstanciaRuc = $data['foto7']; //Constancia de Ruc



      //PARTE 2 - TABLA VEHICULOS
      $imagenHabilitacionFrontal = $data['foto8']; // habilitacion frontal
      $imagenHabilitacionTrasera = $data['foto9']; // habilitacion reverso
      $MarcaVehiculo_idMarcaVehiculo = $data['MarcaVehiculo_idMarcaVehiculo'];
      $Modelo_idModelo = $data['Modelo_idModelo'];
      $matricula = $data['matricula'];
      $anhoVehiculo = $data['anhoVehiculo'];
      $tipoVehiculo = $data['tipoVehiculo'];
      $latitud = 0;//$data['latitud'];
      $longitud = 0;//$data['longitud'];
      $direccionMaps = 0;//$data['direccionMaps'];

      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });



  		try {


            $sql = "CALL SP_GenerarUsuarioGeneral(:nombre, :direccion, :telefonoMovil, :tipo_documento, :num_documento, :sexo, :login, :email, :clave, :codigoConfirmado, :imagen, :imagenCIFrontal, :imagenCITrasera, :imagenLicenciaConducirFrontal, :imagenLicenciaConducirTrasera, :imagenAntecedentePolicial, :imagenConstanciaRuc, :imagenHabilitacionFrontal, :imagenHabilitacionTrasera, :MarcaVehiculo_idMarcaVehiculo, :Modelo_idModelo, :matricula, :anhoVehiculo, :tipoVehiculo, :latitud, :longitud, :direccionMaps)";
            		
            $stmt  = $this->db->prepare($sql);  
            
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':telefonoMovil', $telefonoMovil);
            $stmt->bindParam(':tipo_documento', $tipo_documento);
            $stmt->bindParam(':num_documento', $num_documento);
            $stmt->bindParam(':sexo', $sexo);
            $stmt->bindParam(':login', $email);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':clave', $clave );
            $stmt->bindParam(':codigoConfirmado', $codigoConfirmado);


            $stmt->bindParam(':imagen', $imagen);
            $stmt->bindParam(':imagenCIFrontal', $imagenCIFrontal);
            $stmt->bindParam(':imagenCITrasera', $imagenCITrasera);
            $stmt->bindParam(':imagenLicenciaConducirFrontal', $imagenLicenciaConducirFrontal);
            $stmt->bindParam(':imagenLicenciaConducirTrasera', $imagenLicenciaConducirTrasera);
            $stmt->bindParam(':imagenAntecedentePolicial', $imagenAntecedentePolicial);
            $stmt->bindParam(':imagenConstanciaRuc', $imagenConstanciaRuc);


            $stmt->bindParam(':imagenHabilitacionFrontal', $imagenHabilitacionFrontal);
            $stmt->bindParam(':imagenHabilitacionTrasera', $imagenHabilitacionTrasera);
            $stmt->bindParam(':MarcaVehiculo_idMarcaVehiculo', $MarcaVehiculo_idMarcaVehiculo);
            $stmt->bindParam(':Modelo_idModelo', $Modelo_idModelo);
            $stmt->bindParam(':matricula', $matricula);
            $stmt->bindParam(':anhoVehiculo', $anhoVehiculo);
            $stmt->bindParam(':tipoVehiculo', $tipoVehiculo);
            $stmt->bindParam(':latitud', $latitud);
            $stmt->bindParam(':longitud', $longitud);
            $stmt->bindParam(':direccionMaps', $direccionMaps);
            
		
            $estado=$stmt->execute();

            return $estado;    


		} catch (Exception $e) {
		    return $e;
		}

  		//Restablecemos el tratamiento de errores
  		restore_error_handler();
            
	}
//


    function actualizarAntecedentePolicial($data){

      //PARTE 2 - TABLA DOCUMENTOS PERSONALES
      $id = $data['id']; //perfil
      $imagenAntecedentePolicial = $data['imagen']; // AJ
 
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

  		try { 

            $sql = "CALL SP_ActualizarAntecedentePolicial(:imagenAntecedentePolicial, :id)";
            		
            $stmt  = $this->db->prepare($sql);  
            
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':imagenAntecedentePolicial', $imagenAntecedentePolicial);

            $estado=$stmt->execute();

            return $estado;    

		} catch (Exception $e) {
		    return $e;
		}

  		//Restablecemos el tratamiento de errores
  		restore_error_handler();
            
	}

    function actualizarCiFrontal($data){

      //PARTE 2 - TABLA DOCUMENTOS PERSONALES 
      $id = $data['id']; //perfil
      $imagenCIFrontal = $data['imagen']; // AJ
 
      //Activamos todas las notificaciones de error posibles 
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

  		try { 

            $sql = "CALL SP_ActualizarCiFrontal(:imagenCIFrontal, :id)";
            		
            $stmt  = $this->db->prepare($sql);  
             
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':imagenCIFrontal', $imagenCIFrontal);

            $estado=$stmt->execute();

            return $estado;    

		} catch (Exception $e) {
		    return $e;
		}

  		//Restablecemos el tratamiento de errores
  		restore_error_handler();
            
	}


    function actualizarCiReverso($data){

      //PARTE 2 - TABLA DOCUMENTOS PERSONALES 
      $id = $data['id']; //perfil
      $imagenCITrasera = $data['imagen']; // AJ
 
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

  		try { 

            $sql = "CALL SP_ActualizarCiReverso(:imagenCITrasera, :id)";
            		
            $stmt  = $this->db->prepare($sql);  
             
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':imagenCITrasera', $imagenCITrasera);

            $estado=$stmt->execute();

            return $estado;    

		} catch (Exception $e) {
		    return $e;
		}

  		//Restablecemos el tratamiento de errores
  		restore_error_handler();
            
	}


    function actualizarConstanciaRuc($data){

      //PARTE 2 - TABLA DOCUMENTOS PERSONALES 
      $id = $data['id']; //perfil
      $imagenConstanciaRuc = $data['imagen']; //Constancia de Ruc
 
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

  		try { 

            $sql = "CALL SP_ActualizarConstanciaRuc(:imagenConstanciaRuc, :id)";
            		
            $stmt  = $this->db->prepare($sql);  
             
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':imagenConstanciaRuc', $imagenConstanciaRuc);

            $estado=$stmt->execute();

            return $estado;    

		} catch (Exception $e) {
		    return $e;
		}

  		//Restablecemos el tratamiento de errores
  		restore_error_handler();
            
	}


    function actualizarFotoPerfil($data){

      //PARTE 2 - TABLA DOCUMENTOS PERSONALES 
      $id = $data['id']; //perfil
      $imagen = $data['imagen']; //perfil

      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

  		try { 

            $sql = "CALL SP_ActualizarFotoPerfil(:imagen, :id)";
            		
            $stmt  = $this->db->prepare($sql);  
             
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':imagen', $imagen);

            $estado=$stmt->execute(); 

            return $estado;    

		} catch (Exception $e) {
		    return $e;
		}

  		//Restablecemos el tratamiento de errores
  		restore_error_handler();
            
	}

    function actualizarHabilitacionFrontal($data){

      //PARTE 2 - TABLA DOCUMENTOS PERSONALES 
      $id = $data['id']; //perfil
      $imagenHabilitacionFrontal = $data['imagen']; // habilitacion frontal 

      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

  		try {   

            $sql = "CALL SP_ActualizarHabilitacionFrontal(:imagenHabilitacionFrontal, :id)";
            		
            $stmt  = $this->db->prepare($sql);  
             
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':imagenHabilitacionFrontal', $imagenHabilitacionFrontal); 

            $estado=$stmt->execute(); 

            return $estado;    

		} catch (Exception $e) {
		    return $e;
		}

  		//Restablecemos el tratamiento de errores
  		restore_error_handler();
            
	}


    function actualizarHabilitacionReverso($data){

      //PARTE 2 - TABLA DOCUMENTOS PERSONALES 
      $id = $data['id']; //perfil
      $imagenHabilitacionTrasera = $data['imagen']; // habilitacion reverso

      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

  		try {   

            $sql = "CALL SP_ActualizarHabilitacionReverso(:imagenHabilitacionTrasera, :id)";
            		
            $stmt  = $this->db->prepare($sql);  
             
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':imagenHabilitacionTrasera', $imagenHabilitacionTrasera); 

            $estado=$stmt->execute(); 

            return $estado;    

		} catch (Exception $e) {
		    return $e;
		}

  		//Restablecemos el tratamiento de errores
  		restore_error_handler();
            
	}

    function actualizarLicenciaConducirFrontal($data){

      //PARTE 2 - TABLA DOCUMENTOS PERSONALES 
      $id = $data['id']; //perfil
	  $imagenLicenciaConducirFrontal = $data['imagen']; //licencia frontal
      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

  		try {   

            $sql = "CALL SP_ActualizarLicenciaConducirFrontal(:imagenLicenciaConducirFrontal, :id)";
            		
            $stmt  = $this->db->prepare($sql);  
             
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':imagenLicenciaConducirFrontal', $imagenLicenciaConducirFrontal); 

            $estado=$stmt->execute(); 

            return $estado;    

		} catch (Exception $e) {
		    return $e;
		}

  		//Restablecemos el tratamiento de errores
  		restore_error_handler();
            
	}

    function actualizarLicenciaConducirReverso($data){

      //PARTE 2 - TABLA DOCUMENTOS PERSONALES 
      $id = $data['id']; //perfil
      $imagenLicenciaConducirTrasera = $data['imagen']; //licencia reverso
      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

  		try {   

            $sql = "CALL SP_ActualizarLicenciaConducirReverso(:imagenLicenciaConducirTrasera, :id)";
            		
            $stmt  = $this->db->prepare($sql);  
             
            $stmt->bindParam(':id', $id);  
            $stmt->bindParam(':imagenLicenciaConducirTrasera', $imagenLicenciaConducirTrasera); 

            $estado=$stmt->execute(); 

            return $estado;    

		} catch (Exception $e) {
		    return $e;
		}

  		//Restablecemos el tratamiento de errores
  		restore_error_handler();
            
	}


    function actualizarSeguro($data){

      //PARTE 2 - TABLA DOCUMENTOS PERSONALES 
      $id = $data['id']; //perfil
      $imagenSeguro = $data['imagen']; //licencia reverso
      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

      try {   

            $sql = "CALL SP_ActualizarSeguro(:imagenSeguro, :id)";
                
            $stmt  = $this->db->prepare($sql);  
             
            $stmt->bindParam(':id', $id);  
            $stmt->bindParam(':imagenSeguro', $imagenSeguro); 

            $estado=$stmt->execute(); 

            return $estado;    

    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  } 







    function verificarEmail($data){


      //PARTE 2 - TABLA DOCUMENTOS PERSONALES 
      $id = $data['email']; //perfil
      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

      try {   

            $sql = "select * from usuario where email = :id limit 1;";
                
            $stmt  = $this->db->prepare($sql);  
            $stmt->bindParam(':id', $id);  
            $stmt->execute();   
            $estado = $stmt->fetchAll();


    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
           
     if (count($estado) > 0) {
        $json = array('encontro' =>  true);
      }else{
        $json = array('encontro' =>  false);
      }

      return $json;
            
  } 



    function verificarCelular($data){

      //PARTE 2 - TABLA DOCUMENTOS PERSONALES 
      $id = $data['celular']; //perfil
      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

      try {   

            $sql = "SELECT * from usuario where telefonoMovil = :id limit 1;";
                
            $stmt  = $this->db->prepare($sql);  
            $stmt->bindParam(':id', $id);  
            $stmt->execute();   
            $estado = $stmt->fetchAll();


    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
           
     if (count($estado) > 0) {
        $json = array('encontro' =>  true);
      }else{
        $json = array('encontro' =>  false);
      }

      return $json;
            
  } 




    function verificarCedula($data){

      //PARTE 2 - TABLA DOCUMENTOS PERSONALES 
      $id = $data['ci']; //perfil
      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

      try {   

            $sql = "SELECT * from usuario where num_documento = :id limit 1;";
                
            $stmt  = $this->db->prepare($sql);  
            $stmt->bindParam(':id', $id);  
            $stmt->execute();   
            $estado = $stmt->fetchAll();


    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
           
     if (count($estado) > 0) {
        $json = array('encontro' =>  true);
      }else{
        $json = array('encontro' =>  false);
      }

      return $json;


  } 




  //aca creamos los servicios para actualizar cada documento o vehiculo.

  function actualizar($data){

      $idUsuario = $data['idUsurio'];

	}
    

    public function borrar($data){

            $id = $data['id'];


            $sql_mora_insert = "UPDATE usuario set inactivo = 1 WHERE (idUsuario=:idoremail) or (email =:idoremail) ";
			
            $stmt  = $this->db->prepare($sql_mora_insert);  
            
            $stmt->bindParam(':idoremail', $id);
            



            $estado=$stmt->execute();

			if ($estado) {
				$estado= "exito";
			} else {
				$estado="fallo";
			};
            
			$array = array(
                "codigo" => $codigo,
                "estado" => $estado
            );

            $data = $array;

            
            return $data;    
    }
}

