var tabla;

//Función que se ejecuta al inicio
function init(){
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


	$.post("../ajax/tipoSalario.php?op=selectTipoSalario", function(r){
	            $("#TipoSalario_idTipoSalario").html(r);
	            $('#TipoSalario_idTipoSalario').selectpicker('refresh');

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


//Función limpiar
function limpiar()
{
	$("#idConceptoSalario").val("");
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
					url: '../ajax/conceptoSalario.php?op=listar',
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
		url: "../ajax/conceptoSalario.php?op=guardaryeditar",
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
function desactivar(idConceptoSalario)
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
	    url: '../ajax/conceptoSalario.php?op=desactivar',
	    data: {idConceptoSalario:idConceptoSalario},
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
function activar(idConceptoSalario)
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
	    url: '../ajax/conceptoSalario.php?op=activar',
	    data: {idConceptoSalario:idConceptoSalario},
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



function mostrar(idConceptoSalario)
{
	$.post("../ajax/conceptoSalario.php?op=mostrar",{idConceptoSalario : idConceptoSalario}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#TipoLiquidacion_idTipoLiquidacion").val(data.TipoLiquidacion_idTipoLiquidacion);
		$("#TipoLiquidacion_idTipoLiquidacion").selectpicker('refresh');
		$("#TipoSalario_idTipoSalario").val(data.TipoSalario_idTipoSalario);
		$("#TipoSalario_idTipoSalario").selectpicker('refresh');
		$("#tipo").val(data.tipo);
		$("#tipo").selectpicker('refresh');
		$("#esSalario").val(data.esSalario);
		$("#esSalario").selectpicker('refresh');
		$("#porcentaje").val(data.porcentaje);
		$("#descripcion").val(data.descripcion);
 		$("#idConceptoSalario").val(data.idConceptoSalario);


 	})
}



init();