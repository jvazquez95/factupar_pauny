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
	$.post("../ajax/movimientoBancario.php?op=selectMoneda", function(r){
	            $("#Moneda_idMoneda").html(r);
	            $('#Moneda_idMoneda').selectpicker('refresh');

	}); 
 
	//Cargamos los items al select grupo
	$.post("../ajax/movimientoBancario.php?op=selectBanco", function(r){
	            $("#Banco_idBanco").html(r);
	            $('#Banco_idBanco').selectpicker('refresh');

	}); 		 
           
	//Cargamos los items al select grupo
	$.post("../ajax/movimientoBancario.php?op=selectCentroCosto", function(r){
	            $("#CentroCosto_idCentroCosto").html(r);
	            $('#CentroCosto_idCentroCosto').selectpicker('refresh');

	}); 	

	//Cargamos los items al select grupo
	$.post("../ajax/movimientoBancario.php?op=selectPersonaPersonal", function(r){
	            $("#Persona_idPersonaPersonal").html(r);
	            $('#Persona_idPersonaPersonal').selectpicker('refresh');

	}); 	

}

//Función limpiar
function limpiar()
{
	$("#idMovimientoBancario").val("");
	$("#ano").val("");
	$("#mes").val("");
	$("#Moneda_idMoneda").val("");
	$("#nroCuenta").val("");
	$("#Banco_idBanco").val(""); 
	$("#nroSecuencia").val(""); 
	$("#fechaMovimiento").val(""); 
	$("#nroOrden").val(""); 
	$("#beneficiario").val(""); 
	$("#Importe").val(""); 
	$("#tipoMovimiento").val(""); 
	$("#concepto").val(""); 
	$("#nroDocumento").val(""); 
	$("#fechaCobro").val(""); 
	$("#fechaEmision").val(""); 
	$("#fechaAnulacion").val(""); 
	$("#situacion").val(""); 
	$("#CentroCosto_idCentroCosto").val(""); 
	$("#Persona_idPersonaPersonal").val(""); 
	$("#cargo").val(""); 
	$("#indicadorSueldo").val(""); 
	$("#mesSueldo").val(""); 
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
					url: '../ajax/movimientoBancario.php?op=listar',
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
		url: "../ajax/movimientoBancario.php?op=guardaryeditar",
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

function mostrar(idMovimientoBancario)
{
	$.post("../ajax/movimientoBancario.php?op=mostrar",{idMovimientoBancario : idMovimientoBancario}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true); 

	    $("#idMovimientoBancario").val(data.idMovimientoBancario);
		$("#ano").val(data.ano);
 		$("#mes").val(data.mes);
 		$("#Moneda_idMoneda").val(data.Moneda_idMoneda);
 		$("#nroCuenta").val(data.nroCuenta);
 		$("#Banco_idBanco").val(data.Banco_idBanco); 
 		$("#nroSecuencia").val(data.nroSecuencia); 
 		$("#fechaMovimiento").val(data.fechaMovimiento); 
 		$("#nroOrden").val(data.nroOrden); 
 		$("#beneficiario").val(data.beneficiario); 
 		$("#Importe").val(data.Importe); 
 		$("#tipoMovimiento").val(data.tipoMovimiento); 
 		$("#concepto").val(data.concepto); 
 		$("#nroDocumento").val(data.nroDocumento); 
 		$("#fechaCobro").val(data.fechaCobro); 
 		$("#fechaEmision").val(data.fechaEmision); 
 		$("#fechaAnulacion").val(data.fechaAnulacion); 
 		$("#situacion").val(data.situacion); 
 		$("#CentroCosto_idCentroCosto").val(data.CentroCosto_idCentroCosto); 
 		$("#Persona_idPersonaPersonal").val(data.Persona_idPersonaPersonal); 
 		$("#cargo").val(data.cargo); 
 		$("#indicadorSueldo").val(data.indicadorSueldo); 
 		$("#mesSueldo").val(data.mesSueldo); 
 		
 	}) 
}  

//Función para desactivar registros
function desactivar(idMovimientoBancario)
{
	bootbox.confirm("¿Está Seguro de desactivar el movimiento bancario?", function(result){
		if(result)
        {
        	$.post("../ajax/movimientoBancario.php?op=desactivar", {idMovimientoBancario : idMovimientoBancario}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idMovimientoBancario)
{
	bootbox.confirm("¿Está Seguro de activar el movimiento bancario?", function(result){ 
		if(result)
        {
        	$.post("../ajax/movimientoBancario.php?op=activar", {idMovimientoBancario : idMovimientoBancario}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

 
init();