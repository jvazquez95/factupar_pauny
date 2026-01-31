<?php
namespace App\Model;
error_reporting(1);
use App\Lib\Response;

class AddressModel
{

    private $db;
    private $response;

    public function __CONSTRUCT($db)
    {
        $this->db = $db;
        $this->response = new Response();
    }
    
    public function getAddress()
    {


          $sql = "SELECT * FROM barrio as b join Ciudad as c ON b.Ciudad_idCiudad = b.idCiudad ";   

          $stmt = $this->db->prepare($sql);
          $stmt->execute();

          return $stmt->fetchAll();  
	
    }


    public function getAddressID( $id )
    {

          $sql = "SELECT * FROM barrio as b join Ciudad as c ON b.Ciudad_idCiudad = c.idCiudad WHERE  c.idCiudad = :id ;";   
       
          $stmt = $this->db->prepare($sql);
             $stmt->bindParam(':id', $id );
          $stmt->execute();
          return $stmt->fetchAll();  
  
    }


  
}

