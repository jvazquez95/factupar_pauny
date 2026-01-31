var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
}

//Función limpiar
function limpiar()
{
	$("#idPais").val("");
	$("#nombre").val("");
	$("#bandera").val("");
	$("#codCelular").val("");
}  

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
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
					url: '../ajax/pais.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/pais.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
		    {                    
				swal({
				  position: 'top-end',
				  type: 'success',
				  title: 'Generacion Exitosa!.',
				  showConfirmButton: false,
				  timer: 1500
				 });
				 mostrarform(false);	
				 tabla.ajax.reload();
		    }

	});
	limpiar();
}

function mostrar(idPais)
{
	$.post("../ajax/pais.php?op=mostrar",{idPais : idPais}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

	    $("#idPais").val(data.idPais);
		$("#nombre").val(data.nombre);
 		$("#bandera").val(data.bandera);
 		$("#codCelular").val(data.codCelular);	
 	}) 
}

 
function desactivar(idPais)
{
	swal({
		  title: 'Esta seguro de desactivar el Pais',
		  text: "",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Si, desactivar!'
		}).then((result) => {
		  if (result.value) {
				$.ajax({
	    type: "post",
	    url: '../ajax/pais.php?op=desactivar',
	    data: {idPais:idPais},
		dataType:"json",

	    complete: function(data)
		{	
				swal({
				  position: 'top-end',
				  type: 'success',
				  title: 'Listo',
				  showConfirmButton: false,
				  timer: 900
				 })		
	    	listar();
	    }

	});
	  }
	})
}


//Función para activar registros
function activar(idPais)
{
	swal({
		  title: 'Esta seguro de activar el pais?',
		  text: "",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Si, activar!'
		}).then((result) => {
		  if (result.value) {
				$.ajax({
	    type: "post",
	    url: '../ajax/pais.php?op=activar',
	    data: {idPais:idPais},
		dataType:"json",

	    complete: function(data)
		{	
				swal({
				  position: 'top-end',
				  type: 'success',
				  title: 'Listo',
				  showConfirmButton: false,
				  timer: 900
				 })		
	    	listar();
	    }

	});
	  }
	})
}


 
init();