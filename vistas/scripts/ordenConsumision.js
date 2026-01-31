var tabla;
var cont = 0;
var precioServicioPaquete = 0;
var detalles = 0;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
$("#paquetedetalle").hide();
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	//Cargamos los items al select cliente
	$.post("../ajax/venta.php?op=selectCliente", function(r){
	            $("#Cliente_idCliente").html(r);
	            $('#Cliente_idCliente').selectpicker('refresh');
	});	


	//Cargamos los items al select cliente
	$.post("../ajax/ordenConsumision.php?op=selectEmpleado", function(r){
	            $("#Empleado_idEmpleado").html(r);
	            $('#Empleado_idEmpleado').selectpicker('refresh');
	});	


}


function mostrarDetallePaquete(){
	var seleccion = $("#tipoArticulo").val();
	if (seleccion == 'PAQUETE') {
		$("#paquetedetalle").show();
	}else{
		$("#paquetedetalle").hide();
	}
}

//Función limpiar
function limpiar()
{
	$("#idArticulo").val("");
	$("#nombre").val("");
	$("#descripcion").val("");
	$("#codigo").val("");
	$("#codigoBarra").attr("src","");
	$("#codigoAlternativo").val("");
	$("#print").hide();
	$("#GrupoArticulo_idGrupoArticulo").val("1");
	$("#Categoria_idCategoria").val("1");
	$("#TipoImpuesto_idTipoImpuesto").val("1");
	$("#Unidad_idUnidad").val("1");
	$("#precioVenta").val("");
	$("#usuarioInsersion").val("");
	$("#usuarioModificacion").val("");
	$("#imagen").val("");
	$("#imagenactual").val("");
	$("#comisiongs").val("");
	$("#comisionp").val("");
	$(".filas").remove();
}

function cargarPS(){

	var lcliente = $('#Cliente_idCliente').val();
	//Cargamos los items al select cliente
	$.post("../ajax/ordenConsumision.php?op=selectPaqueteCliente",{lcliente:lcliente}, function(r){
	            $("#Articulo_idArticulo").html(r);
	            $('#Articulo_idArticulo').selectpicker('refresh');
	});	

	//Cargamos los items al select cliente
	$.post("../ajax/ordenConsumision.php?op=selectServicioCliente",{lcliente:lcliente}, function(r){
	            $("#Articulo_idArticulo_Servicio").html(r);
	            $('#Articulo_idArticulo_Servicio').selectpicker('refresh');
	});	
}

function cargarS(){

	var lcliente = $('#Cliente_idCliente').val();
	var lpaquete = $('#Articulo_idArticulo').val();

if(lpaquete == '000'){
	//Cargamos los items al select cliente
	$.post("../ajax/ordenConsumision.php?op=selectServicioCliente",{lcliente:lcliente}, function(r){
	            $("#Articulo_idArticulo_Servicio").html(r);
	            $('#Articulo_idArticulo_Servicio').selectpicker('refresh');
	});	
}else{
	//Cargamos los items al select cliente
	$.post("../ajax/ordenConsumision.php?op=selectServicioClientePaquete",{lcliente:lcliente,lpaquete:lpaquete}, function(r){
	            $("#Articulo_idArticulo_Servicio").html(r);
	            $('#Articulo_idArticulo_Servicio').selectpicker('refresh');
	});	
}
}


function mostrarDetalle(id){
	$('#myModal').modal('show');
	//$("#detalle").val(idVenta);
$(document).ready(function() {
    $('#tbldetalle').DataTable( {
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
					url: '../ajax/ordenConsumision.php?op=listarDetalle',
					data:{id:id},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación
	    "order": [[ 1, "desc" ],[ 2, "desc" ]]//Ordenar (columna,orden)

    } );
} );
}



//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();

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
	document.getElementById("btnGuardar").disabled = true;

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
					url: '../ajax/ordenConsumision.php?op=listar',
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

function agregarDetalle()
  {

	var lpaquete = $("#Articulo_idArticulo option:selected").val();
  	var lpaquete_nombre = $("#Articulo_idArticulo option:selected").text();

	var lservicio = $("#Articulo_idArticulo_Servicio option:selected").val();
  	var lservicio_nombre = $("#Articulo_idArticulo_Servicio option:selected").text();

	var lcantidad = $("#cantidad").val();
	var lempleado = $("#Empleado_idEmpleado option:selected").val();
	var lempleado_nombre = $("#Empleado_idEmpleado option:selected").text();

	var cantidad_utilizada = 0;
	var terminado = 0;

	var lfi = $("#fi").val();
	var lff = $("#ff").val();
	var lsala = $("#sala").val();
	var lsala_nombre = $("#sala option:selected").text();


    	var fila='<tr class="filas class="input-sm"" id="fila'+cont+'">'+
    	'<td width="1%"><button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td width="9%"><input type="hidden" class="form-control input-sm" name="idPaquete[]" value="'+lpaquete+'">'+lpaquete_nombre+'</td>'+
    	'<td width="25%"><input type="hidden" class="form-control input-sm" name="idServicio[]" value="'+lservicio+'">'+lservicio_nombre+'</td>'+
    	'<td width="10%"><input type="number" class="form-control input-sm" name="cantidad[]" id="cantidad[]" value="'+lcantidad+'"></td>'+
    	'<td width="10%"><input type="number" class="form-control input-sm" name="cantidad_utilizada[]" id="cantidad_utilizada[]" value="'+cantidad_utilizada+'"></td>'+
    	'<td width="25%"><input type="hidden" class="form-control input-sm" name="idEmpleado[]" value="'+lempleado+'">'+lempleado_nombre+'</td>'+
    	'<td width="40%"><input type="hidden" class="form-control input-sm" name="terminado[]" value="'+terminado+'">'+terminado+'</td>'+
    	'<td width="40%"><input type="hidden" class="form-control input-sm" name="fi[]" value="'+lfi+'">'+lfi+'</td>'+
    	'<td width="40%"><input type="hidden" class="form-control input-sm" name="ff[]" value="'+lff+'">'+lff+'</td>'+
    	'<td width="40%"><input type="hidden" class="form-control input-sm" name="sala[]" value="'+lsala+'">'+lsala_nombre+'</td>'+
    	'</tr>';
    	cont++;
    	detalles=detalles+1;
		document.getElementById("btnGuardar").disabled = false;
    	$('#detalles').append(fila);

  }

  function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	detalles=detalles-1;
  	if (detalles <= 0) {
		document.getElementById("btnGuardar").disabled = true;
  	}
  }

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/ordenConsumision.php?op=guardaryeditar",
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

function mostrar(idArticulo)
{
	$.post("../ajax/articulo.php?op=mostrar",{idArticulo : idArticulo}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

	$("#nombre").val(data.nombre);
	$("#descripcion").val(data.descripcion);
	$("#codigo").val(data.codigo);
	$("#codigoBarra").val(data.codigoBarra);
 	generarbarcode();
	$("#codigoAlternativo").val(data.codigoAlternativo);
	$("#print").hide();
	$("#tipoArticulo").val(data.tipoArticulo);
	$("#GrupoArticulo_idGrupoArticulo").val(data.GrupoArticulo_idGrupoArticulo);
	$("#Categoria_idCategoria").val(data.Categoria_idCategoria);
	$("#TipoImpuesto_idTipoImpuesto").val(data.TipoImpuesto_idTipoImpuesto);
	$("#Unidad_idUnidad").val(data.Unidad_idUnidad);
	$("#precioVenta").val(data.precioVenta);
	$("#usuarioInsersion").val(data.usuarioInsersion);
	$("#usuarioModificacion").val(data.usuarioModificacion);
	//$("#imagen").val(data.imagen);
	$("#imagenmuestra").show();
	$("#imagenmuestra").attr("src","../files/articulos/"+data.imagen);
	$("#imagenactual").val(data.imagen);
	$("#idArticulo").val(data.idArticulo);
	$("#comisiongs").val(data.comisiongs);
	$("#comisionp").val(data.comisionp);

 	})
}

//Función para desactivar registros
function desactivar(idOrdenConsumision)
{
	bootbox.confirm("¿Está Seguro de anular la orden de consumision?", function(result){
		if(result)
        {
        	$.post("../ajax/ordenConsumision.php?op=desactivar", {idOrdenConsumision : idOrdenConsumision}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idArticulo)
{
	bootbox.confirm("¿Está Seguro de activar el Artículo?", function(result){
		if(result)
        {
        	$.post("../ajax/articulo.php?op=activar", {idArticulo : idArticulo}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//función para generar el código de barras
function generarbarcode()
{
	codigo=$("#codigoBarra").val();
	JsBarcode("#barcode", codigo);
	$("#print").show();
}

//Función para imprimir el Código de barras
function imprimir()
{
	$("#print").printArea();
}

init();