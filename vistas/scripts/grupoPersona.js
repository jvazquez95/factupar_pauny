var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})



	//cargamos los items al select usuario
	$.post("../ajax/cuentaContable.php?op=selectCuentaContable", function(r){
		$("#cuentaAnticipo").html(r);
		$("#cuentaAnticipo").selectpicker('refresh');

		$("#cuentaAPagar").html(r);
		$("#cuentaAPagar").selectpicker('refresh');


	});


}

//Función limpiar
function limpiar()
{
	$("#idGrupoPersona").val("");
	$("#descripcion").val("");
	$("#cuentaAnticipo").val("");
	$("#cuentaAPagar").val("");
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
					url: '../ajax/grupoPersona.php?op=listar',
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
		url: "../ajax/grupoPersona.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: datos,
			  showConfirmButton: false,
			  timer: 1500
			 })		         
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}


//Función para desactivar registros
function desactivar(idGrupoPersona)
{
	bootbox.confirm("¿Está Seguro de desactivar la grupoPersona?", function(result){
		if(result)
        {
        	$.post("../ajax/grupoPersona.php?op=desactivar", {idGrupoPersona : idGrupoPersona}, function(e){
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: e,
			  showConfirmButton: false,
			  timer: 1500
			 })		
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idGrupoPersona)
{
	bootbox.confirm("¿Está Seguro de activar la grupoPersona?", function(result){
		if(result)
        {
        	$.post("../ajax/grupoPersona.php?op=activar", {idGrupoPersona : idGrupoPersona}, function(e){
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: e,
			  showConfirmButton: false,
			  timer: 1500
			 })		
	            tabla.ajax.reload();
        	});	
        }
	})
}

function mostrar(idGrupoPersona)
{
	$.post("../ajax/grupoPersona.php?op=mostrar",{idGrupoPersona : idGrupoPersona}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#descripcion").val(data.descripcion);
		$("#cuentaAnticipo").val(data.cuentaAnticipo);
		$("#cuentaAPagar").val(data.cuentaAPagar);
 		$("#idGrupoPersona").val(data.idGrupoPersona);

 	})
}



init();