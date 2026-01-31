var tabla;
var contDireccion = 0;
var contTelefono = 0;
var contVisita = 0;
var contContacto = 0;
var contTP = 0;
var detallesContacto = 0;
var detallesT = 0;
var detallesV = 0;
var detallesD = 0;
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
	$("#contactos").hide();
	mostrarform(false);
	listar();


	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	//Cargamos los items al select grupo

	//Cargamos los items al select categoria
	$.post("../ajax/cargo.php?op=selectCargo", function(r){
	            $("#Cargo_idCargo_l").html(r);
	            $('#Cargo_idCargo_l').selectpicker('refresh');

	});

	$.post("../ajax/barrio.php?op=selectBarrio", function(r){
	            $("#Barrio_idBarrio_l").html(r);
	            $('#Barrio_idBarrio_l').selectpicker('refresh');

	});

	//Cargamos los items al select categoria
	$.post("../ajax/ciudad.php?op=selectCiudad", function(r){
	            $("#Ciudad_idCiudad_l").html(r);
	            $('#Ciudad_idCiudad_l').selectpicker('refresh');

	});


	//Cargamos los items al select categoria
	$.post("../ajax/grupoPersona.php?op=selectGrupoPersona", function(r){
	            $("#GrupoPersona_idGrupoPersona_l").html(r);
	            $('#GrupoPersona_idGrupoPersona_l').selectpicker('refresh');

	});

	//Cargamos los items al select categoria
	$.post("../ajax/terminoPago.php?op=selectTerminoPago", function(r){
	            $("#terminoPago_l").html(r);
	            $('#terminoPago_l').selectpicker('refresh');

	});


	$.post("../ajax/banco.php?op=selectCuentaContable", function(r){
	            $("#cuentaAPagar_l").html(r);
	            $('#cuentaAPagar_l').selectpicker('refresh');
            

	            $("#cuentaAnticipo_l").html(r);
	            $('#cuentaAnticipo_l').selectpicker('refresh');

	});


		//Cargamos los items al select categoria
	$.post("../ajax/tipoDireccionTelefono.php?op=selectTipoDireccionTelefono", function(r){
	            $("#TipoDireccion_Telefono_idTipoDireccion_Telefono_l").html(r);
	            $('#TipoDireccion_Telefono_idTipoDireccion_Telefono_l').selectpicker('refresh');

	            $("#TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_l").html(r);
	            $('#TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_l').selectpicker('refresh');


	});


	//Cargamos los items al select categoria
	$.post("../ajax/tipoPersona.php?op=select", function(r){
	            $("#TipoPersona_idTipoPersona_l").html(r);
	            $('#TipoPersona_idTipoPersona_l').selectpicker('refresh');

	});
	//Cargamos los items al select categoria
	$.post("../ajax/tipoPersona.php?op=selectTipoPersona", function(r){
	            $("#tipoPersona_idTipoPersona").html(r);
	            $('#tipoPersona_idTipoPersona').selectpicker('refresh');

	});

	$("#imagenmuestra").hide();
	$("#divtwo").hide();
}



function mostrarDetalleComodato(idPersona){ 
	$('#modal_detalle2').modal('show');
	$("#detalle2").val(idPersona);  
$(document).ready(function() {
    $('#tbllistado2').DataTable( {
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
					url: '../ajax/consultas.php?op=rpt_comodato',
					data:{idPersona:idPersona}, 
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
  			"columnDefs": [
            {
                "targets": [ 2],
                "visible": true,
                "searchable": false
            }],

                    "language": {
            "decimal": ".",
            "thousands": ","
        },
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación
	    "order": [[ 2, "desc" ],[ 2, "desc" ]],//Ordenar (columna,orden)

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
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseFloat(intVal(a)) + parseFloat(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 2 ).footer() ).html(
               formatNumber.new(pageTotal) 
            );
        }
    } );
} );
}


function mostrarDetalleTelefono(idPersona){ 
	$('#modal_detalle_telefono').modal('show');
	$("#detalle5").val(idPersona);  
$(document).ready(function() {
    $('#tbllistado5').DataTable( {
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
					url: '../ajax/consultas.php?op=rpt_telefono_detalle',
					data:{idPersona:idPersona}, 
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
  			
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación
	    "order": [[ 2, "desc" ],[ 2, "desc" ]],//Ordenar (columna,orden)

    } );
} );
}


var tabladireccion = 0;
function mostrarDetalleDirecciones(idPersona){ 
	$('#modal_detalle').modal('show');
	$("#detalle4").val(idPersona);  
$(document).ready(function() {
	tabladireccion = $('#tbllistadoDireccion').DataTable( {
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
					url: '../ajax/consultas.php?op=rpt_direcciones',
					data:{idPersona:idPersona}, 
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
  			"columnDefs": [
            {
                "targets": [ 4],
                "visible": true,
                "searchable": false
            }],

                    "language": {
            "decimal": ".",
            "thousands": ","
        },
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación
	    "order": [[ 2, "desc" ],[ 2, "desc" ]],//Ordenar (columna,orden)

    } );
} );
}

//Función limpiar
function limpiar()
{
	$("#idPersona").val("");
	$("#razonSocial").val("");
	$("#nombreComercial").val("");
	$("#tipoDocumento").val("");
	$("#nroDocumento").val("");
	$("#mail").val("");
	$("#fechaNacimiento").val("");
	$("#regimenTurismo").val("2");
	$("#tipoEmpresa").val("1");
	$("#longitud_l").val("");
	$("#latitud_l").val("");
	$("#callePrincipal_l").val("");
	$("#calleTransversal_l").val("");
	$("#nroCasa_l").val("");
	$("#telefono_l").val("");
	$("#telefono_l2").val("");
	$("#nya_l").val("");
	$("#Cargo_idCargo_l").val("");
	$("#email_l").val("");

	$(".filasTP").remove();
	$(".filasD").remove();
	$(".filasT").remove();
	$(".filasV").remove();
	$(".filasContacto").remove();

	detallesT=0;
	detallesTP=0;
	detallesD=0;
	contTelefono=0;
	contDireccion=0;
	contTP=0
}

function personalizar(x){

	if (x.value == 1 || x.value == 2) {
		$("#divtwo").hide();
		$("#divone").show();
	}else if(x.value == 3){
		$("#divtwo").show();
		$("#divone").hide();
	}

	if (x.value == 2) {
		$("#contactos").show();
	}else{
		$("#contactos").hide();		
	}


}


function verificarRuc(x){
	var codigo = x.value;
	//Habilitacion ticket
	$.post("../ajax/persona.php?op=verificarRuc", {codigo:codigo} ,function(data, status)
		{
			data = JSON.parse(data);

			if ($('#idPersona').val() == '' ) {

					if (data.cantidad > 0) {

					$('#'+x.id ).focus();
					swal({
					  position: 'top-end',
					  type: 'error',
					  title: 'Persona ya se encuentra registrada',
					  showConfirmButton: false,
					  timer: 1500
					 })	

				}	
			}
	 });
} 




function cambiarTerminoPago(x){

	alert(x.value);
	alert(x.id);


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
					url: '../ajax/proveedor.php?op=listarc',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 100,//Paginación
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
		url: "../ajax/persona.php?op=guardaryeditar",
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
						  timer: 3000
						 })	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(idPersona)
{
	$.post("../ajax/persona.php?op=mostrar",{idPersona : idPersona}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

	$("#razonSocial").val(data.razonSocial);
	$("#nombreComercial").val(data.nombreComercial);
	$("#tipoDocumento").val(data.tipoDocumento);
	$("#tipoDocumento").selectpicker("refresh");
	$("#regimenTurismo").val(data.regimenTurismo);
	$("#regimenTurismo").selectpicker("refresh");
	$("#nroDocumento").val(data.nroDocumento);
	$("#mail").val(data.mail);
	$("#fechaNacimiento").val(data.fechaNacimiento);
	$("#tipoEmpresa").val(data.tipoEmpresa);
	$("#tipoEmpresa").selectpicker("refresh");
	$("#idPersona").val(data.idPersona);

 	})

 	$.post("../ajax/persona.php?op=listarDetalleTipoPersona&idPersona="+idPersona,function(r){
	        $("#detalleTipoPersona").html(r);
	});	

 	$.post("../ajax/persona.php?op=listarDetalleTelefono&idPersona="+idPersona,function(r){
	        $("#detalleTelefono").html(r);
	});	

 	$.post("../ajax/persona.php?op=listarDetalleDireccion&idPersona="+idPersona,function(r){
	        $("#detalleDireccion").html(r);
	});	
 	$.post("../ajax/persona.php?op=listarDetalleDias&idPersona="+idPersona,function(r){
	        $("#detalleVisita").html(r);
	});	


 	$.post("../ajax/persona.php?op=listarDetallePersonaContacto&idPersona="+idPersona,function(r){
	        $("#detalleContacto").html(r);
			let filas = $(detallesContacto).find('tbody tr').length;
	});	


		$("#btnGuardar").prop("disabled",false);


}

  function eliminarDetalleTipoPersona(indice,valor){

				if (valor > 0) {

				        	$.post("../ajax/persona.php?op=desactivarTP", {idTP : valor}, function(e){
				        	});
				}	

		    $("#filaTP" + indice).remove();
		  	detallesTP=detallesTP-1;

			if(document.getElementsByName("TipoPersona_idTipoPersona[]").length <=0){
				$("#btnGuardar").prop("disabled",true);
		  	}


        }



function addDetalleDireccion()
  {
   	
	var TipoDireccion_Telefono_idTipoDireccion_Telefono = $("#TipoDireccion_Telefono_idTipoDireccion_Telefono_l option:selected").val();
  	var TipoDireccion_Telefono_idTipoDireccion_Telefono_text = $("#TipoDireccion_Telefono_idTipoDireccion_Telefono_l option:selected").text();

	var Barrio_idBarrio = $("#Barrio_idBarrio_l option:selected").val();
  	var Barrio_idBarrio_text = $("#Barrio_idBarrio_l option:selected").text();


	var Ciudad_idCiudad = $("#Ciudad_idCiudad_l option:selected").val();
  	var Ciudad_idCiudad_text = $("#Ciudad_idCiudad_l option:selected").text();

  	//var lservicio_nombre = $("#Articulo_idArticulo_Servicio option:selected").text();

	var callePrincipal = $("#callePrincipal_l").val();
	var calleTransversal = $("#calleTransversal_l").val();
	var nroCasa = $("#nroCasa_l").val();
	var latitud = $("#latitud_l").val();
	var longitud = $("#longitud_l").val();
 	//lmonto = lmonto.replace(".", "");
	//var lempleado = $("#Empleado_idEmpleado option:selected").val();
	//var lempleado_nombre = $("#Empleado_idEmpleado option:selected").text();

		if (callePrincipal=='') {
			alert('Complete la calle Principal / Email');
			$("#callePrincipal_l").focus();
			return;			
		}


    	var fila=

    	
    	'<tr class="filasD" id="filaD'+contDireccion+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleDireccion('+contDireccion+',0)">X</button></td>'+
    	'<td><input type="hidden" name="TipoDireccion_Telefono_idTipoDireccion_Telefono[]" value="'+TipoDireccion_Telefono_idTipoDireccion_Telefono+'">'+TipoDireccion_Telefono_idTipoDireccion_Telefono_text+'</td>'+
    	'<td><input type="hidden" name="Ciudad_idCiudad[]" id="Ciudad_idCiudad[]" value="'+Ciudad_idCiudad+'">'+Ciudad_idCiudad_text+'</td>'+
    	'<td><input type="hidden" name="Barrio_idBarrio[]" value="'+Barrio_idBarrio+'">'+Barrio_idBarrio_text+'</td>'+
    	'<td><input type="hidden" name="callePrincipal[]" id="callePrincipal[]" value="'+callePrincipal+'">'+callePrincipal+'</td>'+
    	'<td><input type="hidden" name="calleTransversal[]" id="calleTransversal[]" value="'+calleTransversal+'">'+calleTransversal+'</td>'+
    	'<td><input type="hidden" name="nroCasa[]" id="nroCasa[]" value="'+nroCasa+'">'+nroCasa+'</td>'+
    	'<td><input type="hidden" name="longitud[]" id="longitud[]" value="'+longitud+'">'+longitud+'</td>'+
    	'<td><input type="hidden" name="latitud[]" id="latitud[]" value="'+latitud+'">'+latitud+'</td>'+
    	'<td><input type="hidden" name="idDireccion[]" id="idDireccion[]" data-iddireccion="0" value="0"></td>'+
    	'</tr>';
    	contDireccion++;
    	detallesD=detallesD+1;
    	$('#detalleDireccion').append(fila);
    	//modificarSubototales();
  }

  function eliminarDetalleDireccion(indice,valor){


				if (valor > 0) {
				        	$.post("../ajax/persona.php?op=desactivarDireccion", {idDireccion : valor}, function(e){
				        	});		
				}
    	
  			$("#filaD" + indice).remove();
		  	detallesD=detallesD-1;

  }

function addDetalleTelefono()
  {
   	
	var TipoDireccion_Telefono_idTipoDireccion_Telefono_tel = $("#TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_l option:selected").val();
  	var TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_text = $("#TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_l option:selected").text();

	var telefono = $("#telefono_l").val();

		if (telefono=='') {
			alert('Complete el nro de telefono');
			$("#telefono_l").focus();
			return;			
		}
    	var fila=
    	'<tr class="filasT" id="filaT'+contTelefono+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleTelefono('+contTelefono+',0)">X</button></td>'+
    	'<td><input type="hidden" name="TipoDireccion_Telefono_idTipoDireccion_Telefono_tel[]" value="'+TipoDireccion_Telefono_idTipoDireccion_Telefono_tel+'">'+TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_text+'</td>'+
    	'<td><input type="hidden" name="telefono[]"  value="'+telefono+'">'+telefono+'</td>'+
    	'<td><input type="hidden" name="idTelefono[]" data-idtelefono="0"  value="0"></td>'+

    	'</tr>';
    	contTelefono++;
    	detallesT=detallesT+1;
    	$('#detalleTelefono').append(fila);
		
  }

  function eliminarDetalleTelefono(indice,valor){

	if (valor > 0) {
        	$.post("../ajax/persona.php?op=desactivarTelefono", {idTelefono : valor}, function(e){
				//tabla.ajax.reload();
        	});		
    }

  	$("#filaT" + indice).remove();
	detallesT=detallesT-1;
	


  }






function addDetalleContacto()
  {
	var nya = $("#nya_l").val();
	
	var Cargo_idCargo = $("#Cargo_idCargo_l option:selected").val();
  	var Cargo_idCargo_text = $("#Cargo_idCargo_l option:selected").text();

	var telefono = $("#telefono_l2").val();

		if (telefono=='') {
			alert('Complete el nro de telefono');
			$("#telefono_l2").focus();
			return;			
		}

	var email = $("#email_l").val();


    	var fila=
    	'<tr class="filasContacto" id="filaContacto'+contContacto+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleContacto('+contContacto+',0)">X</button></td>'+
    	'<td><input type="hidden" name="nya[]" value="'+nya+'">'+nya+'</td>'+
    	'<td><input type="hidden" name="Cargo_idCargo[]"  value="'+Cargo_idCargo+'">'+Cargo_idCargo_text+'</td>'+
    	'<td><input type="hidden" name="telefono_2[]"  value="'+telefono+'">'+telefono+'</td>'+
    	'<td><input type="hidden" name="email_2[]"  value="'+email+'">'+email+'</td>'+
    	'<td><input type="hidden" name="idPersonaContacto[]" data-idPersonaContacto="0"  value="0"></td>'+

    	'</tr>';
    	contContacto++;
    	detallesContacto=detallesContacto+1;
    	$('#detalleContacto').append(fila);
		
  }

  function eliminarDetalleContacto(indice,valor){

	if (valor > 0) {
        	$.post("../ajax/persona.php?op=desactivarContacto", {idPersonaContacto : valor}, function(e){
				//tabla.ajax.reload();
        	});		
    }

  	$("#filaContacto" + indice).remove();
	detallesContacto=detallesContacto-1;
	


  }






function addDetalleDias()
  {
   	
	var Dia_idDia = $("#Dia_idDia option:selected").val();
  var Dia_idDia_text = $("#Dia_idDia option:selected").text();

	var cantidad = $("#cantidad").val();

		if (cantidad=='') {
			alert('Complete la cantidad');
			$("#cantidad").focus();
			return;			
		}
    	var fila=
    	'<tr class="filasV" id="filaV'+contVisita+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleVisita('+contVisita+',0)">X</button></td>'+
    	'<td><input type="hidden" name="Dia_idDia_persona[]" value="'+Dia_idDia+'">'+Dia_idDia_text+'</td>'+
    	'<td><input type="hidden" name="cantidad_persona[]"  value="'+cantidad+'">'+cantidad+'</td>'+
    	'<td><input type="hidden" name="idPersonaDia[]" data-idPersonaDia="0"  value="0"></td>'+

    	'</tr>';
    	contVisita++;
    	detallesV=detallesV+1;
    	$('#detalleVisita').append(fila);
		
  }

  function eliminarDetalleVisita(indice,valor){

	if (valor > 0) {
        	$.post("../ajax/persona.php?op=desactivarVisita", {idPersonaDia : valor}, function(e){
				//tabla.ajax.reload();
        	});		
    }

  	$("#filaV" + indice).remove();
	detallesV=detallesV-1;
	


  }



  



//Función para desactivar registros
function marcarDias(x, idDireccion, sino, dia)
{

alert(dia);

}




//Función para desactivar registros
function desactivarDireccion(idDireccion)
{

        	$.post("../ajax/persona.php?op=desactivarDireccion", {idDireccion : idDireccion}, function(e){
        		swal({
			  position: 'top-end',
			  type: 'success',
			  title: e,
			  showConfirmButton: false,
			  timer: 1500
			 })	     ;
	            tabla.ajax.reload();
        	});	

}

//Función para activar registros
function activar(idPersona)
{
	$.post("../ajax/persona.php?op=activar", {idPersona : idPersona}, function(e){
		swal({
	  position: 'top-end',
	  type: 'success',
	  title: e,
	  showConfirmButton: false,
	  timer: 1500
	 })	     ;
		tabla.ajax.reload();
	});	
}



init();



function asignarVehiculo(idDireccion) {
	console.log("[asignarVehiculo] idDireccion =", idDireccion);
	
	// Guardar id en el modal
	$("#idDireccionVehiculo").val(idDireccion);
  
	// Limpiar el select antes de rellenarlo
	$("#selectVehiculo").empty();
  
	// Petición a 'listarVehiculos' que imprime directamente <option>...
	$.ajax({
	  url: "../ajax/cliente.php?op=listarVehiculos",
	  type: "POST",
	  success: function(opcionesHTML) {
		console.log("[asignarVehiculo] Recibido HTML:", opcionesHTML);
  
		// Insertamos esas <option> en el select
		$("#selectVehiculo").html(opcionesHTML);
  
		// Finalmente, abrimos el modal
		$("#modalVehiculo").modal("show");
	  },
	  error: function(xhr, status, error){
		console.error("[asignarVehiculo] Error AJAX:", error);
		alert("Error al cargar vehículos");
	  }
	});
  }
  
  
  function guardarVehiculo() {
	var idDireccion = $("#idDireccionVehiculo").val();
	var vehiculo = $("#selectVehiculo").val();
  
	if (!vehiculo) {
	  alert("Por favor seleccione un vehículo.");
	  return;
	}
	
	$.post("../ajax/cliente.php?op=asignarVehiculo", 
	  { idDireccion: idDireccion, vehiculo: vehiculo },
	  function(response) {
		console.log("Respuesta del servidor:", response);
		swal({
			position: 'top-end',
			type: 'success',
			title: 'Se completo la operacion',
			showConfirmButton: false,
			timer: 3000
		   })	
  
		// Cerramos el modal
		$("#modalVehiculo").modal("hide");
  
		// ************** Recargamos la tabla **************
		// asumiendo que tu DataTable se guardó en "tabla4"
		// y que lo inicializas al cargar la página
		tabladireccion.ajax.reload();
	  }
	);
  }
  






