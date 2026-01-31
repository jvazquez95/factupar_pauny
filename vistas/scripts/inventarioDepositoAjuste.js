var tabla;
var foco = 0;
//Función que se ejecuta al inicio
function init(){
	listar();

		//cargamos los items al select usuario
	//cargamos los items al select usuario
	$.post("../ajax/habilitacion.php?op=selectDeposito", function(r){
		$("#idDeposito").html(r);
		$("#idDeposito").selectpicker('refresh');
	});
}


//Función Listar
function listar()
{
	var idDeposito = $("#idDeposito").val();

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
					url: '../ajax/consultas.php?op=rpt_inventario_deposito_ajuste',
					data:{idDeposito: idDeposito},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 500,//Paginación
	    "order": [[ 2, "desc" ]]//Ordenar (columna,orden)
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


function actualizar(x, articulo, deposito){
	var cantidad = x.value;
	var articulo = articulo;
	var deposito = deposito;

	$.ajax({
    type: "POST",
    url: '../ajax/consultas.php?op=ajuste_actualizar',
    data: {cantidad:cantidad, articulo:articulo, deposito:deposito},
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


init();