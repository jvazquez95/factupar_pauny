var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	$.post("../ajax/habilitacion.php?op=selectDeposito", function(r){
		$("#Deposito_idDeposito").html(r);
		$("#Deposito_idDeposito").selectpicker('refresh');
	});

	//Cargamos los items al select cliente
	$.post("../ajax/ordenConsumision.php?op=selectEmpleado", function(r){
	            $("#Empleado_idEmpleado").html(r);
	            $('#Empleado_idEmpleado').selectpicker('refresh');
	});	

	//Cargamos los items al select cliente
	$.post("../ajax/articulo.php?op=listarActivosProductosInternos", function(r){
	            $("#Articulo_idArticulo").html(r);
	            $('#Articulo_idArticulo').selectpicker('refresh');
	});		
	


}

//Función limpiar
function limpiar()
{
	$("#idMovimiento").val("");
	$("#idConcepto").val("");
	$("#descripcion").val("");
	$("#monto").val("");
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


//Función mostrar formulario
function mostrarform1(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",true);
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
					url: '../ajax/articuloEmpleado.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/articuloEmpleado.php?op=guardaryeditar",
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

function mostrar1(idMovimiento)
{
	$.post("../ajax/movimiento.php?op=mostrar",{idMovimiento : idMovimiento}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform1(true);

		$("#concepto").val(data.Caja_idCaja);
		$("#habilitacion").selectpicker('refresh');
		$("#descripcion").val(data.Usuario_idUsuario);
		$("#monto").val(data.monto);
		$("#idMovimiento").val(data.idMovimiento);

 	})
}



function mostrar(idMovimiento)
{
	$.post("../ajax/movimiento.php?op=mostrar",{idMovimiento : idMovimiento}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#idConcepto").val(data.concepto);
		$("#habilitacion").val(data.habilitacion);
		$("#habilitacion1").val(data.habilitacion);
		$("#idConcepto").selectpicker('refresh');
		$("#descripcion").val(data.descripcion);
		$("#monto").val(data.monto);
		$("#idMovimiento").val(data.idMovimiento);

 	})
}

//Función para activar registros
function cerrar(idArticuloEmpleado)
{
	bootbox.confirm("¿Está Seguro de invalidar el movimiento?", function(result){
		if(result)
        {
        	$.post("../ajax/articuloEmpleado.php?op=desactivar", {idArticuloEmpleado : idArticuloEmpleado}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}




function alertDismissJS(msj, tipo){
	var salida;
	switch (tipo){
		case 'error':
			salida = "<div id='alerta' class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
			"<span class='glyphicon glyphicon-exclamation-sign'>&nbsp;</span>"+msj+"</div>";
		break;
		
		case 'error_span':
			salida = "<span id='alerta' class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
			"<span class='glyphicon glyphicon-exclamation-sign'>&nbsp;</span>"+msj+"</span>";
		break;
		
		case 'warning':
			salida = "<div id='alerta' class='alert alert-warning alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
			"<span class='glyphicon glyphicon-exclamation-sign'>&nbsp;</span>"+msj+"</div>";
		break;
		
		case 'ok':
			salida = "<div id='alerta' class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
			"<span class='glyphicon glyphicon-ok'>&nbsp;</span>"+msj+"</div>";
		break;
		
		case 'ok_span':
			salida = "<span id='alerta' class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
			"<span class='glyphicon glyphicon-ok'>&nbsp;</span>"+msj+"</span>";
		break;
		
		case 'info':
			salida = "<div id='alerta' class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+
			"<span class='glyphicon glyphicon-exclamation-sign'>&nbsp;</span>"+msj+"</div>";
		break;
	}
	return salida; 
}

function fechaMYSQL(fecha){
	//Para el calendario de Jqwidgets
    var fechaArr = fecha.split("/");
    var salida = fechaArr[2]+","+fechaArr[1]+","+fechaArr[0];
	return salida;
}

function fechaLatina(fecha){
    var fechaArr = fecha.split("-");
    var salida = fechaArr[2]+"/"+fechaArr[1]+"/"+fechaArr[0];
	return salida;
}

//Permitir nÃºmeros y puntos (decimales)
function isNumberKey(evt){
	 // skip for arrow keys
    if(evt.which >= 37 && evt.which <= 40){
	   evt.preventDefault();
    }
	var charCode = (evt.which) ? evt.which : evt.keyCode
	if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}

//Uso: onkeypress="return soloNumeros(event)"
function soloNumeros(event){
	var key = window.event ? event.keyCode : event.which;
	if (event.keyCode == 8 || event.keyCode == 46 ||  event.keyCode == 35  || event.keyCode == 36 || event.keyCode == 116
		|| event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 13 || event.keyCode == 16 || event.keyCode == 9) {
		return true;
	}
	else if ( key < 48 || key > 57 ) {
		return false;
	}
	else return true;
}

//Separador de miles al momento de escribir
function separadorMilesOnKey(event,input){
	  if(event.which >= 37 && event.which <= 40){
		  event.preventDefault();
	  }
	  var $this = $(input);
	  var num = $this.val().replace(/[^\d]/g,'').split("").reverse().join("");
	  var num2 = RemoveRougeChar(num.replace(/(.{3})/g,"$1.").split("").reverse().join(""), ".");
	  return $this.val(num2);
}

//Separacion de miles para guaranies y decimales para dolares
function separadorMilesDecimales(convertString, separa){
	if(convertString.substring(0,1) == separa){
		return convertString.substring(1, convertString.length)            
		}
	return convertString;
}

function separadorMiles(x) {
	if(x){
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	}else{
		return 0;
	}
}

function quitaSeparadorMiles(valor){
	if(valor){
		return parseInt(valor.replace(/\./g, ""));
	}else{
		return 0;
	}
}

//Enter desde el input hace click al button seleccionado
function enterClick(input, button){
	$("#"+input).keyup(function(event){
		if(event.keyCode == 13){
			$("#"+button).click();
			}
	});
}
//Quita todos los tags HTML
function htmlToText(x){
	return x.replace(/<[^>]*>/gi, ' - ');
}


function getDateTime() {
    var now     = new Date(); 
    var year    = now.getFullYear();
    var month   = now.getMonth()+1; 
    var day     = now.getDate();
    var hour    = now.getHours();
    var minute  = now.getMinutes();
    var second  = now.getSeconds(); 
    if(month.toString().length == 1) {
        var month = '0'+month;
    }
    if(day.toString().length == 1) {
        var day = '0'+day;
    }   
    if(hour.toString().length == 1) {
        var hour = '0'+hour;
    }
    if(minute.toString().length == 1) {
        var minute = '0'+minute;
    }
    if(second.toString().length == 1) {
        var second = '0'+second;
    }   
	//var dateTime = day+'/'+month+'/'+year+' '+hour+':'+minute+':'+second;   
    var dateTime = day+'/'+month+'/'+year+' '+hour+':'+minute+' hs';   
    return dateTime;
}

//Separacion de miles para guaranies y decimales para dolares
function RemoveRougeChar(convertString, separa){
	if(convertString.substring(0,1) == separa){
		return convertString.substring(1, convertString.length)            
		}
	return convertString;
}

function readImage(input, output, divFoto) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('#'+divFoto).css('display', 'inline');
			$('#'+output)
				.attr('src', e.target.result)
				.height(120);
			if (input.id == "foto1"){
				$('#borrarFot1').css('display', 'inline');
				$('#borrar_foto1').val('');
			}
			if (input.id == "foto2"){
				$('#borrarFot2').css('display', 'inline');
				$('#borrar_foto2').val('');
			}
			
			
			
		};

		reader.readAsDataURL(input.files[0]);
	}
}

function noSubmitForm(obj){
	$(obj).on('keyup keypress', function(e) {
	  var code = e.keyCode || e.which;
	  if (code == 13) { 
		e.preventDefault();
		return false;
	  }
	});
}


//Funcion que sirve para enviar variables por POST a un form en un popup. Esto evita que se vean las variables en la barra de direcciÃ³n del navegador
function OpenWindowWithPost(url, windowoption, name, params)
{
	var form = document.createElement("form");
	form.setAttribute("method", "post");
	form.setAttribute("action", url);
	form.setAttribute("target", name);
	for (var i in params) {
		if (params.hasOwnProperty(i)) {
			var input = document.createElement('input');
			input.type = 'hidden';
			input.name = i;
			input.value = params[i];
			form.appendChild(input);
		}
	}
	document.body.appendChild(form);
	window.open("", name, windowoption);
	form.submit();
	document.body.removeChild(form);
}

//Oculta div padre del alert al cerrar mensaje para que el efecto de fadein funcione
/*function ocultarMensaje(){
	$('#alerta').on('close.bs.alert', function () {
	  $('#alerta').parent().css("display","none");
	});
}*/

init();