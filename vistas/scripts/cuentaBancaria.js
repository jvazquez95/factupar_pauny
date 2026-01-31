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
	$.post("../ajax/cuentaBancaria.php?op=selectMoneda", function(r){
	            $("#Moneda_idMoneda").html(r);
	            $('#Moneda_idMoneda').selectpicker('refresh');

	}); 
 
	//Cargamos los items al select grupo
	$.post("../ajax/cuentaBancaria.php?op=selectBanco", function(r){
	            $("#Banco_idBanco").html(r);
	            $('#Banco_idBanco').selectpicker('refresh');

	}); 		 
           
	//Cargamos los items al select grupo
	$.post("../ajax/cuentaBancaria.php?op=selectCuentaContable", function(r){
	            $("#CuentaContable_idCuentaContable").html(r);
	            $('#CuentaContable_idCuentaContable').selectpicker('refresh');

	}); 	

}

//Función limpiar
function limpiar()
{
	$("#idCuentaBancaria").val("");
	$("#descripcion").val("");
	$("#nroCuenta").val("");
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
					url: '../ajax/cuentaBancaria.php?op=listar',
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
		url: "../ajax/cuentaBancaria.php?op=guardaryeditar",
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

function mostrar(idCuentaBancaria)
{
	$.post("../ajax/cuentaBancaria.php?op=mostrar",{idCuentaBancaria : idCuentaBancaria}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

	    $("#idCuentaBancaria").val(data.idCuentaBancaria);
		$("#descripcion").val(data.descripcion);
 		$("#Moneda_idMoneda").val(data.Moneda_idMoneda);
 		$("#CuentaContable_idCuentaContable").val(data.CuentaContable_idCuentaContable);
 		$("#Banco_idBanco").val(data.Banco_idBanco);
 		$("#tipoCuenta").val(data.tipoCuenta); 
 		
 	}) 
}  

//Función para desactivar registros
function desactivar(idCuentaBancaria)
{
	bootbox.confirm("¿Está Seguro de desactivar la cuenta bancaria?", function(result){
		if(result)
        {
        	$.post("../ajax/cuentaBancaria.php?op=desactivar", {idCuentaBancaria : idCuentaBancaria}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idCuentaBancaria)
{
	bootbox.confirm("¿Está Seguro de activar la cuenta bancaria?", function(result){
		if(result)
        {
        	$.post("../ajax/cuentaBancaria.php?op=activar", {idCuentaBancaria : idCuentaBancaria}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

 
init();