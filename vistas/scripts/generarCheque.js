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
	$.post("../ajax/banco.php?op=selectBanco", function(r){
		$("#Banco_idBancoCh").html(r);
		$("#Banco_idBancoCh").selectpicker('refresh');
	});


}

//Función limpiar
function limpiar()
{
	$("#idCheque").val("");
	$("#FechaEmision").val("");
	$("#fechaCobro").val("");
	$("#Banco_idBanco").val("");
	$("#Moneda_idMoneda").val("");
	$("#tipoCheque").val("");
	$("#nroCheque").val("");
	$("#firmante").val("");
	$("#cliente").val("");
	$("#monto").val("");
	$("#comentario").val("");
	$("#fechaConfirmacion").val("");
	$("#fechaRechazo").val("");
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


function filtrarCC(x){
	var Banco_idBanco = x.value;
	$.post("../ajax/cheque.php?op=selectCuentaCorrienteBanco", {Banco_idBanco: Banco_idBanco}, function(r){
		$("#CuentaCorriente_idCuentaCorriente").html(r);
		$("#CuentaCorriente_idCuentaCorriente").selectpicker('refresh');
	});
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
					url: '../ajax/cheque.php?op=listar',
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
		url: "../ajax/cheque.php?op=generar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: 'Cheques generados correctamente',
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
function desactivar(idCheque)
{
	bootbox.confirm("¿Está Seguro de desactivar la barrio?", function(result){
		if(result)
        {
        	$.post("../ajax/cheque.php?op=desactivar", {idCheque : idCheque}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idCheque)
{
	bootbox.confirm("¿Está Seguro de activar la barrio?", function(result){
		if(result)
        {
        	$.post("../ajax/cheque.php?op=activar", {idCheque : idCheque}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

function mostrar(idCheque)
{
	$.post("../ajax/cheque.php?op=mostrar",{idCheque : idCheque}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

	$("#fechaEmision").val(data.FechaEmision);
	$("#fechaCobro").val(data.fechaCobro);
	$("#Banco_idBanco").val(data.Banco_idBanco);
	$("#Banco_idBanco").selectpicker('refresh');
	$("#Moneda_idMoneda").val(data.Moneda_idMoneda);
	$("#Moneda_idMoneda").selectpicker('refresh');
	$("#tipoCheque").val(data.tipoCheque);
	$("#tipoCheque").selectpicker('refresh');
	$("#nroCheque").val(data.nroCheque);
	$("#firmante").val(data.firmante);
	$("#cliente").val(data.cliente);
	$("#monto").val(data.monto);
	$("#comentario").val(data.comentario);
	$("#fechaConfirmacion").val(data.fechaConfirmacion);
	$("#fechaRechazo").val(data.fechaRechazo); 		
	$("#idCheque").val(data.idCheque);

 	})
}



init();