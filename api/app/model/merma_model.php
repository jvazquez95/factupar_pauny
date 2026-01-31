<?php
namespace App\Model;
error_reporting(0);
use App\Lib\Response;

class MermasModel
{

    private $db;
    private $table = 'creditos';
    private $table_id = 'credito';
    private $response;
    PRIVATE $nvo_nombre;
    PRIVATE $cadena;
    public function __CONSTRUCT($db)
    {
        $this->db = $db;
        $this->response = new Response();
    }
    
    public function consulta()
    {


          $sql2 = "SELECT idUnidad as id, descripcion as nombre FROM unidad where inactivo = 0";   

          $stmt = $this->db->prepare($sql2);
          $stmt->bindParam(':codigo', $id);
          $stmt->execute();
          $unidadesDeMedida = $stmt->fetchAll();  
			
          $sql2 = "SELECT idMotivo as id, descripcion as nombre FROM motivo where inactivo = 0";   

          $stmt = $this->db->prepare($sql2);
          $stmt->bindParam(':codigo', $id);
          $stmt->execute();
          $motivos = $stmt->fetchAll();  

       /*   $sql2 = "SELECT idSabor as id, descripcion as nombre FROM sabor where inactivo = 0";   

          $stmt = $this->db->prepare($sql2);
          $stmt->bindParam(':codigo', $id);
          $stmt->execute();
          $sabores = $stmt->fetchAll();  
*/
          $sql2 = "SELECT idSector as id, descripcion as nombre FROM sector where inactivo = 0";   

          $stmt = $this->db->prepare($sql2);
          $stmt->bindParam(':codigo', $id);
          $stmt->execute();
          $sectores = $stmt->fetchAll();  

  /*        $sql2 = "SELECT idTamano as id, descripcion as nombre FROM tamano where inactivo = 0";   

          $stmt = $this->db->prepare($sql2);
          $stmt->bindParam(':codigo', $id);
          $stmt->execute();
          $tamanos = $stmt->fetchAll();  
*/
          $sql2 = "SELECT idUsuario as id, login as username, clave as password FROM usuario";   

          $stmt = $this->db->prepare($sql2);
          $stmt->bindParam(':codigo', $id);
          $stmt->execute();
          $usuarios = $stmt->fetchAll();  

          $sql2 = "SELECT idProducto as id, descripcion as nombre,codContenido as codigoContenido, codVacio as codigoVacio FROM producto where inactivo = 0";   

          $stmt = $this->db->prepare($sql2);
          $stmt->bindParam(':codigo', $id);
          $stmt->execute();
          $productos = $stmt->fetchAll();  

          $turnos =  array(
            [id  => 1,  nombre => 'MAÑANA'],
            [id  => 2,  nombre => 'TARDE'],
            [id  => 3,  nombre => 'NOCHE']
          );

          $tipos =  array(
            [id  => 1,  nombre => 'Contenido'],
            [id  => 2,  nombre => 'Vacio']
          );


          $json = array('turnos' =>  $turnos,'tipos' =>  $tipos,'motivos' =>  $motivos,'sectores' =>  $sectores, 'unidadesDeMedida' =>  $unidadesDeMedida, 'usuarios' =>  $usuarios,'productos' =>  $productos);


        
          return $json;

    }


    public function mermas()
    {


		$sql2 = "SELECT localId as id, usuarioIns as usuarioId, idProducto as productoId, idSector as sectorId, idUnidad as unidadDeMedidaId, turno as turnoId, contenidoVacio as tipoId, idMotivo as motivoId, fecha,codContenido as codigoContenido, codVacio as codigoVacio, observaciones, cantidad, inactivo, horaMod as fechaInactivo, imagen, idMerma as remoteId FROM mermas where inactivo = 0 and usuarioIns = :usuarioId and fecha > :desde";   

          $stmt = $this->db->prepare($sql2);
          $stmt->bindParam(':usuarioId', $usuarioId);
          $stmt->bindParam(':desde', $desde);
		  $usuarioId =$_GET['usuarioId'];
		  $desde =date('Y-m-d', strtotime('-1 month'));


          $stmt->execute();
          $mermas = $stmt->fetchAll();  

          $json = array('mermas' =>  $mermas);
          return $json;
    }




    public function sincronizacion($data)
    {

    	$lista = $data['mermas'];
    	$usuarioId = '';


		try {


    		$num_elementos = 0;
    		while ($num_elementos < count($lista)) {
				$sql="INSERT INTO mermas (idProducto,fecha, turno, contenidoVacio, codContenido, codVacio, idSector, idMotivo, observaciones, cantidad, imagen, usuarioIns, idUnidad, localId, inactivo, horaMod)
				VALUES 
					(:productoId,:fecha,:turnoId,:tipoId,:codigoContenido,:codigoVacio,:sectorId,:motivoId,:observaciones,:cantidad,:imagen,:usuarioId,:unidadDeMedidaId, :id, :inactivo, :fechaInactivo)";
							
								$stmt = $this->db->prepare($sql);
					            $stmt->bindParam(':id', $id);
					            $stmt->bindParam(':usuarioId', $usuarioId);
					            $stmt->bindParam(':productoId', $productoId);
					            $stmt->bindParam(':sectorId', $sectorId);
					            $stmt->bindParam(':unidadDeMedidaId', $unidadDeMedidaId);
					            $stmt->bindParam(':turnoId', $turnoId);
					            $stmt->bindParam(':tipoId', $tipoId);
					            $stmt->bindParam(':motivoId', $motivoId);
					            $stmt->bindParam(':fecha', $fecha);
					            $stmt->bindParam(':codigoContenido', $codigoContenido);
					            $stmt->bindParam(':codigoVacio', $codigoVacio);
					            $stmt->bindParam(':observaciones', $observaciones);
					            $stmt->bindParam(':cantidad', $cantidad);
					            $stmt->bindParam(':inactivo', $inactivo);
					            $stmt->bindParam(':fechaInactivo', $fechaInactivo);
					            $stmt->bindParam(':imagen', $imagen);
			            		
			            		$id =$lista[$num_elementos]['id'];
			            		$usuarioId =$lista[$num_elementos]['usuarioId'];
			            		$productoId =$lista[$num_elementos]['productoId'];
			            		$sectorId =$lista[$num_elementos]['sectorId'];
			            		$unidadDeMedidaId =$lista[$num_elementos]['unidadDeMedidaId'];
			            		$turnoId =$lista[$num_elementos]['turnoId'];
			            		$tipoId =$lista[$num_elementos]['tipoId'];
			            		$motivoId =$lista[$num_elementos]['motivoId'];
			            		$fecha =$lista[$num_elementos]['fecha'];
			            		$codigoContenido =$lista[$num_elementos]['codigoContenido'];
			            		$codigoVacio =$lista[$num_elementos]['codigoVacio'];
			            		$observaciones =$lista[$num_elementos]['observaciones'];
			            		$cantidad =$lista[$num_elementos]['cantidad'];
			            		$inactivo =$lista[$num_elementos]['inactivo'];
			            		$fechaInactivo =$lista[$num_elementos]['fechaInactivo'];
			            		$imagen =$lista[$num_elementos]['imagen'];

					          	$stmt->execute(); 

							$num_elementos++;   		
    					}


		} catch (Exception $e) {
          $json = array('error' =>  false);

		}

		$sql2 = "SELECT localId as id, usuarioIns as usuarioId, idProducto as productoId, idSector as sectorId, idUnidad as unidadDeMedidaId, turno as turnoId, contenidoVacio as tipoId, idMotivo as motivoId, fecha,codContenido as codigoContenido, codVacio as codigoVacio, observaciones, cantidad, inactivo, horaMod as fechaInactivo, imagen, idMerma as remoteId FROM mermas where inactivo = 0 and usuarioIns = :usuarioId";   

          $stmt = $this->db->prepare($sql2);
          $stmt->bindParam(':usuarioId', $usuarioId);
		  $usuarioId =$usuarioId;


          $stmt->execute();
          $mermas = $stmt->fetchAll();  

          $json = array('mermas' =>  $mermas);




        
          return $json;

    }



}
  
