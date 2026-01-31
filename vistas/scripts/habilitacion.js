var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	//cargamos los items al select usuario
	$.post("../ajax/habilitacion.php?op=selectUsuario", function(r){
		$("#Usuario_idUsuario").html(r);
		$("#Usuario_idUsuario").selectpicker('refresh');
	});
	//cargamos los items al select usuario
	$.post("../ajax/habilitacion.php?op=selectCaja", function(r){
		$("#Caja_idCaja").html(r);
		$("#Caja_idCaja").selectpicker('refresh');
	});
}

//Función limpiar
function limpiar()
{
	$("#idhabilitacion").val("");
	$("#Caja_idCaja").val("");
	$("#Usuario_idUsuario").val("");
	//$("#fechaApertura").val("");
	$("#fechaCierre").val("");
	$("#montoApertura").val("");
	$("#montoCierre").val("");
	$("#estado").val("");
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


function mostrarDetalle(idHabilitacion){
	$('#modal_detalle').modal('show');
	$("#detalle").val(idHabilitacion);
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
					url: '../ajax/consultas.php?op=rpt_habilitacion_detalle',
					data:{idHabilitacion:idHabilitacion},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
  			"columnDefs": [
            {
                "targets": [ 0,1,2,3,4,5 ],
                "visible": true	,  
                "searchable": true,
                "className": 'text-right' 

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
 
        }
    } );
} );
}

function actualizarMontoCierre(x,item,item2){

	montoCierre = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/consultas.php?op=actualizarMontoCierre',
    	data: {item:item, montoCierre:montoCierre},
		dataType:"json",
	})

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

//Función mostrar formulario
function actualizaform()
{
	limpiar();
 	window.location = ("../vistas/cargaHabilitacion.php") ;
}

function abrirHabilitacion(idHabilitacion){
window.open("../reportes/rptNewArqueo.php?habilitacion="+idHabilitacion, "_blank");
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
					url: '../ajax/habilitacion.php?op=listar',
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
	
	// //habilitacion factura
	// $.post("../ajax/venta.php?op=habilitacion", function(data, status)
	// 	{

	// 		data = JSON.parse(data);		
	// 		$('#Habilitacion_idHabilitacion').val(data.idhabilitacion);

	// 		if ($('#Habilitacion_idHabilitacion').val() == '') {
	// 		alert('No cuenta con una habilitacion activa.');	
	// 		location.href ="habilitacion.php";
	// 		}else{
	// 			listar($('#Habilitacion_idHabilitacion').val());
	// 		}
	//  });

	
	
	
	
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/habilitacion.php?op=guardaryeditar",
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

function mostrar1(idhabilitacion)
{
	$.post("../ajax/habilitacion.php?op=mostrar",{idhabilitacion : idhabilitacion}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform1(true);

		$("#Caja_idCaja").val(data.Caja_idCaja);
		$("#Caja_idCaja").selectpicker('refresh');
		$("#Usuario_idUsuario").val(data.Usuario_idUsuario);
		$("#Usuario_idUsuario").selectpicker('refresh');
		$("#montoApertura").val(data.montoApertura);
		$("#montoCierre").val(data.montoCierre);
		$("#fechaApertura").val(data.fechaApertura);
		$("#fechaCierre").val(data.fechaCierre);
		$("#estado").val(data.estado);
		$("#idhabilitacion").val(data.idhabilitacion);

 	})
}



function mostrar(idhabilitacion)
{
	$.post("../ajax/habilitacion.php?op=mostrar",{idhabilitacion : idhabilitacion}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#Caja_idCaja").val(data.Caja_idCaja);
		$("#Caja_idCaja").selectpicker('refresh');
		$("#Usuario_idUsuario").val(data.Usuario_idUsuario);
		$("#Usuario_idUsuario").selectpicker('refresh');
		$("#montoApertura").val(data.montoApertura);
		$("#montoCierre").val(data.montoCierre);
		$("#fechaApertura").val(data.fechaApertura);
		$("#fechaCierre").val(data.fechaCierre);
		$("#estado").val(data.estado);
		$("#idhabilitacion").val(data.idhabilitacion);

 	})
}

//Función para activar registros
function cerrar(idhabilitacion)
{

        	$.post("../ajax/habilitacion.php?op=cerrar", {idhabilitacion : idhabilitacion}, function(e){
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



//Función para anular registros
function habilitar()
{
	var idhabilitacion = $("#idHabilitacion").val();
	bootbox.confirm("¿Está Seguro de habilitar la habiitacion?", function(result){
		if(result)
        {
        	$.post("../ajax/habilitacion.php?op=habilitar", {idhabilitacion : idhabilitacion}, function(e){
        		bootbox.alert(e);
        	});	
        }
	})
}




//Función para anular registros
function cambiarPass()
{
	var clave = $("#clave").val();
swal({
	  title: 'Esta seguro de actualizar su clave?',
	  text: "",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si, actualizar!'
	}).then((result) => {
	  if (result.value) {
        	$.post("../ajax/usuario.php?op=editarPass", {clave : clave}, function(e){
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: e,
			  showConfirmButton: false,
			  timer: 1500
			 })	
        	});	
        }
	})
}


init();


init();