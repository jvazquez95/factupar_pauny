var tabla;
var contT = 0;
var detallesTP = 0;
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
	$.post("../ajax/ajusteStock.php?op=selectDeposito", function(r){ 
	            $("#Deposito_IdDeposito").html(r);
	            $('#Deposito_IdDeposito').selectpicker('refresh');             

	});  

	//Cargamos los items al select categoria
	$.post("../ajax/ajusteStock.php?op=selectArticulo", function(r){
	            $("#Articulo_idArticulo").html(r);
	            $('#Articulo_idArticulo').selectpicker('refresh');

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
					url: '../ajax/ajusteStock.php?op=listar',
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
		url: "../ajax/ajusteStock.php?op=guardaryeditar",
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
	$.post("../ajax/ajusteStock.php?op=mostrar",{idAjusteStock : idAjusteStock}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#idAjusteStock").val(data.idAjusteStock);
		$("#Deposito_IdDeposito").val(data.Deposito_IdDeposito);
        $('#Deposito_IdDeposito').selectpicker('refresh');             
		$("#comentario").val(data.comentario);


 	})

	$.post("../ajax/ajusteStock.php?op=listarDetalle&idAjusteStock="+idAjusteStock,function(r){
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

				        	$.post("../ajax/ajusteStock.php?op=desactivarDetalle", {idAjusteStockDetalle : valor}, function(e){
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
	  title: 'Esta seguro de desactivar el ajuste?',
	  text: "",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si!'
	}).then((result) => {
	  if (result.value) {
        	$.post("../ajax/ajusteStock.php?op=desactivar", {idAjusteStock : idAjusteStock}, function(e){
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
        	$.post("../ajax/ajusteStock.php?op=activar", {idAjusteStock : idAjusteStock}, function(e){
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