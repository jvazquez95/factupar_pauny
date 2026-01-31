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
}


//Función Listar
function listar()
{
	var habilitacion = $("#habilitacion").val();

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
					url: '../ajax/consultas.php?op=rpt_compras_habilitacion',
					data:{habilitacion: habilitacion},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5000,//Paginación
	    "order": [[ 0, "desc" ]],
		
"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$.]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
              
            // Remove the formatting to get integer data for summation
            var intVal2 = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '.')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over this page
            montoTotal8 = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseInt(intVal(a)) + parseInt(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 6 ).footer() ).html(
               formatNumber.new(montoTotal8.toFixed(0)) 
            );

            // Total over this page
            montoTotal9 = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseInt(intVal(a)) + parseInt(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 7 ).footer() ).html(
               formatNumber.new(montoTotal9.toFixed(0)) 
            );	

            // Total over this page
            montoTota20 = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseInt(intVal(a)) + parseInt(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 8 ).footer() ).html(
               formatNumber.new(montoTota20.toFixed(0)) 
            );			
		
},
	}).DataTable();
}




function mostrar(idCompra){
	$('#modal_detalle').modal('show');
	$("#detalle").val(idCompra);
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
					url: '../ajax/consultas.php?op=rpt_compras_detalle',
					data:{idCompra:idCompra},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
  			"columnDefs": [
            {
                "targets": [ 4 ],
                "visible": true,
                "searchable": false
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
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over this page
            pageTotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 6 ).footer() ).html(
               pageTotal 
            );
        }
    } );
} );
}


init();