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
	$.post("../ajax/persona.php?op=selectCliente", function(r){
		$("#Persona_idPersona").html(r);
		$("#Persona_idPersona").selectpicker('refresh');
	});

	//cargamos los items al select usuario
	$.post("../ajax/sucursal.php?op=selectSucursal", function(r){
		$("#Sucursal_idSucursal").html(r);
		$("#Sucursal_idSucursal").selectpicker('refresh');
	});
 

	getCurrentLocation();

} 



function getCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            currentLatitude = position.coords.latitude;
            currentLongitude = position.coords.longitude;
			$("#latitud").val(currentLatitude);
			$("#longitud").val(currentLongitude);
            console.log("Latitud:", currentLatitude, "Longitud:", currentLongitude);
        }, function(error) {
            console.error("Error obteniendo la ubicación: ", error);
        });
    } else {
        console.error("Geolocalización no es soportada por este navegador.");
    }
}


 
function noCambiar(){
  
 
	$.post("../ajax/persona.php?op=selectDirecciones", { idPersona: $("#Persona_idPersona").val() } , function(r){
	    $("#Direccion_idDireccion").html(r);
	    $('#Direccion_idDireccion').selectpicker('refresh');
	});	
   
}

function noCambiar2(){ 
  
 
	$.post("../ajax/sucursal.php?op=selectDepositoxSucursal", { idSucursal: $("#Sucursal_idSucursal").val() } , function(r){
	    $("#Deposito_idDeposito").html(r);
	    $('#Deposito_idDeposito').selectpicker('refresh'); 
	});	
  
}

function noCambiar3(){ 
  
 
	$.post("../ajax/deposito.php?op=selectVehiculoxDeposito", { idDeposito: $("#Deposito_idDeposito").val() } , function(r){
	    $("#Vehiculo_idVehiculo").html(r);
	    $('#Vehiculo_idVehiculo').selectpicker('refresh');  
	});	
  
}


//Función limpiar
function limpiar()
{
	$("#idPersonaAgenda").val("");
	$("#Persona_idPersona").val("");
	$("#Sucursal_idSucursal").val("");
	$("#Deposito_idDeposito").val("");	
	$("#Vehiculo_idVehiculo").val("");		 
	$("#fechaVisita").val("");
	$("#cantidad").val("");
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
					url: '../ajax/personaAgenda.php?op=listar',
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

function aprobar(idPersonaAgenda)
{
swal({
	  title: 'Esta seguro de confirmar la agenda?',
	  text: "",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si!'
	}).then((result) => {
	  if (result.value) {
        	$.post("../ajax/personaAgenda.php?op=aprobar", {idPersonaAgenda : idPersonaAgenda}, function(e){
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


function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/personaAgenda.php?op=guardaryeditar",
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
function desactivar(idPersonaAgenda)
{

        	$.post("../ajax/personaAgenda.php?op=desactivar", {idPersonaAgenda : idPersonaAgenda}, function(e){
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
function activar(idPersonaAgenda)
{

        	$.post("../ajax/personaAgenda.php?op=activar", {idPersonaAgenda : idPersonaAgenda}, function(e){
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

function mostrar(idPersonaAgenda)
{
	$.post("../ajax/personaAgenda.php?op=mostrar",{idPersonaAgenda : idPersonaAgenda}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#Persona_idPersona").val(data.Persona_idPersona);
		$("#fechaVisita").val(data.fechaVisita);
		$("#cantidad").val(data.cantidad);
 		$("#idPersonaAgenda").val(data.idPersonaAgenda);

 	})
}



init();