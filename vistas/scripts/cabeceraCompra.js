var tabla;

//Función que se ejecuta al inicio
function init(){

	mostrarform(false);
	listar();



	//Cargamos los items al select grupo
	$.post("../ajax/cabeceraCompra.php?op=selectDeposito", function(r){
	            $("#Deposito_idDeposito").html(r);
	            $('#Deposito_idDeposito').selectpicker('refresh');

	}); 
 
	//Cargamos los items al select grupo
	$.post("../ajax/cabeceraCompra.php?op=selectPersona", function(r){
	            $("#Persona_idPersona").html(r);
	            $('#Persona_idPersona').selectpicker('refresh');

	}); 		  
           
	//Cargamos los items al select grupo
	$.post("../ajax/cabeceraCompra.php?op=selectMoneda", function(r){
	            $("#Moneda_idMoneda").html(r);
	            $('#Moneda_idMoneda').selectpicker('refresh');

	}); 	
 
	//Cargamos los items al select grupo
	$.post("../ajax/cabeceraCompra.php?op=selectCentroCosto", function(r){
	            $("#CentroCosto_idCentroCosto").html(r);
	            $('#CentroCosto_idCentroCosto').selectpicker('refresh');

	}); 

 
	//Cargamos los items al select grupo
	$.post("../ajax/cabeceraCompra.php?op=selectTerminoPago", function(r){
	            $("#TerminoPago_idTerminoPago").html(r);
	            $('#TerminoPago_idTerminoPago').selectpicker('refresh');

	});		

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});	

}

//Función limpiar
function limpiar()
{	
	$("#idCompra").val("");
	$("#idCompra2").val("");
	$("#Persona_idPersona").val("");
	$("#Deposito_idDeposito").val("");
	$("#TerminoPago_idTerminoPago").val("");
	$("#tipoCompra").val("");
	$("#tipo_comprobante").val("")
	$("#nroFactura").val("");   
	$("#fechaFactura").val("");
	$("#fechaVencimiento").val("");  
	$("#timbrado").val(""); 
	$("#vtoTimbrado").val(""); 		  		
	$("#Moneda_idMoneda").val("");		 
	$("#tasaCambio").val("");  	 		 		 		 		 		 				 		 		 		 		 		 		
	$("#tasaCambioBases").val("");  
	$("#totalImpuesto").val("");  
	$("#total").val(""); 
	$("#totalNeto").val(""); 
	$("#saldo").val("");   		
	$("#CentroCosto_idCentroCosto").val("");    

}  

//Función aleditar
function aleditar()
{
	$("#idCompra2").prop("disabled",true); 	
	$("#totalImpuesto").prop("disabled",true);
	$("#total").prop("disabled",true); 
	$("#totalNeto").prop("disabled",true); 
	$("#saldo").prop("disabled",true); 
	$("#tasaCambio").prop("disabled",true);  
	$("#tasaCambioBases").prop("disabled",true);
	$("#Moneda_idMoneda").prop("disabled",true);   
	$("#fechaVencimiento").prop("disabled",true);   
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
					url: '../ajax/cabeceraCompra.php?op=listar',
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
		url: "../ajax/cabeceraCompra.php?op=guardaryeditar",
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

function mostrar(idCompra) 
{ 
	$.post("../ajax/cabeceraCompra.php?op=mostrar",{idCompra : idCompra}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		 
	    $("#idCompra").val(data.idCompra);
	    $("#idCompra2").val(data.idCompra);
	    $("#Persona_idPersona").val(data.Persona_idPersona);
	    $("#Persona_idPersona").selectpicker('refresh');
 		$("#Deposito_idDeposito").val(data.Deposito_idDeposito);
 		$("#Deposito_idDeposito").selectpicker('refresh');
 		$("#TerminoPago_idTerminoPago").val(data.TerminoPago_idTerminoPago);
 		$("#TerminoPago_idTerminoPago").selectpicker('refresh');
 		$("#tipoCompra").val(data.tipoCompra);
		$("#tipoCompra").selectpicker('refresh'); 		
 		$("#tipo_comprobante").val(data.tipo_comprobante);
		$("#tipo_comprobante").selectpicker('refresh');
 		$("#nroFactura").val(data.nroFactura);   
 		$("#fechaFactura").val(data.fechaFactura);
 		$("#fechaVencimiento").val(data.fechaVencimiento); 
 		$("#timbrado").val(data.timbrado); 
 		$("#vtoTimbrado").val(data.vtoTimbrado); 		  		
 		$("#Moneda_idMoneda").val(data.Moneda_idMoneda);
		$("#Moneda_idMoneda").selectpicker('refresh'); 		 
 		$("#tasaCambio").val(data.tasaCambio);  	 		 		 		 		 		 				 		 		 		 		 		 		
 		$("#tasaCambioBases").val(data.tasaCambioBases);  
 		$("#totalImpuesto").val(data.totalImpuesto);  
 		$("#total").val(data.total); 
 		$("#totalNeto").val(data.totalNeto); 
 		$("#saldo").val(data.saldo);   		
 		$("#CentroCosto_idCentroCosto").val(data.CentroCosto_idCentroCosto);
		$("#CentroCosto_idCentroCosto").selectpicker('refresh'); 		 	 		
 		aleditar();	

 	});  
	
	
}  

//Función para desactivar registros
function desactivar(idCompra)
{


	swal({
		  title: 'Esta seguro de desactivar la Compra?',
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
	    url: '../ajax/cabeceraCompra.php?op=desactivar',
	    data: {idCompra:idCompra},
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
function activar(idCompra)
{
	swal({
		  title: 'Esta seguro de activar la Compra?',
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
	    url: '../ajax/cabeceraCompra.php?op=activar',
	    data: {idCompra:idCompra},
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