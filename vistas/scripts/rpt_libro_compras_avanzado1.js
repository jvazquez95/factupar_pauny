var tabla;

//Función que se ejecuta al inicio
function init(){
	listar();
	$("#fecha_inicio").change(listar);	$("#fecha_fin").change(listar); 	$("#proceso").change(listar);


}


//Función Listar
function listar()
{
	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
	var proceso = $("#proceso").val();

	tabla=$('#tbllistado').dataTable(
	{
		"fnRowCallback": function( nRow, aaData, iDisplayIndex, iDisplayIndexFull ) {
		  if ( aaData[17] == 1 )
		  {
			$('td', nRow).css('background-color', '#ADFAA8' );
		  }
		},
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
					url: '../ajax/consultas.php?op=rpt_libro_compras_avanzado1',
					data:{fecha_inicio: fecha_inicio, fecha_fin: fecha_fin, proceso:proceso},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 100,//Paginación
	    "order": [[ 0, "asc" ]]//Ordenar (columna,orden)
	}).DataTable();
}






function actualizar1(x,nro_compra){


	dato = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/consultas.php?op=actualizar1',
    	data: {nro_compra:nro_compra, dato:dato},
		dataType:"json",
	})

}


function actualizar2(x,nro_compra){


	dato = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/consultas.php?op=actualizar2',
    	data: {nro_compra:nro_compra, dato:dato},
		dataType:"json",
	})

}


function actualizar3(x,nro_compra){


	dato = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/consultas.php?op=actualizar3',
    	data: {nro_compra:nro_compra, dato:dato},
		dataType:"json",
	})

}



function actualizar4(x,nro_compra){


	dato = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/consultas.php?op=actualizar4',
    	data: {nro_compra:nro_compra, dato:dato},
		dataType:"json",
	})

}



function actualizarTimbrado(x,nro_compra){


	dato = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/consultas.php?op=actualizarTimbrado',
    	data: {nro_compra:nro_compra, dato:dato},
		dataType:"json",
	})

}






init();