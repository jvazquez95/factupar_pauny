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
	//listar();

        //Cargamos los items al select cliente
    $.post("../ajax/venta.php?op=selectCliente", function(r){
                $("#Cliente_idCliente").html(r);
                $('#Cliente_idCliente').selectpicker('refresh');
    }); 

}


function cargarPS(){

    var lcliente = $('#Cliente_idCliente').val();
    //Cargamos los items al select cliente
    $.post("../ajax/ordenConsumision.php?op=selectPaqueteCliente",{lcliente:lcliente}, function(r){
                $("#idPaquete").html(r);
                $('#idPaquete').selectpicker('refresh');
    }); 

    //Cargamos los items al select cliente
    $.post("../ajax/ordenConsumision.php?op=selectServicioCliente",{lcliente:lcliente}, function(r){
                $("#idServicio").html(r);
                $('#idServicio').selectpicker('refresh');
    }); 
}

function cargarS(){

    var lcliente = $('#Cliente_idCliente').val();
    var lpaquete = $('#idPaquete').val();

if(lpaquete == '000'){
    //Cargamos los items al select cliente
    $.post("../ajax/ordenConsumision.php?op=selectServicioCliente",{lcliente:lcliente}, function(r){
                $("#idServicio").html(r);
                $('#idServicio').selectpicker('refresh');
    }); 
}else{
    //Cargamos los items al select cliente
    $.post("../ajax/ordenConsumision.php?op=selectServicioClientePaquete",{lcliente:lcliente,lpaquete:lpaquete}, function(r){
                $("#idServicio").html(r);
                $('#idServicio').selectpicker('refresh');
    }); 
}
}




    //cargamos los items al select usuario
/*$.post("../ajax/movimiento.php?op=selectConcepto", function(r){
        $("#idConcepto").html(r);
        $("#idConcepto").selectpicker('refresh');
});
*/

//Función Listar
function listar()
{
	var fi = $("#fi").val();
    var ff = $("#ff").val();
    var idCliente = $("#Cliente_idCliente").val();
    var idServicio = $("#idServicio").val();
	var idPaquete = $("#idPaquete").val();

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
					url: '../ajax/consultas.php?op=rpt_ordenesConsumisionDetalle_d',
					data:{fi: fi, ff:ff, idCliente:idCliente, idPaquete:idPaquete, idServicio:idServicio},
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
            pageTotal = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 8 ).footer() ).html(
               formatNumber.new(pageTotal) 
            );
        }//Ordenar (columna,orden)
	}).DataTable();
}




function mostrar(idVenta){
	$('#modal_detalle').modal('show');
	$("#detalle").val(idVenta);
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
					url: '../ajax/consultas.php?op=rpt_ventas_detalle',
					data:{idVenta:idVenta},
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