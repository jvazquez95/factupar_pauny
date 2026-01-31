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
   //$("#actualizar").click(listar);
    //cargamos los items al select usuario
    // $.post("../ajax/consultas.php?op=selectChofer", function(r){
    //     $("#chofer").html(r);
    //     $("#chofer").selectpicker('refresh');
    // });
}




function rechazar(id){

            $.post("../ajax/cheque.php?op=rechazar", {idCheque : id}, function(e){
                swal({
                      position: 'top-end',
                      type: 'error',
                      title: 'Cheque rechazado',
                      showConfirmButton: false,
                      timer: 1500
                }) 
                listar();
            }); 


}


function confirmar(id){

            $.post("../ajax/cheque.php?op=confirmar", {idCheque : id}, function(e){
                swal({
                      position: 'top-end',
                      type: 'success',
                      title: 'Cheque Confirmado',
                      showConfirmButton: false,
                      timer: 1500
                }) 
                listar();
            }); 

}




//Función Listar
function listar()
{

    var f_i = $("#f_i").val();
    var f_f = $("#f_f").val();
    var tipoFecha = $("#tipoFecha").val();
    var tipoCheque = $("#tipoCheque").val();

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
                            url: '../ajax/cheque.php?op=rpt_cheques_tipo',
                            data:{fechaInicial: f_i, fechaFinal: f_f, tipoCheque:tipoCheque, tipoFecha:tipoFecha},
                            type : "post",
                            dataType : "json",                      
                            error: function(e){
                                console.log(e.responseText);    
                            }
                        },
                "bDestroy": true,
                "iDisplayLength": 10000000,//Paginación
                "order": [[ 0, "asc" ],[ 0, "asc" ]]//Ordenar (columna,orden)
				// "footerCallback": function ( row, data, start, end, display ) {
				// 	var api = this.api(), data;
		 
				// 	// Remove the formatting to get integer data for summation
				// 	var intVal = function ( i ) {
				// 		return typeof i === 'string' ?
				// 			i.replace(/[\$,]/g, '')*1 :
				// 			typeof i === 'number' ?
				// 				i : 0;
				// 	};

				//   // Total over this page
				// 	montoTotal1 = api
				// 		.column( 5, { page: 'current'} )
				// 		.data()
				// 		.reduce( function (a, b) {
				// 			return (parseInt(intVal(a)) + parseInt(intVal(b)));
				// 		}, 0 );	
		 
				// 	// Update footer
				// 	$( api.column( 5 ).footer() ).html(
				// 	   formatNumber.new(montoTotal1.toFixed(0)) 
				// 	);
				// }
				
            } );
        } );


}
init(); 
  