var tabla;

//Función que se ejecuta al inicio
function init(){

	mostrarform(false);
	listar();



	//Cargamos los items al select grupo
	$.post("../ajax/cuentaContable.php?op=selectProceso", function(r){
	            $("#Proceso_idProceso").html(r);
	            $('#Proceso_idProceso').selectpicker('refresh');

	}); 
 
	//Cargamos los items al select grupo
	$.post("../ajax/cuentaContable.php?op=selectCentroCosto", function(r){
	            $("#CentroCosto_idCentroCosto").html(r);
	            $('#CentroCosto_idCentroCosto').selectpicker('refresh');

	}); 		 
           
	//Cargamos los items al select grupo
	$.post("../ajax/cuentaContable.php?op=selectCuentaContablePadre", function(r){
	            $("#CuentaContable_idCuentaContablePadre").html(r);
	            $('#CuentaContable_idCuentaContablePadre').selectpicker('refresh');

	}); 	
 

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});	

}

//Función limpiar
function limpiar()
{
	$("#idCuentaContable").val("");
	$("#nroCuentaContable").val("");
	$("#descripcion").val("");
	$("#CentroCosto_idCentroCosto").val("");
	$("#Proceso_idProceso").val("");
	$("#CuentaContable_idCuentaContablePadre").val("");
	$("#tipoCuenta").val(""); 
	$("#nivel").val(""); 
	$("#debitoAnterior").val("");
	$("#creditoAnterior").val(""); 
	$("#debitoEnero").val(""); 
	$("#debitoFebrero").val(""); 
	$("#debitoMarzo").val(""); 
	$("#debitoAbril").val(""); 
	$("#debitoMayo").val(""); 
	$("#debitoJunio").val(""); 
	$("#debitoJulio").val(""); 
	$("#debitoAgosto").val(""); 
	$("#debitoSetiembre").val(""); 
	$("#debitoOctubre").val(""); 
	$("#debitoNoviembre").val("");  		 		 		 		 		 		 		
	$("#debitoDiciembre").val(""); 
	$("#creditoEnero").val(""); 
	$("#creditoFebrero").val(""); 
	$("#creditoMarzo").val(""); 
	$("#creditoAbril").val(""); 
	$("#creditoMayo").val(""); 
	$("#creditoJunio").val(""); 
	$("#creditoJulio").val(""); 
	$("#creditoAgosto").val(""); 
	$("#creditoSetiembre").val(""); 
	$("#creditoOctubre").val(""); 
	$("#creditoNoviembre").val("");  		 		 		 		 		 		 		
	$("#creditoDiciembre").val("");  
}  

//Función aleditar
function aleditar()
{
	$("#debitoAnterior").prop("disabled",false);
	$("#creditoAnterior").prop("disabled",false); 
	$("#debitoEnero").prop("disabled",false); 
	$("#debitoFebrero").prop("disabled",false); 
	$("#debitoMarzo").prop("disabled",false); 
	$("#debitoAbril").prop("disabled",false); 
	$("#debitoMayo").prop("disabled",false); 
	$("#debitoJunio").prop("disabled",false); 
	$("#debitoJulio").prop("disabled",false); 
	$("#debitoAgosto").prop("disabled",false); 
	$("#debitoSetiembre").prop("disabled",false); 
	$("#debitoOctubre").prop("disabled",false); 
	$("#debitoNoviembre").prop("disabled",false);  		 		 		 		 		 		 		
	$("#debitoDiciembre").prop("disabled",false); 
	$("#creditoEnero").prop("disabled",false); 
	$("#creditoFebrero").prop("disabled",false); 
	$("#creditoMarzo").prop("disabled",false); 
	$("#creditoAbril").prop("disabled",false); 
	$("#creditoMayo").prop("disabled",false); 
	$("#creditoJunio").prop("disabled",false); 
	$("#creditoJulio").prop("disabled",false); 
	$("#creditoAgosto").prop("disabled",false); 
	$("#creditoSetiembre").prop("disabled",false); 
	$("#creditoOctubre").prop("disabled",false); 
	$("#creditoNoviembre").prop("disabled",false);  		 		 		 		 		 		 		
	$("#creditoDiciembre").prop("disabled",false);  
}

//Función alinsertar
function alinsertar()
{
	 		 		 		 		 		 		
	$("#debitoAnterior").prop("disabled",true);
	$("#creditoAnterior").prop("disabled",true); 
	$("#debitoEnero").prop("disabled",true); 
	$("#debitoFebrero").prop("disabled",true); 
	$("#debitoMarzo").prop("disabled",true); 
	$("#debitoAbril").prop("disabled",true); 
	$("#debitoMayo").prop("disabled",true); 
	$("#debitoJunio").prop("disabled",true); 
	$("#debitoJulio").prop("disabled",true); 
	$("#debitoAgosto").prop("disabled",true); 
	$("#debitoSetiembre").prop("disabled",true); 
	$("#debitoOctubre").prop("disabled",true); 
	$("#debitoNoviembre").prop("disabled",true);  		 		 		 		 		 		 		
	$("#debitoDiciembre").prop("disabled",true); 
	$("#creditoEnero").prop("disabled",true); 
	$("#creditoFebrero").prop("disabled",true); 
	$("#creditoMarzo").prop("disabled",true); 
	$("#creditoAbril").prop("disabled",true); 
	$("#creditoMayo").prop("disabled",true); 
	$("#creditoJunio").prop("disabled",true); 
	$("#creditoJulio").prop("disabled",true); 
	$("#creditoAgosto").prop("disabled",true); 
	$("#creditoSetiembre").prop("disabled",true); 
	$("#creditoOctubre").prop("disabled",true); 
	$("#creditoNoviembre").prop("disabled",true);  		 		 		 		 		 		 		
	$("#creditoDiciembre").prop("disabled",true);  
}  


//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	
	if (flag)
	{	
		alinsertar();
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
					url: '../ajax/cuentaContable.php?op=listar',
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
		url: "../ajax/cuentaContable.php?op=guardaryeditar",
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

function mostrar(idCuentaContable) 
{ 
	$.post("../ajax/cuentaContable.php?op=mostrar",{idCuentaContable : idCuentaContable}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		 
	    $("#idCuentaContable").val(data.idCuentaContable);
	    $("#nroCuentaContable").val(data.nroCuentaContable);
		$("#descripcion").val(data.descripcion);
 		$("#CentroCosto_idCentroCosto").val(data.CentroCosto_idCentroCosto);
 		$("#CentroCosto_idCentroCosto").selectpicker('refresh');
 		$("#Proceso_idProceso").val(data.Proceso_idProceso);
 		$("#Proceso_idProceso").selectpicker('refresh');
 		$("#CuentaContable_idCuentaContablePadre").val(data.CuentaContable_idCuentaContablePadre);
		$("#CuentaContable_idCuentaContablePadre").selectpicker('refresh');
 		$("#tipoCuenta").val(data.tipoCuenta); 
 		$("#tipoCuenta").selectpicker('refresh');
 		$("#nivel").val(data.nivel);  
 		$("#nivel").selectpicker('refresh'); 
 		$("#debitoAnterior").val(data.debitoAnterior);
 		$("#creditoAnterior").val(data.creditoAnterior); 
 		$("#debitoEnero").val(data.debitoEnero); 
 		$("#debitoFebrero").val(data.debitoFebrero); 
 		$("#debitoMarzo").val(data.debitoMarzo); 
 		$("#debitoAbril").val(data.debitoAbril); 
 		$("#debitoMayo").val(data.debitoMayo); 
 		$("#debitoJunio").val(data.debitoJunio); 
 		$("#debitoJulio").val(data.debitoJulio); 
 		$("#debitoAgosto").val(data.debitoAgosto); 
 		$("#debitoSetiembre").val(data.debitoSetiembre); 
 		$("#debitoOctubre").val(data.debitoOctubre); 
 		$("#debitoNoviembre").val(data.debitoNoviembre);  		 		 		 		 		 		 		
 		$("#debitoDiciembre").val(data.debitoDiciembre); 
 		$("#creditoEnero").val(data.creditoEnero); 
 		$("#creditoFebrero").val(data.creditoFebrero); 
 		$("#creditoMarzo").val(data.creditoMarzo); 
 		$("#creditoAbril").val(data.creditoAbril); 
 		$("#creditoMayo").val(data.creditoMayo); 
 		$("#creditoJunio").val(data.creditoJunio); 
 		$("#creditoJulio").val(data.creditoJulio); 
 		$("#creditoAgosto").val(data.creditoAgosto); 
 		$("#creditoSetiembre").val(data.creditoSetiembre); 
 		$("#creditoOctubre").val(data.creditoOctubre); 
 		$("#creditoNoviembre").val(data.creditoNoviembre);  		 		 		 		 		 		 		
 		$("#creditoDiciembre").val(data.creditoDiciembre);  	 		
 		aleditar();	

 	});  
	
	
}  

//Función para desactivar registros
function desactivar(idCuentaContable)
{


	swal({
		  title: 'Esta seguro de desactivar la cuenta Contable?',
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
	    url: '../ajax/cuentaContable.php?op=desactivar',
	    data: {idCuentaContable:idCuentaContable},
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
function activar(idCuentaContable)
{
	swal({
		  title: 'Esta seguro de activar la cuenta Contable?',
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
	    url: '../ajax/cuentaContable.php?op=activar',
	    data: {idCuentaContable:idCuentaContable},
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