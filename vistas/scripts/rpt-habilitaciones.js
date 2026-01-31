 var tabla;
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
function init () {
  listar();

  // eventos de la vista
  $('#f_i').change();
  $('#f_f').change();
  $('#actualizar').click(listar);

  /* ════════════════════════════════════════════════
     Un solo llamado → rellena ambos selectpicker
  ═════════════════════════════════════════════════ */
  $.post('../ajax/consultas.php?op=selectChofer', function (htmlOptions) {

    // Asigna las mismas <option> a ambos combos
    $('#chofer, #ayudante').html(htmlOptions);

    // Refresca todos los selectpicker de la página
    $('.selectpicker').selectpicker('refresh');
  });
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

            tabla.ajax.reload();

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



function actualizarMontoApertura(x,item,item2){

	montoApertura = x.value;

	$.ajax({
    	type: "get",
    	url: '../ajax/consultas.php?op=actualizarMontoApertura',
    	data: {item:item, montoApertura:montoApertura},
		dataType:"json",
	})

}



function abrirHabilitacion(idHabilitacion){
    window.open("../reportes/rptNewArqueo.php?habilitacion="+idHabilitacion, "_blank");
    }



    function abrirAjusteInventario(idHabilitacion){
        window.open("inventarioAjusteApp.php", "_blank");
        }

    



function mostrar1(y,x, z){
    

    $("#impresion").val(z);
    $('#mapamodal1').modal('show');
    var f_i = $("#f_i").val();
    var f_f = $("#f_f").val();
    var ch = $("#chofer").val();
    var filtro = x;
    $("#nombre1").val(y);
	$("#nroHoja").val(x);
    var x5 = 2;
    if( $('#check1').prop('checked') ) {
    check = 1;
    }else{
    check = 0;
    } 

    $(document).ready(function() {
        $('#tbllistado5').DataTable( {
            "aProcessing": true,//Activamos el procesamiento del datatables
			"language": {
            "decimal": ",",
            "thousands": "."
			},
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
                        url: '../ajax/consultas.php?op=hojaRuta1Modal',
                        data:{f_i: f_i, f_f: f_f, x5:x5, ch:ch, filtro:filtro, check:check},
                        type : "get",
                        dataType : "json",                      
                        error: function(e){
                            console.log(e.responseText);    
                        }
                    },

            "bDestroy": true,
            "iDisplayLength": 4000,//Paginación
            "order": [[ 0, "asc" ],[ 0, "asc" ]],//Ordenar (columna,orden)
        "columnDefs": [
            {
                "targets": [ 15,16,17,18,19,20 ],
                "visible": false,
                "searchable": false,
                "width": "20%",
            }],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
     
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
     

          // Total over this page
          montoTotal1 = api
                .column( 15, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseInt(intVal(a)) + parseInt(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 7 ).footer() ).html(
               formatNumber.new(montoTotal1.toFixed(2)) 
            );


            }
        } );
} );

}


function mostrar2(){
    var f_i = $("#f_i").val();
    var f_f = $("#f_f").val();

$(document).ready(function() {
    $('#tbllistado6').DataTable( {
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
                    url: '../ajax/consultas.php?op=hechaukaVentas',
                    data:{f_i: f_i, f_f: f_f},
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                        console.log(e.responseText);    
                    }
                },

        "bDestroy": true,
        "iDisplayLength": 2000,//Paginación
        "order": [[ 0, "asc" ],[ 0, "asc" ]],//Ordenar (columna,orden)
        "columnDefs": [
            {
                "targets": [ 15,16,17,18,19,20 ],
                "visible": false,
                "searchable": false,
                "width": "20%",
            }],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

          // Total over this page
          montoTotal1 = api
                .column( 15, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseInt(intVal(a)) + parseInt(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 7 ).footer() ).html(
               formatNumber.new(montoTotal1.toFixed(2)) 
            );


        }
    } );
} );

}


//Función Listar
function listar()
{

    var f_i = $("#f_i").val();
    var f_f = $("#f_f").val();

        $(document).ready(function() {
            $('#tbllistado').DataTable( {
                "aProcessing": true,//Activamos el procesamiento del datatables
                "aServerSide": true,//Paginación y filtrado realizados por el servidor
                dom: 'Bfrtip',//Definimos los elementos del control de tabla
                "language": {
            "decimal": "-",
            "thousands": "."
          },
                buttons: [                
                            'copyHtml5',
                            'excelHtml5',
                            'csvHtml5',
                            'pdf'
                        ],
                "ajax":
                        {
                            url: '../ajax/habilitacion.php?op=listar2',
                            data:{f_i: f_i, f_f: f_f},
                            type : "get",
                            dataType : "json",                      
                            error: function(e){
                                console.log(e.responseText);    
                            }
                        },
                "bDestroy": true,
                "iDisplayLength": 10000000,//Paginación
                "order": [[ 2, "asc" ],[ 1, "asc" ]]
				
            } );
        } );


}


// =====================================================
//  NUEVA FUNCIÓN: abrir el PDF de Arqueo por Fechas
//    Lo agrega sin interferir con DataTables ni flujos
// =====================================================
function abrirArqueoFechasPDF () {
  const f_i = $('#f_i').val();
  const f_f = $('#f_f').val();

  if (!f_i || !f_f) {
    swal('Atención', 'Debes seleccionar la fecha inicial y la fecha final', 'warning');
    return;
  }

  // Construye la URL del reporte FPDF
  const url = `https://mineraqua.com.py/mineraqua/reportes/rptNewArqueoFechas.php?fecha_inicio=${encodeURIComponent(f_i)}&fecha_fin=${encodeURIComponent(f_f)}`;

  // Abre el PDF en una nueva pestaña
  window.open(url, '_blank');
}





/* ════════════════════════════════════════════════
   ASIGNAR ACOMPAÑANTE
════════════════════════════════════════════════ */

/**
 * Abre el modal, carga la lista de acompañantes y
 * guarda la habilitación sobre la que trabajaremos.
 * @param  {int} idHabilitacion
 */
function asignarAyudante (idHabilitacion) {
  // --- guarda el ID de la habilitación
  $('#idHabAsignacion').val(idHabilitacion);
  $('#hab_num').text(idHabilitacion);

  // --- carga SELECT de acompañantes solo la primera vez
  $.post('../ajax/habilitacion.php?op=selectUsuario', function (r) {
    $('#ayudante').html(r);
    $('#ayudante').selectpicker('refresh');
  });

  // --- muestra modal
  $('#modal_asignar_ayudante').modal('show');
}

/**
 * Click «Procesar» → envía la asignación al servidor
 -------------------------------------------------- */
$('#btnProcesarAsignacion').on('click', function () {
  const idHabilitacion = $('#idHabAsignacion').val();
  const idAyudante     = $('#ayudante').val();

  if (!idAyudante) {
    swal('Atención',
         'Debes seleccionar un acompañante antes de continuar.',
         'warning');
    return;
  }

  $.post('../ajax/habilitacion.php?op=asignarAyudante',
         { idhabilitacion: idHabilitacion, idAyudante: idAyudante },
         function (resp) {
           swal({
             position: 'top-end',
             type: 'success',
             title: resp,
             showConfirmButton: false,
             timer: 1500
           });

           // cierra modal y refresca tabla principal
           $('#modal_asignar_ayudante').modal('hide');
           tabla.ajax.reload(null, false); // sin resetear paginación
         }
  ).fail(function (jqXHR) {
      console.error(jqXHR.responseText);
      swal('Error', 'No se pudo asignar el acompañante', 'error');
  });
});




init(); 
  