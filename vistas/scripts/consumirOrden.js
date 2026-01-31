var tabla;

//Función que se ejecuta al inicio
function init(){
	listar();
	//Cargamos los items al select cliente
	$.post("../ajax/empleado.php?op=selectEmpleado", function(r){
	            $("#idEmpleado").html(r);
	            $('#idEmpleado').selectpicker('refresh');
	});
}


//Función Listar
function listar()
{
	var idEmpleado = $("#idEmpleado").val();

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
					url: '../ajax/consultas.php?op=consumirOrden',
					data:{idEmpleado: idEmpleado},
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


function actualizar(x){

	var cantidad = x.value;
	var lid = x.id;


	swal({
	  title: 'Esta seguro de confirmar el servicio realizado?',
	  text: "Una vez realizado ya no podras visualizar la orden!",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si, generar!'
	}).then((result) => {
	  if (result.value) {
			$.ajax({
    type: "get",
    url: '../ajax/consultas.php?op=orden_actualizar',
    data: {cantidad:cantidad, lid:lid},
	dataType:"json",

    complete: function(data)
	{	
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: 'Servicio realizado correctamente.',
			  showConfirmButton: false,
			  timer: 1500
			 })		
    	listar();
    }

	});
	  }
	})

	
}

function refresh(x){
	
	//x = valor (this)
	//y = id
	//z = opcion
	
	foco = parseInt(x.id);

//	var foco = parseInt(x.id);
//	var foco1 = parseInt(x.id) + 5;
//	document.getElementById(foco).focus();
//	$('#' + foco1).val(5);
	listar();	 
}



init();