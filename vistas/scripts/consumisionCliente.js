var tabla;

//Función que se ejecuta al inicio
function init(){
	listar();

	//Cargamos los items al select categoria
	$.post("../ajax/cliente.php?op=selectCliente", function(r){
	            $("#idCliente").html(r);
	            $('#idCliente').selectpicker('refresh');

	});

}


//Función Listar
function listar()
{
	var idCliente = $("#idCliente").val();

	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
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
					url: '../ajax/consultas.php?op=rpt_consumisiones_cliente',
					data:{idCliente: idCliente},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 500,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}




init();