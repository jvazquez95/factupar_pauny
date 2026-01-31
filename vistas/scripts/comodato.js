var tabla;
var contT = 0;
var detallesTP = 0;
var g_idCliente = 0;
//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)   
	{
		guardaryeditar(e);	
	})

	//Cargamos los items al select grupo

	//Cargamos los items al select categoria
	$.post("../ajax/comodato.php?op=selectDeposito", function(r){ 
	            $("#Deposito_IdDeposito").html(r);
	            $('#Deposito_IdDeposito').selectpicker('refresh');             

	});  

	//Cargamos los items al select categoria
	$.post("../ajax/comodato.php?op=selectArticulo", function(r){
	            $("#Articulo_idArticulo").html(r);
	            $('#Articulo_idArticulo').selectpicker('refresh');

	});

	$.post("../ajax/persona.php?op=selectDirecciones", { idPersona: g_idCliente } , function(r){
	            $("#Direccion_idDireccion").html(r);
	            $('#Direccion_idDireccion').selectpicker('refresh');
	});	


	$("#imagenmuestra").hide();
}

//Función limpiar
function limpiar()
{
	$("#idAjusteStock").val("");
	$("#usuario").val(""); 
	$("#Deposito_IdDeposito").val("");
	$("#comentario").val("");
	$("#fechaTransaccion").val("");
	$("#costoTotal").val("");
	$("#cantidadTotal").val("");  
	$("#idAjusteStockDetalle").val(""); 
	$("#AjusteSTock_idAjusteStock").val("");
	$("#Articulo_idArticulo").val("");
	$("#cantidad").val("");
	$("#costo").val("");
	$("#subtotal").val(""); 
	$("#imagen").val("");
	$("#imagenactual").val("");	
	detallesTP=0;
	contT=0
	$(".filasTP").remove();

}


function crud(ventana){
	window.open("../vistas/"+ ventana +".php", "Diseño Web", "width=600, height=600");
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

//Función para enviar registros
function enviarTransito(idAjusteStock)
{
swal({
	  title: 'Esta seguro de confirmar el registro?', 
	  text: "",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si!'
	}).then((result) => {
	  if (result.value) {
        	$.post("../ajax/comodato.php?op=enviarTransito", {idAjusteStock : idAjusteStock}, function(e){
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
					url: '../ajax/comodato.php?op=listar',
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


function noCambiar(){
	//esta funcion solo se activa si la factura se genera desde una orden de venta.
	var l_persona = 0;
	if (g_idCliente > 0) {

    $.ajax({
    type: "POST",
    url: "../ajax/persona.php?op=selectClienteLimit",
    data:{keyword:idPersona, tipoPersona: 1},
    success: function(data){
      $("select.selector_persona ").html(data);
      $("select.selector_persona").selectpicker("refresh");
    
		$("#Cliente_idCliente").val(idPersona);
		$("#Cliente_idCliente").selectpicker('refresh');
		l_persona = data;
    },
    error: function(data){
        console.log("NO se pudo enviar");
    }
    }); 


	$("#Cliente_idCliente").val(g_idCliente);
	$("#Cliente_idCliente").selectpicker('refresh');

	} 

	$.post("../ajax/persona.php?op=selectDirecciones", { idPersona: $("#Cliente_idCliente").val() } , function(r){
        $("#Direccion_idDireccion").html(r);
        $('#Direccion_idDireccion').selectpicker('refresh');
	});	 
	
}

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/comodato.php?op=guardaryeditar",
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

function mostrar(idAjusteStock) 
{
	$.post("../ajax/comodato.php?op=mostrar",{idAjusteStock : idAjusteStock}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#idAjusteStock").val(data.idAjusteStock);
		$("#Deposito_IdDeposito").val(data.Deposito_IdDeposito);
        $('#Deposito_IdDeposito').selectpicker('refresh');             
		$("#comentario").val(data.comentario);


 	})

	$.post("../ajax/comodato.php?op=listarDetalle&idAjusteStock="+idAjusteStock,function(r){
	        $("#detalleAjusteStock").html(r);
	});	
}


function addDetalleAjusteStock()
  {
   	 
	var Articulo_idArticulo = $("#buscar_articulo option:selected").val();
  	var Articulo_idArticulo_text = $("#buscar_articulo option:selected").text();
  
	var cantidad = $("#cantidad").val();
	var costo = $("#costo").val();
	var subtotal = $("#subtotal").val();



	if (Articulo_idArticulo == '' || cantidad == '') {
		alert('Cargar todos los datos');
		return;
	}


	var fila=
	'<tr class="filasT" id="filaT'+contT+'">'+
	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleAjusteStock ('+contT+', 0)">X</button></td>'+
	'<td><input type="hidden" name="Articulo_idArticulo[]" value="'+Articulo_idArticulo+'">'+Articulo_idArticulo_text+'</td>'+
	'<td><input type="hidden" name="cantidad[]" id="cantidad[]" value="'+cantidad+'">'+cantidad+'</td>'+
	'<td><input type="hidden" name="costo[]" id="costo[]" value="'+costo+'">'+costo+'</td>'+
	'<td><input type="hidden" name="subtotal[]" id="subtotal[]" value="'+subtotal+'">'+subtotal+'</td>'+				
	'</tr>';
	contT++;
	detallesTP=detallesTP+1;
	$('#detalleAjusteStock').append(fila);
	//modificarSubototales();
  }


  function eliminarDetalleAjusteStock(indice,valor){

				if (valor > 0) {

				        	$.post("../ajax/comodato.php?op=desactivarDetalle", {idAjusteStockDetalle : valor}, function(e){
				        	});
				}	

		    $("#filaT" + indice).remove();
		  	detallesTP=detallesTP-1;

			if(document.getElementsByName("Articulo_idArticulo[]").length <=0){
							$("#btnGuardar").prop("disabled",true);
					  	}


        }



//Función para desactivar registros
function desactivar(idAjusteStock)
{
swal({
	  title: 'Esta seguro de desactivar el registro?',
	  text: "", 
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si!'
	}).then((result) => {
	  if (result.value) {
        	$.post("../ajax/comodato.php?op=desactivar", {idAjusteStock : idAjusteStock}, function(e){
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
function activar(idAjusteStock)
{
swal({
	  title: 'Esta seguro de activar el ajuste?',
	  text: "",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si!'
	}).then((result) => {
	  if (result.value) {
        	$.post("../ajax/comodato.php?op=activar", {idAjusteStock : idAjusteStock}, function(e){
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

function imagenTest(x) {
	$("#imagenmuestra").attr("src",URL.createObjectURL(x.files[0]));
	$("#imagenmuestra").show();

}

init();