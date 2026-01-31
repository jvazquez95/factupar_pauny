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
function init(){
   listar();
   $("#f_i").change();
   $("#f_f").change();
   $("#actualizar").click(listar);
    //cargamos los items al select usuario
    $.post("../ajax/consultas.php?op=selectChofer", function(r){
        $("#chofer").html(r);
        $("#chofer").selectpicker('refresh');
    });
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
                            url: '../ajax/consultas.php?op=rptpagos',
                            data:{f_i: f_i, f_f: f_f},
                            type : "get",
                            dataType : "json",                      
                            error: function(e){
                                console.log(e.responseText);    
                            }
                        },
                "bDestroy": true,
                "iDisplayLength": 10000000,//Paginación
                "order": [[ 0, "asc" ],[ 0, "asc" ]],//Ordenar (columna,orden)
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
						.column( 5, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
							return (parseInt(intVal(a)) + parseInt(intVal(b)));
						}, 0 );	
		 
					// Update footer
					$( api.column( 5 ).footer() ).html(
					   formatNumber.new(montoTotal1.toFixed(0)) 
					);
				}
				
            } );
        } );


}
init(); 
  