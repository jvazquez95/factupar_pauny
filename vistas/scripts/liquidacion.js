var tabla;

//Función que se ejecuta al inicio
function init(){

	$("#detalle").hide();

	var id =getUrlParameter('id');
	if (id > 0) {
		mostrarform(true);
	}else{
		mostrarform(false);
	}
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})


	$.post("../ajax/tipoLiquidacion.php?op=selectTipoLiquidacion", function(r){
	            $("#TipoLiquidacion_idTipoLiquidacion").html(r);
	            $('#TipoLiquidacion_idTipoLiquidacion').selectpicker('refresh');

	});


	$.post("../ajax/moneda.php?op=selectMoneda", function(r){
	            $("#Moneda_idMoneda").html(r);
	            $('#Moneda_idMoneda').selectpicker('refresh');

	});
	


}


var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};



function generarLiquidacionDetallado(){

window.open("../reportes/rptDetalleLiquidacion.php?id="+ g_idHacerPedido, "PYVENTAS", "width=600, height=600");


}

function generarLiquidacionResumido(){

window.open("../reportes/rptResumenLiquidacion.php?id="+ g_idHacerPedido, "PYVENTAS", "width=600, height=600");


}



function generarLegajoLiquidacion(){

window.open("../reportes/rptLegajoLiquidacion.php?id="+ g_idHacerPedido, "PYVENTAS", "width=600, height=600");


}


//Función limpiar
function limpiar()
{
	$("#idLiquidacion").val("");
	$("#TipoLiquidacion_idTipoLiquidacion").val("");
	$("#TipoLiquidacion_idTipoLiquidacion").selectpicker('refresh');

	$("#TipoSalario_idTipoSalario").val("");
	$("#TipoSalario_idTipoSalario").selectpicker('refresh');

	$("#esSalario").val(1);
	$("#esSalario").selectpicker('refresh');

	$("#porcentaje").val("");
	$("#descripcion").val("");

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



//Función cancelarform
function volver()
{
	$("#cabecera").show();
	$("#detalle").hide();
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
					url: '../ajax/liquidacion.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
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
		url: "../ajax/liquidacion.php?op=guardaryeditar",
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


//Función para desactivar registros
function desactivar(idLiquidacion)
{
	swal({
		  title: 'Esta seguro de desactivar la ciudad?',
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
	    url: '../ajax/liquidacion.php?op=desactivar',
	    data: {idLiquidacion:idLiquidacion},
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
function activar(idLiquidacion)
{
	swal({
		  title: 'Esta seguro de activar la ciudad?',
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
	    url: '../ajax/liquidacion.php?op=activar',
	    data: {idLiquidacion:idLiquidacion},
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



function mostrar(idLiquidacion)
{
	$.post("../ajax/liquidacion.php?op=mostrar",{idLiquidacion : idLiquidacion}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#TipoLiquidacion_idTipoLiquidacion").val(data.TipoLiquidacion_idTipoLiquidacion);
		$("#TipoLiquidacion_idTipoLiquidacion").selectpicker('refresh');

		$("#Moneda_idMoneda").val(data.TipoSalario_idTipoSalario);
		$("#Moneda_idMoneda").selectpicker('refresh');
		
		$("#fechaInicioPeriodo").val(data.fechaInicioPeriodo);
		$("#fechaFinPeriodo").val(data.fechaFinPeriodo);
		$("#fechaApertura").val(data.fechaApertura);
 		$("#TipoLiquidacion_idTipoLiquidacion").val(data.TipoLiquidacion_idTipoLiquidacion);
 		$("#Moneda_idMoneda").val(data.Moneda_idMoneda);


 	})
}


function mostrarDetalle(id)
{

	l_idhacerpedidodetalle = id;
	g_idHacerPedido = id;
	$("#cabecera").hide();
	$("#detalle").show();


	tabla=$('#tbllistadoDetalle').dataTable(
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
					url: '../ajax/liquidacion.php?op=mostrarDetalle',
					type : "get",
					data : { idLiquidacion:id },
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
					
		"bDestroy":true,
        "scrollY":        "380px",
        "scrollCollapse": true,
        "paging":         false,
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();

}




init();