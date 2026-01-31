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
	$("#idSucursal").val("");
	$("#nombre").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#correo").val("");
	$("#ciudad").val("");
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
					url: '../ajax/sucursal.php?op=listar',
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
		url: "../ajax/sucursal.php?op=guardaryeditar",
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

function mostrar(idSucursal)
{
	$.post("../ajax/sucursal.php?op=mostrar",{idSucursal : idSucursal}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#idSucursal").val(data.idSucursal);
		$("#nombre").val(data.nombre);
		$("#direccion").val(data.direccion || "");
		$("#telefono").val(data.telefono || "");
		$("#correo").val(data.correo || "");
		$("#ciudad").val(data.ciudad || "");
 	})
}


//Función para desactivar registros
function desactivar(idSucursal)
{
	bootbox.confirm("¿Está Seguro de desactivar la sucursal?", function(result){
		if(result)
        {
        	$.post("../ajax/sucursal.php?op=desactivar", {idSucursal : idSucursal}, function(e){
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
function activar(idSucursal)
{
	bootbox.confirm("¿Está Seguro de activar la sucursal?", function(result){
		if(result)
        {
        	$.post("../ajax/sucursal.php?op=activar", {idSucursal : idSucursal}, function(e){
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



init();