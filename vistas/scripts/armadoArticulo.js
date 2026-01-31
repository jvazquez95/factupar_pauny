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
	$.post("../ajax/armadoArticulo.php?op=selectArticulo", function(r){
	            $("#Articulo_idArticulo").html(r);
	            $('#Articulo_idArticulo').selectpicker('refresh');

	 
	            $("#Articulo_idArticulo1").html(r);
	            $('#Articulo_idArticulo1').selectpicker('refresh');

	});


	$("#imagenmuestra").hide();
}

//Función limpiar
function limpiar()
{
	$("#idArmadoArticulo").val("");
	$("#usuario").val("");  
	$("#comentario").val("");
	$("#fechaTransaccion").val("");
	$("#costoTotal").val("");
	$("#cantidadTotal").val("");  
	$("#idArmadoArticuloDetalle").val(""); 
	$("#AjusteSTock_idArmadoArticulo").val("");
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
					url: '../ajax/armadoArticulo.php?op=listar',
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
		url: "../ajax/armadoArticulo.php?op=guardaryeditar",
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

function mostrar(idArmadoArticulo) 
{
	$.post("../ajax/armadoArticulo.php?op=mostrar",{idArmadoArticulo : idArmadoArticulo}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#idArmadoArticulo").val(data.idArmadoArticulo);
		$("#comentario").val(data.comentario);


 	})

	$.post("../ajax/armadoArticulo.php?op=listarDetalle&idArmadoArticulo="+idArmadoArticulo,function(r){
	        $("#detalleArmadoArticulo").html(r);
	});	
}


function addDetalleArmadoArticulo()
  {
   	 
	var Articulo_idArticulo1 = $("#buscar_articulo1 option:selected").val();
  	var Articulo_idArticulo_text1 = $("#buscar_articulo1 option:selected").text();
  	   	 
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
	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleArmadoArticulo ('+contT+', 0)">X</button></td>'+
	'<td><input type="hidden" name="Articulo_idArticulo[]" value="'+Articulo_idArticulo+'">'+Articulo_idArticulo_text+'</td>'+
	'<td><input type="hidden" name="cantidad[]" id="cantidad[]" value="'+cantidad+'">'+cantidad+'</td>'+
	'<td><input type="hidden" name="costo[]" id="costo[]" value="'+costo+'">'+costo+'</td>'+
	'<td><input type="hidden" name="subtotal[]" id="subtotal[]" value="'+subtotal+'">'+subtotal+'</td>'+	
	'<td><input type="hidden" name="Articulo_idArticulo1[]" value="'+Articulo_idArticulo1+'"></td>'+		
	'</tr>';
	contT++;
	detallesTP=detallesTP+1;
	$('#detalleArmadoArticulo').append(fila);
	//modificarSubototales();
  }


  function eliminarDetalleArmadoArticulo(indice,valor){

				if (valor > 0) {

				        	$.post("../ajax/armadoArticulo.php?op=desactivarDetalle", {idArmadoArticuloDetalle : valor}, function(e){
				        	});
				}	

		    $("#filaT" + indice).remove();
		  	detallesTP=detallesTP-1;

			if(document.getElementsByName("Articulo_idArticulo[]").length <=0){
							$("#btnGuardar").prop("disabled",true);
					  	}


        }



//Función para desactivar registros
function desactivar(idArmadoArticulo)
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
        	$.post("../ajax/armadoArticulo.php?op=desactivar", {idArmadoArticulo : idArmadoArticulo}, function(e){
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
function activar(idArmadoArticulo)
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
        	$.post("../ajax/armadoArticulo.php?op=activar", {idArmadoArticulo : idArmadoArticulo}, function(e){
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