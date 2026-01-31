var tabla;
var contTP = 0;
var detallesTP = 0;
var t1 = 0;
var t2 = 0;
var importeDebito=0;
var importeCredito=0;	
var tdt1 = 0;
var tdt2 = 0;
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

	//Cargamos los items al select grupo

	//Cargamos los items al select categoria
	$.post("../ajax/banco.php?op=selectCuentaContable", function(r){
	            $("#CuentaContable_idCuentaContable").html(r);
	            $('#CuentaContable_idCuentaContable').selectpicker('refresh');

	});

	//Cargamos los items al select categoria
	$.post("../ajax/asiento.php?op=selectCuentaCorriente", function(r){
	            $("#CuentaCorriente_idCuentaCorriente").html(r);
	            $('#CuentaCorriente_idCuentaCorriente').selectpicker('refresh');

	});


	//Cargamos los items al select categoria
	$.post("../ajax/cuentaContable.php?op=selectCentroCosto", function(r){
	            $("#CentroCosto_idCentroCosto").html(r);
	            $('#CentroCosto_idCentroCosto').selectpicker('refresh');

	});

	//Cargamos los items al select categoria
	$.post("../ajax/cuentaBancaria.php?op=selectBanco", function(r){
	            $("#Banco_idBanco").html(r);
	            $('#Banco_idBanco').selectpicker('refresh');

	});


	//Cargamos los items al select categoria
	$.post("../ajax/cuentaContable.php?op=selectProceso", function(r){
	            $("#Proceso_idProceso").html(r);
	            $('#Proceso_idProceso').selectpicker('refresh');

	}); 

	//Cargamos los items al select categoria
	$.post("../ajax/banco.php?op=selectMoneda", function(r){
	            $("#Moneda_idMoneda").html(r);
	            $('#Moneda_idMoneda').selectpicker('refresh');

	});


	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	$("#imagenmuestra").hide();
}

//Función limpiar
function limpiar()
{
	$("#idAsientoDetalle").val("");
	$("#Proceso_idProceso").val(""); 
	$("#Asiento_idAsiento").val("");
	$("#item").val("");
	$("#CuentaContable_idCuentaContable").val("");
	$("#CuentaCorriente_idCuentaCorriente").val("");
	$("#tipoMovimiento").val(""); 
	$("#CentroCosto_idCentroCosto").val("");
	$("#importeDebito").val("");
	$("#importeCredito").val("");
	$("#tasaCambio").val("");
	$("#tasaCambioBases").val("");	
	$("#Concepto_idConcepto").val(""); 
	$("#tipoComprobante").val("");
	$("#nroComprobante").val("");
	$("#Banco_idBanco").val("");
	$("#nroCheque").val("");
	$("#idAsiento").val("");
	$("#Moneda_idMoneda").val("");
	$("#fechaAsiento").val("");	
	$("#fechaPlanilla").val("");	
	$("#transaccionOrigen").val("");	
	$("#nroOrigen").val("");
	$("#comentario").val("");	
	$("#total1").val("");

	detallesTP=0;
	contTP=0
	$(".filasTP").remove();

}

 
function crud(ventana){
	window.open("../vistas/"+ ventana +".php", "Diseño Web", "width=600, height=600");
}


function mostrarDetalleasientoDetalle(Asiento_idAsiento){
	$('#modal_detalle').modal('show');
	$("#detalle4").val(Asiento_idAsiento);  
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
					url: '../ajax/consultas.php?op=rpt_asiento_detalle',
					data:{Asiento_idAsiento:Asiento_idAsiento},   
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

            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseFloat(intVal(a)) + parseFloat(intVal(b));
                }, 0 );

            // Update footer
            $( api.column( 5 ).footer() ).html(
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
					url: '../ajax/asiento.php?op=listar',
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
	var importeDeb = document.getElementsByName("totalDebito[]");
	var impDeb = importeDeb[0].value;
	var importeCred = document.getElementsByName("totalCredito[]");
	var impCre = importeCred[0].value;
	t1 = parseFloat(t1) + parseFloat(impDeb);	
	t2 = parseFloat(t2) + parseFloat(impCre);
 
	if (t1 == t2) {
		e.preventDefault(); //No se activará la acción predeterminada del evento
		$("#btnGuardar").prop("disabled",true);

		var formData = new FormData($("#formulario")[0]);

		$.ajax({
			url: "../ajax/asiento.php?op=guardaryeditar",
		    type: "POST",
		    data: formData,
		    contentType: false,
		    processData: false,

		    success: function(datos)
		    {                    
				swal({
				  position: 'top-end',
				  type: 'success',
				  title: 'Generacion Exitosa!.',
				  showConfirmButton: false,
				  timer: 1500
				 });
				 mostrarform(false);	
				 tabla.ajax.reload();
		    }

		}); 
		limpiar();
	} else{
		swal({
		  position: 'top-end',
		  type: 'success',
		  title: 'El asiento no pudo ser guardado!.',
		  showConfirmButton: false,
		  timer: 1500
		 }); 
	}		 	
}

function mostrar(idAsiento)
{
	$.post("../ajax/asiento.php?op=mostrar",{idAsiento : idAsiento}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#Proceso_idProceso").val(data.Proceso_idProceso); 
		$("#Proceso_idProceso").selectpicker('refresh');  
		$("#idAsiento").val(data.idAsiento);
		$("#Moneda_idMoneda").val(data.Moneda_idMoneda);
		$("#Moneda_idMoneda").selectpicker('refresh'); 
		$("#fechaAsiento").val(data.fechaAsiento);	
		$("#fechaPlanilla").val(data.fechaPlanilla);	
		$("#transaccionOrigen").val(data.transaccionOrigen);	
		$("#nroOrigen").val(data.nroOrigen);
		$("#comentario").val(data.comentario);		

	 	$.post("../ajax/asiento.php?op=listarDetalleAsiento&idAsiento="+idAsiento,function(r){
		        $("#detalle").html(r);
		});	
 		
		$("#totalDebito").val(data.totalDebito);	
		$("#totalCredito").val(data.totalCredito);
	 	$('#CuentaContable_idCuentaContable').removeAttr("required");
	 	$('#CuentaCorriente_idCuentaCorriente').removeAttr("required");
	 	$('#tipoMovimiento').removeAttr("required");
	 	$('#CentroCosto_idCentroCosto').removeAttr("required");
	 	$('#importeDebito').removeAttr("required");
	 	$('#importeCredito').removeAttr("required");
	 	$('#tasaCambio').removeAttr("required");
	 	$('#tasaCambioBases').removeAttr("required");
	 	$('#tipoComprobante').removeAttr("required");
	 	$('#nroComprobante').removeAttr("required");
	 	$('#Banco_idBanco').removeAttr("required");
	 	$('#nroCheque').removeAttr("required");
	 	$('#item').removeAttr("required"); 
	 	$('#Concepto_idConcepto').removeAttr("required"); 
	 	$("#Concepto_idConcepto").selectpicker('refresh'); 

 	})
}
 


function addDetalleAsiento()
  {
   	 
	var CuentaContable_idCuentaContable = $("#CuentaContable_idCuentaContable option:selected").val();
  	var CuentaContable_idCuentaContable_text = $("#CuentaContable_idCuentaContable option:selected").text();

	var CuentaCorriente_idCuentaCorriente = $("#CuentaCorriente_idCuentaCorriente option:selected").val();
  	var CuentaCorriente_idCuentaCorriente_text = $("#CuentaCorriente_idCuentaCorriente option:selected").text();


	var CentroCosto_idCentroCosto = $("#CentroCosto_idCentroCosto option:selected").val();
  	var CentroCosto_idCentroCosto_text = $("#CentroCosto_idCentroCosto option:selected").text();

	var Banco_idBanco = $("#Banco_idBanco option:selected").val();
  	var Banco_idBanco_text = $("#Banco_idBanco option:selected").text();

 
	var item = $("#item").val();
	var tipoMovimiento = $("#tipoMovimiento option:selected").val();
	var tipoMovimientoDesc = $("#tipoMovimiento option:selected").text();
 	if (tipoMovimiento==1){
		importeDebito = $("#importe").val();
		importeCredito = 0;
		t1 = t1 + parseFloat(importeDebito); 
	}; 
 	if (tipoMovimiento==2){	
		  importeCredito = $("#importe").val();
		  importeDebito = 0;
		  t2 = t2 + parseFloat(importeCredito);
	}

	var tasaCambio = $("#tasaCambio").val(); 
	var tasaCambioBases = $("#tasaCambioBases").val();
	var Concepto_idConcepto = $("#Concepto_idConcepto").val();
	var tipoComprobante = $("#tipoComprobante").val(); 
	var nroComprobante = $("#nroComprobante").val();
	var nroCheque = $("#nroCheque").val();
	var totalImporte = $("#importe").val(); 
                                    
	var fila=
	'<tr class="filasTP" id="filaTP'+contTP+'">'+
	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleAsiento ('+contTP+')">X</button></td>'+
	'<td><input type="hidden" name="item[]" id="item[]" value="'+contTP+'">'+contTP+'</td>'+
	'<td><input type="hidden" name="CuentaContable_idCuentaContable[]" value="'+CuentaContable_idCuentaContable+'">'+CuentaContable_idCuentaContable_text+'</td>'+
	'<td><input type="hidden" name="CuentaCorriente_idCuentaCorriente[]" value="'+CuentaCorriente_idCuentaCorriente+'">'+CuentaCorriente_idCuentaCorriente_text+'</td>'+
	'<td><input type="hidden" name="tipoMovimiento[]" id="tipoMovimiento[]" value="'+tipoMovimiento+'">'+tipoMovimientoDesc+'</td>'+
	'<td><input type="hidden" name="CentroCosto_idCentroCosto[]" value="'+ CentroCosto_idCentroCosto+'">'+CentroCosto_idCentroCosto_text+'</td>'+
	'<td><input type="hidden" name="importeDebito[]" id="importeDebito[]" value="'+importeDebito+'">'+importeDebito+'</td>'+
	'<td><input type="hidden" name="importeCredito[]" id="importeCredito[]" value="'+importeCredito+'">'+importeCredito+'</td>'+
	'<td><input type="hidden" name="Banco_idBanco[]" value="'+ Banco_idBanco+'">'+Banco_idBanco_text+'</td>'+
	'<td><input type="hidden" name="nroCheque[]" id="nroCheque[]" value="'+nroCheque+'">'+nroCheque+'</td>'+	 				
	'<td><input type="hidden" name="tasaCambio[]" id="tasaCambio[]" value="'+tasaCambio+'">'+tasaCambio+'</td>'+
	'<td><input type="hidden" name="tasaCambioBases[]" id="tasaCambioBases[]" value="'+tasaCambioBases+'">'+tasaCambioBases+'</td>'+
	'<td><input type="hidden" name="Concepto_idConcepto[]" id="Concepto_idConcepto[]" value="'+Concepto_idConcepto+'">'+Concepto_idConcepto+'</td>'+
	'<td><input type="hidden" name="nroComprobante[]" id="nroComprobante[]" value="'+nroComprobante+'">'+nroComprobante+'</td>'+
	'<td><input type="hidden" name="tipoComprobante[]" id="tipoComprobante[]" value="'+tipoComprobante+'">'+tipoComprobante+'</td>'+
	'</td><td><input type="hidden" name="totalImporte[]" id="totalImporte[]" value="'+totalImporte+'"></td>'+
	'</td><td><input type="hidden" name="idAsientoDetalle[]" id="idAsientoDetalle[]" value="'+0+'"></td>'+
	'</tr>';
	contTP++;
	detallesTP=detallesTP+1;
	var t1t = formatNumber.new(t1);
	var t2t = formatNumber.new(t2);
	$('#detalle').append(fila);
 	$("#total1").html(" " + t1t );
	$("#total_ventan").val(t1t);
	$("#total1C").html(" " + t2t);
    $("#total_ventanC").val(t2t); 
  }

 
 
  function eliminarDetalleAsiento(indice){

	swal({
		  title: 'Esta seguro de desactivar la cuenta Contable?',
		  text: "",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Si, desactivar!'
		}).then((result) => 
		{
		  if (result.value) 
		  {
		  	var asientodetalled = document.getElementsByName("idAsientoDetalle[]");
			var idAsientoDetalle = asientodetalled[indice].value;
				$.ajax({
				    type: "post",
				    url: '../ajax/asiento.php?op=desactivarDetalleAsiento',
				    data: {idAsientoDetalle:idAsientoDetalle},
					dataType:"json",

				    complete: function(data)
					{	
							swal({
							  position: 'top-end',
							  type: 'success',
							  title: 'Listo', 
							  showConfirmButton: false,
							  timer: 900
							 })		
				    		//mostrarform(false);	
							//tabla.ajax.reload();
	    			}	    				
			});

			var importeDeb = document.getElementsByName("importeDebito[]");
        	var impDeb = importeDeb[indice].value;
        	var importeCred = document.getElementsByName("importeCredito[]");
        	var impCre = importeCred[indice].value;
        	t1 = parseFloat(t1) - parseFloat(impDeb);   
        	t2 = parseFloat(t2) - parseFloat(impCre);
		  	$("#filaTP" + indice).remove();	
	  	}
	})
 
  }

//Función para desactivar registros
function desactivar(idAsiento)
{
	swal({
		  title: 'Esta seguro de desactivar asiento?',
		  text: "",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Si, desactivar!'
		}).then((result) => {
		  if (result.value) {
				$.ajax({
	    type: "post",
	    url: '../ajax/asiento.php?op=desactivar',
	    data: {idAsiento:idAsiento},
		dataType:"json",

	    complete: function(data)
		{	
				swal({
				  position: 'top-end',
				  type: 'success',
				  title: 'Listo',
				  showConfirmButton: false,
				  timer: 900
				 })		
	    	listar();
	    }

	});
	  }
	})
}

//Función para activar registros
function activar(idAsiento)
{
	swal({
		  title: 'Esta seguro de activar el asiento?',
		  text: "",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Si, activar!'
		}).then((result) => {
		  if (result.value) {
				$.ajax({
	    type: "post",
	    url: '../ajax/asiento.php?op=activar',
	    data: {idAsiento:idAsiento},
		dataType:"json",

	    complete: function(data)
		{	
				swal({
				  position: 'top-end',
				  type: 'success',
				  title: 'Listo',
				  showConfirmButton: false,
				  timer: 900
				 })		
	    	listar();
	    }

	});
	  }
	})
}



init();