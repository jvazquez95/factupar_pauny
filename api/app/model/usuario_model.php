<?php
namespace App\Model;
use App\Lib\Response;
use App\Lib\Auth;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class UsuarioModel
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

    function verificarDocumento($data) {
      try {
          $token = Auth::getData($data['token']);
          $idUsuario = $token->id; 
          $Vehiculo_idVehiculo = $token->vehiculo; 
          $nroDocumento = $data['nroDocumento'] ?? null;
  
          if (!$nroDocumento) {
              return null;
          }
  
          // Solo la parte antes del guion
          $nroDocumentoLimpio = explode('-', $nroDocumento)[0];
  
          // Consulta de persona con comparación segura
          $sql = "SELECT * FROM persona 
                  WHERE SUBSTRING_INDEX(nroDocumento, '-', 1) = :nroDocumento 
                  LIMIT 1";
          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':nroDocumento', $nroDocumentoLimpio);
          $stmt->execute();
          $persona = $stmt->fetch();
          $stmt = null;
  
          if (!$persona) {
              return null;
          }
  
          // Consulta de direcciones relacionadas
          $sql = "SELECT 
              d.idDireccion,
              d.Persona_idPersona,
              c.descripcion AS ciudad,
              c.code AS ciudadCode,
              d.direccion,
              d.inactivo,
              d.latitud,
              d.longitud,
              CONCAT('https://factupar.com.py/pauny/files/direcciones/', d.imagen) AS imagen,
              
              -- Agrupar los días y vehículos concatenados
              GROUP_CONCAT(
                  CONCAT(
                      UPPER(da.diaSemana), ' - ', v.nombreReferencia
                  ) 
                  ORDER BY FIELD(da.diaSemana, 'domingo','lunes','martes','miercoles','jueves','viernes','sabado')
                  SEPARATOR ' | '
              ) AS diasAsignados

          FROM direccion d
          JOIN ciudad2 c ON c.code = d.Ciudad_idCiudad
          LEFT JOIN direccion_asignacion_ruta da ON da.Direccion_idDireccion = d.idDireccion
          LEFT JOIN vehiculo v ON v.idVehiculo = da.Vehiculo_idVehiculo
          WHERE d.Persona_idPersona = :Persona_idPersona
          GROUP BY d.idDireccion
          ORDER BY d.idDireccion;
          ";
          
          $stmt = $this->db->prepare($sql);
          //$stmt->bindParam(':Vehiculo_idVehiculo', $Vehiculo_idVehiculo);
          $stmt->bindParam(':Persona_idPersona', $persona->idPersona);
          $stmt->execute();
          $direcciones = $stmt->fetchAll();
          $stmt = null;
  
          $persona->direcciones = $direcciones ?: [];
  
          return $persona;
  
      } catch (Exception $e) {
          return null;
      }
  }
  


    function insertCompraImagen($data) {

      $token = Auth::getData($data['token']);
      $idUsuario = $token->id;
  
      // Definir los valores para insertar
      $fechaInsercion = date('Y-m-d H:i:s');
      $estado = $data['estado'];
      $inactivo = $data['inactivo'];
      $imagen = $data['imagen'];
      //$usuario = $data['usuario'];

      $imagenBase64 = $data['imagen']; // Asegúrate de validar y sanear esta entrada

       if (strpos($imagenBase64, 'data:image/jpeg;base64,') === 0) {
           $imagenBase64 = substr($imagenBase64, strlen('data:image/png;base64,'));
       }
     
       $imagenBase64 = str_replace(' ', '+', $imagenBase64);
       $datosImagen = base64_decode($imagenBase64);
     
       if ($datosImagen === false) {
           // La cadena Base64 no es válida
           die("Error en la decodificación de Base64");
       }
     
       $nombreArchivo = uniqid() . '.jpeg';
       $directorioDestino = "/home/junior/web/factupar.com.py/public_html/pauny/files/comprasApp/";
       $rutaArchivo = $directorioDestino . $nombreArchivo;
     
       $resultado = file_put_contents($rutaArchivo, $datosImagen);
       if ($resultado === false) {
           // No se pudo escribir el archivo
           die("Error al escribir el archivo");
       }
  
      try {
          // Preparar la consulta SQL para insertar datos en comprasImagenes
          $sql = "INSERT INTO comprasImagenes (fechaInsercion, usuarioInsercion, estado, inactivo, imagen)
                  VALUES (:fechaInsercion, :usuarioInsercion, :estado, :inactivo, :imagen)";
          
          // Preparar la declaración
          $stmt = $this->db->prepare($sql);
          
          // Vincular parámetros
          $stmt->bindParam(':fechaInsercion', $fechaInsercion);
          $stmt->bindParam(':usuarioInsercion', $idUsuario);
          $stmt->bindParam(':estado', $estado);
          $stmt->bindParam(':inactivo', $inactivo);
          $stmt->bindParam(':imagen', $nombreArchivo);
          
          // Ejecutar la consulta
          $stmt->execute();
  
          // Retornar el ID del registro insertado
          return array('success' => true, 'idCompraImagen' => $this->db->lastInsertId());
  
      } catch (Exception $e) {
          // Manejar excepciones
          return array('error' => $e->getMessage());
      }
  }
  




  public function getOVPending($data)
  {
      try {
          // Consulta para obtener las cabeceras de OrdenVenta
          $sql = "SELECT o.idOrdenVenta, o.Persona_idPersona, F_NOMBRE_PERSONA(o.Persona_idPersona) as razonSocial
                  FROM ordenventa o 
                  WHERE o.inactivo = 0 and preparado = 0 and o.usuarioInsercion in ('cajatablet', 'admin')";
          
          $stmt = $this->db->prepare($sql);
          $stmt->execute();
           $result = $stmt->fetchAll();
          $stmt = 0;
  
          // Para cada orden, se obtiene su detalle (iteramos por referencia)
          foreach ($result as $orden) {

              $sqlDetail = "SELECT d.OrdenVenta_idOrdenVenta, d.Articulo_idArticulo, F_NOMBRE_ARTICULO(d.Articulo_idArticulo) descripcion, d.cantidad  
                            FROM detalleordenventa d 
                            WHERE d.OrdenVenta_idOrdenVenta = '$orden->idOrdenVenta'";

              $stmtDetail = $this->db->prepare($sqlDetail);
              $stmtDetail->execute();
              $detalle = $stmtDetail->fetchAll();
              // Se agrega el detalle en una clave "detalle"
              $orden->detalle = $detalle;
          }
          unset($orden); // Se libera la referencia
  
          return $result;
  
      } catch (Exception $e) {
          return array('error' => $e->getMessage());
      }
  }
  




    function getComprasImagenes($data) {

      $token = Auth::getData($data['token']);
      $idUsuario = $token->id;

      try {
          // Preparar la consulta SQL para seleccionar datos de comprasImagenes
          $sql = "SELECT idCompraImagen, 
                         fechaInsercion, 
                         usuarioInsercion, 
                         estado, 
                         inactivo, 
                         CONCAT('https://factupar.com.py/pauny/files/comprasApp/', imagen) as imagen 
                  FROM comprasImagenes
                  WHERE usuarioInsercion = :usuarioInsercion";
          
          // Preparar y ejecutar la declaración
          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':usuarioInsercion', $idUsuario);
          $stmt->execute();
  
          // Obtener los resultados
          $result = $stmt->fetchAll();
  
          return $result;
  
      } catch (Exception $e) {
          // Manejar excepciones
          return array('error' => $e->getMessage());
      }
  }
  


function reporte_hr_por_habilitacion($data)
{
    $habilitacion_id = $data['Habilitacion_idHabilitacion'];

    try {
        $sql = "
          /* ---------- ORIGEN (sucursal) ---------- */
              SELECT 
                  s.nombre                AS nombreComercial,
                  0                       AS idPersona,
                  'origen'                AS tipo,
                  1                       AS estado,
                  s.latitud               AS lat,          -- ← alias igual que en visitas
                  s.longitud              AS lng,
                  s.ciudad,
                  s.direccion,
                  0                       AS idDireccion,
                  NULL                    AS imagen,
                  /* flags de días para mantener la misma estructura */
                  0 AS lunes, 0 AS martes, 0 AS miercoles,
                  0 AS jueves, 0 AS viernes, 0 AS sabado, 0 AS domingo
              FROM habilitacion h
              JOIN caja      c ON c.idCaja      = h.Caja_idCaja
              JOIN deposito  d ON d.idDeposito  = c.Deposito_idDeposito
              JOIN sucursal  s ON s.idSucursal  = d.Sucursal_idSucursal
              WHERE h.idhabilitacion = :hid

              UNION ALL

              /* ---------- VISITAS DEL DÍA ---------- */
              SELECT 
                  p.nombreComercial,
                  p.idPersona,
                  v.tipo,
                  v.estado,
                  v.lat                     AS lat,    -- ← mismo alias
                  v.lng                     AS lng,
                  v.ciudad,
                  v.direccion,
                  d.idDireccion,
                  CONCAT('https://factupar.com.py/pauny/files/direcciones/', d.imagen) AS imagen,
                  d.lunes, d.martes, d.miercoles,
                  d.jueves, d.viernes, d.sabado, d.domingo
              FROM ventas_visitas_x_hojaruta_dia v
              JOIN habilitacion h ON v.habilitacion_id = h.idhabilitacion
              JOIN direccion   d ON v.direccion_id     = d.idDireccion
              JOIN persona     p ON d.Persona_idPersona= p.idPersona
              WHERE h.idhabilitacion = :hid

      

        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':hid', $habilitacion_id);
        $stmt->execute();

        return $stmt->fetchAll();

    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}






function reporte_hr($data) {

    $Vehiculo_idVehiculo = $data['Vehiculo_idVehiculo'];
    $diaSemana = $data['diaSemana'];  // acá viene el nombre literal, por ejemplo: 'martes'

    try {
        // Preparar la consulta SQL
        $sql = "SELECT 'ORIGEN' AS nombreComercial, 
                      NULL AS lunes, 
                      NULL AS martes, 
                      NULL AS miercoles, 
                      NULL AS jueves, 
                      NULL AS viernes, 
                      NULL AS sabado, 
                      NULL AS domingo, 
                      -25.3201697 AS latitud,
                      -57.5940285 AS longitud,
                      '' as imagen
                UNION ALL
                SELECT 
                      p.nombreComercial, 
                      CASE WHEN :diaSemana = 'lunes' THEN 1 ELSE NULL END AS lunes,
                      CASE WHEN :diaSemana = 'martes' THEN 1 ELSE NULL END AS martes,
                      CASE WHEN :diaSemana = 'miercoles' THEN 1 ELSE NULL END AS miercoles,
                      CASE WHEN :diaSemana = 'jueves' THEN 1 ELSE NULL END AS jueves,
                      CASE WHEN :diaSemana = 'viernes' THEN 1 ELSE NULL END AS viernes,
                      CASE WHEN :diaSemana = 'sabado' THEN 1 ELSE NULL END AS sabado,
                      CASE WHEN :diaSemana = 'domingo' THEN 1 ELSE NULL END AS domingo,
                      d.latitud, 
                      d.longitud,
                      CONCAT('https://factupar.com.py/pauny/files/direcciones/', d.imagen) AS imagen
                FROM direccion d
                JOIN persona p ON p.idPersona = d.Persona_idPersona
                JOIN direccion_asignacion_ruta ar ON ar.Direccion_idDireccion = d.idDireccion
                WHERE ar.Vehiculo_idVehiculo = :Vehiculo_idVehiculo 
                  AND ar.diaSemana = :diaSemana";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':Vehiculo_idVehiculo', $Vehiculo_idVehiculo);
        $stmt->bindParam(':diaSemana', $diaSemana);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;

    } catch (Exception $e) {
        return array('error' => $e->getMessage());
    }
}




    function reporte_vehiculos($data) {

      try {
          // Preparar la consulta SQL
          $sql = "SELECT idVehiculo, nombreReferencia, matricula from vehiculo v";
  
          // Preparar y ejecutar la declaración
          $stmt = $this->db->prepare($sql);
          $stmt->execute();
          // Obtener los resultados
          $result = $stmt->fetchAll();
  
          return $result;
  
      } catch (Exception $e) {
          // Manejar excepciones
          return array('error' => $e->getMessage());
      }
  }


function reporte_seguimiento($data) {

    $vehiculo     = $data['vehiculo'];
    $fechaInicio  = $data['fechaInicio'];   //  formato YYYY-MM-DD
    $fechaFin     = $data['fechaFin'];

    try {
        /* -------------------------------------------------------------
         *  Día de la semana de la venta  ➜  necesitamos compararlo con
         *  la columna ar.diaSemana  (ENUM: lunes…domingo).
         *  MySQL:  DAYNAME(fechaTransaccion)  → “Monday”, “Tuesday”…;
         *  usamos ELT/WEEKDAY() para obtenerlo en castellano.
         * ------------------------------------------------------------*/
        $sql = "
        SELECT  v.idVenta,
                p.razonSocial,
                v.fechaTransaccion,
                v.serie,
                v.nroFactura,
                v.fechaFactura,
                v.total,
                v.latitud   AS lat_venta,
                v.longitud  AS lng_venta,
                d.latitud   AS lat_direccion,
                d.longitud  AS lng_direccion,
                d.imagen
        FROM        venta v
        JOIN        persona  p ON p.idPersona      = v.Cliente_idCliente
        JOIN        direccion d ON d.idDireccion   = v.Direccion_idDireccion
        JOIN        direccion_asignacion_ruta ar
                       ON ar.Direccion_idDireccion = d.idDireccion
                      AND ar.Vehiculo_idVehiculo   = :vehiculo
                      AND ar.diaSemana             =
                          ELT( WEEKDAY(v.fechaTransaccion)+1,
                               'lunes','martes','miercoles',
                               'jueves','viernes','sabado','domingo')
        WHERE DATE(v.fechaTransaccion) BETWEEN :fechaInicio AND :fechaFin
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':vehiculo'    , $vehiculo      );
        $stmt->bindParam(':fechaInicio' , $fechaInicio   );
        $stmt->bindParam(':fechaFin'    , $fechaFin      );
        $stmt->execute();

        return $stmt->fetchAll();

    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}




    function verificar_habilitacion($data) {
      // Obtener datos del token
      $token = Auth::getData($data['token']);
      $idUsuario = $token->id;
  
      // Variables adicionales
      $tipodocumento = $data['tipodocumento'];  // Asegúrate de recibir 'tipodocumento' en el $data
  
      try {
          // Preparar la consulta SQL
          $sql = "SELECT
              habilitacion.estado, 
              habilitacion.Usuario_idUsuario, 
              habilitacion.idhabilitacion, 
              deposito.idDeposito as dp, 
              DATE(habilitacion.fechaApertura) as fecha, 
              documentocajero.Documento_idTipoDocumento as tipoDocumento, 
              documentocajero.serie, 
              RIGHT(CONCAT('000000', LTRIM(RTRIM(REPLACE(documentocajero.numeroActual + 1, '', '')))), 7) as a, 
              documentocajero.fechaEntrega, 
              documentocajero.timbrado, 
              deposito.idDeposito as deposito, 
              sucursal.nombre as sucursal,
              habilitacion.usuario_ins as usuario_ins
          FROM habilitacion
          JOIN caja ON caja.idcaja = habilitacion.Caja_idCaja
          JOIN sucursal ON caja.Sucursal_idSucursal = sucursal.idsucursal
          JOIN deposito ON deposito.idDeposito = caja.Deposito_idDeposito
          JOIN documentocajero ON documentocajero.Usuario_idUsuario = habilitacion.Usuario_idUsuario
          WHERE habilitacion.Usuario_idUsuario = :idUsuario
          AND habilitacion.estado = 1
          AND documentocajero.Documento_idTipoDocumento = :tipodocumento
          LIMIT 1";
  
          // Preparar y ejecutar la declaración
          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':idUsuario', $idUsuario);
          $stmt->bindParam(':tipodocumento', $tipodocumento);
          $stmt->execute();
  
          // Obtener los resultados
          $result = $stmt->fetch();
  
          return $result;
  
      } catch (Exception $e) {
          // Manejar excepciones
          return array('error' => $e->getMessage());
      }
  }
  


    function calificar($data){
      
      $token = Auth::getData( $data['token'] );
      $email = $token->usuario;


      $calificacion1 = $data['calificacion1'];
      $calificacion2 = $data['calificacion2'];
      $calificacion3 = $data['calificacion3'];
      $comentario = $data['comentario'];
      $uuid = $data['uuid'];

      
    
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

      try {
            // $sql = "CALL SP_conductor_enViaje( :email)";
                
            // $stmt  = $this->db->prepare($sql);  
            
            // $stmt->bindParam(':email', $email);
            // $stmt->execute();
            // $estado = $stmt->fetchAll();


            return  array('calificado' => 1 );     


    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
}



function clientes_usuarios($data){
      
  //$token = Auth::getData( $data['token'] );
  $usuario = $data['usuario'];
  

  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "SELECT idDireccion,persona.razonSocial, persona.telefono, latitud, longitud, direccion.imagen, ciudad2.descripcion 
        from direccion, persona, ciudad2 
        where Persona_idPersona = idPersona and Ciudad_idCiudad = code ";

        $stmt  = $this->db->prepare($sql);  
        // $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $estado = $stmt->fetchAll();
        $stmt = 0; //hacemos esto para poder realizar otras consultas mas abajo.

        return $estado;     


} catch (Exception $e) {
    return $e;
}

  //Restablecemos el tratamiento de errores
  restore_error_handler();
        
}


    public function perfilToken($data)
    {

          $token = Auth::getData( $data['token'] );
          $email = $token->usuario;



            $sql2 = "SELECT idPersona, persona.razonSocial, persona.tipoDocumento, nroDocumento, email, usuario.imagen FROM usuario, persona WHERE persona.idPersona = Persona_idPersona and email=:email and persona.inactivo = 0 limit 1";   
            $stmt = $this->db->prepare($sql2);
            $stmt->bindParam(':email', $email);
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


             $profile[$i++] = $e;









      $json = array('usuario' =>  $profile[0]);

        
      return $json;


    }







    public function validarActivacion($data)
    {



          $token = Auth::getData( $data['token'] );
          $email = $token->usuario;



            $sql = "SELECT f_verificar_documentos( idUsuario ) as documentos, f_verificar_vehiculos( idUsuario ) as vehiculos FROM usuario WHERE  email=:email limit 1";   
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $usuario = $stmt->fetch(); 


      $json = array('usuario' =>  $usuario);

        
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
    



public function finishOrder($data)
    {
      
      $idOrdenVenta = $data['idOrdenVenta'];

      $sql = "UPDATE ordenventa set preparado = 1, fechaPreparadoFin = now() where idOrdenVenta = :idOrdenVenta";   
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':idOrdenVenta', $idOrdenVenta);
      $usuario =  $stmt->execute();




      return $usuario;

    }




public function recuperarPasswordInterno($data)
    {
      
      $token = Auth::getData( $data['token'] );
      $idPersona = $token->id;

      $contrasenaNueva = hash("SHA256",  $data['contrasenaNueva'] );

      $sql = "UPDATE persona set clave = :contrasenaNueva where idPersona = :idPersona";   
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':idPersona', $idPersona);
      $stmt->bindParam(':contrasenaNueva', $contrasenaNueva);
      $usuario =  $stmt->execute();




      return $usuario;

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



    public function consultarPaquetes($data)
    {
          $token = Auth::getData( $data['token'] );
          $idPersona = $token->id;



            $sql = "SELECT nroGuia as nroTracking, 
              CASE
                  WHEN Estado_idEstado > 3 THEN pesoReal
                  WHEN Estado_idEstado < 4 THEN proveedor
              END as origen,
              date(fechaInsercion) as fechaEntrega, 
              descripcion, 
              Estado_idEstado as estado, 
              idImport as idFactura 
              from import 
              where casilla = :idPersona";   
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idPersona', $idPersona);
            $stmt->execute();
            $usuario = $stmt->fetchAll(); 


      $json = array('paquetes' =>  $usuario);

        
      return $json;


    }



    public function consultarPaquetesTracking($data)
    {
          $token = Auth::getData( $data['token'] );
          $idPersona = $token->id;
          $nroTracking = $data['nroTracking'];



            $sql = "SELECT nroGuia as nroTracking, pesoReal, date(fechaInsercion) as fechaEntrega, descripcion, origen, Estado_idEstado as estado, idImport as idFactura from import where casilla = :idPersona and nroGuia = :nroTracking";   
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idPersona', $idPersona);
            $stmt->bindParam(':nroTracking', $nroTracking);
            $stmt->execute();
            $usuario = $stmt->fetchAll(); 


      $json = array('paquetes' =>  $usuario);

        
      return $json;


    }



    public function comprobantes($data)
    {
          $token = Auth::getData( $data['token'] );
          $idPersona = $token->id;



            $sql = "SELECT idVenta, fechaFactura, CONCAT( serie,'-',nroFactura ) as nroFactura, total, 'EFECTIVO' as medioPago, 
            CONCAT( 'https://idealbox.com.py/idealbox/reportes/exFacturaFormPdf.php?id=',idVenta ) as url from venta where Cliente_idCliente = :idPersona";   
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idPersona', $idPersona);
            $stmt->execute();
            $usuario = $stmt->fetchAll(); 


      $json = array('comprobantes' =>  $usuario);

        
      return $json;


    }






    function actualizar($data){

      //PARTE 1 - TABLA USUARIO - PERSONA
          $token = Auth::getData( $data['token'] );
          $idPersona = $token->id;
          $nombre =    $data['nombre'];
          $telefonoMovil = $data['telefonoMovil'];
          $num_documento = $data['num_documento'];
          $fechaNacimiento = $data['fechaNacimiento'];
          $sexo = $data['sexo'];
          $email = strtolower($data['email']);
          $clave = hash("SHA256",  $data['clave'] );
          $latitud = $data['latitud'];
          $longitud = $data['longitud'];
          $direccion = $data['direccion'];
      

      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });



      try {


           $sql = "CALL update_persona( :nombreCompleto, :nroDocumento, :mail, :telefono, :nacimiento, :sexo,:latitud,:longitud, :idPersona, :direccion)";     
           $stmt  = $this->db->prepare($sql);  
            
            $stmt->bindParam(':nombreCompleto', $nombre);
            $stmt->bindParam(':telefono', $telefonoMovil);
            $stmt->bindParam(':nacimiento', $fechaNacimiento);
            $stmt->bindParam(':nroDocumento', $num_documento);
            $stmt->bindParam(':sexo', $sexo);
            $stmt->bindParam(':mail', $email);
            $stmt->bindParam(':idPersona', $idPersona );
            $stmt->bindParam(':latitud', $latitud);
            $stmt->bindParam(':longitud', $longitud);
            $stmt->bindParam(':direccion', $direccion);

    
            $estado=$stmt->execute();
   

            return $estado;
          
    } catch (Exception $e) {
        return $e;
    }




      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }




    function contacto($data){

      //PARTE 1 - TABLA USUARIO - PERSONA
          $nombre =    $data['nombre'];
          $telefono = $data['telefono'];
          $motivo = $data['motivo'];
          $mensaje = $data['mensaje'];

      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });



      try {


                $mail = new PHPMailer(true);
                $mail->SMTPDebug = 0;                               
                $mail->isSMTP();            
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = true;                          
                $mail->Username = "idealbox.atc@gmail.com";                 
                $mail->Password = "caxjbsfgoxdnyvyb";                           
                $mail->SMTPSecure = "tls";                           
                $mail->Port = 587;                                   
                $mail->setFrom('no-reply@robsa.com.py');
                $mail->isHTML(true);
                $mail->addAddress('idealbox.atc@gmail.com'); 
                $mail->Subject = "IdealBox - Formulario de Contacto";

            $mail->Body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                            <html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml">
                              <head>
                                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                                <title>IdealBox</title>
                                
                                
                              </head>
                              <body style="-webkit-text-size-adjust: none; box-sizing: border-box; color: #74787E; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; height: 100%; line-height: 1.4; margin: 0; width: 100% !important;" bgcolor="#F2F4F6"><style type="text/css">
                            body {
                            width: 100% !important; height: 100%; margin: 0; line-height: 1.4; background-color: #F2F4F6; color: #74787E; -webkit-text-size-adjust: none;
                            }
                            @media only screen and (max-width: 600px) {
                              .email-body_inner {
                                width: 100% !important;
                              }
                              .email-footer {
                                width: 100% !important;
                              }
                            }
                            @media only screen and (max-width: 500px) {
                              .button {
                                width: 100% !important;
                              }
                            }
                            </style>

                                <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;" bgcolor="#F2F4F6">
                                  <tr>
                                    <td align="center" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">
                                      <table class="email-content" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;">
                                        <tr>
                                          <td class="email-masthead" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; padding: 25px 0; word-break: break-word;" align="center">
                                            <a href="<?php echo URL; ?>" class="email-masthead_name" style="box-sizing: border-box; color: #bbbfc3; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 16px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
                                    IdealBox
                                  </a>
                                          </td>
                                        </tr>
                                        
                                        <tr>
                                          <td class="email-body" width="100%" cellpadding="0" cellspacing="0" style="-premailer-cellpadding: 0; -premailer-cellspacing: 0; border-bottom-color: #EDEFF2; border-bottom-style: solid; border-bottom-width: 1px; border-top-color: #EDEFF2; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0; padding: 0; width: 100%; word-break: break-word;" bgcolor="#FFFFFF">
                                            <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0 auto; padding: 0; width: 570px;" bgcolor="#FFFFFF">
                                              
                                              <tr>
                                                <td class="content-cell" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; padding: 35px; word-break: break-word;">
                                                  <h1 style="box-sizing: border-box; color: #2F3133; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 19px; font-weight: bold; margin-top: 0;" align="left">Hola mi nombre es: '.$nombre.' , mi Telefono/Cedular es: '.$telefono.',</h1>
                                                  <p style="box-sizing: border-box; color: #74787E; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">El motivo es: '. $motivo .' y el mensaje es: '.$mensaje.' <strong style = "tamaño de caja: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;"></strong></p>
                                                  
                                                </td>
                                              </tr>
                                            </table>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">
                                            <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0 auto; padding: 0; text-align: center; width: 570px;">
                                              <tr>
                                                <td class="content-cell" align="center" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; padding: 35px; word-break: break-word;">
                                                  <p class="sub align-center" style="box-sizing: border-box; color: #AEAEAE; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center">© 2023 IdealBox. Todos los derechos reservados.</p>
                                                </td>
                                              </tr>
                                            </table>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </table>
                              </body>
                            </html>';

                  $mail->send();

                  return $mail;

          
    } catch (Exception $e) {
        return $e;
    }




      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }



 function envio_correo_recuperacion_contrasena($data){

      $correo = $data['correo'];
      $tokenUnico = uniqid();
      $url = "https://idealbox.com.py/auth/recovery?code-verificacion=".$tokenUnico."&email=".$correo;
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });



      try {


            $sql = "select * from persona where mail = :correo";   
            $stmt = $this->db->prepare($sql); 
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
            $resultados = $stmt->fetch(); 
            $nombre = $resultados->razonSocial;
            $id = $resultados->idPersona;
                $mail = new PHPMailer(true);
                $mail->SMTPDebug = 0;                               
                $mail->isSMTP();            
                $mail->Host = getenv('MAILGUN_SMTP_HOST') ?: "smtp.mailgun.org";
                $mail->SMTPAuth = true;                          
                $mail->Username = getenv('MAILGUN_SMTP_USERNAME') ?: "";                 
                $mail->Password = getenv('MAILGUN_SMTP_PASSWORD') ?: "";                           
                $mail->SMTPSecure = "tls";                           
                $mail->Port = 587;                                   
                $mail->setFrom('no-reply@idealbox.com.py');
                $mail->isHTML(true);
                $mail->addAddress($correo); 
                $mail->Subject = "IdealBox - Recuperacion de cuenta";

                $mail->Body = '<!DOCTYPE html>
                <html>
                <head>
                  <meta charset="utf-8">
                  <title>Recuperación de contraseña de la cuenta de IDEALBOX</title>
                  <style>
                    body {
                      font-family: Arial, sans-serif;
                      font-size: 16px;
                      line-height: 1.5;
                      color: #333;
                    }
                    .container {
                      margin: 0 auto;
                      padding: 30px !important;
                      max-width: 600px;
                      background-color: #020c41;
                    }

                    
                    h1 {
                      margin-top: 0;
                      margin-bottom: 20px;
                      font-size: 24px;
                      font-weight: bold;
                      color: #333;
                      text-align: center;
                    }
                    
                    p {
                      margin-top: 0;
                      margin-bottom: 20px;
                      font-size: 16px;
                      line-height: 1.5;
                      color: #333;
                    }
                    
                    a {
                      color: #007bff;
                      text-decoration: none;
                    }
                    
                    a:hover {
                      color: #0056b3;
                      text-decoration: underline;
                    }
                    
                    .container {
                      max-width: 600px;
                      margin: 0 auto;
                      padding: 20px;
                      background-color: #fff;
                      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                      border-radius: 10px;
                    }
                    
                    .btn {
                      display: inline-block;
                      padding: 10px 20px;
                      font-size: 16px;
                      font-weight: bold;
                      color: #fff;
                      background-color: #007bff;
                      border-radius: 5px;
                      text-decoration: none;
                    }
                    
                    .btn:hover {
                      background-color: #0056b3;
                    }
                  </style>
                </head>
                <body>
                  <div class="container">
                  <tr>
                  <td>
                    <img height="80" src="https://idealbox.com.py/logo.png" alt="" />
                  </td>
                </tr>
                    <h1>Recuperación de contraseña de la cuenta de IDEALBOX</h1>
                    <p>Hola '.$nombre.', hemos recibido una solicitud de recuperación de contraseña para la cuenta de IDEALBOX asociada con este correo electrónico. Si no solicitó la recuperación de contraseña, por favor ignore este mensaje.</p>
                    <p>Si necesita restablecer su contraseña, por favor haga clic en el siguiente botón:</p>
                    <p><a href="'.$url.'" class="btn">Restablecer contraseña</a></p>
                    <p>Por favor, tenga en cuenta que la contraseña debe contener al menos 8 caracteres y debe incluir al menos una letra mayúscula, una letra minúscula, un número y un carácter especial. Le recomendamos que elija una contraseña segura y única para evitar posibles riesgos de seguridad.</p>
                    <p>Si tiene alguna pregunta o necesita asistencia adicional, no dude en ponerse en contacto con nuestro equipo de soporte a través de nuestro sitio web o por correo electrónico.</p>
                  </div>
                </body>
                </html>
                              ';

                  $mail->send();

                    $sql = "UPDATE persona set fechaModificacion = now(), claveRecuperacion = :claveRecuperacion, fechaVencimiento = now() where idPErsona = :id";      
                    $stmt  = $this->db->prepare($sql);            
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':claveRecuperacion', $tokenUnico);
                    $estado=$stmt->execute();


                  return $estado;

          
    } catch (Exception $e) {
        return $e;
    }




      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }








    function envio_correo($data){

      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });



      try {


            $sql = "SELECT notificacionesEstados.*, descripcion, nroGuia 
            from notificacionesEstados, import where import.idImport = notificacionesEstados.Import_idImport 
            and notificado = 0 and estado = 'MIAMI'  group by estado, Import_idImport order by 1 asc ;";   
            $stmt = $this->db->prepare($sql); 
            $stmt->execute();
            $resultados = $stmt->fetchAll(); 
            //return $resultados;
            foreach ($resultados as $resultado) {

              $mail = new PHPMailer(true);
              $mail->SMTPDebug = 0;                               
              $mail->isSMTP();            
              $mail->Host = getenv('MAILGUN_SMTP_HOST') ?: "smtp.mailgun.org";
              $mail->SMTPAuth = true;                          
              $mail->Username = getenv('MAILGUN_SMTP_USERNAME') ?: "";                 
              $mail->Password = getenv('MAILGUN_SMTP_PASSWORD') ?: "";                           
              $mail->SMTPSecure = "tls";                           
              $mail->Port = 587;                                   
              $mail->setFrom('atc@idealbox.com.py');
              $mail->isHTML(true);
              $mail->addAddress($resultado->correo); 
              $mail->Subject = "IdealBox - Notificacion de Estado de Paquetes";

                $mail->Body = '<!DOCTYPE html>
                <html>
                <head>
                  <meta charset="utf-8">
                  <style>
                    /* Estilos CSS */
                    body {
                      font-family: Arial, sans-serif;
                      background-color: #111c4e;
                      margin: 0;
                      padding: 0;
                    }
                
                    .container {
                      margin: 0 auto;
                      padding: 30px !important;
                      max-width: 600px;
                      background-color: #020c41;
                    }
                
                    h1 {
                      color: #ffffff;
                      margin-top: 0;
                    }
                
                    p {
                      color: #ffffff;
                      margin-top: 0;
                    }
                
                    .button {
                      display: inline-block;
                      color: #ffffff;
                      padding: 10px 20px;
                      text-align: center;
                      text-decoration: none;
                      border-radius: 5px;
                      background-color: #1fb1d7;
                    }
                
                    .box-one {
                      padding: 30px;
                      border-radius: 16px;
                      background-color: rgba(255, 255, 255, 0.04);
                    }
                
                    .saludo {
                      color: #ffffff;
                      font-family: "Montserrat", sans-serif;
                      font-size: 30px;
                      font-weight: 900;
                      line-height: normal;
                      text-transform: uppercase;
                    }
                
                    .text .p1 {
                      color: #ffffff;
                      font-family: "Inter", sans-serif;
                      font-size: 16px;
                      font-weight: 400;
                      line-height: 1.5;
                      margin: 0;
                    }
                
                    .bloque-inner-one {
                      display: flex;
                      padding: 10px;
                      gap: 5px;
                      align-items: center;
                    }
                
                    .titulo-pregunta {
                      color: #ffffff;
                      font-size: 17px;
                      font-weight: 900;
                      line-height: normal;
                      text-transform: uppercase;
                    }
                
                    .cat {
                      display: flex;
                      justify-content: space-between;
                      align-items: center;
                    }
                
                    .icono {
                      border-radius: 8px;
                      background-color: rgba(255, 255, 255, 0.05);
                    }
                
                    .copytext {
                      color: #ffffff;
                      font-family: "Inter", sans-serif;
                      font-size: 14px;
                      font-weight: 400;
                      line-height: normal;
                    }
                
                    .tr-bold th {
                      color: #ffffff;
                      font-family: "Inter", sans-serif;
                      font-size: 14px;
                      font-weight: 700;
                      line-height: normal;
                      text-transform: uppercase;
                      border-bottom: solid 1px #c7c7c7b5;
                    }
                
                    .tr-light td {
                      color: #ffffff;
                      font-family: "Inter", sans-serif;
                      font-size: 14px;
                      font-weight: 400;
                      line-height: normal;
                      text-transform: uppercase;
                      padding: 5px;
                    }
                
                    .head-table {
                      border-bottom: solid 1px #ffffff;
                    }
                  </style>
                </head>
                <body>
                <table class="container" cellpadding="0" cellspacing="0">
                  <tr>
                    <img height="80" src="https://idealbox.com.py/logo.png" alt="" />
                  </tr>
                  <tr>
                    <td class="box-one">
                      <h1 class="saludo">HOLA '.$resultado->nombre.'</h1>
                      <div class="bloque-inner-one">
                        <div class="icono">
                            <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.3333 45.3333C13.3333 46.7478 13.8952 48.1044 14.8953 49.1046C15.8955 50.1048 17.2521 50.6667 18.6666 50.6667C20.0811 50.6667 21.4376 50.1048 22.4378 49.1046C23.438 48.1044 23.9999 46.7478 23.9999 45.3333C23.9999 43.9188 23.438 42.5623 22.4378 41.5621C21.4376 40.5619 20.0811 40 18.6666 40C17.2521 40 15.8955 40.5619 14.8953 41.5621C13.8952 42.5623 13.3333 43.9188 13.3333 45.3333ZM39.9999 45.3333C39.9999 46.7478 40.5618 48.1044 41.562 49.1046C42.5622 50.1048 43.9188 50.6667 45.3333 50.6667C46.7477 50.6667 48.1043 50.1048 49.1045 49.1046C50.1047 48.1044 50.6666 46.7478 50.6666 45.3333C50.6666 43.9188 50.1047 42.5623 49.1045 41.5621C48.1043 40.5619 46.7477 40 45.3333 40C43.9188 40 42.5622 40.5619 41.562 41.5621C40.5618 42.5623 39.9999 43.9188 39.9999 45.3333Z" stroke="#FFC800" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M13.3333 45.3333H7.99992V34.6666M5.33325 13.3333H34.6666V45.3333M23.9999 45.3333H39.9999M50.6666 45.3333H55.9999V29.3333M55.9999 29.3333H34.6666M55.9999 29.3333L47.9999 15.9999H34.6666M7.99992 23.9999H18.6666" stroke="#FFC800" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                        </div>
                        <div class="text">
                          <p class="p1">Tu paquete está en</p>
                          <strong class="p1">MIAMI</strong>
                        </div>
                      </div>
                      <div class="bloque-inner-one">
                        <div class="icono">
                          <svg
                            width="64"
                            height="64"
                            viewBox="0 0 64 64"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              d="M24 13.3333H18.6667C17.2522 13.3333 15.8956 13.8952 14.8954 14.8953C13.8952 15.8955 13.3333 17.2521 13.3333 18.6666V50.6666C13.3333 52.0811 13.8952 53.4376 14.8954 54.4378C15.8956 55.438 17.2522 55.9999 18.6667 55.9999H45.3333C46.7478 55.9999 48.1044 55.438 49.1046 54.4378C50.1048 53.4376 50.6667 52.0811 50.6667 50.6666V18.6666C50.6667 17.2521 50.1048 15.8955 49.1046 14.8953C48.1044 13.8952 46.7478 13.3333 45.3333 13.3333H40"
                              stroke="#FFC800"
                              stroke-width="3"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                            />
                            <path
                              d="M24 32H40M24 42.6667H40M24 13.3333C24 11.9188 24.5619 10.5623 25.5621 9.5621C26.5623 8.5619 27.9188 8 29.3333 8H34.6667C36.0812 8 37.4377 8.5619 38.4379 9.5621C39.4381 10.5623 40 11.9188 40 13.3333C40 14.7478 39.4381 16.1044 38.4379 17.1046C37.4377 18.1048 36.0812 18.6667 34.6667 18.6667H29.3333C27.9188 18.6667 26.5623 18.1048 25.5621 17.1046C24.5619 16.1044 24 14.7478 24 13.3333Z"
                              stroke="#FFC800"
                              stroke-width="3"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                            />
                          </svg>
                        </div>
                        <div class="text">
                          <p class="p1">Descripción</p>
                          <strong class="p1">'.$resultado->descripcion.'</strong>
                        </div>
                      </div>
                      <div class="bloque-inner-one">
                        <div class="icono">
                          <svg
                            width="64"
                            height="64"
                            viewBox="0 0 64 64"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              d="M10.6667 18.6667V16.0001C10.6667 14.5856 11.2286 13.229 12.2288 12.2288C13.2289 11.2287 14.5855 10.6667 16 10.6667H21.3333M10.6667 45.3334V48.0001C10.6667 49.4146 11.2286 50.7711 12.2288 51.7713C13.2289 52.7715 14.5855 53.3334 16 53.3334H21.3333M42.6667 10.6667H48C49.4145 10.6667 50.771 11.2287 51.7712 12.2288C52.7714 13.229 53.3333 14.5856 53.3333 16.0001V18.6667M42.6667 53.3334H48C49.4145 53.3334 50.771 52.7715 51.7712 51.7713C52.7714 50.7711 53.3333 49.4146 53.3333 48.0001V45.3334M26.6667 29.3334V34.6667M50.6667 29.3334V34.6667M13.3333 29.3334H16V34.6667H13.3333V29.3334ZM37.3333 29.3334H40V34.6667H37.3333V29.3334Z"
                              stroke="#FFC800"
                              stroke-width="3"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                            />
                          </svg>
                        </div>
                        <div class="text">
                          <p class="p1">N° de Tracking:</p>
                          <strong class="p1">'.$resultado->nroGuia.'</strong>
                        </div>
                      </div>
                    </td>
                  </tr>
                </table>
                <table class="container">
                    <td class="box-one">
            
                        <div class="cat">
                            <div class="titulo-pregunta">
                                Tenés dudas o consultas sobre el servicio?
                            </div>
                            <div>
                                <p><a href="https://idealbox.com.py/contacto" class="button">CONTACTA</a></p>
                
                            </div>
                        </div>
                    </td>
                </table>
                <div class="copytext">Todos los derechos reservados © 2023. IdealBox</div>
              </body>
                </html>';
                
                

                  $mail->send();

                    $sql = "UPDATE notificacionesEstados set notificado = 1, fechaNotificado = now() where idNotificacionEstado = :id";      
                    $stmt  = $this->db->prepare($sql);            
                    $stmt->bindParam(':id', $resultado->idNotificacionEstado);
                    $estado=$stmt->execute();

                    

                  }

                  return $mail;

          
    } catch (Exception $e) {
        return $e;
    }




      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }





  function envio_correo_asuncion($data){

    //Activamos todas las notificaciones de error posibles
    error_reporting (E_ALL);
   
    //Definimos el tratamiento de errores no controlados
    set_error_handler(function () 
    {
      throw new Exception("Error");
    });



    try {

          $sql = "SELECT  import.casilla ,notificacionesEstados.nombre, notificacionesEstados.correo, import.manifiesto, idNotificacionEstado
          from notificacionesEstados, import 
          where import.idImport = notificacionesEstados.Import_idImport and notificado = 0 and estado = 'ASUNCION' 
          group by casilla, import.manifiesto  order by 4,1 asc";   

          $stmt = $this->db->prepare($sql); 
          $stmt->execute();
          $resultados = $stmt->fetchAll();
          $stmt = 0;

          foreach ($resultados as $resultado) {

            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 0;                               
            $mail->isSMTP();            
            $mail->Host = getenv('MAILGUN_SMTP_HOST') ?: "smtp.mailgun.org";
            $mail->SMTPAuth = true;                          
            $mail->Username = getenv('MAILGUN_SMTP_USERNAME') ?: "";                 
            $mail->Password = getenv('MAILGUN_SMTP_PASSWORD') ?: "";                           
            $mail->SMTPSecure = "tls";                           
            $mail->Port = 587;                                   
            $mail->setFrom('atc@idealbox.com.py');
            $mail->isHTML(true);
            $mail->addAddress($resultado->correo); 
            $mail->Subject = "IdealBox - Notificacion de Estado de Paquetes";


            $sql = "SELECT  notificacionesEstados.*, descripcion, nroGuia, import.pesoReal
            from notificacionesEstados, import 
            where import.idImport = notificacionesEstados.Import_idImport and notificado = 0 and estado = 'ASUNCION' and import.manifiesto = :manifiesto and import.casilla = :casilla
             order by 1 asc";   
            $stmt2 = $this->db->prepare($sql); 
            $stmt2->bindParam(':manifiesto', $resultado->manifiesto);
            $stmt2->bindParam(':casilla', $resultado->casilla);
            $stmt2->execute();
            $detalles = $stmt2->fetchAll();
            $stmt2 = 0;
            $detalle_2 = '';
            foreach ($detalles as $detalle) {
                $detalle_2 .= '<tr class="tr-light"><td>'.$detalle->nroGuia.'</td><td>'.$detalle->pesoReal.'</td><td>'.$detalle->descripcion.'</td></tr>';
            }

              $mail->Body = '<!DOCTYPE html>
              <html>
                <head>
                  <meta charset="utf-8" />
                  <style>
                    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;900&family=Montserrat:wght@800&family=Nunito:wght@400;600;700&display=swap");
                  </style>
                  <style>
                    /* Estilos CSS */
                    body {
                      font-family: Arial, sans-serif;
                      background-color: #111c4e;
                      margin: 0;
                      padding: 0;
                    }
                
                    .container {
                      margin: 0 auto;
                      padding: 30px !important;
                      max-width: 600px;
                      background-color: #020c41;
                    }
                
                    h1 {
                      color: #ffffff;
                      margin-top: 0;
                    }
                
                    p {
                      color: #ffffff;
                      margin-top: 0;
                    }
                
                    .button {
                      display: inline-block;
                      color: #ffffff;
                      padding: 10px 20px;
                      text-align: center;
                      text-decoration: none;
                      border-radius: 5px;
                      background-color: #1fb1d7;
                    }
                
                    .box-one {
                      padding: 30px;
                      border-radius: 16px;
                      background-color: rgba(255, 255, 255, 0.04);
                    }
                
                    .saludo {
                      color: #ffffff;
                      font-family: "Montserrat", sans-serif;
                      font-size: 30px;
                      font-weight: 900;
                      line-height: normal;
                      text-transform: uppercase;
                    }
                
                    .text .p1 {
                      color: #ffffff;
                      font-family: "Inter", sans-serif;
                      font-size: 16px;
                      font-weight: 400;
                      line-height: 1.5;
                      margin: 0;
                    }
                
                    .bloque-inner-one {
                      display: flex;
                      padding: 10px;
                      gap: 5px;
                      align-items: center;
                    }
                
                    .titulo-pregunta {
                      color: #ffffff;
                      font-size: 17px;
                      font-weight: 900;
                      line-height: normal;
                      text-transform: uppercase;
                    }
                
                    .cat {
                      display: flex;
                      justify-content: space-between;
                      align-items: center;
                    }
                
                    .icono {
                      border-radius: 8px;
                      background-color: rgba(255, 255, 255, 0.05);
                    }
                
                    .copytext {
                      color: #ffffff;
                      font-family: "Inter", sans-serif;
                      font-size: 14px;
                      font-weight: 400;
                      line-height: normal;
                    }
                
                    .tr-bold th {
                      color: #ffffff;
                      font-family: "Inter", sans-serif;
                      font-size: 14px;
                      font-weight: 700;
                      line-height: normal;
                      text-transform: uppercase;
                      border-bottom: solid 1px #c7c7c7b5;
                    }
                
                    .tr-light td {
                      color: #ffffff;
                      font-family: "Inter", sans-serif;
                      font-size: 14px;
                      font-weight: 400;
                      line-height: normal;
                      text-transform: uppercase;
                      padding: 5px;
                    }
                
                    .head-table {
                      border-bottom: solid 1px #ffffff;
                    }
                  </style>
                </head>
                <body>
                  <div class="container" cellpadding="0" cellspacing="0">
                    <div>
                      <img height="80" src="https://idealbox.com.py/logo.png" alt="" />
                    </div>
                  
                      <div class="box-one">
                        <h1 class="saludo">HOLA '.$resultado->nombre.'</h1>
                        <div class="bloque-inner-one">
                          <div class="icono">
                              <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M5 35H35M5 11.6667V13.3333C5 14.6594 5.52678 15.9312 6.46447 16.8689C7.40215 17.8065 8.67392 18.3333 10 18.3333C11.3261 18.3333 12.5979 17.8065 13.5355 16.8689C14.4732 15.9312 15 14.6594 15 13.3333M5 11.6667H35M5 11.6667L8.33333 5H31.6667L35 11.6667M15 13.3333V11.6667M15 13.3333C15 14.6594 15.5268 15.9312 16.4645 16.8689C17.4021 17.8065 18.6739 18.3333 20 18.3333C21.3261 18.3333 22.5979 17.8065 23.5355 16.8689C24.4732 15.9312 25 14.6594 25 13.3333M25 13.3333V11.6667M25 13.3333C25 14.6594 25.5268 15.9312 26.4645 16.8689C27.4021 17.8065 28.6739 18.3333 30 18.3333C31.3261 18.3333 32.5979 17.8065 33.5355 16.8689C34.4732 15.9312 35 14.6594 35 13.3333V11.6667M8.33333 35V18.0833M31.6667 35V18.0833M15 35V28.3333C15 27.4493 15.3512 26.6014 15.9763 25.9763C16.6014 25.3512 17.4493 25 18.3333 25H21.6667C22.5507 25 23.3986 25.3512 24.0237 25.9763C24.6488 26.6014 25 27.4493 25 28.3333V35" stroke="#FFC800" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                  </svg>  
                          </div>
                          <div class="text">
                            <p class="p1">Te informamos que tus paquetes ya estan en nuestra oficina listos para retirar.</p>
                          </div>
                        </div>
                      <table class="tb-content">
                          <thead class="head-table">
                              <tr class="tr-bold">
                                  <th>Nro. de tracking</th>
                                  <th>PESO KG</th>
                                  <th>DESCRIPCION</th>
                                </tr>
                          </thead>
                          <tbody>
                          '.$detalle_2.'
                          </tbody>
                        </table>
                      </div>
                  </div>
                  <table class="container">
                      <td class="box-one">
              
                          <div class="cat">
                          <div class="titulo-pregunta">
                              Tenes dudas o consultas sobre el servicio?
                          </div>
                          <div>
                              <p><a href="https://idealbox.com.py/contacto" class="button">CONTACTA</a></p>
              
                          </div>
                      </td>
                  </table>
                  <div class="copytext">Todos los derechos reservados © 2023. IdealBox</div>
                </body>
              </html>
              ';
              
              

                $mail->send();

                  $sql = "UPDATE notificacionesEstados set notificado = 1, fechaNotificado = now() where manifiesto = :id and correo = :correo and estado = 'ASUNCION'";      
                  $stmt  = $this->db->prepare($sql);            
                  $stmt->bindParam(':id', $resultado->manifiesto);
                  $stmt->bindParam(':correo', $resultado->correo);
                  $estado=$stmt->execute();

                }

                return $mail;

        
  } catch (Exception $e) {
      return $e;
  }




    //Restablecemos el tratamiento de errores
    restore_error_handler();
          
}


public function datosCuenta($data)
{
      $token = Auth::getData( $data['token'] );
      $idUsuario = $token->id;
      $login = $token->login;

      $sql = "SELECT * from usuario where idusuario = :idUsuario";   
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':idUsuario', $idUsuario);
      $stmt->execute();
      $usuario = $stmt->fetch(); 
      $stmt = 0;

      $sql = "SELECT * from habilitacion h where h.estado = 1 and Usuario_idUsuario = :idUsuario";   
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':idUsuario', $idUsuario);
      $stmt->execute();
      $habilitaciones = $stmt->fetchAll(); 
      $stmt = 0;
      



  $json = array('usuario' =>  $usuario, 'habilitaciones' => $habilitaciones, 'visitas' => 0, 'ventas' => 0, 'cobros' => 0, 'productos_vendidos' => 0);

    
  return $json;


}


function misHabilitaciones($data){
      
  $token = Auth::getData($data['token']);
  $idUsuario = $token->id;
  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "SELECT h.idhabilitacion , c.nombre , c.Deposito_idDeposito as nroDeposito,  u.login, h.fechaApertura , h.fechaCierre, CONCAT('https://factupar.com.py/pauny/reportes/rptNewArqueo.php?habilitacion=', h.idHabilitacion) as urlArqueo ,h.estado 
        from habilitacion h, caja c , usuario u  
        where h.Caja_idCaja = c.idcaja and u.idusuario = h.Usuario_idUsuario  and h.Usuario_idUsuario = :idUsuario 
        order by 1 desc";
            
        $stmt  = $this->db->prepare($sql);  
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();
        return $cajas= $stmt->fetchAll();  


} catch (Exception $e) {
    return $e;
}

  //Restablecemos el tratamiento de errores
  restore_error_handler();
        
}



function listarCuotasVenta($data){
  $token = Auth::getData($data['token']);
  $idVenta = $data['idVenta'];
  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "SELECT nroCuota, fechaVencimiento, monto, saldo from detalleventacuotas where Venta_idVenta = :idVenta and saldo> 0";
            
        $stmt  = $this->db->prepare($sql);  
        $stmt->bindParam(':idVenta', $idVenta);
        $stmt->execute();
        return $cuotasPendientes = $stmt->fetchAll();  


} catch (Exception $e) {
    return $e;
}

}

function selectRecibosPersona($data){
  $token = Auth::getData($data['token']);
  $idPersona = $data['idPersona'];
  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "SELECT idVenta, serie, nroFactura, fechaFactura, cuotas, sum(detalleventacuotas.saldo) as saldo 
        from venta, detalleventacuotas 
        where venta.idVenta = detalleventacuotas.Venta_idVenta and 
        venta.Cliente_idCliente = :idPersona and 
        detalleventacuotas.saldo >0 and venta.inactivo = 0 
        group by idVenta";
            
        $stmt  = $this->db->prepare($sql);  
        $stmt->bindParam(':idPersona', $idPersona);
        $stmt->execute();
        return $facturasPendientes = $stmt->fetchAll();  


} catch (Exception $e) {
    return $e;
}

  //Restablecemos el tratamiento de errores
  restore_error_handler();
        
}





function selectDireccionesPersona($data){
  $token = Auth::getData($data['token']);
  $idPersona = $data['idPersona'];
  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "SELECT idDireccion, direccion from direccion where  Persona_idPersona = :idPersona";
            
        $stmt  = $this->db->prepare($sql);  
        $stmt->bindParam(':idPersona', $idPersona);
        $stmt->execute();
        return $cajas= $stmt->fetchAll();  


} catch (Exception $e) {
    return $e;
}

  //Restablecemos el tratamiento de errores
  restore_error_handler();
        
}




function selectTerminosPagos($data){
  $token = Auth::getData($data['token']);
  $idPersona = $data['idPersona'];
  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "SELECT terminopago.idTerminoPago, terminopago.descripcion
        from terminopago 
        where cantidadCuotas <= (select cantidadCuotas from persona_tipopersona, terminopago where persona_tipopersona.terminoPago = terminopago.idTerminoPago and Persona_idPersona = :idPersona and TipoPersona_idTipoPersona = 1 and terminopago.inactivo = 0 order by persona_tipopersona.idPersonaTipoPersona desc limit 1)";
            
        $stmt  = $this->db->prepare($sql);  
        $stmt->bindParam(':idPersona', $idPersona);
        $stmt->execute();
        return $cajas= $stmt->fetchAll();  


} catch (Exception $e) {
    return $e;
}

  //Restablecemos el tratamiento de errores
  restore_error_handler();
        
}



function selectFormasPagos($data){
      
  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "SELECT idFormaPago, descripcion FROM formapago where inactivo=0";
            
        $stmt  = $this->db->prepare($sql);  
        $stmt->execute();
        return $cajas= $stmt->fetchAll();  


} catch (Exception $e) {
    return $e;
}

  //Restablecemos el tratamiento de errores
  restore_error_handler();
        
}


function selectBancos($data){
      
  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "SELECT idBanco , descripcion  from banco b";
            
        $stmt  = $this->db->prepare($sql);  
        $stmt->execute();
        return $bancos= $stmt->fetchAll();  


} catch (Exception $e) {
    return $e;
}

  //Restablecemos el tratamiento de errores
  restore_error_handler();
        
}


function preventas_fecha_anulados($data){

  $token = Auth::getData($data['token']);
  $usuario = $token->login;
  
  $fecha_inicial = $data['fecha_inicial'];
  $fecha_final = $data['fecha_final'];

  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "SELECT o.idOrdenVenta , p.nombreComercial, p.nroDocumento, o.usuarioInsercion , o.fechaInsercion , tp.descripcion as termino, total
        FROM ordenventa o
        JOIN terminopago tp ON tp.idTerminoPago = o.TerminoPago_idTerminoPago
        JOIN persona p ON p.idPersona = o.Persona_idPersona 
        WHERE o.inactivo = 1 and o.usuarioInsercion  = :usuario and o.fecha BETWEEN :fecha_inicial and :fecha_final order by 1 desc";  
        $stmt = $this->db->prepare($sql);  
        $stmt->bindParam(':fecha_inicial', $fecha_inicial);
        $stmt->bindParam(':fecha_final', $fecha_final);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $ventas= $stmt->fetchAll();  
        $stmt = 0;

        foreach ($ventas as $venta) {
          $idOrdenVenta = $venta->idOrdenVenta;
          $sql = "SELECT d.idDetalleOrdenVenta , d.OrdenVenta_idOrdenVenta , descripcion , cantidad , precio , total  from detalleordenventa d 
          where d.OrdenVenta_idOrdenVenta  = :idOrdenVenta";
          $stmt = $this->db->prepare($sql);  
          $stmt->bindParam(':idOrdenVenta', $idOrdenVenta);
          $stmt->execute();
          $detalle= $stmt->fetchAll();  
          $stmt = 0;
          $venta->detalle = $detalle;
        }


        return $ventas;
  } catch (Exception $e) {
    return $e;
}

      //Restablecemos el tratamiento de errores
      restore_error_handler();
        
}






function ventas_fecha_anulados($data){

  $token = Auth::getData($data['token']);
  $fecha_inicial = $data['fecha_inicial'];
  $fecha_final = $data['fecha_final'];

  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "CALL SP_ListadoVentasAnuladas(1, 1, :fecha_inicial, :fecha_final )";
            
        $stmt = $this->db->prepare($sql);  
        $stmt->bindParam(':fecha_inicial', $fecha_inicial);
        $stmt->bindParam(':fecha_final', $fecha_final);
        $stmt->execute();
        $ventas= $stmt->fetchAll();  
        $stmt = 0;

        foreach ($ventas as $venta) {
          $idVenta = $venta->idVenta;
          $sql = "SELECT d.idDetalleVenta, Venta_idVenta, descripcion , cantidad , precio , total  from detalleventa d where d.Venta_idVenta = :idVenta";  
          $stmt = $this->db->prepare($sql);  
          $stmt->bindParam(':idVenta', $idVenta);
          $stmt->execute();
          $detalle= $stmt->fetchAll();  
          $stmt = 0;
          $venta->detalle = $detalle;
        }


        return $ventas;

} catch (Exception $e) {
    return $e;
}

  //Restablecemos el tratamiento de errores
  restore_error_handler();
        
}




function preventas_fecha($data){

  $token = Auth::getData($data['token']);
  $usuario = $token->login;
  $fecha_inicial = $data['fecha_inicial'];
  $fecha_final = $data['fecha_final'];

  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "SELECT o.idOrdenVenta , p.nombreComercial, p.nroDocumento, o.usuarioInsercion , o.fechaInsercion as fechaTransaccion, o.fecha , tp.descripcion as termino, total
        FROM ordenventa o
        JOIN terminopago tp ON tp.idTerminoPago = o.TerminoPago_idTerminoPago
        JOIN persona p ON p.idPersona = o.Persona_idPersona 
        WHERE o.inactivo = 0 and o.usuarioInsercion  = :usuario and o.fecha BETWEEN :fecha_inicial and :fecha_final order by 1 desc";  
        $stmt = $this->db->prepare($sql);  
        $stmt->bindParam(':fecha_inicial', $fecha_inicial);
        $stmt->bindParam(':fecha_final', $fecha_final);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $ventas= $stmt->fetchAll();  
        $stmt = 0;

        foreach ($ventas as $venta) {
          $idOrdenVenta = $venta->idOrdenVenta;
          $sql = "SELECT d.idDetalleOrdenVenta , d.OrdenVenta_idOrdenVenta , descripcion , cantidad , precio , total  from detalleordenventa d 
          where d.OrdenVenta_idOrdenVenta  = :idOrdenVenta";
          $stmt = $this->db->prepare($sql);  
          $stmt->bindParam(':idOrdenVenta', $idOrdenVenta);
          $stmt->execute();
          $detalle= $stmt->fetchAll();  
          $stmt = 0;
          $venta->detalle = $detalle;
        }


        return $ventas;
  } catch (Exception $e) {
    return $e;
}

      //Restablecemos el tratamiento de errores
      restore_error_handler();
        
}








function ventas_fecha($data){

  $token = Auth::getData($data['token']);
  $usuario = $token->login;
  $fecha_inicial = $data['fecha_inicial'];
  $fecha_final = $data['fecha_final'];

  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "SELECT Remision, idVenta, p.nombreComercial, p.nroDocumento, usuario, CONCAT(serie,'-',nroFactura) as nroFactura, fechaTransaccion, fechaVencimiento, timbrado, tp.descripcion as termino, m.descripcion as moneda, total, vendedor, total/IF(cuotas=0,1,cuotas) AS montoCuota
        FROM venta v
        JOIN moneda m ON m.idMoneda = v.Moneda_idMoneda
        JOIN terminopago tp ON tp.idTerminoPago = v.TerminoPago_idTerminoPago
        JOIN persona p ON p.idPersona = v.Cliente_idCliente
        WHERE v.inactivo = 0 and v.usuario = :usuario and fechaFactura BETWEEN :fecha_inicial and :fecha_final order by 2 desc";  
        $stmt = $this->db->prepare($sql);  
        $stmt->bindParam(':fecha_inicial', $fecha_inicial);
        $stmt->bindParam(':fecha_final', $fecha_final);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $ventas= $stmt->fetchAll();  
        $stmt = 0;

        foreach ($ventas as $venta) {
          $idVenta = $venta->idVenta;
          $sql = "SELECT d.idDetalleVenta, Venta_idVenta, descripcion , cantidad , precio , total  from detalleventa d where d.Venta_idVenta = :idVenta";  
          $stmt = $this->db->prepare($sql);  
          $stmt->bindParam(':idVenta', $idVenta);
          $stmt->execute();
          $detalle= $stmt->fetchAll();  
          $stmt = 0;
          $venta->detalle = $detalle;
        }


        return $ventas;
  } catch (Exception $e) {
    return $e;
}

      //Restablecemos el tratamiento de errores
      restore_error_handler();
        
}



function selectCajas($data){
      
  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "SELECT  c.idCaja,
        c.nombre,
        d.descripcion
FROM    caja      AS c
JOIN    deposito  AS d   ON d.idDeposito = c.Deposito_idDeposito
WHERE   NOT EXISTS (
          SELECT 1
          FROM   habilitacion AS h
          WHERE  h.Caja_idCaja = c.idCaja
            AND  h.estado      = 1
        );";
            
        $stmt  = $this->db->prepare($sql);  
        $stmt->execute();
        return $cajas= $stmt->fetchAll();  


} catch (Exception $e) {
    return $e;
}

  //Restablecemos el tratamiento de errores
  restore_error_handler();
        
}



function listadoParametrosSincronizar($data){
  $token = Auth::getData($data['token']);
  $idPersona = $data['idPersona'];
  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "SELECT a.idArticulo , a.nombre , a.descripcion , a.codigo , 'https://factupar.com.py/pauny/files/articulos/noimage.png' as imagen  from articulo a where a.inactivo = 0 and a.tipoArticulo IN ('PRODUCTO','PRODUCTO_SINSTOCK') order by orden asc'";
            
        $stmt  = $this->db->prepare($sql);  
        $stmt->execute();
        $articulos = $stmt->fetchAll();  
        
        foreach ($articulos as $articulo) {
          $idArticulo = $articulo->idArticulo;
          $sql = "SELECT Articulo_idArticulo, GrupoPersona_idGrupoPersona, precio from precio p where inactivo = 0 and Articulo_idArticulo = :idArticulo group by GrupoPersona_idGrupoPersona";  
          $stmt = $this->db->prepare($sql);  
          $stmt->bindParam(':idArticulo', $idArticulo);
          $stmt->execute();
          $precios = $stmt->fetchAll();  
          $stmt = 0;
          $articulo->precios = $precios;
        }


        return $articulos;

} catch (Exception $e) {
    return $e;
}

  //Restablecemos el tratamiento de errores
  restore_error_handler();
        
}




function listadoArticulosSincronizar($data){
  $token = Auth::getData($data['token']);
  //$idPersona = $data['idPersona'];
  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "SELECT a.idArticulo , a.nombre , a.descripcion , a.codigo , 'https://factupar.com.py/pauny/files/articulos/noimage.png' as imagen  from articulo a where a.inactivo = 0 and a.tipoArticulo IN ('PRODUCTO', 'PRODUCTO_SINSTOCK') order by orden asc";
            
        $stmt  = $this->db->prepare($sql);  
        $stmt->execute();
        $articulos = $stmt->fetchAll();  
        
        foreach ($articulos as $articulo) {
          $idArticulo = $articulo->idArticulo;
          $sql = "SELECT Articulo_idArticulo, GrupoPersona_idGrupoPersona, precio from precio p where inactivo = 0 and Articulo_idArticulo = :idArticulo group by GrupoPersona_idGrupoPersona";  
          $stmt = $this->db->prepare($sql);  
          $stmt->bindParam(':idArticulo', $idArticulo);
          $stmt->execute();
          $precios = $stmt->fetchAll();  
          $stmt = 0;
          $articulo->precios = $precios;
        }


        return $articulos;

} catch (Exception $e) {
    return $e;
}

  //Restablecemos el tratamiento de errores
  restore_error_handler();
        
}



function listadoArticulos($data){
  $token = Auth::getData($data['token']);
  $idPersona = $data['idPersona'];
  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
      $sql = "SELECT F_STOCKTERCERIZADOS_PERSONA(:idPersona) as cantStockTercerizado, a.idArticulo, F_STOCKMINIMO_TERCERIZADOS_COMODATOS(:idPersona) as cantMinima,
        CONCAT(a.idArticulo, ' | ', a.codigo ,' | ', a.nombre) AS nombre,
        a.descripcion,
        a.codigo,
        p.precio,
        'https://factupar.com.py/pauny/files/logo/logo.png' AS imagen,
        a.TipoImpuesto_idTipoImpuesto AS impuesto
FROM articulo a
JOIN precio p
      ON a.idArticulo = p.Articulo_idArticulo
JOIN persona_tipopersona pt
      ON pt.TipoPersona_idTipoPersona = 1
     AND p.GrupoPersona_idGrupoPersona = pt.GrupoPersona_idGrupoPersona
     AND pt.Persona_idPersona = :idPersona
WHERE a.tipoArticulo IN ('PRODUCTO','PRODUCTO_SINSTOCK')
  AND a.inactivo = 0
  AND p.inactivo = 0
  AND pt.inactivo = 0
GROUP BY a.idArticulo
ORDER BY a.orden ASC";

            
        $stmt  = $this->db->prepare($sql);  
        $stmt->bindParam(':idPersona', $idPersona);

        $stmt->execute();
        return $cajas= $stmt->fetchAll();  


} catch (Exception $e) {
    return $e;
}

  //Restablecemos el tratamiento de errores
  restore_error_handler();
        
}



function listadoClientesSincronizar($data){

  $token = Auth::getData($data['token']);


  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "SELECT idPersona , razonSocial , nroDocumento , mail, pt.terminoPago, pt.GrupoPersona_idGrupoPersona 
        from persona p, persona_tipopersona pt 
        where p.idPersona = pt.Persona_idPersona and pt.TipoPersona_idTipoPersona = 1";
            
        $stmt  = $this->db->prepare($sql);
        $stmt->execute();
        $clientes=  $stmt->fetchAll();  
        $stmt = 0;

        foreach ($clientes as $cliente) {
          $idPersona = $cliente->idPersona;
          $sql = "SELECT d.idDireccion , d.direccion , c.descripcion , d.latitud , d.longitud , d.domingo , d.lunes , d.martes , d.miercoles , d.jueves , d.viernes , d.sabado  from direccion d, ciudad2 c where d.Ciudad_idCiudad  = c.code and Persona_idPersona = :idPersona";  
          $stmt = $this->db->prepare($sql);  
          $stmt->bindParam(':idPersona', $idPersona);
          $stmt->execute();
          $direcciones= $stmt->fetchAll();  
          $stmt = 0;
          $cliente->direcciones = $direcciones;
        }

        foreach ($clientes as $cliente) {
          $idPersona = $cliente->idPersona;
          $sql = "SELECT idTelefono , telefono , TipoDireccion_Telefono_idTipoDireccion_Telefono  from telefono where Persona_idPersona = :idPersona";  
          $stmt = $this->db->prepare($sql);  
          $stmt->bindParam(':idPersona', $idPersona);
          $stmt->execute();
          $telefonos= $stmt->fetchAll();  
          $stmt = 0;
          $cliente->telefonos = $telefonos;
        }


        foreach ($clientes as $cliente) {
          $idPersona = $cliente->idPersona;
          $sql = "SELECT idVenta, nroFactura, fechaFactura, cuotas, sum(detalleventacuotas.saldo) as saldo 
                  FROM venta, detalleventacuotas 
                  WHERE venta.idVenta = detalleventacuotas.Venta_idVenta 
                  AND venta.Cliente_idCliente = :idPersona 
                  AND detalleventacuotas.saldo > 0 
                  AND venta.inactivo = 0 
                  GROUP BY idVenta";  
          $stmt = $this->db->prepare($sql);  
          $stmt->bindParam(':idPersona', $idPersona);
          $stmt->execute();
          $facturasPendientes = $stmt->fetchAll();  
          $stmt = null;
      
          foreach ($facturasPendientes as $factura) {
              $idVenta = $factura->idVenta;
              $sql = "SELECT nroCuota, fechaVencimiento, monto, saldo 
                      FROM detalleventacuotas 
                      WHERE Venta_idVenta = :idVenta 
                      AND saldo > 0";  
              $stmt = $this->db->prepare($sql);  
              $stmt->bindParam(':idVenta', $idVenta);
              $stmt->execute();
              $cuotasPendientes = $stmt->fetchAll();  
              $stmt = null;
              $factura->cuotasPendientes = $cuotasPendientes;
          }
          $cliente->facturasPendientes = $facturasPendientes; // Aquí se almacena correctamente todas las facturas pendientes.
      }
      





        return $clientes;

} catch (Exception $e) {
    return $e;
}

  //Restablecemos el tratamiento de errores
  restore_error_handler();
        
}




function listadoClientes($data){

  $token = Auth::getData($data['token']);
  $pageSize = $data['pageSize'];
  $offset = $data['offset'];

  //Activamos todas las notificaciones de error posibles
  error_reporting (E_ALL);
 
  //Definimos el tratamiento de errores no controlados
  set_error_handler(function () 
  {
    throw new Exception("Error");
  });

  try {
        $sql = "SELECT idPersona , razonSocial , nroDocumento , mail from persona p LIMIT $pageSize, $offset";
            
        $stmt  = $this->db->prepare($sql);
        $stmt->execute();
        $clientes=  $stmt->fetchAll();  
        $stmt = 0;

        foreach ($clientes as $cliente) {
          $idPersona = $cliente->idPersona;
          $sql = "SELECT d.idDireccion , d.direccion , c.descripcion , d.latitud , d.longitud , d.domingo , d.lunes , d.martes , d.miercoles , d.jueves , d.viernes , d.sabado  from direccion d, ciudad2 c where d.Ciudad_idCiudad  = c.code and Persona_idPersona = :idPersona";  
          $stmt = $this->db->prepare($sql);  
          $stmt->bindParam(':idPersona', $idPersona);
          $stmt->execute();
          $direcciones= $stmt->fetchAll();  
          $stmt = 0;
          $cliente->direcciones = $direcciones;
        }

        foreach ($clientes as $cliente) {
          $idPersona = $cliente->idPersona;
          $sql = "SELECT idTelefono , telefono , TipoDireccion_Telefono_idTipoDireccion_Telefono  from telefono where Persona_idPersona = :idPersona";  
          $stmt = $this->db->prepare($sql);  
          $stmt->bindParam(':idPersona', $idPersona);
          $stmt->execute();
          $telefonos= $stmt->fetchAll();  
          $stmt = 0;
          $cliente->telefonos = $telefonos;
        }


        return $clientes;

} catch (Exception $e) {
    return $e;
}

  //Restablecemos el tratamiento de errores
  restore_error_handler();
        
}


/**
 * Devuelve un listado de artículos que coincidan con la palabra clave.
 * Si no hay coincidencias (o la palabra está vacía) regresa un array con
 * un único placeholder “ARTÍCULO NO ENCONTRADO”, de modo que el front-end
 * nunca reciba null ni un objeto.
 *
 * @param array $data ['token' => string JWT, 'keyword' => string]
 * @return array      siempre un array indexado
 */
function buscarArticulosPorPalabraClave(array $data)
{
    /* 1· Token ------------------------------------------------------------- */
    $token     = Auth::getData($data['token']);
    $idUsuario = $token->id;   // ← por si lo necesitas luego
    $usuario   = $token->login;

    /* 2· Palabra clave vacía ---------------------------------------------- */
    if (empty(trim($data['keyword'] ?? ''))) {
        return [[
            'idArticulo'  => 0,
            'nombre'      => 'ARTÍCULO NO ENCONTRADO',
            'descripcion' => 'ARTÍCULO NO ENCONTRADO',
            'codigo'      => '',
            'imagen'      => 'https://factupar.com.py/pauny/files/articulos/logo.png',
            'impuesto'    => null
        ]];
    }

    /* 3· Consulta segura --------------------------------------------------- */
    $keyword = '%' . $data['keyword'] . '%';

    $sql = "
        SELECT  a.idArticulo,
                a.nombre,
                a.descripcion,
                a.codigo,
                'https://factupar.com.py/pauny/files/articulos/logo.png' AS imagen,
                a.TipoImpuesto_idTipoImpuesto AS impuesto
        FROM    articulo a
        WHERE   a.tipoArticulo IN ('PRODUCTO', 'PRODUCTO_SINSTOCK')
          AND   a.inactivo = 0
          AND   a.nombre LIKE :keyword
        LIMIT   50
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':keyword', $keyword);
    $stmt->execute();

    $resultados = $stmt->fetchAll();

    /* 4· Placeholder si no hay coincidencias ------------------------------ */
    if (empty($resultados)) {
        $resultados[] = [
            'idArticulo'  => 0,
            'nombre'      => 'ARTÍCULO NO ENCONTRADO',
            'descripcion' => 'ARTÍCULO NO ENCONTRADO',
            'codigo'      => '',
            'imagen'      => 'https://factupar.com.py/pauny/files/articulos/logo.png',
            'impuesto'    => null
        ];
    }

    return $resultados;   // ← array, no json_encode
}







function buscarClientesPorPalabraClave($data) {
  $token = Auth::getData( $data['token'] );
  $usuario = $token->login;
  $idUsuario = $token->id;
  if (!empty($data['keyword'])) {
      // La consulta preparada para evitar inyección SQL
      $tipoPersona = 1; 
      $query = "SELECT * FROM persona p 
          JOIN persona_tipopersona ptp ON p.idPersona = ptp.Persona_idPersona
          JOIN tipopersona tp ON tp.idTipoPersona = ptp.TipoPersona_idTipoPersona
          WHERE
          ptp.inactivo = 0 AND p.inactivo = 0
          AND ptp.TipoPersona_idTipoPersona = :tipoPersona
          AND (razonSocial LIKE :keyword OR nombreComercial LIKE :keyword OR nroDocumento LIKE :keyword OR idPersona LIKE :keyword)
         group by p.idPersona  LIMIT 0,1000 
      ";

      $stmt = $this->db->prepare($query);
      $keyword = "%".$data['keyword']."%";
      $stmt->bindParam(':tipoPersona', $tipoPersona);
      $stmt->bindParam(':keyword', $keyword);
      $stmt->bindParam(':usuario', $usuario);
      $stmt->execute();

      $result = $stmt->fetchAll();

      if (!empty($result)) {
        // Construir y devolver el JSON de los datos
        return $result;
    } else {
        // Devolver un JSON vacío si no hay resultados

        $result = array(
          array(
              "idPersona" => 0,
              "razonSocial" => "CLIENTE NO ENCONTRADO",
              "nombreComercial" => "CLIENTE NO ENCONTRADO",
              "tipoDocumento" => "",
              "nroDocumento" => "",
              "direccion" => "",
              "telefono" => "",
              "mail" => "",
              "descripcion" => "CLIENTE NO ENCONTRADO"
          )
      );

        return $result;
    }
} else {
    // Devolver un mensaje de error en formato JSON si el keyword está vacío
    return json_encode(['error' => 'La palabra clave está vacía']);
}
}



function cerrar_habilitacion($data){

  return ['error' => 'El arqueo de caja debe cerrar la administracion.'];
  // PARTE 1 - TABLA USUARIO - PERSONA
  $token = Auth::getData($data['token']);
  $usuario = $token->usuario;
  $Habilitacion_idHabilitacion = $data['Habilitacion_idHabilitacion'];

  try {
      // Inicia la transacción
      $this->db->beginTransaction();

      $sql="UPDATE habilitacion SET estado = 0, fechaCierre = now()  WHERE idHabilitacion = :Habilitacion_idHabilitacion"; 
      $stmt = $this->db->prepare($sql);  
      // Vincula los parámetros
      $stmt->bindParam(':Habilitacion_idHabilitacion', $Habilitacion_idHabilitacion);
      // Ejecuta la sentencia
      $success = $stmt->execute();

      // Si la actualización fue exitosa, commitea la transacción
      if ($success) {
          $this->db->commit();
          return true; // Indica éxito
      } else {
          // Si la ejecución no fue exitosa, hace rollback
          $this->db->rollBack();
          return false; // Indica fallo
      }
  } catch (Exception $e) {
      // Si ocurre un error, hace rollback
      $this->db->rollBack();
      // Aquí podrías registrar el error según tu política de manejo de errores
      return false; // Indica fallo
  }

  restore_error_handler();
}


function crear_habilitacion($data){

  //PARTE 1 - TABLA USUARIO - PERSONA


      $token = Auth::getData( $data['token'] );
      $idUsuario = $token->id;
      $login = $token->login;
      $Usuario_idUsuario =    $idUsuario;
      $Caja_idCaja = $data['idCaja'];
      $Moneda_idMoneda = 1;
      $m1 = $data['m1'];
      $m2 = $data['m2'];
      $m3 = $data['m3'];
      $m4 = $data['m4'];
      $m5 = $data['m5'];
      $m6 = $data['m6'];
      $m7 = $data['m7'];
      $m8 = $data['m8'];
      $m9 = $data['m9'];
      $m10 = $data['m10'];


      try {
        // Start the transaction
        $this->db->beginTransaction();
    
        // Llamada al procedimiento almacenado utilizando un parámetro de entrada y una variable de salida de MySQL.
        $sql = "CALL sp_insert_habilitacion(:usuario_ins, @idHabilitacion)";
        $stmt = $this->db->prepare($sql);

        // Aquí se asume que $Usuario_idUsuario contiene el valor del login (por ejemplo, 'chofer1')
        $stmt->bindParam(':usuario_ins', $login);

        // Ejecutar la llamada al procedimiento almacenado.
        $stmt->execute();
        // Es importante cerrar el cursor para liberar recursos y poder ejecutar otra consulta.
        $stmt->closeCursor();

        // Recuperar el valor del parámetro de salida (@idHabilitacion)
        $sql2 = "SELECT @idHabilitacion AS idHabilitacion";
        $stmt2 = $this->db->prepare($sql2);
        $stmt2->execute();
        $result = $stmt2->fetch();

        $idHabilitacion = $result->idHabilitacion;

        // Liberar el statement si es necesario.
        $stmt2->closeCursor();

        // Ahora $idHabilitacion contiene el id de la habilitación insertada.


        $sql = "INSERT INTO `detallehabilitacion`(`Habilitacion_idHabilitacion`,`Moneda_idMoneda`,`Denominacion_idDenominacion`,`montoApertura`,`montoCierre`, `estado`) VALUES (:Habilitacion_idHabilitacion, 1, 1, :m1, 0, 0)";
        $stmt  = $this->db->prepare($sql); 
        $stmt->bindParam(':Habilitacion_idHabilitacion', $idHabilitacion);
        $stmt->bindParam(':m1', $m1);
        $stmt->execute();
        $stmt = 0;


        $sql = "INSERT INTO `detallehabilitacion`(`Habilitacion_idHabilitacion`,`Moneda_idMoneda`,`Denominacion_idDenominacion`,`montoApertura`,`montoCierre`, `estado`) VALUES (:Habilitacion_idHabilitacion, 1, 2, :m1, 0, 0)";
        $stmt  = $this->db->prepare($sql); 
        $stmt->bindParam(':Habilitacion_idHabilitacion', $idHabilitacion);
        $stmt->bindParam(':m1', $m2);
        $stmt->execute();
        $stmt = 0;


        $sql = "INSERT INTO `detallehabilitacion`(`Habilitacion_idHabilitacion`,`Moneda_idMoneda`,`Denominacion_idDenominacion`,`montoApertura`,`montoCierre`, `estado`) VALUES (:Habilitacion_idHabilitacion, 1, 3, :m1, 0, 0)";
        $stmt  = $this->db->prepare($sql); 
        $stmt->bindParam(':Habilitacion_idHabilitacion', $idHabilitacion);
        $stmt->bindParam(':m1', $m3);
        $stmt->execute();
        $stmt = 0;


        $sql = "INSERT INTO `detallehabilitacion`(`Habilitacion_idHabilitacion`,`Moneda_idMoneda`,`Denominacion_idDenominacion`,`montoApertura`,`montoCierre`, `estado`) VALUES (:Habilitacion_idHabilitacion, 1, 4, :m1, 0, 0)";
        $stmt  = $this->db->prepare($sql); 
        $stmt->bindParam(':Habilitacion_idHabilitacion', $idHabilitacion);
        $stmt->bindParam(':m1', $m4);
        $stmt->execute();
        $stmt = 0;


        $sql = "INSERT INTO `detallehabilitacion`(`Habilitacion_idHabilitacion`,`Moneda_idMoneda`,`Denominacion_idDenominacion`,`montoApertura`,`montoCierre`, `estado`) VALUES (:Habilitacion_idHabilitacion, 1, 5, :m1, 0, 0)";
        $stmt  = $this->db->prepare($sql); 
        $stmt->bindParam(':Habilitacion_idHabilitacion', $idHabilitacion);
        $stmt->bindParam(':m1', $m5);
        $stmt->execute();
        $stmt = 0;


        $sql = "INSERT INTO `detallehabilitacion`(`Habilitacion_idHabilitacion`,`Moneda_idMoneda`,`Denominacion_idDenominacion`,`montoApertura`,`montoCierre`, `estado`) VALUES (:Habilitacion_idHabilitacion, 1, 6, :m1, 0, 0)";
        $stmt  = $this->db->prepare($sql); 
        $stmt->bindParam(':Habilitacion_idHabilitacion', $idHabilitacion);
        $stmt->bindParam(':m1', $m6);
        $stmt->execute();
        $stmt = 0;

        $sql = "INSERT INTO `detallehabilitacion`(`Habilitacion_idHabilitacion`,`Moneda_idMoneda`,`Denominacion_idDenominacion`,`montoApertura`,`montoCierre`, `estado`) VALUES (:Habilitacion_idHabilitacion, 1, 7, :m1, 0, 0)";
        $stmt  = $this->db->prepare($sql); 
        $stmt->bindParam(':Habilitacion_idHabilitacion', $idHabilitacion);
        $stmt->bindParam(':m1', $m7);
        $stmt->execute();
        $stmt = 0;


        $sql = "INSERT INTO `detallehabilitacion`(`Habilitacion_idHabilitacion`,`Moneda_idMoneda`,`Denominacion_idDenominacion`,`montoApertura`,`montoCierre`, `estado`) VALUES (:Habilitacion_idHabilitacion, 1, 8, :m1, 0, 0)";
        $stmt  = $this->db->prepare($sql); 
        $stmt->bindParam(':Habilitacion_idHabilitacion', $idHabilitacion);
        $stmt->bindParam(':m1', $m8);
        $stmt->execute();
        $stmt = 0;

        $sql = "INSERT INTO `detallehabilitacion`(`Habilitacion_idHabilitacion`,`Moneda_idMoneda`,`Denominacion_idDenominacion`,`montoApertura`,`montoCierre`, `estado`) VALUES (:Habilitacion_idHabilitacion, 1,9, :m1, 0, 0)";
        $stmt  = $this->db->prepare($sql); 
        $stmt->bindParam(':Habilitacion_idHabilitacion', $idHabilitacion);
        $stmt->bindParam(':m1', $m9);
        $stmt->execute();
        $stmt = 0;

        $sql = "INSERT INTO `detallehabilitacion`(`Habilitacion_idHabilitacion`,`Moneda_idMoneda`,`Denominacion_idDenominacion`,`montoApertura`,`montoCierre`, `estado`) VALUES (:Habilitacion_idHabilitacion, 1, 10, :m1, 0, 0)";
        $stmt  = $this->db->prepare($sql); 
        $stmt->bindParam(':Habilitacion_idHabilitacion', $idHabilitacion);
        $stmt->bindParam(':m1', $m10);
        $stmt->execute();
        $stmt = 0;



        $sql = "CALL SP_AjusteInventarioApp(0, :usuario_ins, 0, 1, 1, 1, :Habilitacion_idHabilitacion)";
        $stmt  = $this->db->prepare($sql); 
        $stmt->bindParam(':Habilitacion_idHabilitacion', $idHabilitacion);
        $stmt->bindParam(':usuario_ins', $Usuario_idUsuario);
        $stmt->execute();
        $stmt = 0;



        // Commit the transaction
        $this->db->commit();
    
        // Return the ID
        return $idHabilitacion;
    } catch (Exception $e) {
        // An error occurred, rollback any changes
        $this->db->rollBack();
        // Log the error or handle it as per your need
         throw $e; // Optionally rethrow or handle it as per your application's error handling policy
        //return 'Error: ' . $e->getMessage();
    }

  restore_error_handler();
        
}



function ajustar_stock_tercerizado($data){
  //PARTE 1 - TABLA USUARIO - PERSONA
      $token = Auth::getData( $data['token'] );
      $usuario = $token->login;
      $Usuario_idUsuario =   $token->id;
      $Persona_idPersona = $data['idPersona'];
      $cantidad = $data['cantidad'];
      $habilitacion = $data['habilitacion'];
      $idHabilitacion = $habilitacion['idhabilitacion'];
      $lat = $data['latitud'];
      $lng = $data['longitud'];

      

      try {
        // Start the transaction
        $this->db->beginTransaction();
    
        $sql="UPDATE stockTercerizados set cantidad = cantidad + ( :cantidad ) where Persona_idPersona = :Persona_idPersona"; 
        $stmt  = $this->db->prepare($sql);  
        
        // Bind parameters
        $stmt->bindParam(':Persona_idPersona', $Persona_idPersona);
        $stmt->bindParam(':cantidad', $cantidad);
        
        // Execute the statement
        $stmt->execute();
    
        // Get the last inserted ID
        $visita = $this->db->lastInsertId();
        $stmt = 0;

        // Commit the transaction
        $this->db->commit();
    
        // Return the ID
        return $visita;
    } catch (Exception $e) {
        // An error occurred, rollback any changes
        $this->db->rollBack();
        // Log the error or handle it as per your need
        // throw $e; // Optionally rethrow or handle it as per your application's error handling policy
        return false; // Indicate failure
    }

  restore_error_handler();
        
}



function crear_visita_sinventa($data){
  //PARTE 1 - TABLA USUARIO - PERSONA
      $token = Auth::getData( $data['token'] );
      $usuario = $token->login;
      $Usuario_idUsuario =   $token->id;
      $Direccion_idDireccion = $data['idDireccion'];
      $Persona_idPersona = $data['idPersona'];
      $habilitacion = $data['habilitacion'];
      $idHabilitacion = $habilitacion['idhabilitacion'];
      $lat = $data['latitud'];
      $lng = $data['longitud'];

      

      try {
        // Start the transaction
        $this->db->beginTransaction();
    
        $sql="INSERT INTO `visitasSinVenta`(`Persona_idPersona`,`Direccion_idDireccion`,`lat`,`lng`,`usuario_insercion`,`fecha_insercion`,`inactivo`, `Habilitacion_idHabilitacion`)
              VALUES
              (
                :Persona_idPersona,
                :Direccion_idDireccion,
                :lat,
                :lng,
                :usuario,
                now(),
                0,
                :Habilitacion_idHabilitacion
              )"; 
        $stmt  = $this->db->prepare($sql);  
        
        // Bind parameters
        $stmt->bindParam(':Persona_idPersona', $Persona_idPersona);
        $stmt->bindParam(':Direccion_idDireccion', $Direccion_idDireccion);
        $stmt->bindParam(':lat', $lat);
        $stmt->bindParam(':lng', $lng);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':Habilitacion_idHabilitacion', $idHabilitacion);
        
        // Execute the statement
        $stmt->execute();
    
        // Get the last inserted ID
        $visita = $this->db->lastInsertId();
        $stmt = 0;

        // Commit the transaction
        $this->db->commit();
    
        // Return the ID
        return $visita;
    } catch (Exception $e) {
        // An error occurred, rollback any changes
        $this->db->rollBack();
        // Log the error or handle it as per your need
        // throw $e; // Optionally rethrow or handle it as per your application's error handling policy
        return false; // Indicate failure
    }

  restore_error_handler();
        
}


function recibo_crear($data)
{
    /* ---------- 1. PARAMETROS ---------- */
    $token         = Auth::getData($data['token']);
    $usuarioLogin  = $token->login;

    $Cliente_idCliente        = $data['idCliente'];
    $lat                      = $data['latitude'];
    $lng                      = $data['longitude'];
    $habilitacion             = $data['habilitacion'];
    $Habilitacion_idHabilitacion = $habilitacion['idhabilitacion'];

    /* pagos en efectivo / retención */
    $totalEfectivo   = floatval($data['efectivo']  ?? 0);
    $totalRetencion  = floatval($data['retencion'] ?? 0);

    /* arrays de medios de pago */
    $cheques        = $data['cheques']        ?? [];
    $transferencias = $data['transferencias'] ?? [];
    $posDebito      = $data['posDebito']      ?? [];   // 🆕
    $posCredito     = $data['posCredito']     ?? [];   // 🆕

    /* ---------- 2. VALIDAR TOTALES ---------- */
    $sum = fn($arr)=>array_sum(array_column($arr,'importe'));

    $totalCheques        = $sum($cheques);
    $totalTransferencias = $sum($transferencias);
    $totalPosDebito      = $sum($posDebito);   // 🆕
    $totalPosCredito     = $sum($posCredito);  // 🆕

    $totalPagos = $totalEfectivo + $totalRetencion +
                  $totalCheques + $totalTransferencias +
                  $totalPosDebito + $totalPosCredito;   // 🆕

    $totalItems = array_sum(array_column($data['itemRecibo'],'monto'));

    if ($totalPagos != $totalItems) {
        return ['success'=>false,'message'=>'El total de los pagos no coincide con el total de los ítems.'];
    }

    /* ---------- 3. TRANSACCION ---------- */
    try {
        $this->db->beginTransaction();

        /* 3.1 RECIBO header */
        $stmt = $this->db->prepare(
            "INSERT INTO recibo
                (CLIENTE_IDCLIENTE,USUARIO,HABILITACION_IDHABILITACION,
                 NRORECIBO,FECHATRANSACCION,FECHARECIBO,TOTAL,
                 USUARIOINSERCION,INACTIVO,MONEDA_IDMONEDA,TASACAMBIO,TASACAMBIOBASES,lat,lng)
             VALUES
                (:cli,:usr,:hab,0,NOW(),NOW(),:tot,:usr,0,1,1,1,:lat,:lng)"
        );
        $stmt->execute([
            ':cli'=>$Cliente_idCliente, ':usr'=>$usuarioLogin,
            ':hab'=>$Habilitacion_idHabilitacion, ':tot'=>$totalItems,
            ':lat'=>$lat, ':lng'=>$lng
        ]);
        $idRecibo = $this->db->lastInsertId();

        /* 3.2 detalle recibo-facturas */
        $stmt = $this->db->prepare(
            "INSERT INTO detallerecibofacturas
                (RECIBO_IDRECIBO,VENTA_IDVENTA,MONTOAPLICADO,INACTIVO,CUOTA)
             VALUES
                (:rec,:ven,:mto,0,:cuota)"
        );
        foreach ($data['itemRecibo'] as $it) {
            $stmt->execute([
                ':rec'=>$idRecibo,
                ':ven'=>$it['factura'],
                ':mto'=>$it['monto'],
                ':cuota'=>$it['cuota']
            ]);
        }

        /* helper para insertar pagos */
        $insertPago = function($formaId,$banco,$monto) use ($idRecibo) {
            $sql = "INSERT INTO detallerecibo
                       (RECIBO_IDRECIBO,FORMAPAGO_IDFORMAPAGO,BANCO_IDBANCO,MONTO,
                        INACTIVO,Moneda_idMoneda,tasaCambio)
                    VALUES
                       (:rec,:fp,:bco,:mon,0,1,1)";
            $st  = $this->db->prepare($sql);
            $st->execute([
                ':rec'=>$idRecibo, ':fp'=>$formaId,
                ':bco'=>$banco,    ':mon'=>$monto
            ]);
        };

        /* 3.3 Cheques (id 4) */
        foreach ($cheques as $c)        $insertPago(4,$c['banco'],$c['importe']);

        /* 3.4 Transferencias (id 1) */
        foreach ($transferencias as $t) $insertPago(1,$t['banco'],$t['importe']);

        /* 3.5 POS Débito (id 2)  🆕 */
        foreach ($posDebito as $p)      $insertPago(9,$p['banco'],$p['importe']);

        /* 3.6 POS Crédito (id 3) 🆕 */
        foreach ($posCredito as $p)     $insertPago(10,$p['banco'],$p['importe']);

        /* 3.7 Efectivo (id 5) & Retención (id 7) */
        if ($totalEfectivo  > 0) $insertPago(5,null,$totalEfectivo);
        if ($totalRetencion > 0) $insertPago(7,null,$totalRetencion);

        /* ---------- 4. COMMIT ---------- */
        $this->db->commit();

        /* ---------- 5. RESPUESTA ---------- */
        $cab = $this->db->prepare(
            "SELECT r.USUARIO,r.IDRECIBO,r.FECHATRANSACCION,r.TOTAL,
                    p.razonSocial,
                    s.nombre AS nombreSucursal,s.nombreEmpresa,s.rucEmpresa,
                    s.telefono AS telefonoEmpresa,s.correo AS correoEmpresa,
                    s.direccion AS direccionEmpresa
               FROM recibo r
               JOIN persona     p ON p.idPersona        = r.CLIENTE_IDCLIENTE
               JOIN habilitacion h ON h.idhabilitacion  = r.HABILITACION_IDHABILITACION
               JOIN caja        c ON c.idcaja           = h.Caja_idCaja
               JOIN sucursal    s ON s.idSucursal       = c.Sucursal_idSucursal
              WHERE r.IDRECIBO = :id"
        );
        $cab->execute([':id'=>$idRecibo]);
        $result = $cab->fetch();

        /* detalle facturas */
        $detFact = $this->db->prepare(
            "SELECT d.VENTA_IDVENTA, CONCAT(v.serie,'-',v.nroFactura) AS nroFactura,
                    d.cuota, d.MONTOAPLICADO
               FROM detallerecibofacturas d
               JOIN venta v ON v.idVenta = d.VENTA_IDVENTA
              WHERE d.RECIBO_IDRECIBO = :id"
        );
        $detFact->execute([':id'=>$idRecibo]);
        $result->detalleFacturas = $detFact->fetchAll();

        /* detalle pagos */
        $detPag = $this->db->prepare(
            "SELECT f.descripcion AS formaPago,
                    b.descripcion AS banco,
                    d.NROCHEQUE   AS referenciaBanco,
                    d.MONTO
               FROM detallerecibo d
               LEFT JOIN formapago f ON f.idFormaPago = d.FORMAPAGO_IDFORMAPAGO
               LEFT JOIN banco     b ON b.idBanco     = d.BANCO_IDBANCO
              WHERE d.RECIBO_IDRECIBO = :id AND d.MONTO > 0"
        );
        $detPag->execute([':id'=>$idRecibo]);
        $result->detallePagos = $detPag->fetchAll();

        return ['success'=>true,'idRecibo'=>$idRecibo,'data'=>$result];

    } catch (Exception $e) {
        $this->db->rollBack();
        return ['success'=>false,'message'=>$e->getMessage()];
    }
}




function crear_gasto($data) {
  // Recibir el JSON y obtener datos del token
  $token = Auth::getData($data['token']);
  $usuario = $token->login;
  $idUsuario = $token->id;

  // Datos principales del JSON
  $descripcion = isset($data['descripcion']) ? $data['descripcion'] : null; 
  $monto = isset($data['monto']) ? $data['monto'] : 0; 
  $conceptoGasto = $data['concepto'];
  $habilitacion = $data['habilitacion']; 

  // Se puede definir Empleado_idEmpleado si es requerido
  $Empleado_idEmpleado = isset($data['Empleado_idEmpleado']) ? $data['Empleado_idEmpleado'] : null;

  if (!$descripcion || !$monto || !$conceptoGasto || !$habilitacion || !$usuario) {
    return ['error' => 'Faltan campos obligatorios'];
  }

  try {
    // Iniciar la transacción
    $this->db->beginTransaction();

    // Insertar en la tabla `movimiento`
    $sql = "INSERT INTO `movimiento` (
                `descripcion`,
                `monto`,
                `concepto`,
                `habilitacion`,
                `usuario`,
                `inactivo`,
                `Empleado_idEmpleado`,
                `fechaTransaccion`
            ) VALUES (
                :descripcion, 
                :monto, 
                :concepto, 
                :habilitacion, 
                :usuario, 
                0, 
                :Empleado_idEmpleado, 
                NOW()
            )";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':monto', $monto);
    $stmt->bindParam(':concepto', $conceptoGasto);
    $stmt->bindParam(':habilitacion', $habilitacion['idhabilitacion']);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':Empleado_idEmpleado', $Empleado_idEmpleado);

    // Ejecutar la consulta
    $stmt->execute();

    // Confirmar la transacción
    $this->db->commit();

    // Retornar el éxito de la operación
    return ['success' => true, 'mensaje' => 'Gasto creado exitosamente'];
  } catch (Exception $e) {
    // Rollback en caso de error
    $this->db->rollBack();
    return ['error' => 'Ocurrió un error al procesar la transacción.', 'mensaje' => $e->getMessage()];
  }
}




function crear_comodato($data) {
  // Recibir el JSON y obtener datos del token
  $token = Auth::getData($data['token']);
  $usuario = $token->login;
  $idUsuario = $token->id;

  // Datos principales del JSON
  $Persona_idPersona = $data['idPersona'];
  $idDireccion = $data['idDireccion'];
  $latitude = $data['latitud'];
  $longitude = $data['longitud'];
  $idArticulo = $data['articulo'];
  $cantidad = $data['cantidad'];
  $habilitacion = $data['habilitacion']; // Obtener el objeto habilitacion

  // Datos opcionales que podrían no estar en el JSON
  $comentario = isset($data['comentario']) ? $data['comentario'] : null; // Comentario opcional
  $costoTotal = isset($data['costoTotal']) ? $data['costoTotal'] : 0; // Si no hay costoTotal, se asigna 0 por defecto
  $cantidadTotal = isset($data['cantidadTotal']) ? $data['cantidadTotal'] : $cantidad; // Cantidad total de artículos (por defecto igual a cantidad)
  $nombre = isset($data['nombre']) ? $data['nombre'] : ''; // Nombre opcional, vacío por defecto
  $imagen = isset($data['imagen']) ? $data['imagen'] : null; // Imagen opcional
  $compromisoVenta = isset($data['compromisoVenta']) ? $data['compromisoVenta'] : null; // Compromiso de venta opcional

  try {
      // Iniciar la transacción
      $this->db->beginTransaction();

      // Insertar en la tabla `comodato`
      $sql = "INSERT INTO `comodato` (
                  `Deposito_IdDeposito`,
                  `usuario`,
                  `comentario`,
                  `fechaTransaccion`,
                  `costoTotal`,
                  `cantidadTotal`,
                  `usuarioInsercion`,
                  `inactivo`,
                  `nombre`,
                  `Direccion_idDireccion`,
                  `Cliente_idCliente`,
                  `imagen`,
                  `compromisoVenta`
              ) VALUES (
                  :Deposito_IdDeposito, 
                  :usuario,
                  :comentario,
                  NOW(),
                  :costoTotal,
                  :cantidadTotal,
                  :usuario,    
                  0, 
                  :nombre,
                  :Direccion_idDireccion,
                  :Cliente_idCliente,
                  :imagen,
                  :compromisoVenta
              )";
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':Deposito_IdDeposito', $habilitacion['dp']);
      $stmt->bindParam(':usuario', $usuario);
      $stmt->bindParam(':comentario', $comentario);
      $stmt->bindParam(':costoTotal', $costoTotal);
      $stmt->bindParam(':cantidadTotal', $cantidadTotal);
      $stmt->bindParam(':nombre', $nombre);
      $stmt->bindParam(':Direccion_idDireccion', $idDireccion);
      $stmt->bindParam(':Cliente_idCliente', $Persona_idPersona);
      $stmt->bindParam(':imagen', $imagen);
      $stmt->bindParam(':compromisoVenta', $compromisoVenta);
      $stmt->execute();

      // Obtener el ID del comodato recién creado
      $idComodato = $this->db->lastInsertId();

      // Insertar en la tabla `comodatodetalle`
      $sql_detalle = "INSERT INTO `comodatodetalle` (
                          `Comodato_idComodato`,
                          `Articulo_idArticulo`,
                          `cantidad`,
                          `costo`,
                          `subtotal`,
                          `inactivo`,
                          `Deposito_IdDeposito`,
                          `ultimo`
                      ) VALUES (
                          :Comodato_idComodato,
                          :Articulo_idArticulo,
                          :cantidad,
                          :costo,
                          :subtotal,
                          0,
                          :Deposito_IdDeposito,
                          1
                      )";

      // Supongamos que el costo y subtotal son calculados a partir de la cantidad
      $costo = 100; // Ejemplo de costo por artículo (este valor debería ser calculado o proporcionado)
      $subtotal = $costo * $cantidad;

      $stmt_detalle = $this->db->prepare($sql_detalle);
      $stmt_detalle->bindParam(':Comodato_idComodato', $idComodato);
      $stmt_detalle->bindParam(':Articulo_idArticulo', $idArticulo);
      $stmt_detalle->bindParam(':cantidad', $cantidad);
      $stmt_detalle->bindParam(':costo', $costo);
      $stmt_detalle->bindParam(':subtotal', $subtotal);
      $stmt_detalle->bindParam(':Deposito_IdDeposito', $habilitacion['dp']);
      $stmt_detalle->execute();

      // Confirmar la transacción
      $this->db->commit();

      // Retornar el ID del comodato creado y la respuesta
      return ['success' => true, 'idComodato' => $idComodato];
  } catch (Exception $e) {
      // Rollback en caso de error
      $this->db->rollBack();
      return ['error' => 'Ocurrió un error al procesar la transacción.', 'mensaje' => $e->getMessage()];
  }
}



function orden_venta_crear($data) {
  // Recibir el JSON

  //return $data;

  $token = Auth::getData($data['token']);
  $usuario = $token->login;
  $idUsuario = $token->id;

  $esRemision = ($data['esRemision'] == 1) ? 'S' : 'N';

  $Persona_idPersona = $data['idCliente'];
  $idDireccion = $data['idDireccion'];
  $latitude = $data['latitude'];
  $longitude = $data['longitude'];
  //$efectivo = $data['efectivo'];
  $pagoTipo = $data['pagoTipo'];
  //$retencion = $data['retencion'];
  $total = $data['total'];
  $habilitacion = $data['habilitacion'];  // Obtener el objeto habilitacion


  // Obtener lista de artículos seleccionados
  $listArticulosSelected = $data['listArticulosSelected'];


  $cuotas = 1;

  try {
      // Iniciar la transacción
      $this->db->beginTransaction();

      // Insertar en la tabla `venta`
      $sql = "INSERT INTO ordenventa (
        Persona_idPersona,
        TerminoPago_idTerminoPago,
        total,
        latitud,
        longitud,
        Deposito_idDeposito,
        Habilitacion_idHabilitacion,
        fecha,
        usuarioInsercion,
        fechaInsercion,
        fechaEntrega,
        tipo
    ) VALUES (
        :Persona_idPersona,
        :TerminoPago_idTerminoPago,
        :total,
        :latitud,
        :longitud,
        :Deposito_idDeposito,
        :Habilitacion_idHabilitacion,
        NOW(),
        :usuario,
        NOW(),
        NOW(),
        1
    )";

  $stmt = $this->db->prepare($sql);
  $stmt->bindParam(':Persona_idPersona', $Persona_idPersona);
  $stmt->bindParam(':TerminoPago_idTerminoPago', $pagoTipo);
  $stmt->bindParam(':total', $total);
  $stmt->bindParam(':latitud', $latitude);
  $stmt->bindParam(':longitud', $longitude);
  $stmt->bindParam(':Deposito_idDeposito', $habilitacion['dp']);
  $stmt->bindParam(':Habilitacion_idHabilitacion', $habilitacion['idhabilitacion']);
  $stmt->bindParam(':usuario', $usuario);

  $stmt->execute();
  $idOrdenVenta = $this->db->lastInsertId();


      // Insertar en la tabla `detalleventa`
      foreach ($listArticulosSelected as $articulo) {
        $sql = "INSERT INTO detalleordenventa (
                    OrdenVenta_idOrdenVenta, 
                    Articulo_idArticulo, 
                    cantidad, 
                    cantidadStock,
                    precio, 
                    descuento, 
                    impuesto, 
                    totalNeto, 
                    total
                ) VALUES (
                    :OrdenVenta_idOrdenVenta, 
                    :Articulo_idArticulo, 
                    :cantidad, 
                    :cantidadStock, 
                    :precio, 
                    0, 
                    :impuesto, 
                    :total, 
                    :total
                )";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':OrdenVenta_idOrdenVenta', $idOrdenVenta);
        $stmt->bindParam(':Articulo_idArticulo', $articulo['idArticulo']);
        $stmt->bindParam(':cantidad', $articulo['cantidad']);
        $stmt->bindParam(':cantidadStock', $articulo['cantidadStock']);
        $stmt->bindParam(':precio', $articulo['precio']);
        $stmt->bindParam(':impuesto', $articulo['impuesto']);
        $stmt->bindParam(':total', $articulo['precioTotal']);
        $stmt->execute();
    }
    

      $this->db->commit();

      // Suponiendo que $idOrdenVenta exista y sea un valor numérico entero
      $sql = "
      SELECT 
          p.razonSocial,
          p.nroDocumento,
          o.idOrdenVenta,
          o.fechaEntrega,
          'EN EL LOCAL' AS formaEntrega
      FROM ordenventa o
      JOIN persona p ON p.idPersona = o.Persona_idPersona
      WHERE o.idOrdenVenta = :idOrdenVenta
        AND o.usuarioInsercion IN ('cajatablet', 'admin')
      ";

      // Preparar, enlazar y ejecutar
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':idOrdenVenta', $idOrdenVenta);
      $stmt->execute();

      // Obtener la cabecera
      $result = $stmt->fetch();

      // Cerramos el statement
      $stmt = null;

      // Consulta del detalle
      $sqlDetail = "
      SELECT 
          d.OrdenVenta_idOrdenVenta,
          d.Articulo_idArticulo,
          F_NOMBRE_ARTICULO(d.Articulo_idArticulo) AS descripcion,
          d.cantidad,
          d.precio,
          d.total
      FROM detalleordenventa d
      WHERE d.OrdenVenta_idOrdenVenta = :idOrdenVenta
      ";

      $stmtDetail = $this->db->prepare($sqlDetail);
      $stmtDetail->bindParam(':idOrdenVenta', $idOrdenVenta);
      $stmtDetail->execute();

      // Obtener todo el detalle
      $detalle = $stmtDetail->fetchAll();

      // Cerramos el statement
      $stmtDetail = null;



      $sqlreposiciones = "SELECT IFNULL(SUM(cantidad), 0) AS reposicionesdia 
      from detalleventa d, venta v  
      where d.Venta_idVenta = v.idVenta and Articulo_idArticulo = 63 
      and v.Cliente_idCliente = :Persona_idPersona and fechaFactura = date(now())";

      $stmtDetail = $this->db->prepare($sqlreposiciones);
      $stmtDetail->bindParam(':Persona_idPersona', $Persona_idPersona);
      $stmtDetail->execute();

      // Obtener todo el detalle
      $reposiciones = $stmtDetail->fetch();

      // Cerramos el statement
      $stmtDetail = null;


      $sqlvendidos = "SELECT IFNULL(SUM(cantidad), 0) AS vendidos
      from detalleventa d, venta v  
      where d.Venta_idVenta = v.idVenta and Articulo_idArticulo = 165 
      and v.Cliente_idCliente = :Persona_idPersona and fechaFactura = date(now())";

      $stmtDetail = $this->db->prepare($sqlvendidos);
      $stmtDetail->bindParam(':Persona_idPersona', $Persona_idPersona);
      $stmtDetail->execute();

      // Obtener todo el detalle
      $vendidos = $stmtDetail->fetch();
      $stmtDetail = null;


      $sqlStock = "SELECT IFNULL(cantidad, 0) AS cantidad from stockTercerizados st where Persona_idPersona = :Persona_idPersona";

      $stmtDetail = $this->db->prepare($sqlStock);
      $stmtDetail->bindParam(':Persona_idPersona', $Persona_idPersona);
      $stmtDetail->execute();

      // Obtener todo el detalle
      $stock = $stmtDetail->fetch();


      // Cerramos el statement
      $stmtDetail = null;



      // Agregar el detalle dentro de la clave "detalle" en el objeto $result
      // Asegúrate de que $result no sea false si no se encontró la cabecera
      if ($result) {
      $result->detalle = $detalle;
      $result->reposiciones = $reposiciones->reposicionesdia;
      $result->vendidos = $vendidos->vendidos;
      $result->stock = $stock->cantidad;
      }

      // Liberar la variable si ya no se necesita
      unset($orden);

        

      return ['success' => true, 'idVenta' => $idOrdenVenta, 'data' => $result];
  } catch (Exception $e) {
      // Rollback en caso de error
      $this->db->rollBack();
      return ['error' => 'Ocurrió un error al procesar la transacción.', 'mensaje' => $e->getMessage()];
  }
}




function orden_venta_crear_impresion($data) {
  // Recibir el JSON
  $token = Auth::getData($data['token']);
  $usuario = $token->login;
  $idUsuario = $token->id;
  $idOrdenVenta = $data['idOrdenVenta'];

  try {
      // Suponiendo que $idOrdenVenta exista y sea un valor numérico entero
      $sql = "
      SELECT 
          p.idPersona,
          p.razonSocial,
          p.nroDocumento,
          o.idOrdenVenta,
          o.fechaEntrega,
          'EN EL LOCAL' AS formaEntrega
      FROM ordenventa o
      JOIN persona p ON p.idPersona = o.Persona_idPersona
      WHERE o.idOrdenVenta = :idOrdenVenta
        AND o.usuarioInsercion IN ('cajatablet', 'admin')
      ";

      // Preparar, enlazar y ejecutar
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':idOrdenVenta', $idOrdenVenta);
      $stmt->execute();

      // Obtener la cabecera
      $result = $stmt->fetch();

      // Cerramos el statement
      $stmt = null;

      // Consulta del detalle
      $sqlDetail = "
      SELECT 
          d.OrdenVenta_idOrdenVenta,
          d.Articulo_idArticulo,
          F_NOMBRE_ARTICULO(d.Articulo_idArticulo) AS descripcion,
          d.cantidad,
          d.precio,
          d.total
      FROM detalleordenventa d
      WHERE d.OrdenVenta_idOrdenVenta = :idOrdenVenta
      ";

      $stmtDetail = $this->db->prepare($sqlDetail);
      $stmtDetail->bindParam(':idOrdenVenta', $idOrdenVenta);
      $stmtDetail->execute();

      // Obtener todo el detalle
      $detalle = $stmtDetail->fetchAll();

      // Cerramos el statement
      $stmtDetail = null;

      $sqlreposiciones = "SELECT IFNULL(SUM(cantidad), 0) AS reposicionesdia 
      from detalleventa d, venta v  
      where d.Venta_idVenta = v.idVenta and Articulo_idArticulo = 63 
      and v.Cliente_idCliente = :Persona_idPersona and fechaFactura = date(now()) and v.inactivo = 0";

      $stmtDetail = $this->db->prepare($sqlreposiciones);
      $stmtDetail->bindParam(':Persona_idPersona', $result->idPersona);
      $stmtDetail->execute();

      // Obtener todo el detalle
      $reposiciones = $stmtDetail->fetch();

      // Cerramos el statement
      $stmtDetail = null;


      $sqlvendidos = "SELECT IFNULL(SUM(cantidad), 0) AS vendidos
      from detalleventa d, venta v  
      where d.Venta_idVenta = v.idVenta and Articulo_idArticulo = 165 
      and v.Cliente_idCliente = :Persona_idPersona and fechaFactura = date(now()) and v.inactivo = 0";

      $stmtDetail = $this->db->prepare($sqlvendidos);
      $stmtDetail->bindParam(':Persona_idPersona', $result->idPersona);
      $stmtDetail->execute();

      // Obtener todo el detalle
      $vendidos = $stmtDetail->fetch();
      $stmtDetail = null;


      $sqlStock = "SELECT IFNULL(cantidad, 0) AS cantidad from stockTercerizados st where Persona_idPersona = :Persona_idPersona";

      $stmtDetail = $this->db->prepare($sqlStock);
      $stmtDetail->bindParam(':Persona_idPersona', $result->idPersona);
      $stmtDetail->execute();

      // Obtener todo el detalle
      $stock = $stmtDetail->fetch();


      // Cerramos el statement
      $stmtDetail = null;



      // Agregar el detalle dentro de la clave "detalle" en el objeto $result
      // Asegúrate de que $result no sea false si no se encontró la cabecera
      if ($result) {
      $result->detalle = $detalle;
      $result->reposiciones = $reposiciones->reposicionesdia;
      $result->vendidos = $vendidos->vendidos;
      $result->stock = $stock->cantidad;
      }

      // Liberar la variable si ya no se necesita
      unset($orden);

        

      return ['success' => true, 'idVenta' => $idOrdenVenta, 'data' => $result];
  } catch (Exception $e) {
      // Rollback en caso de error
      $this->db->rollBack();
      return ['error' => 'Ocurrió un error al procesar la transacción.', 'mensaje' => $e->getMessage()];
  }
}



  function venta_crear($data) {

      $token = Auth::getData($data['token']);
      $usuario = $token->login;
      $idUsuario = $token->id;
  
      $esRemision = ($data['esRemision'] == 1) ? 'S' : 'N';

      $Persona_idPersona = $data['idCliente'];
      $idDireccion = $data['idDireccion'];
      $latitude = $data['latitude'];
      $longitude = $data['longitude'];
      $efectivo = $data['efectivo'];
      $pagoTipo = $data['pagoTipo'];
      $retencion = $data['retencion'];
      $total = $data['total'];
      $habilitacion = $data['habilitacion'];  // Obtener el objeto habilitacion
  
      // Obtener cheques y transferencias
      $cheques = $data['cheques'];
      $transferencias = $data['transferencias'];
      $posDebito      = $data['posDebito']      ?? [];
      $posCredito     = $data['posCredito']     ?? [];
      // Obtener lista de artículos seleccionados
      $listArticulosSelected = $data['listArticulosSelected'];
  
      // Verificar que el total de la venta es igual al total de detalle de artículos
      $totalDetalle = array_reduce($listArticulosSelected, function($carry, $articulo) {
          return $carry + $articulo['precioTotal'];
      }, 0);
  
      if ($total != $totalDetalle) {
          return ['error' => 'El total de la venta no coincide con el total de los artículos.'];
      }
  
      // Inicializar variables para el total del recibo
      $totalRecibo =  $efectivo + $retencion
              + array_reduce($cheques       , fn($c,$v)=>$c+$v['importe'], 0)
              + array_reduce($transferencias, fn($c,$v)=>$c+$v['importe'], 0)
              + array_reduce($posDebito     , fn($c,$v)=>$c+$v['importe'], 0)   // 🆕
              + array_reduce($posCredito    , fn($c,$v)=>$c+$v['importe'], 0);  // 🆕

  
      // Verificar que el total de los recibos no supera el total de la venta
      if ($totalRecibo > $total) {
          return ['error' => 'El total de los recibos supera el total de la venta.'];
      }
  
      // Verificar que el total de los recibos sea igual al total de la venta cuando es al contado
      if ($pagoTipo == 1 && $totalRecibo != $total) {
          return ['error' => 'El total de la venta al contado debe ser igual al total de todas las formas de pago recibidas.'];
      }
  
      $cuotas = 1;
  
      try {
          // Iniciar la transacción
          $this->db->beginTransaction();
  
          // Insertar en la tabla `venta`
          $sql = "INSERT INTO `venta` (
                      `Cliente_idCliente`, `usuario`, `Direccion_idDireccion`, 
                      `fechaTransaccion`, `total`, `latitud`, `longitud`, `Remision`, 
                      `Habilitacion_idHabilitacion`, `Deposito_idDeposito`, `tipo_comprobante`, 
                      `nroFactura`, `timbrado`, `serie`, `TerminoPago_idTerminoPago`, `fechaFactura`, `vtoTimbrado`, `Moneda_idMoneda`, `tasaCambio`, `tasaCambioBases`, `usuarioInsercion`, `inactivo`, `cuotas`, `fechaPrimeraCuota`, `fechaVencimiento`
                  ) VALUES (
                      :Cliente_idCliente, :usuario, :Direccion_idDireccion, 
                      NOW(), :total, :latitud, :longitud, :Remision, 
                      :Habilitacion_idHabilitacion, :Deposito_idDeposito, :tipo_comprobante, 
                      :nroFactura, :timbrado, :serie, :TerminoPago_idTerminoPago, :fechaFactura, :vtoTimbrado, 1,1,1, :usuario, 0, :cuotas, now(), now()
                  )";
          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':Cliente_idCliente', $Persona_idPersona);
          $stmt->bindParam(':usuario', $usuario);
          $stmt->bindParam(':Direccion_idDireccion', $idDireccion);
          $stmt->bindParam(':total', $total);
          $stmt->bindParam(':latitud', $latitude);
          $stmt->bindParam(':longitud', $longitude);
          $stmt->bindParam(':Remision', $esRemision);
          $stmt->bindParam(':Habilitacion_idHabilitacion', $habilitacion['idhabilitacion']);
          $stmt->bindParam(':Deposito_idDeposito', $habilitacion['dp']);
          $stmt->bindParam(':tipo_comprobante', $habilitacion['tipoDocumento']);
          $stmt->bindParam(':nroFactura', $habilitacion['a']);
          $stmt->bindParam(':timbrado', $habilitacion['timbrado']);
          $stmt->bindParam(':serie', $habilitacion['serie']);
          $stmt->bindParam(':TerminoPago_idTerminoPago', $pagoTipo);
          $stmt->bindParam(':fechaFactura', $habilitacion['fecha']);
          $stmt->bindParam(':cuotas', $cuotas);
          $stmt->bindParam(':vtoTimbrado', $habilitacion['fechaEntrega']);
          $stmt->execute();
          $idVenta = $this->db->lastInsertId();
  
          // Insertar en la tabla `detalleventa`
              /* ───── SENTENCIA PREPARADA (1 sola vez) ───── */
              $sql = "INSERT INTO detalleventa (
                          Venta_idVenta, Articulo_idArticulo, cantidad,
                          precio, impuesto, total,
                          cantidadStock, cantidadRemision
                      ) VALUES (
                          :Venta_idVenta, :Articulo_idArticulo, :cantidad,
                          :precio, :impuesto, :total,
                          :cantidadStock, :cantidadRemision
                      )";
              $stmt = $this->db->prepare($sql);
              /* ───── RECORRER LA LISTA ───── */
              foreach ($listArticulosSelected as $articulo) {
                

                  /* 1. Valores base */
                  $stmt->bindValue(':Venta_idVenta',       $idVenta);
                  $stmt->bindValue(':Articulo_idArticulo', $articulo['idArticulo']);
                  $stmt->bindValue(':cantidad',            $articulo['cantidad']);
                  $stmt->bindValue(':precio',              $articulo['precio']);      // DECIMAL → string
                  $stmt->bindValue(':impuesto',            $articulo['impuesto']);
                  $stmt->bindValue(':total',               $articulo['precioTotal']);

                  /* 2. cantidadStock siempre viene del array */
                  $stmt->bindValue(':cantidadStock', $articulo['cantidadStock'] ?? 0);


                  /* 3. cantidadRemision según $esRemision */
                  $cantidadRemision = ($esRemision === 'S')
                                      ? $articulo['cantidad']   // mismo valor que cantidad
                                      : 0;                      // caso contrario
                  $stmt->bindValue(':cantidadRemision', $cantidadRemision);

                  /* 4. Ejecutar */
                  $stmt->execute();
              }
        $sql = '';        
  
          // Si pagoTipo > 1, no se inserta el recibo y sus detalles
          //if ($pagoTipo <= 1) {
              // Insertar en la tabla `recibo`
              $sql = "INSERT INTO `recibo` (
                          `CLIENTE_IDCLIENTE`, `USUARIO`, `FECHATRANSACCION`, 
                          `TOTAL`, `HABILITACION_IDHABILITACION`
                      ) VALUES (
                          :CLIENTE_IDCLIENTE, :USUARIO, NOW(), 
                          :TOTAL, :HABILITACION_IDHABILITACION
                      )";
              $stmt = $this->db->prepare($sql);
              $stmt->bindParam(':CLIENTE_IDCLIENTE', $Persona_idPersona);
              $stmt->bindParam(':USUARIO', $usuario);
              $stmt->bindParam(':TOTAL', $totalRecibo);
              $stmt->bindParam(':HABILITACION_IDHABILITACION', $habilitacion['idhabilitacion']);
              $stmt->execute();
              $idRecibo = $this->db->lastInsertId();
  
              // Insertar en la tabla `detallerecibofacturas`
              $sql = "INSERT INTO `detallerecibofacturas` (
                          `RECIBO_IDRECIBO`, `VENTA_IDVENTA`, `MONTOAPLICADO`, `INACTIVO`, `CUOTA`
                      ) VALUES (
                          :RECIBO_IDRECIBO, :VENTA_IDVENTA, :MONTOAPLICADO, 0, 1
                      )";
              $stmt = $this->db->prepare($sql);
              $stmt->bindParam(':RECIBO_IDRECIBO', $idRecibo);
              $stmt->bindParam(':VENTA_IDVENTA', $idVenta);
              $stmt->bindParam(':MONTOAPLICADO', $totalRecibo);
              $stmt->execute();
  
              // Insertar en la tabla `detallerecibo`
              foreach ($cheques as $cheque) {
                  $sql = "INSERT INTO `detallerecibo` (
                              `RECIBO_IDRECIBO`, `FORMAPAGO_IDFORMAPAGO`, 
                              `BANCO_IDBANCO`, `MONTO`, `INACTIVO`, `Moneda_idMoneda`, `tasaCambio`
                          ) VALUES (
                              :RECIBO_IDRECIBO, 4, :BANCO_IDBANCO, :MONTO, 0, 1, 1
                          )";
                  $stmt = $this->db->prepare($sql);
                  $stmt->bindParam(':RECIBO_IDRECIBO', $idRecibo);
                  $stmt->bindParam(':BANCO_IDBANCO', $cheque['banco']);
                  $stmt->bindParam(':MONTO', $cheque['importe']);
                  $stmt->execute();
              }
  
              foreach ($transferencias as $transferencia) {
                  $sql = "INSERT INTO `detallerecibo` (
                              `RECIBO_IDRECIBO`, `FORMAPAGO_IDFORMAPAGO`, 
                              `BANCO_IDBANCO`, `MONTO`, `INACTIVO`, `Moneda_idMoneda`, `tasaCambio`
                          ) VALUES (
                              :RECIBO_IDRECIBO, 1, :BANCO_IDBANCO, :MONTO, 0, 1, 1
                          )";
                  $stmt = $this->db->prepare($sql);
                  $stmt->bindParam(':RECIBO_IDRECIBO', $idRecibo);
                  $stmt->bindParam(':BANCO_IDBANCO', $transferencia['banco']);
                  $stmt->bindParam(':MONTO', $transferencia['importe']);
                  $stmt->execute();
              }
  
                /* ---------- POS DÉBITO (id = 2) ---------- */          // 🆕
                foreach ($posDebito as $pd) {
                    $stmt = $this->db->prepare(
                      "INSERT INTO detallerecibo
                        (RECIBO_IDRECIBO, FORMAPAGO_IDFORMAPAGO, BANCO_IDBANCO, MONTO,
                          INACTIVO, Moneda_idMoneda, tasaCambio)
                      VALUES
                        (:rec, 9, :bco, :mnt, 0, 1, 1)"
                    );
                    $stmt->execute([
                      ':rec'=>$idRecibo, ':bco'=>$pd['banco'], ':mnt'=>$pd['importe']
                    ]);
                }

                /* ---------- POS CRÉDITO (id = 3) ---------- */         // 🆕
                foreach ($posCredito as $pc) {
                    $stmt = $this->db->prepare(
                      "INSERT INTO detallerecibo
                        (RECIBO_IDRECIBO, FORMAPAGO_IDFORMAPAGO, BANCO_IDBANCO, MONTO,
                          INACTIVO, Moneda_idMoneda, tasaCambio)
                      VALUES
                        (:rec, 10, :bco, :mnt, 0, 1, 1)"
                    );
                    $stmt->execute([
                      ':rec'=>$idRecibo, ':bco'=>$pc['banco'], ':mnt'=>$pc['importe']
                    ]);
                }


              // Insertar efectivo en la tabla `detallerecibo`
              if ($efectivo > 0) {
                  $sql = "INSERT INTO `detallerecibo` (
                              `RECIBO_IDRECIBO`, `FORMAPAGO_IDFORMAPAGO`, 
                              `MONTO`, `INACTIVO`, `Moneda_idMoneda`, `tasaCambio`
                          ) VALUES (
                              :RECIBO_IDRECIBO, 5, :MONTO, 0, 1, 1
                          )";
                  $stmt = $this->db->prepare($sql);
                  $stmt->bindParam(':RECIBO_IDRECIBO', $idRecibo);
                  $stmt->bindParam(':MONTO', $efectivo);
                  $stmt->execute();
              }
  
              if ($retencion > 0) {
                $sql = "INSERT INTO `detallerecibo` (
                            `RECIBO_IDRECIBO`, `FORMAPAGO_IDFORMAPAGO`, 
                            `MONTO`, `INACTIVO`, `Moneda_idMoneda`, `tasaCambio`
                        ) VALUES (
                            :RECIBO_IDRECIBO, 7, :MONTO, 0, 1, 1
                        )";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':RECIBO_IDRECIBO', $idRecibo);
                $stmt->bindParam(':MONTO', $retencion);
                $stmt->execute();
            }
         // }
  



              // Insertar en la tabla `venta`
              $sql = "INSERT INTO ordenventa (
                Persona_idPersona,
                TerminoPago_idTerminoPago,
                total,
                latitud,
                longitud,
                Deposito_idDeposito,
                Habilitacion_idHabilitacion,
                fecha,
                usuarioInsercion,
                fechaInsercion,
                fechaEntrega,
                tipo,
                facturado
            ) VALUES (
                :Persona_idPersona,
                :TerminoPago_idTerminoPago,
                :total,
                :latitud,
                :longitud,
                :Deposito_idDeposito,
                :Habilitacion_idHabilitacion,
                NOW(),
                :usuario,
                NOW(),
                NOW(),
                1,
                1)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':Persona_idPersona', $Persona_idPersona);
            $stmt->bindParam(':TerminoPago_idTerminoPago', $pagoTipo);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':latitud', $latitude);
            $stmt->bindParam(':longitud', $longitude);
            $stmt->bindParam(':Deposito_idDeposito', $habilitacion['dp']);
            $stmt->bindParam(':Habilitacion_idHabilitacion', $habilitacion['idhabilitacion']);
            $stmt->bindParam(':usuario', $usuario);

            $stmt->execute();
            $idOrdenVenta = $this->db->lastInsertId();


              // Insertar en la tabla `detalleventa`
              foreach ($listArticulosSelected as $articulo) {
                $sql = "INSERT INTO detalleordenventa (
                            OrdenVenta_idOrdenVenta, 
                            Articulo_idArticulo, 
                            cantidad, 
                            precio, 
                            descuento, 
                            impuesto, 
                            totalNeto, 
                            total
                        ) VALUES (
                            :OrdenVenta_idOrdenVenta, 
                            :Articulo_idArticulo, 
                            :cantidad, 
                            :precio, 
                            0, 
                            :impuesto, 
                            :total, 
                            :total
                        )";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':OrdenVenta_idOrdenVenta', $idOrdenVenta);
                $stmt->bindParam(':Articulo_idArticulo', $articulo['idArticulo']);
                $stmt->bindParam(':cantidad', $articulo['cantidad']);
                $stmt->bindParam(':precio', $articulo['precio']);
                $stmt->bindParam(':impuesto', $articulo['impuesto']);
                $stmt->bindParam(':total', $articulo['precioTotal']);
                $stmt->execute();
            }



              // Commit de la transacción
              $this->db->commit();


            $sql = "SELECT v.vtoTimbrado, p.razonSocial , p.nroDocumento , v.idVenta , v.fechaFactura , v.total, concat(v.serie , '-', v.nroFactura) as nroFacturaVenta, v.timbrado, s.direccion as DireccionEmpresa, s.correo as correoEmpresa , s.nombre as nombreSucursal , s.telefono as telefonoEmpresa, s.rucEmpresa , s.nombreEmpresa, t.descripcion  as terminoPago, '' as direccionCliente 
            from venta v, persona p, habilitacion h, caja c, sucursal s , terminopago t  where t.idTerminoPago = v.TerminoPago_idTerminoPago  and  s.idSucursal  = c.Sucursal_idSucursal and c.idcaja = h.Caja_idCaja  and v.Habilitacion_idHabilitacion = h.idhabilitacion and   p.idPersona = v.Cliente_idCliente and v.idVenta  = :idVenta
            ";

            // Preparar, enlazar y ejecutar
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idVenta', $idVenta);
            $stmt->execute();

            // Obtener la cabecera
            $result = $stmt->fetch();

            // Cerramos el statement
            $stmt = null;

            // Consulta del detalle
            $sqlDetail = "select d.descripcion , d.cantidad , d.precio, d.impuesto , d.total , d.cantidadStock from detalleventa d where d.Venta_idVenta = :idVenta";

            $stmtDetail = $this->db->prepare($sqlDetail);
            $stmtDetail->bindParam(':idVenta', $idVenta);
            $stmtDetail->execute();

            // Obtener todo el detalle
            $detalle = $stmtDetail->fetchAll();

            // Cerramos el statement
            $stmtDetail = null;




            // Consulta del detalle
            $sqlDetail = "SELECT d.monto, f.descripcion  from detallerecibo d, detallerecibofacturas d2, formapago f  where f.idFormaPago = d.FORMAPAGO_IDFORMAPAGO and d.RECIBO_IDRECIBO = d2.RECIBO_IDRECIBO and d2.VENTA_IDVENTA = :idVenta and d.MONTO > 0;";

            $stmtDetail = $this->db->prepare($sqlDetail);
            $stmtDetail->bindParam(':idVenta', $idVenta);
            $stmtDetail->execute();

            // Obtener todo el detalle
            $detallePago = $stmtDetail->fetchAll();

            // Cerramos el statement
            $stmtDetailPago = null;

            // Agregar el detalle dentro de la clave "detalle" en el objeto $result
            // Asegúrate de que $result no sea false si no se encontró la cabecera
            if ($result) {
            $result->detalle = $detalle;
            $result->detallePago = $detallePago;
            }

            // Liberar la variable si ya no se necesita
            unset($orden);





              return ['success' => true, 'idVenta' => $idVenta, 'data' => $result];
          } catch (Exception $e) {
              // Rollback en caso de error
              $this->db->rollBack();
              return ['error' => 'Ocurrió un error al procesar la transacción.', 'mensaje' => $e->getMessage()];
          }
      }
      



function venta_reimprimir($data) {
    try {
        $idVenta = $data['id'];

        // Obtener la cabecera de la venta
        $sql = "SELECT 
                    v.vtoTimbrado, p.razonSocial, p.nroDocumento, 
                    v.idVenta, v.fechaFactura, v.total, 
                    CONCAT(v.serie, '-', v.nroFactura) AS nroFacturaVenta, 
                    v.timbrado, s.direccion AS DireccionEmpresa, 
                    s.correo AS correoEmpresa, s.nombre AS nombreSucursal, 
                    s.telefono AS telefonoEmpresa, s.rucEmpresa, 
                    s.nombreEmpresa, t.descripcion AS terminoPago, 
                    '' AS direccionCliente
                FROM venta v
                JOIN persona p ON p.idPersona = v.Cliente_idCliente
                JOIN habilitacion h ON v.Habilitacion_idHabilitacion = h.idhabilitacion
                JOIN caja c ON c.idcaja = h.Caja_idCaja
                JOIN sucursal s ON s.idSucursal = c.Sucursal_idSucursal
                JOIN terminopago t ON t.idTerminoPago = v.TerminoPago_idTerminoPago
                WHERE v.idVenta = :idVenta";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idVenta', $idVenta);
        $stmt->execute();
        $result = $stmt->fetch();

        if (!$result) {
            return ['error' => 'Venta no encontrada.'];
        }

        // Detalle de artículos
        $sqlDetail = "SELECT 
                        d.descripcion, d.cantidad, d.precio, 
                        d.impuesto, d.total, d.cantidadStock 
                      FROM detalleventa d 
                      WHERE d.Venta_idVenta = :idVenta";
        $stmtDetail = $this->db->prepare($sqlDetail);
        $stmtDetail->bindParam(':idVenta', $idVenta);
        $stmtDetail->execute();
        $detalle = $stmtDetail->fetchAll();

        // Detalle de pagos
        $sqlPagos = "SELECT 
                        d.monto, f.descripcion 
                    FROM detallerecibo d
                    JOIN detallerecibofacturas d2 ON d.RECIBO_IDRECIBO = d2.RECIBO_IDRECIBO
                    JOIN formapago f ON f.idFormaPago = d.FORMAPAGO_IDFORMAPAGO
                    WHERE d2.VENTA_IDVENTA = :idVenta AND d.MONTO > 0";
        $stmtPagos = $this->db->prepare($sqlPagos);
        $stmtPagos->bindParam(':idVenta', $idVenta);
        $stmtPagos->execute();
        $detallePago = $stmtPagos->fetchAll();

        // Estructura de respuesta
        $result->detalle = $detalle;
        $result->detallePago = $detallePago;

        return ['success' => true, 'data' => $result];

    } catch (Exception $e) {
        return ['error' => 'Ocurrió un error al recuperar la venta.', 'mensaje' => $e->getMessage()];
    }
}





    function editar_habilitacion($data){

          $token = Auth::getData( $data['token'] );
          $usuario = $token->usuario;

          $Habilitacion_idHabilitacion = $data['Habilitacion_idHabilitacion'];
          $Moneda_idMoneda = 1;
          $m1 = $data['m1'];
          $m2 = $data['m2'];
          $m3 = $data['m3'];
          $m4 = $data['m4'];
          $m5 = $data['m5'];
          $m6 = $data['m6'];
          $m7 = $data['m7'];
          $m8 = $data['m8'];
          $m9 = $data['m9'];
          $m10 = $data['m10'];


          try {
            $this->db->beginTransaction();

            // Preparing SQL for updating records in detallehabilitacion table
            $sql = "UPDATE `detallehabilitacion` 
                    SET `montoCierre` = :m1
                    WHERE `Habilitacion_idHabilitacion` = :Habilitacion_idHabilitacion AND `Moneda_idMoneda` = 1 AND `Denominacion_idDenominacion` = :Denominacion_idDenominacion";
        
            for ($i = 1; $i <= 10; $i++) {
                $stmt = $this->db->prepare($sql);
                $monto = ${"m" . $i};
                $stmt->bindParam(':m1', $monto);
                
                // Set the Denominacion_idDenominacion dynamically
                $stmt->bindParam(':Denominacion_idDenominacion', $i);
                
                // Habilitacion_idHabilitacion remains constant for all updates
                $stmt->bindParam(':Habilitacion_idHabilitacion', $Habilitacion_idHabilitacion);
                
                // Execute the statement
                $stmt->execute();
            }
        
            // Commit the transaction
            $this->db->commit();
    } catch (Exception $e) {
        // An error occurred, rollback any changes
        $this->db->rollBack();
        // Log the error or handle it as per your need
        // throw $e; // Optionally rethrow or handle it as per your application's error handling policy
        return false; // Indicate failure
    }

  restore_error_handler();
        
}

function agregarDireccion($data){


      $token = Auth::getData( $data['token'] );
      $usuario = $token->login;

      $idPersona = $data['idCliente'];
      $direccion = $data['direccion'];
      $ciudad = $data['ciudad'];
      $lat = $data['latitud'];
      $lng = $data['longitud'];
      $domingo = $data['diasSemana']['domingo'];
      $lunes = $data['diasSemana']['lunes'];
      $martes = $data['diasSemana']['martes'];
      $miercoles = $data['diasSemana']['miercoles'];
      $jueves = $data['diasSemana']['jueves'];
      $viernes = $data['diasSemana']['viernes'];
      $sabado = $data['diasSemana']['sabado'];
      $imagen = $data['imagen'];

      $imagenBase64 = $data['imagen']; // Asegúrate de validar y sanear esta entrada

       if (strpos($imagenBase64, 'data:image/jpeg;base64,') === 0) {
           $imagenBase64 = substr($imagenBase64, strlen('data:image/png;base64,'));
       }
     
       $imagenBase64 = str_replace(' ', '+', $imagenBase64);
       $datosImagen = base64_decode($imagenBase64);
     
       if ($datosImagen === false) {
           // La cadena Base64 no es válida
           die("Error en la decodificación de Base64");
       }
     
       $nombreArchivo = uniqid() . '.jpeg';
       $directorioDestino = "/home/junior/web/factupar.com.py/public_html/pauny/files/direcciones/";
       $rutaArchivo = $directorioDestino . $nombreArchivo;
     
       $resultado = file_put_contents($rutaArchivo, $datosImagen);
       if ($resultado === false) {
           // No se pudo escribir el archivo
           die("Error al escribir el archivo");
       }


  try {
       $sql = "CALL SP_GenerarUsuarioGeneralDireccion(:idPersona, :direccion, :ciudad,:lat, :lng, :domingo, :lunes, :martes, :miercoles, :jueves, :viernes, :sabado, :imagen, :usuario )";      
       $stmt  = $this->db->prepare($sql);  
        
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':lat', $lat);
        $stmt->bindParam(':lng', $lng);
        $stmt->bindParam(':domingo', $domingo);
        $stmt->bindParam(':lunes', $lunes);
        $stmt->bindParam(':martes', $martes);
        $stmt->bindParam(':miercoles', $miercoles);
        $stmt->bindParam(':jueves', $jueves);
        $stmt->bindParam(':viernes', $viernes);
        $stmt->bindParam(':sabado', $sabado);
        $stmt->bindParam(':imagen', $nombreArchivo);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':idPersona', $idPersona);


       return $estado=$stmt->execute();
        return $data;

      
} catch (Exception $e) {
    return $e;
}

  restore_error_handler();
        
}


function insertar_app($data){

   

  //PARTE 1 - TABLA USUARIO - PERSONA
      
      $token = Auth::getData( $data['token'] );
      $usuario = $token->login;

      $razonSocial =    $data['nombreCompleto'];
      $tipoDocumento = $data['tipoDocumento'];
      $nroDocumento = $data['numeroDocumento'];
      $direccion = $data['direccion'];
      $celular = $data['telefono'];
      $correo = $data['email'];
     
      $nacimiento = $data['fechaNacimiento'];
      $ciudad = $data['ciudad'];
      $lat = $data['latitud'];
      $lng = $data['longitud'];
      $domingo = $data['diasSemana']['domingo'];
      $lunes = $data['diasSemana']['lunes'];
      $martes = $data['diasSemana']['martes'];
      $miercoles = $data['diasSemana']['miercoles'];
      $jueves = $data['diasSemana']['jueves'];
      $viernes = $data['diasSemana']['viernes'];
      $sabado = $data['diasSemana']['sabado'];
      $imagen = $data['imagen'];
      //$usuario = $data['usuario'];

      $imagenBase64 = $data['imagen']; // Asegúrate de validar y sanear esta entrada

       if (strpos($imagenBase64, 'data:image/jpeg;base64,') === 0) {
           $imagenBase64 = substr($imagenBase64, strlen('data:image/png;base64,'));
       }
     
       $imagenBase64 = str_replace(' ', '+', $imagenBase64);
       $datosImagen = base64_decode($imagenBase64);
     
       if ($datosImagen === false) {
           // La cadena Base64 no es válida
           die("Error en la decodificación de Base64");
       }
     
       $nombreArchivo = uniqid() . '.jpeg';
       $directorioDestino = "/home/junior/web/factupar.com.py/public_html/pauny/files/direcciones/";
       $rutaArchivo = $directorioDestino . $nombreArchivo;
     
       $resultado = file_put_contents($rutaArchivo, $datosImagen);
       if ($resultado === false) {
           // No se pudo escribir el archivo
           die("Error al escribir el archivo");
       }


  try {
       $sql = "CALL SP_GenerarUsuarioGeneral( :razonSocial, :tipoDocumento, :nroDocumento, :direccion, :celular, :correo, :nacimiento, :ciudad,:lat, :lng, :domingo, :lunes, :martes, :miercoles, :jueves, :viernes, :sabado, :imagen, :usuario )";      
       $stmt  = $this->db->prepare($sql);  
        
        $stmt->bindParam(':razonSocial', $razonSocial);
        $stmt->bindParam(':tipoDocumento', $tipoDocumento);
        $stmt->bindParam(':nroDocumento', $nroDocumento);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':celular', $celular);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':nacimiento', $nacimiento );
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':lat', $lat);
        $stmt->bindParam(':lng', $lng);
        $stmt->bindParam(':domingo', $domingo);
        $stmt->bindParam(':lunes', $lunes);
        $stmt->bindParam(':martes', $martes);
        $stmt->bindParam(':miercoles', $miercoles);
        $stmt->bindParam(':jueves', $jueves);
        $stmt->bindParam(':viernes', $viernes);
        $stmt->bindParam(':sabado', $sabado);
        $stmt->bindParam(':imagen', $nombreArchivo);
        $stmt->bindParam(':usuario', $usuario);


       $estado=$stmt->execute();
        return $data;

      
} catch (Exception $e) {
    return $e;
}

  restore_error_handler();
        
}


function insertar_web($data){

   //PARTE 1 - TABLA USUARIO - PERSONA
       $razonSocial =    $data['nombreCompleto'];
       $tipoDocumento = $data['tipoDocumento'];
       $nroDocumento = $data['numeroDocumento'];
       $direccion = $data['direccion'];
       $celular = $data['telefono'];
       $correo = $data['email'];
      
       $nacimiento = $data['fechaNacimiento'];
       $ciudad = $data['ciudad'];
       $lat = $data['latitud'];
       $lng = $data['longitud'];
       $domingo = $data['diasSemana']['domingo'];
       $lunes = $data['diasSemana']['lunes'];
       $martes = $data['diasSemana']['martes'];
       $miercoles = $data['diasSemana']['miercoles'];
       $jueves = $data['diasSemana']['jueves'];
       $viernes = $data['diasSemana']['viernes'];
       $sabado = $data['diasSemana']['sabado'];
       $imagen = $data['imagen'];
       $usuario = $data['usuario'];

       $imagenBase64 = $data['imagen']; // Asegúrate de validar y sanear esta entrada

        if (strpos($imagenBase64, 'data:image/jpeg;base64,') === 0) {
            $imagenBase64 = substr($imagenBase64, strlen('data:image/png;base64,'));
        }
      
        $imagenBase64 = str_replace(' ', '+', $imagenBase64);
        $datosImagen = base64_decode($imagenBase64);
      
        if ($datosImagen === false) {
            // La cadena Base64 no es válida
            die("Error en la decodificación de Base64");
        }
      
        $nombreArchivo = uniqid() . '.jpeg';
        $directorioDestino = "/home/junior/web/factupar.com.py/public_html/pauny/files/direcciones/";
        $rutaArchivo = $directorioDestino . $nombreArchivo;
      
        $resultado = file_put_contents($rutaArchivo, $datosImagen);
        if ($resultado === false) {
            // No se pudo escribir el archivo
            die("Error al escribir el archivo");
        }


   try {
        $sql = "CALL SP_GenerarUsuarioGeneral( :razonSocial, :tipoDocumento, :nroDocumento, :direccion, :celular, :correo, :nacimiento, :ciudad,:lat, :lng, :domingo, :lunes, :martes, :miercoles, :jueves, :viernes, :sabado, :imagen, :usuario )";      
        $stmt  = $this->db->prepare($sql);  
         
         $stmt->bindParam(':razonSocial', $razonSocial);
         $stmt->bindParam(':tipoDocumento', $tipoDocumento);
         $stmt->bindParam(':nroDocumento', $nroDocumento);
         $stmt->bindParam(':direccion', $direccion);
         $stmt->bindParam(':celular', $celular);
         $stmt->bindParam(':correo', $correo);
         $stmt->bindParam(':nacimiento', $nacimiento );
         $stmt->bindParam(':ciudad', $ciudad);
         $stmt->bindParam(':lat', $lat);
         $stmt->bindParam(':lng', $lng);
         $stmt->bindParam(':domingo', $domingo);
         $stmt->bindParam(':lunes', $lunes);
         $stmt->bindParam(':martes', $martes);
         $stmt->bindParam(':miercoles', $miercoles);
         $stmt->bindParam(':jueves', $jueves);
         $stmt->bindParam(':viernes', $viernes);
         $stmt->bindParam(':sabado', $sabado);
         $stmt->bindParam(':imagen', $nombreArchivo);
         $stmt->bindParam(':usuario', $usuario);

 
        return $estado=$stmt->execute();


       
 } catch (Exception $e) {
     return $e;
 }

   restore_error_handler();
         
}




    function insertar($data){

     // return $data;

  
      //PARTE 1 - TABLA USUARIO - PERSONA
          $idPersona =    $data['idPersona'];
          $razonSocial =    $data['razonSocial'];
          $tipoDocumento = $data['tipoDocumento'];
          $nroDocumento = $data['nroDocumento'];
          $direccion = $data['direccion'];
          $celular = $data['celular'];
          $correo = $data['correo'];
         
          $nacimiento = $data['nacimiento'];
          $ciudad = $data['ciudad'];
          $lat = $data['lat'];
          $lng = $data['lng'];
          $domingo = $data['domingo'];
          $lunes = $data['lunes'];
          $martes = $data['martes'];
          $miercoles = $data['miercoles'];
          $jueves = $data['jueves'];
          $viernes = $data['viernes'];
          $sabado = $data['sabado'];
          $imagen = $data['imagen'];


      try {

        if ($idPersona > 0) {
          return true;
        }else{

           $sql = "CALL SP_GenerarUsuarioGeneral( :razonSocial, :tipoDocumento, :nroDocumento, :direccion, :celular, :correo, :nacimiento, :ciudad,:lat, :lng, :domingo, :lunes, :martes, :miercoles, :jueves, :viernes, :sabado, :imagen )";      
           $stmt  = $this->db->prepare($sql);  
            
            $stmt->bindParam(':razonSocial', $razonSocial);
            $stmt->bindParam(':tipoDocumento', $tipoDocumento);
            $stmt->bindParam(':nroDocumento', $nroDocumento);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':celular', $celular);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':nacimiento', $nacimiento );
            $stmt->bindParam(':ciudad', $ciudad);
            $stmt->bindParam(':lat', $lat);
            $stmt->bindParam(':lng', $lng);
            $stmt->bindParam(':domingo', $domingo);
            $stmt->bindParam(':lunes', $lunes);
            $stmt->bindParam(':martes', $martes);
            $stmt->bindParam(':miercoles', $miercoles);
            $stmt->bindParam(':jueves', $jueves);
            $stmt->bindParam(':viernes', $viernes);
            $stmt->bindParam(':sabado', $sabado);
            $stmt->bindParam(':imagen', $imagen);

    
           return $estado=$stmt->execute();
   


            $sql = "SELECT idPersona FROM persona WHERE mail=:email";   
            $stmt = $this->db->prepare($sql); 
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $resultado = $stmt->fetch(); 

          }  
    } catch (Exception $e) {
        return $e;
    }

      return $token;


      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }




    function crearVehiculo($data){
      
      
      //PARTE 2 - TABLA VEHICULOS
      $imagenHabilitacionFrontal = $data['imagenHabilitacionFrontal']; // habilitacion frontal
      $imagenHabilitacionTrasera = $data['imagenHabilitacionTrasera']; // habilitacion reverso
      $imagenSeguro = $data['imagenSeguro']; // habilitacion reverso
      $MarcaVehiculo_idMarcaVehiculo = $data['MarcaVehiculo_idMarcaVehiculo'];
      $Modelo_idModelo = $data['Modelo_idModelo'];
      $matricula = $data['matricula'];
      $anhoVehiculo = $data['anhoVehiculo'];
      $tipoVehiculo = $data['tipoVehiculo'];
      
      $token = Auth::getData( $data['token'] );
      $email = $token->usuario;

      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });


      try {

            $sql = "CALL SP_CrearVehiculos(:imagenHabilitacionFrontal, :imagenHabilitacionTrasera, :imagenSeguro, :MarcaVehiculo_idMarcaVehiculo, :Modelo_idModelo, :matricula, :anhoVehiculo, :tipoVehiculo, :email)";
                
            $stmt  = $this->db->prepare($sql);  
          

            $stmt->bindParam(':imagenHabilitacionFrontal', $imagenHabilitacionFrontal);
            $stmt->bindParam(':imagenHabilitacionTrasera', $imagenHabilitacionTrasera);
            $stmt->bindParam(':imagenSeguro', $imagenSeguro);
            $stmt->bindParam(':MarcaVehiculo_idMarcaVehiculo', $MarcaVehiculo_idMarcaVehiculo);
            $stmt->bindParam(':Modelo_idModelo', $Modelo_idModelo);
            $stmt->bindParam(':matricula', $matricula);
            $stmt->bindParam(':anhoVehiculo', $anhoVehiculo);
            $stmt->bindParam(':tipoVehiculo', $tipoVehiculo);
            $stmt->bindParam(':email', $email);

            
    
            $estado=$stmt->execute();

            return $estado;    


    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }

/*
function ActualizarDireccion($data){
  // PARTE 1 - TABLA USUARIO - PERSONA
  
  $token = Auth::getData( $data['token'] );
      $usuario = $token->usuario;
      $idPersona = $data['idPersona']; 
      $mail = $data['mail']; 
      $nroDocumento = $data['nroDocumento']; 
      $razonSocial = $data['razonSocial'];

  try {
      // Inicia la transacción
      $this->db->beginTransaction();

      $sql="UPDATE persona SET mail = :mail, nroDocumento = :nroDocumento,
      razonSocial = :razonSocial WHERE idPersona = :idPersona";

      $stmt = $this->db->prepare($sql);  
      // Vincula los parámetros
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':nroDocumento', $nroDocumento);
        $stmt->bindParam(':razonSocial', $razonSocial);
  
      // Ejecuta la sentencia
      $success = $stmt->execute();

      // Si la actualización fue exitosa, commitea la transacción
      if ($success) {
          $this->db->commit();
          return true; // Indica éxito
      } else {
          // Si la ejecución no fue exitosa, hace rollback
          $this->db->rollBack();
          return false; // Indica fallo
      }
  } catch (Exception $e) {
      // Si ocurre un error, hace rollback
      $this->db->rollBack();
      // Aquí podrías registrar el error según tu política de manejo de errores
      return false; // Indica fallo
  }

  restore_error_handler();
}

 function CargarDireccion($data){

      $token = Auth::getData( $data['token'] );
      $usuario = $token->usuario;
      $idDireccion = $data['idDireccion']; 
      $Persona_idPersona = $data['Persona_idPersona']; 
      $callePrincipal = $data['callePrincipal'];
      $calleTransversal = $data['calleTransversal'];
      $nroCasa = $data['nroCasa'];
      $TipoDireccion_Telefono_idTipoDireccion_Telefono = $data['TipoDireccion_Telefono_idTipoDireccion_Telefono'];
      $Barrio_idBarrio = $data['Barrio_idBarrio'];
      $Ciudad_idCiudad = $data['Ciudad_idCiudad'];
      $inactivo = $data['inactivo'];
      $usuarioModificacion = $data['usuarioModificacion'];
      $fechaModificacion = $data['fechaModificacion'];
      $usuarioInsercion = $data['usuarioInsercion'];
      $fechaInsercion = $data['fechaInsercion'];
      $latitud = $data['latitud'];
      $longitud = $data['longitud'];

      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });


      try {
        $sql="INSERT INTO `direccion`(`idDireccion`,`Persona_idPersona`,`callePrincipal`,`calleTransversal`,`nroCasa`,`TipoDireccion_Telefono_idTipoDireccion_Telefono`,`Barrio_idBarrio`,`Ciudad_idCiudad`,`inactivo`,`usuarioModificacion`,`fechaModificacion`,`usuarioInsercion`,`fechaInsercion`,`latitud`,`longitud`)
              VALUES
              (
                :idDireccion,
                :Persona_idPersona,
                :callePrincipal,
                :calleTransversal,
                :nroCasa,
                :TipoDireccion_Telefono_idTipoDireccion_Telefono,
                :Barrio_idBarrio,
                :Ciudad_idCiudad,
                :0,
                :usuarioModificacion,
                :fechaModificacion,
                :usuario,
                :curdate(),
                :latitud,
                :longitud
              )"; 
        $stmt  = $this->db->prepare($sql);  
        
        // Bind parameters
        $stmt->bindParam(':idDireccion', $idDireccion);
        $stmt->bindParam(':Persona_idPersona', $Persona_idPersona);
        $stmt->bindParam(':callePrincipal', $callePrincipal);
        $stmt->bindParam(':calleTransversal', $calleTransversal);
        $stmt->bindParam(':nroCasa', $nroCasa);
          $stmt->bindParam(':TipoDireccion_Telefono_idTipoDireccion_Telefono', $TipoDireccion_Telefono_idTipoDireccion_Telefono);
            $stmt->bindParam(':Barrio_idBarrio', $Barrio_idBarrio);
              $stmt->bindParam(':Ciudad_idCiudad', $Ciudad_idCiudad);
                $stmt->bindParam(':inactivo', $inactivo);
                  $stmt->bindParam(':usuarioModificacion', $usuarioModificacion);
                    $stmt->bindParam(':fechaModificacion', $fechaModificacion);
                      $stmt->bindParam(':usuarioInsercion', $usuarioInsercion);
                        $stmt->bindParam(':fechaInsercion', $fechaInsercion);
                          $stmt->bindParam(':latitud', $latitud);
                            $stmt->bindParam(':longitud', $latitud);
        // Execute the statement
        $stmt->execute();

        $estado=$stmt->execute();

        return $estado;

    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }

function ActualizarDireccion($data){
  // PARTE 1 - TABLA USUARIO - PERSONA
  
  $token = Auth::getData( $data['token'] );
      $usuario = $token->usuario;
      $idDireccion = $data['idDireccion']; 
      $Persona_idPersona = $data['Persona_idPersona']; 
      $callePrincipal = $data['callePrincipal'];
      $calleTransversal = $data['calleTransversal'];
      $nroCasa = $data['nroCasa'];
      $TipoDireccion_Telefono_idTipoDireccion_Telefono = $data['TipoDireccion_Telefono_idTipoDireccion_Telefono'];
      $Barrio_idBarrio = $data['Barrio_idBarrio'];
      $Ciudad_idCiudad = $data['Ciudad_idCiudad'];
      $inactivo = $data['inactivo'];
      $usuarioModificacion = $data['usuarioModificacion'];
      $fechaModificacion = $data['fechaModificacion'];
      $usuarioInsercion = $data['usuarioInsercion'];
      $fechaInsercion = $data['fechaInsercion'];
      $latitud = $data['latitud'];
      $longitud = $data['longitud'];

  try {
      // Inicia la transacción
      $this->db->beginTransaction();

      $sql="UPDATE direccion SET Persona_idPersona = :Persona_idPersona, callePrincipal = :callePrincipal,
      calleTransversal = :calleTransversal, nroCasa = :nroCasa, TipoDireccion_Telefono_idTipoDireccion_Telefono =:TipoDireccion_Telefono_idTipoDireccion_Telefono,
      Barrio_idBarrio = :Barrio_idBarrio, Ciudad_idCiudad = :Ciudad_idCiudad, inactivo = :inactivo, usuarioModificacion = :usuarioModificacion, fechaModificacion = :fechaModificacion, usuarioInsercion = :usuario, fechaInsercion = :fechaInsercion, latitud = :latitud, longitud = :longitud WHERE idTelefono = :idTelefono";

      $stmt = $this->db->prepare($sql);  
      // Vincula los parámetros
  $stmt->bindParam(':idDireccion', $idDireccion);
        $stmt->bindParam(':Persona_idPersona', $Persona_idPersona);
        $stmt->bindParam(':callePrincipal', $callePrincipal);
        $stmt->bindParam(':calleTransversal', $calleTransversal);
        $stmt->bindParam(':nroCasa', $nroCasa);
          $stmt->bindParam(':TipoDireccion_Telefono_idTipoDireccion_Telefono', $TipoDireccion_Telefono_idTipoDireccion_Telefono);
            $stmt->bindParam(':Barrio_idBarrio', $Barrio_idBarrio);
              $stmt->bindParam(':Ciudad_idCiudad', $Ciudad_idCiudad);
                $stmt->bindParam(':inactivo', $inactivo);
                  $stmt->bindParam(':usuarioModificacion', $usuarioModificacion);
                    $stmt->bindParam(':fechaModificacion', $fechaModificacion);
                      $stmt->bindParam(':usuarioInsercion', $usuarioInsercion);
                        $stmt->bindParam(':fechaInsercion', $fechaInsercion);
                          $stmt->bindParam(':latitud', $latitud);
                            $stmt->bindParam(':longitud', $latitud);
      // Ejecuta la sentencia
      $success = $stmt->execute();

      // Si la actualización fue exitosa, commitea la transacción
      if ($success) {
          $this->db->commit();
          return true; // Indica éxito
      } else {
          // Si la ejecución no fue exitosa, hace rollback
          $this->db->rollBack();
          return false; // Indica fallo
      }
  } catch (Exception $e) {
      // Si ocurre un error, hace rollback
      $this->db->rollBack();
      // Aquí podrías registrar el error según tu política de manejo de errores
      return false; // Indica fallo
  }

  restore_error_handler();
}


 function CrearTelefono($data){

      $token = Auth::getData( $data['token'] );
      $usuario = $token->usuario;
      $idTelefono = $data['idTelefono']; 
      $Persona_idPersona = $data['Persona_idPersona']; 
      $telefono = $data['telefono'];
      $TipoDireccion_Telefono_idTipoDireccion_Telefono = $data['TipoDireccion_Telefono_idTipoDireccion_Telefono'];
      $inactivo = $data['inactivo'];
      $usuarioModificacion = $data['usuarioModificacion'];
      $fechaModificacion = $data['fechaModificacion'];
      $usuarioInsercion = $data['usuarioInsercion'];
      $fechaInsercion = $data['fechaInsercion'];
      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });


      try {
        $sql="INSERT INTO `telefono`(`idTelefono`,`Persona_idPersona`,`telefono`,`TipoDireccion_Telefono_idTipoDireccion_Telefono`,
          `inactivo`,`usuarioModificacion`,`fechaModificacion`,`usuarioInsercion`,`fechaInsercion`)
              VALUES
              (
                :idTelefono,
                :Persona_idPersona,
                :telefono,
                :TipoDireccion_Telefono_idTipoDireccion_Telefono,
                :0,
                :usuarioModificacion,
                :fechaModificacion,
                :usuario,
                :fechaInsercion
              )"; 
        $stmt  = $this->db->prepare($sql);  
        
        // Bind parameters
        $stmt->bindParam(':idTelefono', $idTelefono);
        $stmt->bindParam(':Persona_idPersona', $Persona_idPersona);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':TipoDireccion_Telefono_idTipoDireccion_Telefono', $TipoDireccion_Telefono_idTipoDireccion_Telefono);
          $stmt->bindParam(':inactivo', $inactivo);
            $stmt->bindParam(':usuarioModificacion', $usuarioModificacion);
              $stmt->bindParam(':fechaModificacion', $fechaModificacion);
                $stmt->bindParam(':usuarioInsercion', $usuarioInsercion);
                  $stmt->bindParam(':fechaInsercion', $fechaInsercion);
        // Execute the statement
        $stmt->execute();

        $estado=$stmt->execute();

        return $estado;

    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }



function ActualizarTelefono($data){
  // PARTE 1 - TABLA USUARIO - PERSONA
  
      $token = Auth::getData( $data['token'] );
      $usuario = $token->usuario;
      $idTelefono = $data['idTelefono']; 
      $Persona_idPersona = $data['Persona_idPersona']; 
      $telefono = $data['telefono'];
      $TipoDireccion_Telefono_idTipoDireccion_Telefono = $data['TipoDireccion_Telefono_idTipoDireccion_Telefono'];
      $inactivo = $data['inactivo'];
      $usuarioModificacion = $data['usuarioModificacion'];
      $fechaModificacion = $data['fechaModificacion'];
      $usuarioInsercion = $data['usuarioInsercion'];
      $fechaInsercion = $data['fechaInsercion'];

  try {
      // Inicia la transacción
      $this->db->beginTransaction();

      $sql="UPDATE telefono SET Persona_idPersona = :Persona_idPersona, telefono = :telefono,
      TipoDireccion_Telefono_idTipoDireccion_Telefono = :TipoDireccion_Telefono_idTipoDireccion_Telefono, inactivo = :inactivo, usuarioModificacion =:usuarioModificacion,
      fechaModificacion = :fechaModificacion, usuarioInsercion = :usuario, fechaInsercion = :fechaInsercion WHERE idTelefono = :idTelefono";

      $stmt = $this->db->prepare($sql);  
      // Vincula los parámetros

      $stmt->bindParam(':idTelefono', $idTelefono);
        $stmt->bindParam(':Persona_idPersona', $Persona_idPersona);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':TipoDireccion_Telefono_idTipoDireccion_Telefono', $TipoDireccion_Telefono_idTipoDireccion_Telefono);
          $stmt->bindParam(':inactivo', $inactivo);
            $stmt->bindParam(':usuarioModificacion', $usuarioModificacion);
              $stmt->bindParam(':fechaModificacion', $fechaModificacion);
                $stmt->bindParam(':usuarioInsercion', $usuarioInsercion);
                  $stmt->bindParam(':fechaInsercion', $fechaInsercion);
      // Ejecuta la sentencia
      $success = $stmt->execute();

      // Si la actualización fue exitosa, commitea la transacción
      if ($success) {
          $this->db->commit();
          return true; // Indica éxito
      } else {
          // Si la ejecución no fue exitosa, hace rollback
          $this->db->rollBack();
          return false; // Indica fallo
      }
  } catch (Exception $e) {
      // Si ocurre un error, hace rollback
      $this->db->rollBack();
      // Aquí podrías registrar el error según tu política de manejo de errores
      return false; // Indica fallo
  }

  restore_error_handler();
}
*/
 function nuevoRuc($data){
      
      
      //PARTE 2 - TABLA VEHICULOS
      $telefono = $data['telefono']; // habilitacion frontal
      $direccion = $data['direccion']; // habilitacion reverso
      $ruc = $data['ruc']; // habilitacion reverso
      $nombre = $data['nombre'];
      
      $token = Auth::getData( $data['token'] );
      $email = $token->usuario;

      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });


      try {

            $sql = "CALL SP_NuevoRuc(:email, :nombre, :ruc, :direccion, :telefono)";
                
            $stmt  = $this->db->prepare($sql);  
          
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':ruc', $ruc);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $email);

            
    
            $stmt->execute();
            $estado = $stmt->fetch();
            return $estado;    


    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }






    function listarRuc($data){
      
      
      $token = Auth::getData( $data['token'] );
      $email = $token->usuario;

      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });


      try {

            $sql = "CALL SP_ListarRuc(:email)";
                
            $stmt  = $this->db->prepare($sql);  
          
            $stmt->bindParam(':email', $email);

            
    
            $stmt->execute();
            $estado= $stmt->fetchAll();
            return $estado;    


    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }





    function finalizarViaje($data){
      
      
      $token = Auth::getData( $data['token'] );
      $email = $token->usuario;


      $uuid = $data['uuid'];
      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });


      try {

             $sql = "CALL generarFactura(:uuid)";    
             $stmt  = $this->db->prepare($sql);  
             $stmt->bindParam(':uuid', $uuid);

             $stmt->execute();
             $estado= $stmt->fetch();

            $amount =  "1.00" ;//$estado->total;

            $url = 'https://vpos.infonet.com.py/vpos/api/0.3/single_buy';
            //$url = 'https://vpos.infonet.com.py/vpos/api/0.3/single_buy';

            $v_public_key = 'ozBiLvvbbStA5uNUfutZNeBuWQOTg5NA';
            $v_private_key = 'dBZzbbt4Nk1TyVZ9C2aJ4rd+Lg(le6Zyq)3WFQiv';


            $v_token = md5($v_private_key . $shop_process_id . $amount . "PYG");


            $request = array(
              "public_key" => $v_public_key,
              "operation" => array(
                "token" => $v_token,
                "shop_process_id" => $shop_process_id,
                "amount" => "$amount",
                "currency" => "PYG",
                "additional_data" => $additional_data,
                "descripcion" => "",
                "return_url" => "robsa.com.py",
                "cancel_url" => "robsa.com.py",
                "Zimple" => "S"
              )
            );
            


          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $request) );
          curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $result = curl_exec($ch);
          curl_close($ch);

          return  json_decode($result) ;

    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }











    function pagoZimple($data){
      
      
      $token = Auth::getData( $data['token'] );
      $email = $token->usuario;


      $additional_data = $data['nroZimple'];
      $shop_process_id = $data['idCarrito'];
      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });


      try {

             //$sql = "CALL SP_totalCarrito(:$shop_process_id)";    
             //$stmt  = $this->db->prepare($sql);  
             //$stmt->bindParam(':shop_process_id', $shop_process_id);

             //$stmt->execute();
             //$estado= $stmt->fetch();

            $amount =  "1.00" ;//$estado->total;

            $url = 'https://vpos.infonet.com.py/vpos/api/0.3/single_buy';
            //$url = 'https://vpos.infonet.com.py/vpos/api/0.3/single_buy';

            $v_public_key = 'ozBiLvvbbStA5uNUfutZNeBuWQOTg5NA';
            $v_private_key = 'dBZzbbt4Nk1TyVZ9C2aJ4rd+Lg(le6Zyq)3WFQiv';


            $v_token = md5($v_private_key . $shop_process_id . $amount . "PYG");


            $request = array(
              "public_key" => $v_public_key,
              "operation" => array(
                "token" => $v_token,
                "shop_process_id" => $shop_process_id,
                "amount" => "$amount",
                "currency" => "PYG",
                "additional_data" => $additional_data,
                "descripcion" => "",
                "return_url" => "robsa.com.py",
                "cancel_url" => "robsa.com.py",
                "Zimple" => "S"
              )
            );
            


          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $request) );
          curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $result = curl_exec($ch);
          curl_close($ch);

          return  json_decode($result) ;

    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }





    function nuevaTarjeta($data){
      
      
      $token = Auth::getData( $data['token'] );
      $email = $token->usuario;

      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });


      try {

            $sql = "CALL SP_NuevaTarjeta(:email)";
                
            $stmt  = $this->db->prepare($sql);  
          
            $stmt->bindParam(':email', $email);

            
    
            $stmt->execute();
            $estado= $stmt->fetch();

            $card_id = $estado->idPersonaTarjeta;
            $user_id = $estado->idPersona;
            $user_cell_phone = $estado->celular;
            $user_mail = $estado->email;

            $url = 'https://vpos.infonet.com.py/vpos/api/0.3/cards/new';
            //$url = 'https://vpos.infonet.com.py/vpos/api/0.3/cards/new';       

            $v_public_key = 'ozBiLvvbbStA5uNUfutZNeBuWQOTg5NA';
            $v_private_key = 'dBZzbbt4Nk1TyVZ9C2aJ4rd+Lg(le6Zyq)3WFQiv';

            $cadena = $v_private_key . $card_id . $user_id . "request_new_card";
            $v_token = md5(  $cadena );

            $v_token = md5($v_private_key . $card_id . $user_id . "request_new_card");


            $request = array(
              "public_key" => $v_public_key,
              "operation" => array(
                "token" => $v_token,
                "card_id" => $card_id,
                "user_id" => $user_id,
                "user_cell_phone" => $user_cell_phone,
                "user_mail" => $user_mail,
                "return_url" => "/home"
              )
            );
            


          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $request) );
          curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $result = curl_exec($ch);
          curl_close($ch);

          return  json_decode($result) ;

    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }




    function listarTarjeta($data){
      
      
      $token = Auth::getData( $data['token'] );
      $email = $token->usuario;

      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });


      try {

            $sql = " SELECT idUsuario, Persona_idPersona, imagen FROM usuario where email = :email ";
                
            $stmt  = $this->db->prepare($sql);  
          
            $stmt->bindParam(':email', $email);

            
    
            $stmt->execute();
            $estado= $stmt->fetch();

            $user_id = $estado->Persona_idPersona;

          $url = "https://vpos.infonet.com.py/vpos/api/0.3/users/$user_id/cards";
          //$url = "https://vpos.infonet.com.py/vpos/api/0.3/users/$user_id/cards";

            $v_public_key = 'ozBiLvvbbStA5uNUfutZNeBuWQOTg5NA';
            $v_private_key = 'dBZzbbt4Nk1TyVZ9C2aJ4rd+Lg(le6Zyq)3WFQiv';

            $v_token = md5($v_private_key . $user_id . "request_user_cards");


            $request = array(
              "public_key" => $v_public_key,
              "operation" => array(
                "token" => $v_token
              )
            );
            


          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $request) );
          curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $result = curl_exec($ch);
          curl_close($ch);

          return  json_decode( $result );

    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }







    function pagoTarjetaToken($data){
      
      
      $token = Auth::getData( $data['token'] );


      $email = $token->usuario;
      $shop_process_id = $data['idCarrito'];
      $alias_token = $data['alias_token'];
      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });


      try {

             $sql = "select total from viaje where idViaje = :shop_process_id;";    
             $stmt  = $this->db->prepare($sql);  
             $stmt->bindParam(':shop_process_id', $shop_process_id);

             $stmt->execute();
             $estado= $stmt->fetch();

            $amount = $estado->total;

            $url = 'https://vpos.infonet.com.py/vpos/api/0.3/charge';
            //$url = 'https://vpos.infonet.com.py/vpos/api/0.3/charge';
            $v_public_key = 'ozBiLvvbbStA5uNUfutZNeBuWQOTg5NA';
            $v_private_key = 'dBZzbbt4Nk1TyVZ9C2aJ4rd+Lg(le6Zyq)3WFQiv';

            $v_token = md5($v_private_key.$shop_process_id."charge".$amount."PYG".$alias_token);


            $request = array(
              "public_key" => $v_public_key,
              "operation" => array(
                    "token" => $v_token,
                    "shop_process_id" => $shop_process_id,
                    "amount" => $amount,
                    "number_of_payments" => 1,
                    "currency" => "PYG",
                    "additional_data" => "",
                    "description" => "TEST",
                    "alias_token" => $alias_token
              )
            );
           

          // {
//     "public_key": "6qDajfOGLqsAl0dCv8zq9cBP0n9BmWUd",
//     "operation": {
//         "token": "6151c1d43ff9a668bc06498756064076",
//         "shop_process_id": 353689,
//         "amount": "256086.00",
//         "number_of_payments": 1,
//         "currency": "PYG",
//         "additional_data": "",
//         "description": "に到着を待 1",
//         "alias_token": "aqui-debe-ingresar-un-alias-token-valido"
//     },
//     "test_client": true
// } 



          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $request) );
          curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $result = curl_exec($ch);
          curl_close($ch);

          return  json_decode($result) ;

    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }



   function consultarCompra($data){
      
      
      
      $token = Auth::getData( $data['token'] );


      $email = $token->usuario;
      $shop_process_id = $data['idCarrito'];

      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });


      try {

          $url = 'https://vpos.infonet.com.py/vpos/api/0.3/single_buy/confirmations';
          //$url = 'https://vpos.infonet.com.py/vpos/api/0.3/single_buy/confirmations';

            $v_public_key = 'ozBiLvvbbStA5uNUfutZNeBuWQOTg5NA';
            $v_private_key = 'dBZzbbt4Nk1TyVZ9C2aJ4rd+Lg(le6Zyq)3WFQiv';

            $v_token = md5($v_private_key.$shop_process_id."get_confirmation");


            $request = array(
              "public_key" => $v_public_key,
              "operation" => array(
                    "token" => $v_token,
                    "shop_process_id" => $shop_process_id
              )
            );
           

          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $request) );
          curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $result = curl_exec($ch);
          curl_close($ch);

          return  json_decode($result) ;

    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }





    function reversoPago($data){
      
      
      $token = Auth::getData( $data['token'] );


      $email = $token->usuario;
      $shop_process_id = $data['idCarrito'];

      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });


      try {

            $url = 'https://vpos.infonet.com.py/vpos/api/0.3/single_buy/rollback';
            //$url = 'https://vpos.infonet.com.py/vpos/api/0.3/single_buy/rollback';

            $v_public_key = 'ozBiLvvbbStA5uNUfutZNeBuWQOTg5NA';
            $v_private_key = 'dBZzbbt4Nk1TyVZ9C2aJ4rd+Lg(le6Zyq)3WFQiv';

            $v_token = md5($v_private_key.$shop_process_id."rollback"."0.00");


            $request = array(
              "public_key" => $v_public_key,
              "operation" => array(
                    "token" => $v_token,
                    "shop_process_id" => $shop_process_id
              )
            );
           

          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $request) );
          curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $result = curl_exec($ch);
          curl_close($ch);

          return  json_decode($result) ;

    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }







    function eliminarTarjeta($data){
      
      
      $token = Auth::getData( $data['token'] );
      $email = $token->usuario;

      $alias_token = $data['alias_token'];


      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });


      try {

            $sql = " SELECT idUsuario, Persona_idPersona, imagen FROM usuario where email = :email ";
                
            $stmt  = $this->db->prepare($sql);  
          
            $stmt->bindParam(':email', $email);

            
    
            $stmt->execute();
            $estado= $stmt->fetch();

            $user_id = $estado->Persona_idPersona;

          $url = "https://vpos.infonet.com.py/vpos/api/0.3/users/$user_id/cards";
            //$url = "https://vpos.infonet.com.py/vpos/api/0.3/users/$user_id/cards";

            $v_public_key = 'ozBiLvvbbStA5uNUfutZNeBuWQOTg5NA';
            $v_private_key = 'dBZzbbt4Nk1TyVZ9C2aJ4rd+Lg(le6Zyq)3WFQiv';

            $v_token = md5($v_private_key."delete_card".$user_id.$alias_token);



            $request = array(
              "public_key" => $v_public_key,
              "operation" => array(
                "token" => "$v_token",
                "alias_token" => "$alias_token"
              )
            );
            


          $ch = curl_init($url);
          //curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $request) );
          curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $result = curl_exec($ch);
          curl_close($ch);

          return  json_decode( $result );

    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
  }







    function updateTokenPush($data){  //para pedidos de viajes o delivery, ventana que abre la app
      
      $token = Auth::getData( $data['token'] );
      $email = $token->usuario;
      
      $tokenPush = $data['tokenPush'];
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

      try {
            $sql = "CALL SP_TokenPush( :email, :tokenPush)";
                
            $stmt  = $this->db->prepare($sql);  
            
            $stmt->bindParam(':tokenPush', $tokenPush);
            $stmt->bindParam(':email', $email);


            
            $estado=$stmt->execute();

            return $estado;    


    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
}




    function updateTokenPushOneSignal($data){
      
      $token = Auth::getData( $data['token'] );
      $email = $token->usuario;
      
      $tokenPush = $data['tokenPush'];
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

      try {
            $sql = "CALL SP_TokenPushOneSignal( :email, :tokenPush)";
                
            $stmt  = $this->db->prepare($sql);  
            
            $stmt->bindParam(':tokenPush', $tokenPush);
            $stmt->bindParam(':email', $email);


            
            $estado=$stmt->execute();

            return $estado;    


    } catch (Exception $e) {
        return $e;
    }

      //Restablecemos el tratamiento de errores
      restore_error_handler();
            
}

















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

            $sql = "select * from persona where mail = :id limit 1;";
                
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
      $id = $data['telefonoMovil']; //perfil
      
      //Activamos todas las notificaciones de error posibles
      error_reporting (E_ALL);
     
      //Definimos el tratamiento de errores no controlados
      set_error_handler(function () 
      {
        throw new Exception("Error");
      });

      try {   

            $sql = "SELECT * from persona where telefono = :id limit 1;";
                
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

  // function actualizar($data){

  //     $idUsuario = $data['idUsurio'];

  // }



    public function crearUsuario($data){

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

