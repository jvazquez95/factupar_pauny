<?php
namespace App\Model;
error_reporting(1);
use App\Lib\Response;

class CategoriaModel
{

    private $db;
    private $response;

    public function __CONSTRUCT($db)
    {
        $this->db = $db;
        $this->response = new Response();
    }
    
    public function getCategoria()
    {


          $sql = "SELECT * , idCategoria as id , nombre as name , nombre as description,  true as hasSubCategory, 0 as parentId FROM categoria WHERE inactivo = 0";   

          $stmt = $this->db->prepare($sql);
          $stmt->execute();

          return $stmt->fetchAll();  
	
    }


    public function getRubro()
    {


          $sql = "SELECT * , idRubro as  idCategoria, idRubro as id , descripcion as name ,  true as hasSubCategory, 0 as parentId FROM rubro WHERE inactivo = 0";   

          $stmt = $this->db->prepare($sql);
          $stmt->execute();

          return $stmt->fetchAll();  
  
    }


    public function getCategoriaID( $id )
    {

          $sql = "SELECT  idCategoria as id , nombre as name , nombre as description,
          '' as image , imagen FROM categoria WHERE inactivo = 0 AND tipo = 1  and idCategoria = :id ;";   
       
          $stmt = $this->db->prepare($sql);
             $stmt->bindParam(':id', $id );
          $stmt->execute();

          // JUNIOR NO LO TOQUES, ES PARA LA APP 
          $data = array();

          $data[0] = $stmt->fetchAll();
          return $data;  
  
    }


    public function getCategoriaRubro( $id )
    {

          $sql = "SELECT  idCategoria as id , nombre as name , nombre as description,
          '' as image , imagen FROM categoria WHERE inactivo = 0 AND Rubro_idRubro = :id ;";   
       
          $stmt = $this->db->prepare($sql);
             $stmt->bindParam(':id', $id );
          $stmt->execute();

          // JUNIOR NO LO TOQUES, ES PARA LA APP 
          $data = array();

          $data[0] = $stmt->fetchAll();
          return $data;  
  
    }


    public function getComercioRubro( $id )
    {

          $sql = "SELECT 
                    p.* 
                  from 
                    persona p join articulo a ON p.idPersona = a.Persona_idPersona, persona_tipopersona, categoria 
                  where 
                    categoria.idCategoria = a.Categoria_idCategoria and
                    persona_tipopersona.Persona_idPersona = p.idPersona and 
                    persona_tipopersona.TipoPersona_idTipoPersona = 2 and categoria.Rubro_idRubro = :id GROUP BY idPersona";   
                         
          $stmt = $this->db->prepare($sql);
             $stmt->bindParam(':id', $id );
          $stmt->execute();

          // JUNIOR NO LO TOQUES, ES PARA LA APP 
          $data = array();

          $data[0] = $stmt->fetchAll();
          return $data;  
  
    }




    public function getProductoRubro( $id )
    {

          $sql = "SELECT articulo.* from articulo, categoria 
                  where articulo.Categoria_idCategoria = categoria.idCategoria and categoria.Rubro_idRubro = :id limit 100 ";   
                         
          $stmt = $this->db->prepare($sql);
             $stmt->bindParam(':id', $id );
          $stmt->execute();

          // JUNIOR NO LO TOQUES, ES PARA LA APP 
          $data = array();

          $data[0] = $stmt->fetchAll();
          return $data;  
  
    }



}

