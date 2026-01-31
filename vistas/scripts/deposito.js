var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})


	//Cargamos los items al select grupo
	$.post("../ajax/deposito.php?op=selectSucursal", function(r){
	            $("#Sucursal_idSucursal").html(r);
	            $('#Sucursal_idSucursal').selectpicker('refresh');

	});


	//Cargamos los items al select grupo
	$.post("../ajax/deposito.php?op=selectVehiculo", function(r){
	            $("#Vehiculo_idVehiculo").html(r);
	            $('#Vehiculo_idVehiculo').selectpicker('refresh');

	});	

}

//Función limpiar
function limpiar()
{
	$("#idDeposito").val("");
	$("#descripcion").val("");
	$("#Sucursal_idSucrusal").val("");
	$("#Vehiculo_idVehiculo").val("");
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
					url: '../ajax/deposito.php?op=listar',
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
		url: "../ajax/deposito.php?op=guardaryeditar",
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

function mostrar(idDeposito)
{
	$.post("../ajax/deposito.php?op=mostrar",{idDeposito : idDeposito}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#descripcion").val(data.descripcion);
		$("#Sucursal_idSucursal").val(data.Sucursal_idSucursal);
	    $("#Sucursal_idSucursal").selectpicker('refresh');

 		$("#idDeposito").val(data.idDeposito);

 	})
}

//Función para desactivar registros
function desactivar(idDeposito)
{

        	$.post("../ajax/deposito.php?op=desactivar", {idDeposito : idDeposito}, function(e){
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: datos,
			  showConfirmButton: false,
			  timer: 1500
			 })		
	            tabla.ajax.reload();
        	});	

}

//Función para activar registros
function activar(idDeposito)
{

        	$.post("../ajax/deposito.php?op=activar", {idDeposito : idDeposito}, function(e){
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: datos,
			  showConfirmButton: false,
			  timer: 1500
			 })		
	            tabla.ajax.reload();
        	});	

}


init();