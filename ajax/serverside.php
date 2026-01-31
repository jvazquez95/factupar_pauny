<?php
//include 'serversideConexion.php';
class TableData { 
 	private $_db;
	public function __construct() {
		try {			
			$host		= 'localhost';
			$database	= 'fullOffice3';
			$user		= 'root';
			$passwd		= 's3guridad2015!A';
			
		    $this->_db = new PDO('mysql:host='.$host.';dbname='.$database, $user, $passwd, array(
				PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		} catch (PDOException $e) {
		    error_log("Failed to connect to database: ".$e->getMessage());
		}				
	}	
	public function get($table, $index_column, $columns) {
		// Paging
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) {
			$sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".intval( $_GET['iDisplayLength'] );
		}
		
		// Ordering
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) ) {
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
					$sortDir = (strcasecmp($_GET['sSortDir_'.$i], 'ASC') == 0) ? 'ASC' : 'DESC';
					$sOrder .= "`".$columns[ intval( $_GET['iSortCol_'.$i] ) ]."` ". $sortDir .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" ) {
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables, and MySQL's regex functionality is very limited
		 */
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($columns) ; $i++ ) {
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" ) {
					$sWhere .= "`".$columns[$i]."` LIKE :search OR ";
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		// Individual column filtering
		for ( $i=0 ; $i<count($columns) ; $i++ ) {
			if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ) {
				if ( $sWhere == "" ) {
					$sWhere = "WHERE ";
				}
				else {
					$sWhere .= " AND ";
				}
				$sWhere .= "`".$columns[$i]."` LIKE :search".$i." ";
			}
		}
		
		// SQL queries get data to display
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $columns))."` FROM `".$table."` ".$sWhere." ".$sOrder." ".$sLimit;
		$statement = $this->_db->prepare($sQuery);
		
		// Bind parameters
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$statement->bindValue(':search', '%'.$_GET['sSearch'].'%', PDO::PARAM_STR);
		}
		for ( $i=0 ; $i<count($columns) ; $i++ ) {
			if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ) {
				$statement->bindValue(':search'.$i, '%'.$_GET['sSearch_'.$i].'%', PDO::PARAM_STR);
			}
		}

		$statement->execute();
		$rResult = $statement->fetchAll();
		
		$iFilteredTotal = current($this->_db->query('SELECT FOUND_ROWS()')->fetch());
		
		// Get total number of rows in table
		$sQuery = "SELECT COUNT(`".$index_column."`) FROM `".$table."`";
		$iTotal = current($this->_db->query($sQuery)->fetch());
		

		// Return array of values
		foreach($rResult as $reg) {
			//$row = array();			
 			$data[]=array(
 				"0"=>(!$reg['ea'])?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg['idArticulo'].')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg['idArticulo'].')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg['idArticulo'].')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg['idArticulo'].')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg['idArticulo'],
 				"2"=>utf8_encode($reg['na']),
 				"3"=>utf8_encode($reg['da']),
 				"4"=>utf8_encode($reg['nprov']),
 				"5"=>$reg['md'],
 				"6"=>$reg['nga'],
 				"7"=>$reg['codigoBarra'],
 				"8"=>$reg['codigo'],
 				"9"=>$reg['codigoAlternativo'],
 				"10"=>$reg['tipoArticulo'],
 				"11"=>$reg['NUC'],
 				"12"=>$reg['NUV'],
 				"13"=>number_format($reg['comision'],0,',','.'),
 				"14"=>$reg['comisionp'],
 				"15"=>$reg['TipoImpuesto_idTipoImpuesto'],
 				"16"=>number_format($reg['precioVenta'],0,',','.'),
 				"17"=>$reg['usuarioInsercion'],
 				"18"=>"<img src='../files/articulos/1.png' height='50px' width='50px' >",
 				//"18"=>"<img src='../files/articulos/".$reg['imagen']."' height='50px' width='50px' >",
 				"19"=>(!$reg['descontinuado'])?
 				'<span class="label bg-green">No</span><input type="checkbox" id="cbox1" onclick="descontinuar(this,\''.$reg['idArticulo'].'\');"> Descontinuar</label><br>':
 				'<span class="label bg-red">Si</span><input type="checkbox" id="cbox1" checked onclick="descontinuar(this,\''.$reg['idArticulo'].'\');"> Continuar </label><br>',
 				"20"=>(!$reg['ea'])?
 				'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
			//$output['aaData'][] = $row;
		}
		

		// Output
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => $data
		);
		

		echo json_encode( $output );
	}
}
header('Pragma: no-cache');
header('Cache-Control: no-store, no-cache, must-revalidate');
// Create instance of TableData class
$table_data = new TableData();
?>