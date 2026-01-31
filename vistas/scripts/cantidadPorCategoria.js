var tabla;

//Función que se ejecuta al inicio
function init(){
	listar();
	$("#fechai").change();
	$("#fechaf").change();
  $("#actualizar").click(listar);
  //$("#problemas").val('0');
  //$("#problemas").selectpicker('refresh');
}


//Función Listar
function listar()
{
	$.post("../ajax/persona.php?op=selectProveedor", function(r){
	            $("#proveedor").html(r);
	            $('#proveedor').selectpicker('refresh');
	});

	var fechai = $("#fechai").val();
	var fechaf = $("#fechaf").val();
	var orden = $("#orden").val();
	var proveedor = $("#proveedor").val();
	
	
	
	

	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
		"language": {
            "decimal": ",",
            "thousands": "."
        },
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/consultas.php?op=rpt_cuentasAPagar',
					data:{fechai: fechai,fechaf: fechaf, orden, proveedor},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 100,//Paginación
	   "order": [[ 1, "asc" ],[ 2, "asc" ],[ 3, "asc" ]]//Ordenar (columna,orden)
	}).DataTable();
	//sumar();
}

init(); 
