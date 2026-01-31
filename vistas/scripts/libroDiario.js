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

    //Cargamos los items al select grupo
    $.post("../ajax/consultas.php?op=selectCuentaContableLibroDiario", function(r){
                $("#c_i").html(r);
                $('#c_i').selectpicker('refresh');
                $("#c_f").html(r);
                $('#c_f').selectpicker('refresh');                
                $('#c_i').selectpicker('val', null);
                $('#c_f').selectpicker('val', null);
    }); 

   listar();
   $("#f_i").change();
   $("#f_f").change();
   $("#actualizar").click(listar);
    //cargamos los items al select usuario 01.05
   /* $.post("../ajax/consultas.php?op=selectChofer", function(r){
        $("#chofer").html(r);
        $("#chofer").selectpicker('refresh');
    });*/
}

/*=============================================
Generar Librio Diario
=============================================*/
function generar(){

    window.open("../reportes/rptLibroDiario.php?fi="+ $("#f_i").val()+"&ff="+ $("#f_f").val()+"&ci="+ $("#c_i").val()+"&cf="+ $("#c_f").val());
}
 


//Función Listar
function listar()
{

    var f_i = $("#f_i").val();
    var f_f = $("#f_f").val();
    var c_i = $("#c_i").val();
    var c_f = $("#c_f").val();    

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
                            url: '../ajax/consultas.php?op=libroDiario',
                            data:{f_i: f_i, f_f: f_f,c_i: c_i, c_f: c_f},
                            type : "get",
                            dataType : "json",                      
                            error: function(e){
                                console.log(e.responseText);    
                            }
                        },
                "bDestroy": true,
                "iDisplayLength": 1000,//Paginación
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

                }
                
            } );
        } );


}
init(); 