<?php
namespace App\Model;
error_reporting(1);
use App\Lib\Response;

class FastmerModel
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


          $sql = "SELECT * FROM categoria WHERE inactivo = 0 /*AND tipo = 1*/";   

          $stmt = $this->db->prepare($sql);
          $stmt->execute();

          return $stmt->fetchAll();  
	
    }


    public function getRubro()
    {


          $sql = "SELECT idCategoria FROM categoria WHERE inactivo = 0 /*AND tipo = 1*/";   

          $stmt = $this->db->prepare($sql);
          $stmt->execute();

          return $stmt->fetchAll();  
  
    }


    public function getCategoriaID( $id )
    {

          $sql = "SELECT * FROM categoria WHERE inactivo = 0 /*AND tipo = 1 */ and idCategoria = :id ;";   
       
          $stmt = $this->db->prepare($sql);
             $stmt->bindParam(':id', $id );
          $stmt->execute();
          return $stmt->fetchAll();  
  
    }

    public function getCategoriaPorRubro( $id )
    {

          $sql = "SELECT Categoria_idCategoriaRubro, c2.nombre as nombreRubro, c.idCategoria, c.nombre as nombreCategoria
        FROM articulo a JOIN categoria c ON a.Categoria_idCategoria = c.idCategoria
        JOIN categoria c2 ON a.Categoria_idCategoriaRubro = c2.idCategoria
        WHERE a.inactivo = 0 AND c.tipo = 1 
        AND c2.idCategoria = :rubro
        GROUP BY c2.idCategoria";   
       
          $stmt = $this->db->prepare($sql);
             $stmt->bindParam(':rubro', $id );
          $stmt->execute();
          return $stmt->fetchAll();  
  
    }


    public function getProductosPorComercio( $id )
    {

          $sql = "SELECT * FROM articulo WHERE Persona_idPersona = :idcomercio";   
       
          $stmt = $this->db->prepare($sql);
             $stmt->bindParam(':idcomercio', $id );
          $stmt->execute();
          return $stmt->fetchAll();  
  
    }


    public function getProductosPorCategoria( $id )
    {

          $sql = "SELECT * FROM articulo WHERE Categoria_idCategoria = :idcategoria";   
       
          $stmt = $this->db->prepare($sql);
             $stmt->bindParam(':idcategoria', $id );
          $stmt->execute();
          return $stmt->fetchAll();  
  
    }


      public function getProductosPorCategoriaComercio( $id , $categoria  )
    {

          $sql = "SELECT * FROM articulo a
          JOIN persona p ON a.Persona_idPersona = p.idPersona
          JOIN categoria c ON a.Categoria_idCategoria = c.idCategoria AND c.tipo = 1
          WHERE Categoria_idCategoria = :idcategoria
          AND a.Persona_idPersona = :idComercio";   
       
          $stmt = $this->db->prepare($sql);
             $stmt->bindParam(':idComercio', $id );
             $stmt->bindParam(':idcategoria', $categoria );
          $stmt->execute();
          return $stmt->fetchAll();  
  
    }


    public function usuarioPrueba(){
       $email = getenv('TEST_USER_EMAIL') ?: '';
       $hash  = getenv('TEST_USER_PASSWORD_HASH') ?: '';
       if ($email === '' || $hash === '') { exit('Configure TEST_USER_EMAIL y TEST_USER_PASSWORD_HASH en .env'); }
       $sql = "INSERT INTO USUARIO (email , clave) VALUES ( :email , :clave )"; 


      try {
           $stmt = $this->db->prepare($sql);
           $stmt->bindParam(':email', $email);
           $stmt->bindParam(':clave', $hash);
           $stmt->execute();

           exit("USUARIO CREADO"); 
        
      } catch (Exception $e) {
          
          exit($e); 
      }


    }


  






}

