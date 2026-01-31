var tabla;
var cont = 0;
var precioServicioPaquete = 0;
var agregados = [];


var contPrecio = 0;
var contMateriaPrima = 0;
var contProveedor = 0;
var contCodigoBarra = 0;

var detallePrecio = 0;
var detallesPrecio = 0;

var detalleMateriaPrima = 0;
var detallesMateriaPrima = 0;


var detalleProveedor = 0;
var detallesProveedor = 0;


var detalleCodigoBarra = 0;
var detallesCodigoBarra = 0;

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

function RemoveRougeChar(convertString, separa){
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




function actualizarOrden(x, orden){


	$.ajax({
    type: "POST",
    url: '../ajax/articulo.php?op=actualizarOrden',
    data: {id:orden, orden:x.value},
	dataType:"json",

    complete: function(data)
	{	
		//$('#modal').modal('hide');		
    }
	});
	
}


function validarCodigo(x){
	var codigo = x.value;
	//Habilitacion ticket
	$.post("../ajax/articulo.php?op=validarCodigo", {codigo:codigo} ,function(data, status)
		{
			data = JSON.parse(data);
			if (data.cantidad > 0) {

			$('#'+x.id ).focus();
			swal({
			  position: 'top-end',
			  type: 'error',
			  title: 'Codigo ya esta en uso',
			  showConfirmButton: false,
			  timer: 1500
			 })	

			}	
	 });
} 


function validarCodigoBarra(x){
	//Habilitacion ticket

	var codigo = x.value;



	$.post("../ajax/articulo.php?op=validarCodigoBarra", {codigo:codigo}, function(data, status)
		{

			data = JSON.parse(data);
			if (data.cantidad > 0) {

			$('#'+x.id ).focus();

			swal({
			  position: 'top-end',
			  type: 'error',
			  title: 'Codigo de barras ya esta en uso',
			  showConfirmButton: false,
			  timer: 1500
			 })	

			}	
	 });
}




//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	
 
$("#paquetedetalle").hide();
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	//Cargamos los items al select grupo
	$.post("../ajax/persona.php?op=selectProveedor", function(r){
	            $("#Persona_idPersona").html(r);
	            $('#Persona_idPersona').selectpicker('refresh');
	            $("#Persona_idPersona_d1").html(r);
	            $('#Persona_idPersona_d1').selectpicker('refresh');

	});
	//Cargamos los items al select grupo
	$.post("../ajax/articulo.php?op=selectGrupo", function(r){
	            $("#GrupoArticulo_idGrupoArticulo").html(r);
	            $('#GrupoArticulo_idGrupoArticulo').selectpicker('refresh');

	});

	//Cargamos los items al select grupo
	$.post("../ajax/marca.php?op=selectMarca", function(r){
	            $("#Marca_idMarca").html(r);
	            $('#Marca_idMarca').selectpicker('refresh');

	});

	//Cargamos los items al select categoria
	$.post("../ajax/articulo.php?op=selectCategoria", function(r){
	            $("#Categoria_idCategoria").html(r);
	            $('#Categoria_idCategoria').selectpicker('refresh');
	            // Subcategorías: cargar según la categoría seleccionada (padre)
	            var catPadre = $("#Categoria_idCategoria").val();
	            $.post("../ajax/articulo.php?op=selectCategoriaDetalle&Categoria_idCategoria="+catPadre, function(r2){
	                $("#Categoria_idCategoriaD").html(r2);
	                $('#Categoria_idCategoriaD').selectpicker('refresh'); 
	            });

	});



	//Cargamos los items al select impuesto
	$.post("../ajax/articulo.php?op=selectImpuesto", function(r){
	            $("#TipoImpuesto_idTipoImpuesto").html(r);
	            $('#TipoImpuesto_idTipoImpuesto').selectpicker('refresh');

	});

	//Cargamos los items al select unidad
	$.post("../ajax/articulo.php?op=selectUnidad", function(r){
	            $("#Unidad_idUnidad_l").html(r);
	            $('#Unidad_idUnidad_l').selectpicker('refresh');

	});

	$.post("../ajax/articulo.php?op=selectArticulos", function(r){
	            $("#Articulo_idArticulo_l").html(r);
	            $('#Articulo_idArticulo_l').selectpicker('refresh');


	            $("#Articulo_idArticulo_lp").html(r);
	            $('#Articulo_idArticulo_lp').selectpicker('refresh');	            

	});

	//Cargamos los items al select unidad
	$.post("../ajax/grupoPersona.php?op=selectGrupoPersona", function(r){
	            $("#GrupoPersona_idGrupoPersona_l").html(r);
	            $('#GrupoPersona_idGrupoPersona_l').selectpicker('refresh');

	});



	//Cargamos los items al select unidad
	$.post("../ajax/sucursal.php?op=selectSucursal", function(r){
	            $("#Sucursal_idSucursal_l").html(r);
	            $('#Sucursal_idSucursal_l').selectpicker('refresh');

	});



	$.post("../ajax/banco.php?op=selectCuentaContableFiltro", { filtro: 'PE' } ,function(r){
	            $("#CuentaContable_idCuentaContable").html(r);
	            $('#CuentaContable_idCuentaContable').selectpicker('refresh');
	            
	});
	//Cargamos los items al select grupo
	$.post("../ajax/rubro.php?op=selectRubro", function(r){
	            $("#Rubro_idRubro").html(r);
	            $('#Rubro_idRubro').selectpicker('refresh');

	});


	$("#imagenmuestra").hide();

	evaluar();

	// UX: mostrar/ocultar campos avanzados del formulario
	$(document).off('click', '#btnToggleAvanzadoArticulo').on('click', '#btnToggleAvanzadoArticulo', function(){
		$('.articulo-avanzado').toggle();
	});

	// Buscador: recargar tabla al escribir o al salir del campo
	var _tBuscar = null;
	$(document).off('input', '#buscar_art').on('input', '#buscar_art', function(){
		clearTimeout(_tBuscar);
		_tBuscar = setTimeout(function(){ listarOriginal(); }, 350);
	});

	// Cargar listado al iniciar la página
	listarOriginal();
}


function crud(ventana){
	window.open("../vistas/"+ ventana +".php", "Diseño Web", "width=600, height=600");
}


$(document).ready(function()
{  
	$("#Categoria_idCategoria").on('change',function()
	{
	//Cargamos los items al select categoria
		var Categoria_idCategoria=$("#Categoria_idCategoria").val(); 
		$.post("../ajax/articulo.php?op=selectCategoriaDetalle&Categoria_idCategoria="+Categoria_idCategoria, function(r){
		    $("#Categoria_idCategoriaD").html(r);
		    $('#Categoria_idCategoriaD').selectpicker('refresh'); 
		});
	});
});


function evaluar(){
	var seleccion = $("#tipoArticulo").val();
	if (seleccion == 'PRODUCTO') {
		$("#CuentaContable_idCuentaContable").prop('disabled', true);
	    $('#CuentaContable_idCuentaContable').selectpicker('refresh');
	}


	if (seleccion == 'PRODUCTO') {
		$("#CuentaContable_idCuentaContable").prop('disabled', true);
	    $('#CuentaContable_idCuentaContable').selectpicker('refresh');
	}

	if (seleccion == 'SERVICIO') {
		$("#CuentaContable_idCuentaContable").prop('disabled', false);
	    $('#CuentaContable_idCuentaContable').selectpicker('refresh');
	}

}

function detalle(idArticulo){
	$('#modal_detalle4').modal('show');
	$("#detalle4").val(idArticulo);
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
					url: '../ajax/articulo.php?op=detalle',
					data:{idArticulo:idArticulo},
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
	$("#imagenmuestra").attr("src","../files/articulos/noimage.png");

	$("#comisiongs").val("");
	$("#comisionp").val("");

	
	$(".filaCodigoBarra").remove();
	$(".filaPrecio").remove();
	$(".filaProveedor").remove();
}
 

function addDetalleCodigoBarra()
  {


var  codigoBarra = [];
var phpCodigoBarra = document.getElementsByName("codigoBarra_detalle[]");


//RECORRIDO POR GRUPO DE SUCURSAL - COMENTAR PARA NO VALIDAR

    for (var index = 0; index < document.getElementsByName("codigoBarra_detalle[]").length; index++) {
        codigoBarra.push(phpCodigoBarra[index].value);
    }
    localStorage.setItem("codigoBarra", codigoBarra);


	//var Persona_idPersona = $("#Persona_idPersona_d1 option:selected").val();
  	var codigoBarra_l = $("#codigoBarra_l").val();
  	var descripcionCodigoBarra_l = $("#descripcionCodigoBarra_l").val();

	var Unidad_idUnidad_l = $("#Unidad_idUnidad_l option:selected").val();
  	var Unidad_idUnidad_text_l = $("#Unidad_idUnidad_l option:selected").text();


    for (var i = 0; i < codigoBarra.length; i++) {
        if (codigoBarra[i] == codigoBarra_l) {
        	swal({
			  position: 'top-end',
			  type: 'error',
			  title: 'Codigo de Barra ya esta en uso',
			  showConfirmButton: false,
			  timer: 1500
			 })	
            return;
        }
    }

    	var cantidadDefecto = 1;

    	var fila=
    	'<tr class="filaCodigoBarra" id="filaCodigoBarra'+contCodigoBarra+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleCodigoBarra ('+contCodigoBarra+', 0)">X</button></td>'+
    	'<td><input type="hidden" name="Unidad_idUnidad_detalle[]" value="'+Unidad_idUnidad_l+'">'+Unidad_idUnidad_text_l+'</td>'+
    	'<td><input type="hidden" name="cantidad_detalle[]" value="'+cantidadDefecto+'">'+cantidadDefecto+'</td>'+
    	'<td><input type="text" name="descripcionCodigoBarra_detalle[]" id="descripcionCodigoBarra_detalle[]" value="'+descripcionCodigoBarra_l+'"></td>'+
    	'<td><input type="hidden" name="codigoBarra_detalle[]" onblur="validarCodigoBarra(this)" id="codigoBarra_detalle'+contCodigoBarra+'" value="'+codigoBarra_l+'">'+ codigoBarra_l +'</td>'+
    	'<td><input type="hidden" name="idArticulo_Codigo[]" id="idArticulo_Codigo[]" value="0"></td>'+
    	'</tr>';
    	contCodigoBarra++;
    	detallesCodigoBarra=detallesCodigoBarra+1;
    	$('#detalleCodigoBarra').append(fila);
    	localStorage.setItem("codigoBarra", codigoBarra);
		$("#btnGuardar").prop("disabled",false);


  }

  function eliminarDetalleCodigoBarra(indice, valor){


			if (valor > 0) {
			
        	$.post("../ajax/articulo.php?op=desactivarArticuloCodigo", {idArticulo_Codigo : valor}, function(e){

        	});
			}	

        	
		  	$("#filaCodigoBarra" + indice).remove();
		  	detallesProveedor=detallesProveedor-1;
		  	if(document.getElementsByName("Persona_idPersona_detalle[]").length <=0){
				$("#btnGuardar").prop("disabled",true);
		  	}

}


function addDetallePrecio()
  {


var sucursal = [];
var grupoPersona = [];
var phpSucursal = document.getElementsByName("Sucursal_idSucursal[]");
var phpGrupoPersona = document.getElementsByName("GrupoPersona_idGrupoPersona[]");

 

    for (var index = 0; index < document.getElementsByName("GrupoPersona_idGrupoPersona[]").length; index++) {
        grupoPersona.push(phpGrupoPersona[index].value);
    }
    localStorage.setItem("grupoPersona", grupoPersona);

	var Sucursal_idSucursal = $("#Sucursal_idSucursal_l option:selected").val();
  	var Sucursal_idSucursal_text = $("#Sucursal_idSucursal_l option:selected").text();

	var GrupoPersona_idGrupoPersona = $("#GrupoPersona_idGrupoPersona_l option:selected").val();
  	var GrupoPersona_idGrupoPersona_text = $("#GrupoPersona_idGrupoPersona_l option:selected").text();

	var costo = $("#costo").val();
	var precio = $("#precio_l").val();
	var margen = $("#margen_l").val();

	if (!precio) {
		alert('Precio es nulo');
		$("#precio_l").focus();
		return;
	}

//RECORRIDO POR GRUPO DE SUCURSAL - COMENTAR PARA NO VALIDAR

    for (var index = 0; index < document.getElementsByName("Sucursal_idSucursal[]").length; index++) {
        sucursal.push(phpSucursal[index].value);
    }
    localStorage.setItem("sucursal", sucursal);



    for (var i = 0; i < sucursal.length; i++) {
        if (sucursal[i] == Sucursal_idSucursal) {

        				swal({
			  position: 'top-end',
			  type: 'success',
			  title: 'Sucursal ya fue agregado, favor verifique.',
			  showConfirmButton: false,
			  timer: 1500
			 })	

            return;
        }
    }

 
 
    	var fila=
    	'<tr class="filaPrecio" id="filaPrecio'+contPrecio+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetallePrecio ('+contPrecio+', 0)">X</button></td>'+
    	'<td><input type="hidden" name="Sucursal_idSucursal[]" value="'+Sucursal_idSucursal+'">'+Sucursal_idSucursal_text+'</td>'+
    	'<td><input type="hidden" name="GrupoPersona_idGrupoPersona[]" value="'+GrupoPersona_idGrupoPersona+'">'+GrupoPersona_idGrupoPersona_text+'</td>'+
    	'<td><input type="hidden" name="margen[]" id="margen[]" value="'+margen+'">'+margen+'</td>'+
    	'<td><input type="text" name="precio[]" id="precio[]" value="'+precio+'"></td>'+
    	'<td><input type="hidden" name="idPrecio[]" id="idPrecio[]" value="0"></td>'+
    	'</tr>';
    	contPrecio++;
    	detallesPrecio=detallesPrecio+1;
    	$('#detalle').append(fila);
    	localStorage.setItem("sucursal", sucursal);
    	localStorage.setItem("grupoPersona", grupoPersona);
		$("#btnGuardar").prop("disabled",false);


  }

/*
function addDetalleMateriaPrima()
  {
 
	var articulo = [];
	var canje = [];
	var phpArticulo = document.getElementsByName("Articulo_idArticulo[]");
	var phpCanje = document.getElementsByName("Canje[]");
	   
	//RECORRIDO POR GRUPO DE PERSONA - COMENTAR PARA NO VALIDAR

  

	var Articulo_idArticulo = $("#Articulo_idArticulo_l option:selected").val();
  	var Articulo_idArticulo_text = $("#Articulo_idArticulo_l option:selected").text();

	var Canje = $("#Canje_l option:selected").val();
  	var Canje_text = $("#Canje_l option:selected").text();

	var costo = $("#costo").val();
	var precio = $("#precio_l").val();
	var cantidadMateriaPrima = $("#cantidad_l").val();

 
	if (!cantidadMateriaPrima) {
		alert('Cantidad es nulo');
		$("#cantidad_l").focus();
		return;
	}	
 
	var fila=
	'<tr class="filaMateriaPrima" id="filaMateriaPrima'+contMateriaPrima+'">'+
	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleMateriaPrima ('+contMateriaPrima+', 0)">X</button></td>'+
	'<td><input type="hidden" name="Articulo_idArticulo[]" value="'+Articulo_idArticulo+'">'+Articulo_idArticulo_text+'</td>'+
	'<td><input type="hidden" name="Canje[]" value="'+Canje+'">'+Canje_text+'</td>'+
	'<td><input type="text" name="cantidadMateriaPrima[]" id="cantidadMateriaPrima[]" value="'+cantidadMateriaPrima+'"></td>'+
	'</tr>'; 
	contMateriaPrima++; 
	detallesMateriaPrima=detallesMateriaPrima+1;
	$('#detalleMateriaPrima').append(fila);
	localStorage.setItem("articulo", articulo);
	localStorage.setItem("canje", canje);
	$("#btnGuardar").prop("disabled",false); 

  }  

 
  function eliminarDetalleMateriaPrima(indice, valor){



			if (valor > 0) {

        	$.post("../ajax/articulo.php?op=desactivarMateriaPrima", {idArticulo_Detalle : valor}, function(e){

        	});	

        	}
        	
		  	$("#filaMateriaPrima" + indice).remove();
		  	detallesMateriaPrima=detallesMateriaPrima-1;
 

}
*/


function addDetalleMateriaPrima()
  {
 
	var articulo = [];
	var canje = [];
	var phpArticulo = document.getElementsByName("Articulo_idArticulolp[]");
	var phpCanje = document.getElementsByName("Canje[]");
	   
	//RECORRIDO POR GRUPO DE PERSONA - COMENTAR PARA NO VALIDAR

   /* for (var index = 0; index < document.getElementsByName("Canje[]").length; index++) {
        canje.push(Canje[index].value);
    }
    localStorage.setItem("canje", canje);*/ 

	var Articulo_idArticulop = $("#Articulo_idArticulo_lp option:selected").val();
  	var Articulo_idArticulo_textp = $("#Articulo_idArticulo_lp option:selected").text();

	var Canje = $("#Canje_l option:selected").val();
  	var Canje_text = $("#Canje_l option:selected").text();

	var costo = $("#costo").val();
	var precio = $("#precio_l").val();
	var cantidadMateriaPrima = $("#cantidad_l").val();

 
	if (!cantidadMateriaPrima) {
		alert('Cantidad es nulo');
		$("#cantidad_l").focus();
		return;
	}	
 
	var fila2=
	'<tr class="filaMateriaPrima" id="filaMateriaPrima'+contMateriaPrima+'">'+
	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleMateriaPrima ('+contMateriaPrima+', 0)">X</button></td>'+
	'<td><input type="hidden" name="Articulo_idArticulop[]" value="'+Articulo_idArticulop+'">'+Articulo_idArticulo_textp+'</td>'+
	'<td><input type="hidden" name="Canje[]" value="'+Canje+'">'+Canje_text+'</td>'+
	'<td><input type="text" name="cantidadMateriaPrima[]" id="cantidadMateriaPrima[]" value="'+cantidadMateriaPrima+'"></td>'+
	'<td><input type="hidden" name="idArticulo_Detalle[]" id="idArticulo_Detalle[]" value="0"></td>'+
	'</tr>'; 
	contMateriaPrima++; 
	detallesMateriaPrima=detallesMateriaPrima+1;
	$('#detalleMateriaPrima').append(fila2);
	localStorage.setItem("articulo", articulo);
	localStorage.setItem("canje", canje);
	$("#btnGuardar").prop("disabled",false); 

  }  

 
  function eliminarDetalleMateriaPrima(indice, valor){



			if (valor > 0) {

        	$.post("../ajax/articulo.php?op=desactivarMateriaPrima", {idArticulo_Detalle : valor}, function(e){

        	});	

        	}
        	
		  	$("#filaMateriaPrima" + indice).remove();
		  	detallesMateriaPrima=detallesMateriaPrima-1;
		  /*	if(document.getElementsByName("Sucursal_idSucursal[]").length <=0){
				$("#btnGuardar").prop("disabled",true);
		  	} */ 

}

  function eliminarDetallePrecio(indice, valor){



			if (valor > 0) {

        	$.post("../ajax/articulo.php?op=desactivarPrecio", {idPrecio : valor}, function(e){

        	});	

        	}
        	
		  	$("#filaPrecio" + indice).remove();
		  	detallesPrecio=detallesPrecio-1;
		  	if(document.getElementsByName("Sucursal_idSucursal[]").length <=0){
				$("#btnGuardar").prop("disabled",true);
		  	}

}





function addDetalleProveedor()
  {


var proveedor = [];
var phpProveedor = document.getElementsByName("Persona_idPersona_detalle[]");


//RECORRIDO POR GRUPO DE SUCURSAL - COMENTAR PARA NO VALIDAR

    for (var index = 0; index < document.getElementsByName("Persona_idPersona_detalle[]").length; index++) {
        proveedor.push(phpProveedor[index].value);
    }
    localStorage.setItem("proveedor", proveedor);


	var Persona_idPersona = $("#Persona_idPersona_d1 option:selected").val();
  	var Persona_idPersona_text = $("#Persona_idPersona_d1 option:selected").text();

	var prioridad = $("#prioridad_d1 option:selected").val();
  	var prioridad_text = $("#prioridad_d1 option:selected").text();

	var descontinuado = $("#descontinuado_d1 option:selected").val();
  	var descontinuado_text = $("#descontinuado_d1 option:selected").text();


	var codigoProveedor = $("#codigoProveedor_d1").val();
	var precio_compra_d1 = $("#precio_compra_d1").val();


    for (var i = 0; i < proveedor.length; i++) {
        if (proveedor[i] == Persona_idPersona) {
        				swal({
			  position: 'top-end',
			  type: 'error',
			  title: 'Proveedor ya fue agregado, favor verifique.',
			  showConfirmButton: false,
			  timer: 1500
			 })	
            return;
        }
    }



    	var fila=
    	'<tr class="filaProveedor" id="filaProveedor'+contProveedor+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleProveedor ('+contProveedor+', 0)">X</button></td>'+
    	'<td><input type="hidden" name="Persona_idPersona_detalle[]" value="'+Persona_idPersona+'">'+Persona_idPersona_text+'</td>'+
    	'<td><input type="text" name="codigoProveedor_detalle[]" id="codigoProveedor_detalle[]" value="'+codigoProveedor+'"></td>'+
    	'<td><input type="text" name="precioCompra_detalle[]" id="precioCompra_detalle[]" value="'+precio_compra_d1+'"></td>'+
    	'<td><input type="text" name="prioridad_detalle[]" id="prioridad_detalle[]" value="'+prioridad+'"></td>'+
    	'<td><input type="hidden" name="descontinuado_detalle[]" value="'+descontinuado+'">'+descontinuado_text+'</td>'+
    	'<td><input type="hidden" name="idArticulo_Proveedor[]" id="idArticulo_Proveedor[]" value="0"></td>'+
    	'</tr>';
    	contProveedor++;
    	detallesProveedor=detallesProveedor+1;
    	$('#detalleProveedor').append(fila);
    	localStorage.setItem("proveedor", proveedor);
		$("#btnGuardar").prop("disabled",false);


  }

  function eliminarDetalleProveedor(indice, valor){


			if (valor > 0) {
			
        	$.post("../ajax/articulo.php?op=desactivarArticuloProveedor", {idArticulo_Proveedor : valor}, function(e){

        	});
			}	

        	
		  	$("#filaProveedor" + indice).remove();
		  	detallesProveedor=detallesProveedor-1;
		  	if(document.getElementsByName("Persona_idPersona_detalle[]").length <=0){
				$("#btnGuardar").prop("disabled",true);
		  	}

}


//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	//$("#cosas").hide();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#buscador").hide();
		$("#formularioregistros").show();
		$("#btnagregar").hide();
		$("#btnGuardar").prop("disabled",false);

	}
	else
	{
		$("#listadoregistros").show();
		$("#buscador").show();
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

function crud(ventana) {
    var ventanawo = window.open("../vistas/"+ ventana +".php", "PYVENTAS"+ventana, "width=600, height=600");
    var interval = setInterval(function(){
        if(ventanawo.closed !== false) {

          window.clearInterval(interval)
          
			

			if (ventana == "grupoArticulo") {
			$.post("../ajax/articulo.php?op=selectGrupo", function(r){
			            $("#GrupoArticulo_idGrupoArticulo").html(r);
			            $('#GrupoArticulo_idGrupoArticulo').selectpicker('refresh');

			});
			}

			else if(ventana == "unidad"){
			//Cargamos los items al select unidad
			$.post("../ajax/articulo.php?op=selectUnidad", function(r){
			            $("#Unidad_idUnidad_l").html(r);
			            $('#Unidad_idUnidad_l').selectpicker('refresh');

			});
			}

			else if(ventana == "persona"){
			$.post("../ajax/persona.php?op=selectProveedor", function(r){
			            $("#Persona_idPersona").html(r);
			            $('#Persona_idPersona').selectpicker('refresh');

    					$("#Persona_idPersona_d1").html(r);
			            $('#Persona_idPersona_d1').selectpicker('refresh');


			});
			}
			else if(ventana == "marca"){
			$.post("../ajax/marca.php?op=selectMarca", function(r){
			            $("#Marca_idMarca").html(r);
			            $('#Marca_idMarca').selectpicker('refresh');

			});
			}
			else if(ventana == "categoria"){
			$.post("../ajax/articulo.php?op=selectCategoria", function(r){
			            $("#Categoria_idCategoria").html(r);
			            $('#Categoria_idCategoria').selectpicker('refresh');
			            $("#Categoria_idCategoriaD").html(r);
			            $('#Categoria_idCategoriaD').selectpicker('refresh');

			});
			}


        } 


    },1000)
    
  
}




 
//Función Listar (formato original DataTable)
function listarOriginal()
{
	var x = $("#buscar_art").val() || '';

	if (!$('#tbllistado').length) return;

	if ($.fn.DataTable.isDataTable('#tbllistado')) {
		$('#tbllistado').DataTable().destroy();
	}

	try {
		tabla = $('#tbllistado').dataTable({
			"aProcessing": true,
			"ajax": {
				url: '../ajax/articulo.php?op=listarOriginal',
				type: 'get',
				data: { x: x },
				dataType: 'json',
				dataSrc: 'aaData',
				error: function(e) { console.log(e.responseText); }
			},
			"columns": [
				{ data: 0 }, { data: 1 }, { data: 2 }, { data: 3 }, { data: 4 }, { data: 5 }, { data: 6 }, { data: 7 },
				{ data: 8 }, { data: 9 }, { data: 10 }, { data: 11 }, { data: 12 }, { data: 13 }, { data: 14 }, { data: 15 },
				{ data: 16 }, { data: 17 }, { data: 18 }, { data: 19 }, { data: 20 }, { data: 21 }, { data: 22 }
			],
			"columnDefs": [
				{ "responsivePriority": 1, "targets": [0, 1, 2, 17, 18, 22] },
				{ "responsivePriority": 2, "targets": [4, 5, 11] },
				{ "responsivePriority": 3, "targets": [3, 6, 7, 8, 9, 10, 12, 13, 14, 15, 16, 19, 20, 21] }
			],
			"responsive": {
				"details": {
					"type": "inline",
					"target": "tr"
				}
			},
			dom: 'Bfrtip',
			buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf'],
			"bDestroy": true,
			"iDisplayLength": 25,
			"order": [[1, "desc"]],
			"language": {
				"lengthMenu": "Mostrar _MENU_ registros",
				"zeroRecords": "No se encontraron resultados",
				"info": "Mostrando _START_ a _END_ de _TOTAL_",
				"infoEmpty": "Mostrando 0 a 0 de 0",
				"infoFiltered": "(filtrado de _MAX_)",
				"search": "Buscar:",
				"paginate": { "first": "Primero", "last": "Último", "next": "Siguiente", "previous": "Anterior" }
			},
			"fnRowCallback": function(nRow, aaData) {
				if (aaData[22] && aaData[22].indexOf('Inactivo') !== -1) {
					$('td', nRow).css('background-color', '#f2dede');
				}
			}
		}).DataTable();
	} catch (e) {
		console.error('Error al cargar listado de artículos:', e);
	}
}



 
//Función Listar
function listar()
{


        $(document).ready(function(){
           $("#tbllistado").DataTable({
           			"fnRowCallback": function( nRow, aaData, iDisplayIndex, iDisplayIndexFull ) {
		  if ( aaData[20] != '<span class="label bg-green">Activado</span>' )
		  {
			$('td', nRow).css('background-color', '#f2dede' );
		  }
		},
		
		"language": {
            "decimal": ",",
            "thousands": "."
        },
		"processing": true,//Activamos el procesamiento del datatables
	    "serverSide": true,//Paginación y filtrado realizados por el servidor

	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
              "processing": true,
              "serverSide": true,
              "responsive": true,
              "sAjaxSource": "../ajax/articulo.php?op=listar",
              "columnDefs":[{
                  "data":null
              }]   
           }); 
        });
 
}


function guardaryeditar(e)
{


	//if (contPrecio > 0  || $("#idArticulo").val() > 1 ) {


		// UX/Operación: no bloquear el guardado si no se usa código de barras.
		// (Muchos artículos/servicios se cargan sin barcode. La sección sigue disponible si se quiere usar.)
		e.preventDefault(); //No se activará la acción predeterminada del evento
		$("#btnGuardar").prop("disabled",true);
		var formData = new FormData($("#formulario")[0]);

		$.ajax({
			url: "../ajax/articulo.php?op=guardaryeditar",
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
		          if (typeof tabla !== 'undefined' && tabla && tabla.ajax) {
		              tabla.ajax.reload();
		          }
		    }

		});
		limpiar();

	//}else{


	//	swal({
	//		  position: 'top-end',
	//		  type: 'error',
	//		  title: 'Se debe agregar por lo menos un precio.',
	//		  showConfirmButton: false,
	//		  timer: 50000
	//		 })		

	//}



}



function calcularPrecioVenta(){

	var margen 	=	$("#margen_l").val();

	if (margen != 0) {
		var costo 	=	$("#costo").val();
		var precio 	= (((parseFloat(costo) * parseFloat(margen)) / 100) + parseFloat(costo));
		alert(costo);
		alert(precio);

		$("#precio_l").val(precio);
	}

}



function calcularMargen(){


	var costo 	=	$("#costo").val();
	var precio 	= ((parseFloat(costo) * parseFloat(margen)) / 100) + parseFloat(costo);
	var margen = 0;


	$("#margen_l").val(margen);

}

function ajuste_actualizar_precio(x,idPrecio,precio){

    $.ajax({
        type: "get",
        url: '../ajax/consultas.php?op=ajuste_actualizar_precio',
        data: {precio:x.value, idPrecio:idPrecio},
        dataType:"json",
    })

}
function mostrarDetallePrecio(idArticulo){ 
	$('#modal_detalle').modal('show');
	$("#detalle").val(idArticulo);  
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
					url: '../ajax/consultas.php?op=rpt_precioventa',
					data:{idArticulo:idArticulo}, 
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
 	if (data.codigoBarra > 0) {
 		generarbarcode();
 	}
	$("#codigoAlternativo").val(data.codigoAlternativo);
	$("#print").hide();
	$("#tipoArticulo").val(data.tipoArticulo);
	$("#tipoArticulo").selectpicker('refresh');


	$("#GrupoArticulo_idGrupoArticulo").val(data.GrupoArticulo_idGrupoArticulo);
	$("#GrupoArticulo_idGrupoArticulo").selectpicker('refresh');


	$("#Categoria_idCategoria").val(data.Categoria_idCategoriaPadre);
	$("#Categoria_idCategoria").selectpicker('refresh');
	// Cargar subcategorías filtradas por categoría padre y luego setear la actual
	var catPadre = data.Categoria_idCategoriaPadre;
	$.post("../ajax/articulo.php?op=selectCategoriaDetalle&Categoria_idCategoria="+catPadre, function(r){
	    $("#Categoria_idCategoriaD").html(r);
	    $("#Categoria_idCategoriaD").val(data.Categoria_idCategoria);
	    $("#Categoria_idCategoriaD").selectpicker('refresh');
	});
	
	$("#TipoImpuesto_idTipoImpuesto").val(data.TipoImpuesto_idTipoImpuesto);
	$("#TipoImpuesto_idTipoImpuesto").selectpicker('refresh');
	

	$("#Unidad_idUnidad").val(data.Unidad_idUnidad);
	$("#Unidad_idUnidad").selectpicker('refresh');
	
	$("#Unidad_idUnidadCompra").val(data.Unidad_idUnidadCompra);
	$("#Unidad_idUnidadCompra").selectpicker('refresh');

	$("#precioVenta").val(data.precioVenta);
	$("#costo").val(data.costo);
	$("#usuarioInsersion").val(data.usuarioInsersion);
	$("#usuarioModificacion").val(data.usuarioModificacion);
	//$("#imagen").val(data.imagen);
	$("#imagenmuestra").show();
	if (data.imagen) {
	$("#imagenmuestra").attr("src","../files/articulos/"+data.imagen);
	}else{
	$("#imagenmuestra").attr("src","../files/articulos/noimage.png");
	}
	//$("#imagenactual").val(data.imagen);
	$("#comisiongs").val(data.comision);
	$("#comisionp").val(data.comisionp);
	
	$("#Persona_idPersona").val(data.Persona_idPersona);
	$("#Persona_idPersona").selectpicker('refresh');

	$("#Marca_idMarca").val(data.Marca_idMarca);
	$("#Marca_idMarca").selectpicker('refresh');

	$("#CuentaContable_idCuentaContable").val(data.CuentaContable_idCuentaContable);
	$("#cantidadPalet").val(data.cantidadPalet);
	$("#cantidadCaja").val(data.cantidadCaja);
	$("#cantidadPiso").val(data.cantidadPiso);
	$("#pesoLiquido").val(data.pesoLiquido);
	$("#pesoBruto").val(data.pesoBruto);
	$("#idArticulo").val(data.idArticulo);

		// Cargar detalles solo después de mostrar el formulario (precio, proveedor, códigos de barras)
		$.post("../ajax/articulo.php?op=listarDetallePrecio&idArticulo="+idArticulo,function(r){
			$("#detalle").html(r);
		});
		$.post("../ajax/articulo.php?op=listarDetalleArticuloProveedor&idArticulo="+idArticulo,function(r){
			$("#detalleProveedor").html(r);
		});
		// Cargar códigos de barras al editar: mostrar con opción de editar, borrar o agregar más
		$.post("../ajax/articulo.php?op=listarDetalleCodigoBarras&idArticulo="+idArticulo,function(r){
			if (r && typeof r === 'string') {
				$("#detalleCodigoBarra tbody").html(r);
				if (r.trim() !== '' && r.indexOf('No hay códigos') === -1) {
					$('a[href="#tab_codigos_barras"]').tab('show');
				}
			}
		});
		evaluar();

	});
}

//Función para desactivar registros
function desactivar(idArticulo)
{

        	$.post("../ajax/articulo.php?op=desactivar", {idArticulo : idArticulo}, function(e){

	            tabla.ajax.reload();
        	});	

}


//Función para activar registros
function activar(idArticulo)
{

        	$.post("../ajax/articulo.php?op=activar", {idArticulo : idArticulo}, function(e){

	            tabla.ajax.reload();
        	});	

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



function actualizarGs(x, id, servicio){
	var comision = x.value;
	var paquete = id;
	var servicio = servicio;

	$.ajax({
    type: "POST",
    url: '../ajax/articulo.php?op=ajuste_actualizar_gs',
    data: {comision:comision, paquete:paquete, servicio:servicio},
	dataType:"json",

    complete: function(data)
	{	
		//$('#modal').modal('hide');		
    }
	});
	
}

function actualizarP(x, id, servicio){
	var comisionP = x.value;
	var paquete = id;
	var servicio = servicio;

	$.ajax({
    type: "POST",
    url: '../ajax/articulo.php?op=ajuste_actualizar_p',
    data: {comisionP:comisionP, paquete:paquete, servicio:servicio},
	dataType:"json",

    complete: function(data)
	{	
		//$('#modal').modal('hide');		
    }
	});
	
}

function actualizarC(x, id, servicio){
	var cantidad = x.value;
	var paquete = id;
	var servicio = servicio;

	$.ajax({
    type: "POST",
    url: '../ajax/articulo.php?op=ajuste_actualizar_c',
    data: {cantidad:cantidad, paquete:paquete, servicio:servicio},
	dataType:"json",

    complete: function(data)
	{	
		//$('#modal').modal('hide');		
    }
	});
	
}

function refresh(x){
	
	//x = valor (this)
	//y = id
	//z = opcion
	
	foco = parseInt(x.id);

//	var foco = parseInt(x.id);
//	var foco1 = parseInt(x.id) + 5;
//	document.getElementById(foco).focus();
//	$('#' + foco1).val(5);
	listar();	 
}



function imagenTest(x) {
	$("#imagenmuestra").attr("src",URL.createObjectURL(x.files[0]));
	$("#imagenmuestra").show();

}




$(document).ready(function() {
	init();
});



