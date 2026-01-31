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
	$("#fechai").change();
	$("#fechaf").change();
  $("#actualizar").click(listar);
  //$("#problemas").val('0');
  //$("#problemas").selectpicker('refresh');
}


//Función Listar
function listar()
{
	// $.post("../ajax/persona.php?op=selectProveedor", function(r){
	//             $("#proveedor").html(r);
	//             $('#proveedor').selectpicker('refresh');
	// });

	var fechai = $("#fechai").val();
	var fechaf = $("#fechaf").val();
	var orden = $("#orden").val();
	var proveedor = $("#proveedor").val();
	
	
	
	

	tabla=$('#tbllistado').dataTable(
	{
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
					url: '../ajax/consultas.php?op=rpt_cuentasAPagarAvanzado',
					data:{fechai: fechai,fechaf: fechaf, orden, proveedor},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"responsive": true,//7 8 10 11
		"responsive": true,
		"iDisplayLength": 100,//Paginación
	   "order": [[ 1, "asc" ],[ 2, "asc" ],[ 3, "asc" ]],//Ordenar (columna,orden)
		
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
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseInt(intVal(a)) + parseInt(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 7 ).footer() ).html(
               formatNumber.new(montoTotal8.toFixed(0)) 
            );

            // Total over this page
            montoTotal9 = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseInt(intVal(a)) + parseInt(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 8 ).footer() ).html(
               formatNumber.new(montoTotal9.toFixed(0)) 
            );	

            // Total over this page
            montoTota20 = api
                .column( 10, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseInt(intVal(a)) + parseInt(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 10 ).footer() ).html(
               formatNumber.new(montoTota20.toFixed(0)) 
            );			
		
            // Total over this page
            montoTota20 = api
                .column( 11, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseInt(intVal(a)) + parseInt(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 11 ).footer() ).html(
               formatNumber.new(montoTota20.toFixed(0)) 
            );


},
	}).DataTable();
}





//Función Listar
function listarAvanzado()
{
    // $.post("../ajax/persona.php?op=selectProveedor", function(r){
    //             $("#proveedor").html(r);
    //             $('#proveedor').selectpicker('refresh');
    // });

    var fechai = $("#fechai").val();
    var fechaf = $("#fechaf").val();
    var orden = $("#orden").val();
    var proveedor = $("#proveedor").val();
    
    
    
    

    tabla=$('#tbllistado').dataTable(
    {
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
                    url: '../ajax/consultas.php?op=rpt_cuentasAPagarAvanzado',
                    data:{fechai: fechai,fechaf: fechaf, orden, proveedor},
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                        console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "responsive": true,//7 8 10 11
        "responsive": true,
        "iDisplayLength": 100,//Paginación
       "order": [[ 1, "asc" ],[ 2, "asc" ],[ 3, "asc" ]],//Ordenar (columna,orden)
        
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
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseInt(intVal(a)) + parseInt(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 7 ).footer() ).html(
               formatNumber.new(montoTotal8.toFixed(0)) 
            );

            // Total over this page
            montoTotal9 = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseInt(intVal(a)) + parseInt(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 8 ).footer() ).html(
               formatNumber.new(montoTotal9.toFixed(0)) 
            );  

            // Total over this page
            montoTota20 = api
                .column( 10, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseInt(intVal(a)) + parseInt(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 10 ).footer() ).html(
               formatNumber.new(montoTota20.toFixed(0)) 
            );          
        
            // Total over this page
            montoTota20 = api
                .column( 11, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseInt(intVal(a)) + parseInt(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 11 ).footer() ).html(
               formatNumber.new(montoTota20.toFixed(0)) 
            );


},
    }).DataTable();
}




init(); 
