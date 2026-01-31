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

/*=============================================
Generar Cuentas a Cobrar  
=============================================*/
function generar(){

    window.open("../reportes/rptCuentasACobrar.php?fechai="+ $("#fechai").val()+"&fechaf="+ $("#fechaf").val()+"&cliente="+ $("#cliente").val()+"&orden="+ $("#orden").val());
} 


function generarRemision(){

    window.open("../reportes/rptCuentasACobrarRemision.php?fechai="+ $("#fechai").val()+"&fechaf="+ $("#fechaf").val()+"&cliente="+ $("#cliente").val()+"&orden="+ $("#orden").val());
} 

 
//Función Listar
function listar()
{
	// $.post("../ajax/persona.php?op=selectCliente", function(r){
	//             $("#cliente").html(r);
	//             $('#cliente').selectpicker('refresh');
	// });

	var fechai = $("#fechai").val();
	var fechaf = $("#fechaf").val();
	var orden = $("#orden").val();
	var cliente = $("#cliente").val();
	
	
	
	

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
					url: '../ajax/consultas.php?op=rpt_cuentasACobrarPorCliente',
					data:{fechai: fechai,fechaf: fechaf, orden, cliente},
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
	   "order": [[ 1, "asc" ],[ 2, "asc" ],[ 3, "asc" ]]
	}).DataTable();
}

init(); 
