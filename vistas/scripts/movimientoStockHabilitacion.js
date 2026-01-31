var tabla;
var contTP = 0;
var detallesTP = 0;
var formatNumber = {
 separador: ".", // separador para los miles
 sepDecimal: ',', // separador para los decimales
 formatear:function (num){
 num +='';
 var splitStr = num.split('.');
 var splitLeft = splitStr[0];
 var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
 var regx = /(\d+)(\d{3})/;
 while (regx.test(splitLeft)) {
 splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
 }
 return this.simbol + splitLeft +splitRight;
 },
 new:function(num, simbol){
 this.simbol = simbol ||'';
 return this.formatear(num);
 }
}

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
	$.post("../ajax/movimientoStock.php?op=selectDepositoOrigenHabilitacion", function(r){
	            $("#Deposito_idDepositoOrigen").html(r);
	            $('#Deposito_idDepositoOrigen').selectpicker('refresh');

	            $("#Deposito_idDeposito_Origen").html(r);
	            $('#Deposito_idDeposito_Origen').selectpicker('refresh');


	});

	//Cargamos los items al select categoria
	$.post("../ajax/movimientoStock.php?op=selectDepositoDestinoHabilitacion", function(r){
	            $("#Deposito_idDepositoDestino").html(r);
	            $('#Deposito_idDepositoDestino').selectpicker('refresh');

	            $("#Deposito_idDeposito_Destino").html(r);
	            $('#Deposito_idDeposito_Destino').selectpicker('refresh');	            

	});

 

	$("#imagenmuestra").hide();
}

//Función limpiar
function limpiar()
{
	$("#idMovimientoStockDetalle").val("");
	$("#MovimientoStock_idMovimientoStock").val(""); 
	$("#Articulo_idArticulo").val("");
	$("#cantidad").val("");
	$("#precio").val("");
	$("#total").val("");

	$("#idMovimientoStock").val(""); 
	$("#Deposito_idDepositoDestino").val("");
	$("#Deposito_idDepositoOrigen").val("");
	$("#comentario").val("");
	$("#fechaTransaccion").val("");	
	$("#total").val(""); 
	$("#cantidadTotal").val("");
		
	detallesTP=0;
	contTP=0
	$(".filasTP").remove();

}


function crud(ventana){
	window.open("../vistas/"+ ventana +".php", "Diseño Web", "width=600, height=600");
}


function mostrarDetalleMovimientoStockDetalle(MovimientoStock_idMovimientoStock){ 
	$('#modal_detalle').modal('show');
	$("#detalle4").val(MovimientoStock_idMovimientoStock);  
$(document).ready(function() {
    $('#tbllistado4').DataTable( {
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
					url: '../ajax/consultas.php?op=rpt_movimiento_stock',
					data:{MovimientoStock_idMovimientoStock:MovimientoStock_idMovimientoStock}, 
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
  			"columnDefs": [
            {
                "targets": [ 3 ],
                "visible": true,
                "searchable": false
            }],

                    "language": {
            "decimal": ".",
            "thousands": ","
        },
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación
	    "order": [[ 3, "desc" ],[ 3, "desc" ]],//Ordenar (columna,orden)

        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$.]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over this page
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseFloat(intVal(a)) + parseFloat(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 3 ).footer() ).html(
               formatNumber.new(pageTotal) 
            );
        }
    } );
} );
}


//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#cabecera").hide();			
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#cabecera").show();		
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
					url: '../ajax/movimientoStock.php?op=listar',
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



//Función Listar
function filtrar()
{


	var Deposito_idDeposito_Origen = $('#Deposito_idDeposito_Origen').val();
	var fi = $('#fi').val();
	var ff = $('#ff').val();
	var estado = $('#estado').val();
	var Deposito_idDeposito_Destino = $('#Deposito_idDeposito_Destino').val();
	 


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
					url: '../ajax/movimientoStock.php?op=filtrar',
					type : "get",
					data : { Deposito_idDeposito_Origen:Deposito_idDeposito_Origen,Deposito_idDeposito_Destino:Deposito_idDeposito_Destino, 
							 fi:fi,ff:ff, estado:estado},
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					} 
				},
		"bDestroy": true,
		"iDisplayLength": 50,//Paginación
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
		url: "../ajax/movimientoStock.php?op=guardaryeditar",
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

function mostrar(idMovimientoStock)
{
	$.post("../ajax/movimientoStock.php?op=mostrar",{idMovimientoStock : idMovimientoStock}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

 		$("#idMovimientoStock").val(data.idMovimientoStock);
		$("#Deposito_idDepositoDestino").val(data.Deposito_idDepositoDestino);
		$("#Deposito_idDepositoOrigen").val(data.Deposito_idDepositoOrigen);
		$("#comentario").val(data.comentario);	
		$("#fechaTransaccion").val(data.fechaTransaccion);	
		$("#totalC").val(data.total);	
		$("#cantidadTotal").val(data.cantidadTotal); 

	 	$.post("../ajax/movimientoStock.php?op=listarDetalleMovimientoStock&idMovimientoStock="+idMovimientoStock,function(r){
		        $("#detalle").html(r);
		});	
  
		$("#MovimientoStock_idMovimientoStock").removeAttr("required"); 
		$("#Articulo_idArticulo").removeAttr("required");
		$("#cantidad").removeAttr("required");
		$("#precio").removeAttr("required");
		$("#total").removeAttr("required"); 

 	})
}

function detalle(idMovimientoStock){
	$('#modal_detalle').modal('show');
	$("#detalle").val(idMovimientoStock);
$(document).ready(function() {
    $('#tbllistado4').DataTable( {
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
					url: '../ajax/movimientoStock.php?op=detalle',
					data:{idMovimientoStock:idMovimientoStock},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación
	    "order": [[ 3, "desc" ],[ 3, "desc" ]]
    } );
} );
}


function agregarDetalle(idArticulo, nombre)
  {
   	 
	var Articulo_idArticulo =  idArticulo;//$("#Articulo_idArticulo option:selected").val();
  	var Articulo_idArticulo_text = nombre;//$("#Articulo_idArticulo option:selected").text();
   
	var cantidad = 0;//$("#cantidad").val();
	//var precio = 0;//$("#precio").val();
	//var total = 0;//$("#total").val();
                                        
	var fila=
	'<tr class="filasTP" id="filaTP'+contTP+'">'+
	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleMovimientoStock ('+contTP+',0)">X</button></td>'+
	'<td><input type="hidden" name="Articulo_idArticulo[]" value="'+Articulo_idArticulo+'">'+Articulo_idArticulo_text+'</td>'+
	'<td><input type="number" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
	'</tr>';
	contTP++;
	detallesTP=detallesTP+1;
	$('#detalle').append(fila);
	$("#btnGuardar").prop("disabled",false);

	//modificarSubototales();
  }

  function eliminarDetalleMovimientoStock(indice, valor){


  	if (valor > 0) {
        	$.post("../ajax/movimientoStock.php?op=desactivarDetalleMovimientoStock", {idMovimientoStockDetalle : valor}, function(e){   										 
        		console.log('eliminado de base de datos');
        	});	
  	}
	
	$("#filaTP" + indice).remove();
    detallesTP=detallesTP-1;
    if (document.getElementsByName("Articulo_idArticulo[]").length <= 0) {
				$("#btnGuardar").prop("disabled",true);
    }    		
  }


//Función para enviar registros
function enviarTransito(idMovimientoStock)
{
swal({
	  title: 'Esta seguro de enviar el movimiento?',
	  text: "",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si!'
	}).then((result) => {
	  if (result.value) {
        	$.post("../ajax/movimientoStock.php?op=enviarTransito", {idMovimientoStock : idMovimientoStock}, function(e){
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


//Función para desactivar registros
function desactivar(idMovimientoStock)
{
swal({
	  title: 'Esta seguro de desactivar el movimiento?',
	  text: "",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si!'
	}).then((result) => {
	  if (result.value) {
        	$.post("../ajax/movimientoStock.php?op=desactivar", {idMovimientoStock : idMovimientoStock}, function(e){
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
function activar(idMovimientoStock)
{
swal({
	  title: 'Esta seguro de reactivar el movimiento?',
	  text: "",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si!'
	}).then((result) => {
	  if (result.value) {
        	$.post("../ajax/movimientoStock.php?op=activar", {idMovimientoStock : idMovimientoStock}, function(e){
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