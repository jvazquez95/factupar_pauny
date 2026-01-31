var tabla;
var contDireccion = 0;
var contTelefono = 0;
var contTP = 0;
var detallesT = 0;
var detallesD = 0;
var detallesTP = 0;
//Función que se ejecuta al inicio
function init(){
    $("#alEditar").hide();

	mostrarform(false);
	listar();


	window.addEventListener("keypress", function(event){
    if (event.keyCode == 13){
        event.preventDefault();
    }
	}, false);


 function enter2tab(e) {
       if (e.keyCode == 13) {
           cb = parseInt($(this).attr('tabindex'));
    
           if ($(':input[tabindex=\'' + (cb + 1) + '\']') != null) {
               $(':input[tabindex=\'' + (cb + 1) + '\']').focus();
               $(':input[tabindex=\'' + (cb + 1) + '\']').select();
               e.preventDefault();
    
               return false;
           }
       }
   }


	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	//Cargamos los items al select grupo

	//Cargamos los items al select categoria
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
	$.post("../ajax/departamento.php?op=selectDepartamento", function(r){
	            $("#Departamento_idDepartamento").html(r);
	            $('#Departamento_idDepartamento').selectpicker('refresh');

	});

	//Cargamos los items al select categoria
	$.post("../ajax/cargo.php?op=selectCargo", function(r){
	            $("#Cargo_idCargo").html(r);
	            $('#Cargo_idCargo').selectpicker('refresh');

	});

	//Cargamos los items al select categoria
	$.post("../ajax/estadoCivil.php?op=selectEstadoCivil", function(r){
	            $("#EstadoCivil_idEstadoCivil").html(r);
	            $('#EstadoCivil_idEstadoCivil').selectpicker('refresh');

	});

	//Cargamos los items al select categoria
	$.post("../ajax/profesion.php?op=selectProfesion", function(r){
	            $("#Profesion_idProfesion").html(r);
	            $('#Profesion_idProfesion').selectpicker('refresh');

	});


	//Cargamos los items al select categoria
	$.post("../ajax/clase.php?op=selectClase", function(r){
	            $("#Clase_idClase").html(r);
	            $('#Clase_idClase').selectpicker('refresh');

	});


	//Cargamos los items al select categoria
	$.post("../ajax/tipoSalario.php?op=selectTipoSalario", function(r){
	            $("#TipoSalario_idTipoSalario").html(r);
	            $('#TipoSalario_idTipoSalario').selectpicker('refresh');

	});


	//Cargamos los items al select categoria
	$.post("../ajax/tipoContrato.php?op=selectTipoContrato", function(r){
	            $("#TipoContrato_idTipoContrato").html(r);
	            $('#TipoContrato_idTipoContrato').selectpicker('refresh');

	});


	//Cargamos los items al select categoria
	$.post("../ajax/medioCobro.php?op=selectMedioCobro", function(r){
	            $("#MedioCobro_idMedioCobro").html(r);
	            $('#MedioCobro_idMedioCobro').selectpicker('refresh');

	});

	$.post("../ajax/sucursal.php?op=selectSucursal", function(r){
	            $("#Sucursal_idSucursal").html(r);
	            $('#Sucursal_idSucursal').selectpicker('refresh');

	});

	$.post("../ajax/banco.php?op=selectBanco", function(r){
	            $("#Banco_idBanco").html(r);
	            $('#Banco_idBanco').selectpicker('refresh');

	});



	$("#imagenmuestra").hide();
	$("#divtwo").hide();
}

//Función limpiar
function limpiar()
{
	// alert('limpiar');
	$("#idPersona").val("");
	$("#razonSocial").val("");
	$("#nombreComercial").val("");
	$("#tipoDocumento").val("");
	$("#nroDocumento").val("");
	$("#mail").val("");
	$("#fechaNacimiento").val("");
	$("#regimenTurismo").val("2");
	$("#tipoEmpresa").val("1");


	            $("#TipoPersona_idTipoPersona_l").val("");
	            $('#TipoPersona_idTipoPersona_l').selectpicker('refresh');




	            $("#Departamento_idDepartamento").val("");
	            $('#Departamento_idDepartamento').selectpicker('refresh');


	            $("#Cargo_idCargo").val("");
	            $('#Cargo_idCargo').selectpicker('refresh');


	            $("#EstadoCivil_idEstadoCivil").val("");
	            $('#EstadoCivil_idEstadoCivil').selectpicker('refresh');


	            $("#Profesion_idProfesion").val("");
	            $('#Profesion_idProfesion').selectpicker('refresh');



	            $("#Clase_idClase").val("");
	            $('#Clase_idClase').selectpicker('refresh');



	            $("#TipoSalario_idTipoSalario").val("");
	            $('#TipoSalario_idTipoSalario').selectpicker('refresh');



	            $("#TipoContrato_idTipoContrato").val("");
	            $('#TipoContrato_idTipoContrato').selectpicker('refresh');



	            $("#MedioCobro_idMedioCobro").val("");
	            $('#MedioCobro_idMedioCobro').selectpicker('refresh');


	            $("#Sucursal_idSucursal").val("");
	            $('#Sucursal_idSucursal').selectpicker('refresh');


	            $("#Banco_idBanco").val("");
	            $('#Banco_idBanco').selectpicker('refresh');

	$("#nroContrato").val("");
	$("#nroCuenta").val("");
	$("#nroSeguroSocial").val("");



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

}



function cambiarTerminoPago(x){

	alert(x.value);
	alert(x.id);


}




function crudV2(ventana) {

    var ventanawo = window.open("../vistas/"+ ventana +".php?id="+ $("#idPersona").val(), "PYVENTAS"+ventana, "width=600, height=600");
    var interval = setInterval(function(){
        if(ventanawo.closed !== false) {

          window.clearInterval(interval)
          
      

      if (ventana == "grupoArticulo") {
      $.post("../ajax/articulo.php?op=selectGrupo", function(r){
                  $("#GrupoArticulo_idGrupoArticulo").html(r);
                  $('#GrupoArticulo_idGrupoArticulo').selectpicker('refresh');

      });
      }
      else if(ventana == "persona"){
      $.post("../ajax/persona.php?op=selectProveedor", function(r){
                  $("#Persona_idPersona").html(r);
                  $('#Persona_idPersona').selectpicker('refresh');

      });
      }
      else if(ventana == "marca"){
      $.post("../ajax/marca.php?op=selectMarca", function(r){
                  $("#Marca_idMarca").html(r);
                  $('#Marca_idMarca').selectpicker('refresh');

      });
      }




        } 


    },1000)
    
  
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
	location.reload();
	//limpiar();
	//mostrarform(false);
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
					url: '../ajax/legajo.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
	    "responsive": true,
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar()
{
//	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/legajo.php?op=guardaryeditar",
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

function mostrar(idPersona)
{

	$.post("../ajax/legajo.php?op=mostrar",{idPersona : idPersona}, function(data, status)
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



	            $("#Departamento_idDepartamento").val(data.Departamento_idDepartamento);
	            $('#Departamento_idDepartamento').selectpicker('refresh');


	            $("#Cargo_idCargo").val(data.Cargo_idCargo);
	            $('#Cargo_idCargo').selectpicker('refresh');


	            $("#EstadoCivil_idEstadoCivil").val(data.EstadoCivil_idEstadoCivil);
	            $('#EstadoCivil_idEstadoCivil').selectpicker('refresh');


	            $("#Profesion_idProfesion").val(data.Profesion_idProfesion);
	            $('#Profesion_idProfesion').selectpicker('refresh');



	            $("#Clase_idClase").val(data.Clase_idClase);
	            $('#Clase_idClase').selectpicker('refresh');



	            $("#TipoSalario_idTipoSalario").val(data.TipoSalario_idTipoSalario);
	            $('#TipoSalario_idTipoSalario').selectpicker('refresh');



	            $("#TipoContrato_idTipoContrato").val(data.TipoContrato_idTipoContrato);
	            $('#TipoContrato_idTipoContrato').selectpicker('refresh');



	            $("#MedioCobro_idMedioCobro").val(data.MedioCobro_idMedioCobro);
	            $('#MedioCobro_idMedioCobro').selectpicker('refresh');


	            $("#Sucursal_idSucursal").val(data.Sucursal_idSucursal);
	            $('#Sucursal_idSucursal').selectpicker('refresh');


	            $("#Banco_idBanco").val(data.Banco_idBanco);
	            $('#Banco_idBanco').selectpicker('refresh');

	$("#nroContrato").val(data.nroContrato);
	$("#nroCuenta").val(data.nroCuenta);
	$("#nroSeguroSocial").val(data.nroSeguroSocial);

	$("#alEditar").show();


 	})

 	$.post("../ajax/legajo.php?op=listarDetalleTipoPersona&idPersona="+idPersona,function(r){
	        $("#detalleTipoPersona").html(r);
	});	

 	$.post("../ajax/legajo.php?op=listarDetalleTelefono&idPersona="+idPersona,function(r){
	        $("#detalleTelefono").html(r);
	});	

 	$.post("../ajax/legajo.php?op=listarDetalleDireccion&idPersona="+idPersona,function(r){
	        $("#detalleDireccion").html(r);
	});	
    $("#alEditar").show();


	$("#btnGuardar").prop("disabled",false);


}


function addDetalleTipoPersona()
  {
   	
	var TipoPersona_idTipoPersona = $("#TipoPersona_idTipoPersona_l option:selected").val();
  	var TipoPersona_idTipoPersona_text = $("#TipoPersona_idTipoPersona_l option:selected").text();

//	var terminosHabilitado = $("#terminosHabilitado_l option:selected").val();
// 	var terminosHabilitado_text = $("#terminosHabilitado option:selected").text();


	var terminoPago = $("#terminoPago_l option:selected").val();
  	var terminoPago_text = $("#terminoPago_l option:selected").text();

	var GrupoPersona_idGrupoPersona = $("#GrupoPersona_idGrupoPersona_l option:selected").val();
  	var GrupoPersona_idGrupoPersona_text = $("#GrupoPersona_idGrupoPersona_l option:selected").text();

  	//var lservicio_nombre = $("#Articulo_idArticulo_Servicio option:selected").text();

	var cuentaAPagar = $("#cuentaAPagar_l").val();
	var cuentaAnticipo = $("#cuentaAnticipo_l").val();
	var comision = $("#comision_l").val();
	var salario = $("#salario_l").val();


	if (TipoPersona_idTipoPersona == 1 || TipoPersona_idTipoPersona == 2) {
		if (cuentaAPagar=='') {
			alert('Complete la cuenta a pagar');
			$("#cuentaAPagar_l").focus();
			return;			
		}

		if (cuentaAnticipo == '') {
			alert('Complete la cuenta anticipo');
			$("#cuentaAnticipo_l").focus();
			return;			

		}


	}

	if (TipoPersona_idTipoPersona == 3) {

		if (comision == '') {
			alert('Complete la comision');
			$("#comision_l").focus();
			return;			


		}

		if (salario == '') {
			alert('Complete el salario');
			$("#salario_l").focus();
			return;			

		}

	}


    	var fila=
    	'<tr class="filasTP nuevos_add" id="filaTP'+contTP+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleTipoPersona ('+contTP+',0)">X</button></td>'+
    	'<td><input type="hidden" name="TipoPersona_idTipoPersona[]" value="'+TipoPersona_idTipoPersona+'">'+TipoPersona_idTipoPersona_text+'</td>'+
    	'<td><input type="hidden" name="terminoPago[]" id="terminoPago[]" value="'+terminoPago+'">'+terminoPago_text+'</td>'+
    	'<td><input type="hidden" name="GrupoPersona_idGrupoPersona[]" id="GrupoPersona_idGrupoPersona[]" value="'+GrupoPersona_idGrupoPersona+'">'+GrupoPersona_idGrupoPersona_text+'</td>'+
    	'<td><input type="hidden" name="cuentaAPagar[]" id="cuentaAPagar[]" value="'+cuentaAPagar+'">'+cuentaAPagar+'</td>'+
    	'<td><input type="hidden" name="cuentaAnticipo[]" id="cuentaAnticipo[]" value="'+cuentaAnticipo+'">'+cuentaAnticipo+'</td>'+
    	'<td><input type="hidden" name="comision[]" id="comision[]" value="'+comision+'">'+comision+'</td>'+
    	'<td><input type="hidden" name="salario[]" id="salario[]" value="'+salario+'">'+salario+'</td>'+
    	'<td><input type="hidden" name="idPersonaTipoPersona[]"  data-tipopersona="0" id="idPersonaTipoPersona[]" value="0"></td>'+

    	'</tr>';
    	contTP++;
    	detallesTP=detallesTP+1;
    	$('#detalleTipoPersona').append(fila);
    	if (detallesTP > 0) {
			$("#btnGuardar").prop("disabled",false);
    	}
    	//modificarSubototales();
  }
  function eliminarDetalleTipoPersona(indice,valor){

				if (valor > 0) {

				        	$.post("../ajax/legajo.php?op=desactivarTP", {idTP : valor}, function(e){
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

    	
    	'<tr class="filasD nuevos_add" id="filaD'+contDireccion+'">'+
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
				        	$.post("../ajax/legajo.php?op=desactivarDireccion", {idDireccion : valor}, function(e){
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
    	'<tr class="filasT nuevos_add" id="filaT'+contTelefono+'">'+
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
        	$.post("../ajax/legajo.php?op=desactivarTelefono", {idTelefono : valor}, function(e){
				//tabla.ajax.reload();
        	});		
    }

  	$("#filaT" + indice).remove();
	detallesT=detallesT-1;
	


  }



//Función para desactivar registros
function desactivar(idPersona)
{
	bootbox.confirm("¿Está Seguro de desactivar el Cliente?", function(result){
		if(result)
        {
        	$.post("../ajax/legajo.php?op=desactivar", {idPersona : idPersona}, function(e){
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
	})
}

//Función para activar registros
function activar(idPersona)
{
	bootbox.confirm("¿Está Seguro de activar el Cliente?", function(result){
		if(result)
        {
        	$.post("../ajax/legajo.php?op=activar", {idPersona : idPersona}, function(e){
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
	})
}



init();


function initialize() {
    var initialLat = $('.search_latitude').val();
    var initialLong = $('.search_longitude').val();
    initialLat = initialLat?initialLat:36.169648;
    initialLong = initialLong?initialLong:-115.141000;

    var latlng = new google.maps.LatLng(initialLat, initialLong);
    var options = {
        zoom: 16,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("geomap"), options);

    geocoder = new google.maps.Geocoder();

    marker = new google.maps.Marker({
        map: map,
        draggable: true,
        position: latlng
    });

    google.maps.event.addListener(marker, "dragend", function () {
        var point = marker.getPosition();
        map.panTo(point);
        geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                $('.search_addr').val(results[0].formatted_address);
                $('.search_latitude').val(marker.getPosition().lat());
                $('.search_longitude').val(marker.getPosition().lng());
            }
        });
    });

}

navigator.geolocation.getCurrentPosition(function(position){ 
var geocoder;
var map;
var marker;
//load google map
geocoder = new google.maps.Geocoder();   
var PostCodeid = '#search_location';
$( "#Ciudad_idCiudad_l" ).on('keyup',function() {
  // alert( "Handler for .change() called." + $("#Ciudad_idCiudad_l").val() );
	if ($("#Ciudad_idCiudad_l").val() == "1") {
		$("#search_location").val("Asuncion, Paraguay");
	}
	else if($("#Ciudad_idCiudad_l").val() == "2"){
	$("#search_location").val("San Lorenzo, Paraguay");
	}
});
$("#callePrincipal_l").on('keyup',function(){
	if ($("#Ciudad_idCiudad_l").val() == "1") {
		$("#search_location").val($("#callePrincipal_l").val()+", Asuncion, Paraguay");
	}
	else if($("#Ciudad_idCiudad_l").val() == "2"){
	$("#search_location").val($("#callePrincipal_l").val()+", San Lorenzo, Paraguay");
	}
});
$("#nroCasa_l").on('keyup',function(){
	if ($("#Ciudad_idCiudad_l").val() == "1") {
		$("#search_location").val($("#callePrincipal_l").val() + "  " +$("#nroCasa_l").val()+", Asuncion, Paraguay");
	}
	else if($("#Ciudad_idCiudad_l").val() == "2"){
	$("#search_location").val($("#callePrincipal_l").val() + "  " +$("#nroCasa_l").val()+", San Lorenzo, Paraguay");
	}
});
 $('#search_location').on('keyup',function() {
   Obtener_ubicacion();
 });

	Obtener_ubicacion();
	var map;
	var marker = false;

	function Obtener_ubicacion(){
		var address = $(PostCodeid).val();
	        geocoder.geocode({'address': address}, function (results, status) {
	            if (status == google.maps.GeocoderStatus.OK) {
	                $('.search_addr').val(results[0].formatted_address);
	                $('.search_latitude').val(results[0].geometry.location.lat());
	                $('.search_longitude').val(results[0].geometry.location.lng());
	                initMap();
	            }
	            else {
	                console.log("ERROR : " + status);
	            }
	                $(function () {
	                    $("#search_location").autocomplete({
	                        source: function (request, response) {
	                            geocoder.geocode({
	                                'address': request.term
	                            }, function (results, status) {
	                                response($.map(results, function (item) {
	                                    return {
	                                        label: item.formatted_address,
	                                        value: item.formatted_address,
	                                        lat: item.geometry.location.lat(),
	                                        lon: item.geometry.location.lng()
	                                    };
	                                }));
	                            });
	                        },
	                        select: function (event, ui) {
	                            $('.search_addr').val(ui.item.value);
	                            $('.search_latitude').val(ui.item.lat);
	                            $('.search_longitude').val(ui.item.lon);
	                            var latlng = new google.maps.LatLng(ui.item.lat, ui.item.lon);
	                            //marker.setPosition(latlng);
	                        }
	                    });
	                });
	        });
	}


	function initMap() {


	    var centerOfMap = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
	 
	    //Map options.
	    var options = {
	      center: centerOfMap, //Set center.
	      zoom: 14 //The zoom value.
	    };
	 
	    map = new google.maps.Map(document.getElementById('map'), options);
	 

		var marker = new google.maps.Marker({
		position: centerOfMap,
		map: map,
		});



	    google.maps.event.addListener(map, 'click', function(event) {                
	        var clickedLocation = event.latLng;
	        if(marker === false){
	            marker = new google.maps.Marker({
	                position: clickedLocation,
	                map: map,
	                draggable: true //make it draggable
	            });
	            google.maps.event.addListener(marker, 'dragend', function(event){
	            	    var currentLocation = marker.getPosition();

	    $("#longitud_l").val(currentLocation.lat());

	    $("#latitud_l").val(currentLocation.lng());
	            });
	        } else{

	            marker.setPosition(clickedLocation);
	        }

	         	    var currentLocation = marker.getPosition();

	    $("#longitud_l").val(currentLocation.lat());

	    $("#latitud_l").val(currentLocation.lng());


	    });
	}




});





