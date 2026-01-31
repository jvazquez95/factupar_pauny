var tabla;

//Función que se ejecuta al inicio
function init(){
	var id =getUrlParameter('id');
	if (id > 0) {
		mostrarform(true);

		$.post("../ajax/legajo.php?op=selectFuncionario", function(r){
		            $("#Legajo_idLegajo").html(r);
		            $('#Legajo_idLegajo').selectpicker('refresh');

		            $("#Legajo_idLegajo").val(id);
		            $('#Legajo_idLegajo').selectpicker('refresh');
		});

	}else{

		mostrarform(false);
			$.post("../ajax/legajo.php?op=selectLegajo", function(r){
	            $("#Legajo_idLegajo").html(r);
	            $('#Legajo_idLegajo').selectpicker('refresh');

	});
	}
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})


	$.post("../ajax/tipoComunicacion.php?op=selectTipoComunicacion", function(r){
	            $("#TipoComunicacion_idTipoComunicacion").html(r);
	            $('#TipoComunicacion_idTipoComunicacion').selectpicker('refresh');

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
	$("#idComunicacionPersonal").val("");
	$("#Legajo_idLegajo").val("");
	$("#Legajo_idLegajo").selectpicker('refresh');

	$("#TipoComunicacion_idTipoComunicacion").val("");
	$("#TipoComunicacion_idTipoComunicacion").selectpicker('refresh');

	//$("#fechaComunicacion").val("");
	$("#concepto").val("");
	$("#imagen").val("");
	$("#imagenactual").val("");

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
					url: '../ajax/comunicacionPersonal.php?op=listar',
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
		url: "../ajax/comunicacionPersonal.php?op=guardaryeditar",
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
function desactivar(idComunicacionPersonal)
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
	    url: '../ajax/comunicacionPersonal.php?op=desactivar',
	    data: {idComunicacionPersonal:idComunicacionPersonal},
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
function activar(idComunicacionPersonal)
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
	    url: '../ajax/comunicacionPersonal.php?op=activar',
	    data: {idComunicacionPersonal:idComunicacionPersonal},
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



function mostrar(idComunicacionPersonal)
{
	$.post("../ajax/comunicacionPersonal.php?op=mostrar",{idComunicacionPersonal : idComunicacionPersonal}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#idComunicacionPersonal").val();

		$("#Legajo_idLegajo").val(data.Legajo_idLegajo);
		$("#Legajo_idLegajo").selectpicker('refresh');

		$("#TipoComunicacion_idTipoComunicacion").val(data.TipoComunicacion_idTipoComunicacion);
		$("#TipoComunicacion_idTipoComunicacion").selectpicker('refresh');

		$("#fechaComunicacion").val(data.fechaComunicacion);
		alert(data.fechaComunicacion);
		$("#concepto").val(data.concepto);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/comunicacionPersonal/"+data.imagen);
 		$("#idComunicacionPersonal").val(data.idComunicacionPersonal);


 	})
}



init();