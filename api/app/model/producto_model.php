<?php
namespace App\Model;
error_reporting(1);
use App\Lib\Response;

class ProductoModel
{

    private $db;
    private $response;

    public function __CONSTRUCT($db)
    {
        $this->db = $db;
        $this->response = new Response();
    }


    public function getCategoriaProducto($categoria)
    {


          $sql = "SELECT articulo.*, idArticulo as id, articulo.nombre as name,30000 as newPrice, 25000 as oldPrice /*precioVenta as newPrice, precioOferta as oldPrice*/, null as discount, valoracion as ratingsCount, valoracion as ratingsValue, descripcion as description, 10 as availibilityCount, 0 as cartCount, null as color, null as size, pesoBruto as weight, idCategoria as categoryId from articulo, categoria where articulo.Categoria_idCategoria = categoria.idCategoria  and articulo.inactivo = 0 and categoria.idCategoria = :categoria limit 30";   
          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':categoria', $categoria);
          $stmt->execute();
          $producto = $stmt->fetchAll();  

          $productos = [];
          $i = 0;

           foreach ($producto as $e) {
            
              $sql = "SELECT idArticuloImagen as id, imagen, Articulo_idArticulo from articuloimagenes where Articulo_idArticulo = :id";
             $stmt2 = $this->db->prepare($sql);
               $stmt2->bindParam(':id', $e->id);
             $stmt2->execute();
             $imagenes = $stmt2->fetchAll();


             $detalles = [];
             $k = 0;


             foreach ($imagenes as $det ) {
              if ($det->Articulo_idArticulo ==  $e->id) {
                
                $detalles[$k++] = $det;

              }
             }

             $e->imagenes = $detalles;
             $productos[$i++] = $e;
           }


          return $productos;










  }


   

    public function getProductosMarca($marca)
    {
          $sql = "SELECT articulo.*, idArticulo as id, articulo.nombre as name, precioVenta as newPrice, precioOferta as oldPrice, null as discount, valoracion as ratingsCount, valoracion as ratingsValue, descripcion as description, 10 as availibilityCount, 0 as cartCount, null as color, null as size, pesoBruto as weight, idCategoria as categoryId from articulo, categoria where articulo.Categoria_idCategoria = categoria.idCategoria  and articulo.inactivo = 0 and Marca_idMarca = :marca limit 30";   

          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':marca', $marca);
          $stmt->execute();
          return $stmt->fetchAll();  
  }


    public function getProductosComercio($comercio)
    {
          $sql = "SELECT articulo.*, idArticulo as id, articulo.nombre as name, precioVenta as newPrice, precioOferta as oldPrice, null as discount, valoracion as ratingsCount, valoracion as ratingsValue, descripcion as description, 10 as availibilityCount, 0 as cartCount, null as color, null as size, pesoBruto as weight, idCategoria as categoryId from articulo, categoria where articulo.Categoria_idCategoria = categoria.idCategoria  and articulo.inactivo = 0 and articulo.Persona_idPersona = :comercio limit 30";   

          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':comercio', $comercio);
          $stmt->execute();
          return $stmt->fetchAll();  
  }


    public function getProductosComercioOferta($comercio)
    {

          $sql = "SELECT articulo.*, idArticulo as id, articulo.nombre as name, precioVenta as newPrice, precioOferta as oldPrice, null as discount, valoracion as ratingsCount, valoracion as ratingsValue, descripcion as description, 10 as availibilityCount, 0 as cartCount, null as color, null as size, pesoBruto as weight, idCategoria as categoryId from articulo, categoria where articulo.Categoria_idCategoria = categoria.idCategoria  and articulo.inactivo = 0 and articulo.Persona_idPersona = :comercio and articulo.ofertaSN = 1 limit 30";   

          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':comercio', $comercio);
          $stmt->execute();
          $producto = $stmt->fetchAll();

          $productos = [];
          $i = 0;

           foreach ($producto as $e) {
          	
           		$sql = "SELECT idArticuloImagen as id, imagen, Articulo_idArticulo from articuloimagenes where Articulo_idArticulo = :id";
		         $stmt2 = $this->db->prepare($sql);
          		 $stmt2->bindParam(':id', $e->id);
		         $stmt2->execute();
		         $imagenes = $stmt2->fetchAll();


		         $detalles = [];
		         $k = 0;


		         foreach ($imagenes as $det ) {
		         	if ($det->Articulo_idArticulo ==  $e->id) {
		        		
		        		$detalles[$k++] = $det;

		         	}
		         }

		         $e->imagenes = $detalles;
		         $productos[$i++] = $e;
           }


          return $productos;


  }


    public function getComercioRubroProducto($comercio, $rubro)
    {
          $sql = "SELECT * from articulo, categoria where articulo.Categoria_idCategoria = categoria.idCategoria and categoria.Rubro_idRubro = :rubro and articulo.Persona_idPersona = :comercio and articulo.inactivo = 0 limit 30";   

          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':comercio', $comercio );
          $stmt->bindParam(':rubro', $rubro );
          $stmt->execute();

          return $stmt->fetchAll();  
	}


    public function getCategoriaRubroProducto($categoria, $rubro)
    {
          $sql = "SELECT * from articulo, categoria where articulo.Categoria_idCategoria = categoria.idCategoria and categoria.Rubro_idRubro = :rubro and articulo.Categoria_idCategoria = :categoria and articulo.inactivo = 0 limit 30;";   

          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':categoria', $categoria );
          $stmt->bindParam(':rubro', $rubro );
          $stmt->execute();

          return $stmt->fetchAll();  
  }

    

    public function getProducto($id)
    {


          $sql = "SELECT  articulo.*, idArticulo as id, articulo.nombre as name,30000 as newPrice, 25000 as oldPrice,  null as discount, valoracion as ratingsCount, valoracion as ratingsValue, descripcion as description, 10 as availibilityCount, 0 as cartCount, null as color, null as size, pesoBruto as weight, Categoria_idCategoria as categoryId FROM articulo WHERE idArticulo = :id limit 1;";   

          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':id', $id);
          $stmt->execute();
          $producto = $stmt->fetchAll();

          $productos = [];
          $i = 0;

          // //Agregar detalle al producto.
           foreach ($producto as $e) {
          	
           		$sql = "SELECT idArticulo as id, descripcion, precioVenta, Articulo_idArticulo 
    					from articulo_agregado, articulo 
    					where idArticulo = articulo_agregado.Agregado_idAgregado 
    					and articulo_agregado.Articulo_idArticulo = 1";
		         $stmt2 = $this->db->prepare($sql);
          		 $stmt2->bindParam(':id', $id);
		         $stmt2->execute();

		         $agregados = $stmt2->fetchAll();


		         $detalles = [];
		         $k = 0;


		         foreach ($agregados as $det ) {
		         	if ($det->Articulo_idArticulo ==  $e->id) {
		        		
		        		$detalles[$k++] = $det;

		         	}
		         }

		         $e->agregados = $detalles;
		         $productos[$i++] = $e;
           }


          // //Agregar detalle al producto.


           foreach ($producto as $e) {
          	
           		$sql = "SELECT idArticulo as id, descripcion, precioVenta ,Articulo_idArticulo  from articulo_sabor, articulo where articulo.idArticulo = articulo_sabor.Sabor_idSabor and articulo_sabor.Articulo_idArticulo = 1";
		         $stmt2 = $this->db->prepare($sql);
          		 $stmt2->bindParam(':id', $id);
		         $stmt2->execute();
		         $sabores = $stmt2->fetchAll();


		         $detalles = [];
		         $k = 0;


		         foreach ($sabores as $det ) {
		         	if ($det->Articulo_idArticulo ==  $e->id) {
		        		
		        		$detalles[$k++] = $det;

		         	}
		         }

		         $e->sabores = $detalles;
		         $productos[$i++] = $e;
           }




           foreach ($producto as $e) {
          	
           		$sql = "SELECT idArticuloImagen as id, imagen, Articulo_idArticulo from articuloimagenes where Articulo_idArticulo = :id";
		         $stmt2 = $this->db->prepare($sql);
          		 $stmt2->bindParam(':id', $id);
		         $stmt2->execute();
		         $imagenes = $stmt2->fetchAll();


		         $detalles = [];
		         $k = 0;


		         foreach ($imagenes as $det ) {
		         	if ($det->Articulo_idArticulo ==  $e->id) {
		        		
		        		$detalles[$k++] = $det;

		         	}
		         }

		         $e->imagenes = $detalles;
		         $productos[$i++] = $e;
           }




          return $productos[1];







  
    }


    public function getProductoToppings($id)
    {

          //recibe el idArticulo y nos trae sus agregados
          $sql = "SELECT * FROM articulo_agregado, articulo WHERE Articulo_idArticulo = :id and articulo.tipoArticulo = 'AGREGADO' and articulo.inactivo = 0 and Agregado_idAgregado = idArticulo limit 30;";   

          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':id', $id );
          $stmt->execute();

          return $stmt->fetchAll();  
  
    }



    public function getProductoSabores($id)
    {


          $sql = "SELECT * FROM articulo_sabor, articulo WHERE Articulo_idArticulo = :id and articulo.tipoArticulo = 'SABOR' and articulo.inactivo = 0 and Sabor_idSabor = idArticulo limit 30;";   

          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(':id', $id );
          $stmt->execute();

          return $stmt->fetchAll();  
  
    }


    public function getProductoDestacado()
    {


          $sql = "SELECT * from articulo where inactivo = 0 order by valoracion, nombre desc limit 30;";   

          $stmt = $this->db->prepare($sql);
          $stmt->execute();

          return $stmt->fetchAll();  
  
    }



    public function getProductoMasVendido()
    {


          $sql = "SELECT articulo.*, detalleventa.descripcion, sum(cantidad) as tv from articulo, detalleventa where articulo.idArticulo = detalleventa.Articulo_idArticulo and  articulo.inactivo = 0 and detalleventa.inactivo = 0 group by idArticulo order by tv desc limit 10";   

          $stmt = $this->db->prepare($sql);
          $stmt->execute();

          return $stmt->fetchAll();  
  
    }



    public function getProductoMasValorados()
    {


          $sql = "SELECT * from articulo where inactivo = 0 order by valoracion desc limit 10";   

          $stmt = $this->db->prepare($sql);
          $stmt->execute();

          return $stmt->fetchAll();  
  
    }




    public function getProductoMasNuevos()
    {


          $sql = "SELECT * from articulo where inactivo = 0 order by idArticulo desc limit 10";   

          $stmt = $this->db->prepare($sql);
          $stmt->execute();

          return $stmt->fetchAll();  
  
    }



    public function getMarcas()
    {


          $sql = "SELECT * from marca where inactivo = 0 limit 20";   

          $stmt = $this->db->prepare($sql);
          $stmt->execute();

          return $stmt->fetchAll();  
  
    }



    public function getComercios()
    {


          $sql = "SELECT * from persona, persona_tipopersona where persona.idPersona = Persona_idPersona and TipoPersona_idTipoPersona = 2 limit 20";   

          $stmt = $this->db->prepare($sql);
          $stmt->execute();

          return $stmt->fetchAll();  
  
    }






}

