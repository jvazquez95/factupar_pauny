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
	$.post("../ajax/notaCreditoCompra.php?op=selectProveedor", function(r){
	            $("#Persona_idPersona").html(r);
	            $('#Persona_idPersona').selectpicker('refresh');

	});

	//Cargamos los items al select categoria
	$.post("../ajax/notaCreditoCompra.php?op=selectHabilitacion", function(r){
	            $("#Habilitacion_idhabilitacion").html(r);
	            $('#Habilitacion_idhabilitacion').selectpicker('refresh');

	}); 

	//Cargamos los items al select categoria 
	$.post("../ajax/notaCreditoCompra.php?op=selectCompra", function(r){
	            $("#Compra_idCompra").html(r);
	            $('#Compra_idCompra').selectpicker('refresh'); 
 
	});


	//Cargamos los items al select categoria
	$.post("../ajax/notaCreditoCompra.php?op=selectArticulo", function(r){
	            $("#Articulo_idArticulo").html(r);
	            $('#Articulo_idArticulo').selectpicker('refresh');

	});

	$("#imagenmuestra").hide();
}

//Función limpiar
function limpiar()
{
	$("#idNotaCreditoCompra").val("");
	$("#Compra_idCompra").val(""); 
	$("#Persona_idPersona").val("");
	$("#Habilitacion_idhabilitacion").val("");
	$("#CuentaContable_idCuentaContable").val("");
	$("#tipoComprobante").val("");
	$("#nroDevolucion").val(""); 
	$("#nroFactura").val("");
	$("#fechaTransaccion").val("");
	$("#fechaVencimiento").val("");
	$("#timbrado").val("");	
	$("#vtoTimbrado").val(""); 
	$("#totalImpuesto").val("");
	$("#totalC").val("");
	$("#subTotal").val("");
	$("#idNotaCreditoCompraDetalle").val("");
	$("#NotaCreditoCompra_idNotaCreditoCompra").val("");
	$("#Articulo_idArticulo").val("");
	$("#cantidad").val("");	
	$("#devuelve").val("");	
	$("#totalNeto").val("");	
	$("#total").val(""); 
	
	detallesTP=0;
	contTP=0
	$(".filasTP").remove();

}


function crud(ventana){
	window.open("../vistas/"+ ventana +".php", "Diseño Web", "width=600, height=600");
}


function mostrarDetalleNotaCreditoCompra(NotaCreditoCompra_idNotaCreditoCompra){
	$('#modal_detalle').modal('show');
	$("#detalle4").val(NotaCreditoCompra_idNotaCreditoCompra);  
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
					url: '../ajax/consultas.php?op=rpt_notacreditocompra_detalle',
					data:{NotaCreditoCompra_idNotaCreditoCompra:NotaCreditoCompra_idNotaCreditoCompra},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					} 
				},
  			"columnDefs": [
            {
                "targets": [ 4 ],
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
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseFloat(intVal(a)) + parseFloat(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
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
					url: '../ajax/notaCreditoCompra.php?op=listar',
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
		url: "../ajax/notaCreditoCompra.php?op=guardaryeditar",
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

function mostrar(idNotaCreditoCompra) 
{
	$.post("../ajax/notaCreditoCompra.php?op=mostrar",{idNotaCreditoCompra : idNotaCreditoCompra}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#idNotaCreditoCompraDetalle").val(data.idNotaCreditoCompraDetalle);
		$("#NotaCreditoCompra_idNotaCreditoCompra").val(data.NotaCreditoCompra_idNotaCreditoCompra); 
		$("#Articulo_idArticulo").val(data.Articulo_idArticulo);
		$("#cantidad").val(data.cantidad);
		$("#devuelve").val(data.devuelve);
		$("#totalNeto").val(data.totalNeto);
		$("#total").val(data.total);  
		$("#idNotaCreditoCompra").val(data.idNotaCreditoCompra);
		$("#Compra_idCompra").val(data.Compra_idCompra);
		$("#Persona_idPersona").val(data.Persona_idPersona);
		$("#Habilitacion_idhabilitacion").val(data.Habilitacion_idhabilitacion);	
		$("#usuario").val(data.usuario); 
		$("#tipoComprobante").val(data.tipoComprobante);
		$("#nroDevolucion").val(data.nroDevolucion);
		$("#nroFactura").val(data.nroFactura);
		$("#fechaTransaccion").val(data.fechaTransaccion);
		$("#fechaVencimiento").val(data.fechaVencimiento);
		$("#timbrado").val(data.timbrado);
		$("#vtoTimbrado").val(data.vtoTimbrado);	
		$("#totalImpuesto").val(data.totalImpuesto);	
		$("#totalC").val(data.totalC);	
		$("#subTotal").val(data.subTotal);   

	 	$.post("../ajax/notaCreditoCompra.php?op=listarDetalleNotaCreditoCompra&idNotaCreditoCompra="+idNotaCreditoCompra,function(r){
		        $("#detalle").html(r);
		});			
	 	$('#Articulo_idArticulo').removeAttr("required");
	 	$('#cantidad').removeAttr("required");
	 	$('#devuelve').removeAttr("required");
	 	$('#totalNeto').removeAttr("required");
	 	$('#total').removeAttr("required");  			
 	})
}


function addDetalleNotaCreditoCompra(idArticulo,dnombre,cantidad)
  {
   	 
	var Articulo_idArticulo = idArticulo;//$("#buscar_articulo option:selected").val();
  	var Articulo_idArticulo_text = dnombre;//$("#buscar_articulo option:selected").text();
  
	var cantidad = 0;//$("#cantidad").val();
	
	var fila=
	'<tr class="filasTP" id="filaTP'+contTP+'">'+
	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleNotaCreditoCompra ('+contTP+')">X</button></td>'+
	'<td><input type="hidden" name="Articulo_idArticulo[]" value="'+Articulo_idArticulo+'">'+Articulo_idArticulo_text+'</td>'+
	'<td><input type="number" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+ 	
	'<td><input type="hidden" name="idNotaCreditoCompraDetalle[]" id="idNotaCreditoCompraDetalle[]" value="0"></td>'+ 			
	'</tr>';
	contTP++;
	detallesTP=detallesTP+1;
	$('#detalle').append(fila);
	//modificarSubototales();
  }


  function eliminarDetalleNotaCreditoCompra(indice){
  	bootbox.confirm("¿Está Seguro de eliminar el precio?", function(result){
		if(result)
	    { 
	    		
			var notacreditocompradetalle = document.getElementsByName("idNotaCreditoCompraDetalle[]");
			var idNotaCreditoCompraDetalle = notacreditocompradetalle[indice].value;
				alert(indice);
	    	$.post("../ajax/notaCreditoCompra.php?op=desactivarDetalleNotaCreditoCompra", {idNotaCreditoCompraDetalle : idNotaCreditoCompraDetalle}, function(e){   
	    		bootbox.alert(e);
	            tabla.ajax.reload(); 
	    	});	

		  	$("#filaTP" + indice).remove(); 
		  	detallesTP=detallesTP-1; 
	    } 	 
	  })
	}  
//Función para desactivar registros
function desactivar(idNotaCreditoCompra)
{
	bootbox.confirm("¿Está Seguro de desactivar el Nota de Credito Compra?", function(result){
		if(result)
        {
        	$.post("../ajax/notaCreditoCompra.php?op=desactivar", {idNotaCreditoCompra : idNotaCreditoCompra}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idNotaCreditoCompra) 
{
	bootbox.confirm("¿Está Seguro de activar el Nota de Credito Compra?", function(result){
		if(result)
        {
        	$.post("../ajax/notaCreditoCompra.php?op=activar", {idNotaCreditoCompra : idNotaCreditoCompra}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}



init();