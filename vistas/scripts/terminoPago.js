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
	$("#idTerminoPago").val("");
	$("#descripcion").val("");
	$("#tipo").val("");
	$("#diasVencimiento").val("");
	$("#cantidadCuotas").val("");
	$("#diaPrimeraCuota").val("");
	$("#porcentajeInteres").val("");
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
					url: '../ajax/terminoPago.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
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
		url: "../ajax/terminoPago.php?op=guardaryeditar",
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

function mostrar(idTerminoPago)
{
	$.post("../ajax/terminoPago.php?op=mostrar",{idTerminoPago : idTerminoPago}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#descripcion").val(data.descripcion);
		$("#tipo").val(data.tipo);
 		$("#idTerminoPago").val(data.idTerminoPago);
		$("#diasVencimiento").val(data.diasVencimiento);
		$("#cantidadCuotas").val(data.cantidadCuotas);
		$("#diaPrimeraCuota").val(data.diaPrimeraCuota);
		$("#porcentajeInteres").val(data.porcentajeInteres);

 	})
}

//Función para desactivar registros
function desactivar(idTerminoPago)
{

        	$.post("../ajax/terminoPago.php?op=desactivar", {idTerminoPago : idTerminoPago}, function(e){
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

//Función para activar registros
function activar(idTerminoPago)
{

        	$.post("../ajax/terminoPago.php?op=activar", {idTerminoPago : idTerminoPago}, function(e){
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



init();