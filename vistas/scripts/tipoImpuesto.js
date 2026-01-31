var tabla;

//Función que se ejecuta al inicio
function init(){
		//Cargamos los items al select categoria
	$.post("../ajax/banco.php?op=selectCuentaContable", function(r){
	            $("#CuentaContable_mercaderiaId").html(r);
	            $('#CuentaContable_mercaderiaId').selectpicker('refresh');

	            $("#CuentaContable_ventasMercaderiasId").html(r);
	            $('#CuentaContable_ventasMercaderiasId').selectpicker('refresh');

	            $("#CuentaContable_costoMercaderiaId").html(r);
	            $('#CuentaContable_costoMercaderiaId').selectpicker('refresh');

	            $("#CuentaContable_impuestoId").html(r);
	            $('#CuentaContable_impuestoId').selectpicker('refresh');

	            $("#CuentaContable_servicioId").html(r);
	            $('#CuentaContable_servicioId').selectpicker('refresh');

	            $("#CuentaContable_notaCreditoId").html(r);
	            $('#CuentaContable_notaCreditoId').selectpicker('refresh');

	            $("#CuentaContable_comprasId").html(r);
	            $('#CuentaContable_comprasId').selectpicker('refresh'); 	            

	});


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
	$("#idTipoImpuesto").val("");
	$("#descripcion").val("");
	$("#porcentajeImpuesto").val("");
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
					url: '../ajax/tipoImpuesto.php?op=listar',
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
		url: "../ajax/tipoImpuesto.php?op=guardaryeditar",
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

function mostrar(idTipoImpuesto)
{
	$.post("../ajax/tipoImpuesto.php?op=mostrar",{idTipoImpuesto : idTipoImpuesto}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#descripcion").val(data.descripcion);
		$("#porcentajeImpuesto").val(data.porcentajeImpuesto);
 		$("#idTipoImpuesto").val(data.idTipoImpuesto);

		$("#CuentaContable_mercaderiaId").val(data.CuentaContable_mercaderiaId); 
		$("#CuentaContable_mercaderiaId").selectpicker('refresh');  

		$("#CuentaContable_ventasMercaderiasId").val(data.CuentaContable_ventasMercaderiasId); 
		$("#CuentaContable_ventasMercaderiasId").selectpicker('refresh');  

		$("#CuentaContable_costoMercaderiaId").val(data.CuentaContable_costoMercaderiaId); 
		$("#CuentaContable_costoMercaderiaId").selectpicker('refresh');  

		$("#CuentaContable_impuestoId").val(data.CuentaContable_ivaId); 
		$("#CuentaContable_impuestoId").selectpicker('refresh');   

		$("#CuentaContable_servicioId").val(data.CuentaContable_servicioId); 
		$("#CuentaContable_servicioId").selectpicker('refresh');  

		$("#CuentaContable_notaCreditoId").val(data.CuentaContable_notaCreditoId); 
		$("#CuentaContable_notaCreditoId").selectpicker('refresh');  

		$("#CuentaContable_comprasId").val(data.CuentaContable_comprasId); 
		$("#CuentaContable_comprasId").selectpicker('refresh');     								
                 
 	})
}

//Función para desactivar registros
function desactivar(idTipoImpuesto)
{
	bootbox.confirm("¿Está Seguro de desactivar este impuesto?", function(result){
		if(result)
        {
        	$.post("../ajax/tipoImpuesto.php?op=desactivar", {idTipoImpuesto : idTipoImpuesto}, function(e){
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
function activar(idTipoImpuesto)
{
	bootbox.confirm("¿Está Seguro de activar este impuesto?", function(result){
		if(result)
        {
        	$.post("../ajax/categoria.php?op=activar", {idTipoImpuesto : idTipoImpuesto}, function(e){
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