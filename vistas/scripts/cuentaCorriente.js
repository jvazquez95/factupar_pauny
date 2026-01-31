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
	$.post("../ajax/cuentaCorriente.php?op=selectProceso", function(r){
	            $("#Proceso_idProceso").html(r);
	            $('#Proceso_idProceso').selectpicker('refresh');

	}); 
            
	//Cargamos los items al select grupo
	$.post("../ajax/cuentaCorriente.php?op=selectCuentaContable", function(r){
	            $("#CuentaContable_idCuentaContable").html(r);
	            $('#CuentaContable_idCuentaContable').selectpicker('refresh');

	}); 	 

}

//Función limpiar
function limpiar()
{
	$("#idCuentaCorriente").val("");
	$("#descripcion").val("");
	$("#tipoCuenta").val("");
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
					url: '../ajax/cuentaCorriente.php?op=listar',
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
		url: "../ajax/cuentaCorriente.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false); 
	          tabla.ajax.reload();
	    }

	});
	limpiar();
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


function mostrar(idCuentaCorriente)
{
	$.post("../ajax/cuentaCorriente.php?op=mostrar",{idCuentaCorriente : idCuentaCorriente}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

	    $("#idCuentaCorriente").val(data.idCuentaCorriente);
		$("#descripcion").val(data.descripcion);
 		$("#Proceso_idProceso").val(data.Proceso_idProceso);
 		$("#CuentaContable_idCuentaContable").val(data.CuentaContable_idCuentaContable);
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
 	}) 
}  

//Función para desactivar registros
function desactivar(idCuentaCorriente)
{
	bootbox.confirm("¿Está Seguro de desactivar la cuenta corriente?", function(result){
		if(result)
        {
        	$.post("../ajax/cuentaCorriente.php?op=desactivar", {idCuentaCorriente : idCuentaCorriente}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idCuentaCorriente)
{
	bootbox.confirm("¿Está Seguro de activar la cuenta corriente?", function(result){
		if(result)
        {
        	$.post("../ajax/cuentaCorriente.php?op=activar", {idCuentaCorriente : idCuentaCorriente}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

 
init();