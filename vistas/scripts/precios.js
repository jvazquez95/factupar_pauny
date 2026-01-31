var tabla;
var cf;
var p1=0;
var p2=0;
var p3 =0;
var p4=0;

var p1Anterior = 0;
var p2Anterior = 0;
var p3Anterior = 0;
var p4Anterior = 0;

var vp1=0;
var vp2=0;
var vp3 =0;
var vp4=0;

var vinicial1 = 0;
var vinicial2 = 0;
var vinicial3 = 0;
var vinicial4 = 0;

var ajusteAux = 0;
var ajusteId = 0;
var vpAux = 0;
//Función que se ejecuta al inicio
function init(){
    //listar();
	
	$("#actualizar").click(listar);
	$("#actualizar2").click(actualizar);
	
    mostrar();
    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);  
    })
	
	$.post("../ajax/grupoPersona.php?op=selectGrupoPersona", function(r){
                $("#GrupoPersona_idGrupoPersona").html(r);
                $('#GrupoPersona_idGrupoPersona').selectpicker('refresh');
    });
	
	$.post("../ajax/sucursal.php?op=selectSucursalTodos", function(r){
                $("#Sucursal_idSucursal").html(r);
                $('#Sucursal_idSucursal').selectpicker('refresh');
    });
	
    $.post("../ajax/persona.php?op=selectProveedor", function(r){
                $("#Persona_idPersona").html(r);
                $('#Persona_idPersona').selectpicker('refresh');
    }); 
	
	$.post("../ajax/grupoArticulo.php?op=selectGrupoArticulo", function(r){
                $("#GrupoArticulo_idGrupoArticulo").html(r);
                $('#GrupoArticulo_idGrupoArticulo').selectpicker('refresh');
    }); 
	
	$.post("../ajax/marca.php?op=selectMarca", function(r){
                $("#Marca_idMarca").html(r);
                $('#Marca_idMarca').selectpicker('refresh');
    }); 
	
	$.post("../ajax/categoria.php?op=selectCategoria", function(r){
                $("#Categoria_idCategoria").html(r);
                $('#Categoria_idCategoria').selectpicker('refresh');
    }); 
    
}

//Función para eliminar registros
/*
function actualizarTasa()
{
	var tasaCambio = $("#tasa").val();
        	$.post("../ajax/precios.php?op=actualizarTasa", {tasaCambio : tasaCambio}, function(e){
        		//bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        
}
*/



function validar(){
$("#ajuste").focus();
}


function actualizar(){

    var t1 = 0;
    var t2 = 0;
    var t3 = 0;
    var t4 = 0;
    var p = 0;


    var lp1 = document.getElementsByName("margen[]");

    var lp1Anterior = document.getElementsByName("1margen[]");
    

    var p = document.getElementsByName("P[]");
     for (var i = 0; i <lp1.length; i++) {

        var inp1=lp1[i];
        var inp1Anterior=lp1Anterior[i];

        p1 = p1 + parseInt(inp1.value);
        p1Anterior = p1Anterior + parseInt(inp1Anterior.value);
        var va1 =parseInt(inp1Anterior.value);

        var ajuste = $("#ajuste").val();
        //alert(tasa);

        var inpp = p[i];
        inpp.value = ((parseInt(inp1.value)/1).toFixed(2)); 
        inp1.value = parseInt(inp1.value) + parseInt(ajuste);
        if (va1 != inp1.value) {

            vp1 = (1-(va1/inp1.value))*100;
            //alert(vp1);
            if (vp1 < -7 || vp1 >= 40) {
                inp1.style.color = "white";
                inp1.style.backgroundColor = "red";
            }else{ 
                    if( vp1 >= -7 & vp1 < -3 || vp1 >= 3 & vp1 < 40 ){
                        inp1.style.color = "black";
                        inp1.style.backgroundColor = "yellow";
                    }else{
                        inp1.style.color = "white";
                        inp1.style.backgroundColor = "green";

                    }
            }

        }else{
                        inp1.style.color = "black";
                        inp1.style.backgroundColor = "white";            
        }
    }

        //$('#pv1').html((p1Anterior/cf).toFixed(2));
        //$('#pv2').html((p1/cf).toFixed(2));
        //$('#pv3').html((p2Anterior/cf).toFixed(2));
        //$('#pv4').html((p2/cf).toFixed(2));
        //$('#pv5').html((p3Anterior/cf).toFixed(2));
        //$('#pv6').html((p3/cf).toFixed(2));
        //$('#pv7').html((p4Anterior/cf).toFixed(2));
        //$('#pv8').html((p4/cf).toFixed(2));


        p1 = 0;
        p2 = 0;
        p3 = 0;
        p4 = 0;
        p1Anterior = 0;
        p2Anterior = 0;
        p3Anterior = 0;
        p4Anterior = 0;


}



function ajuste(x){

    ajusteId = x.id;
    ajusteAux = x.value;
}


function actualizarIndividual(x){

        var c = 1 + x.id;
        inpAnterior = document.getElementById(c).value;
        if (inpAnterior != x.value) {

            var vpAux = (1-(parseInt(inpAnterior)/parseInt(x.value)))*100;
            //alert(vpAux);
            if (vpAux < -7 || vpAux >= 40) {
                document.getElementById(ajusteId).style.color = "white";
                document.getElementById(ajusteId).style.backgroundColor = "red";
                //inp1.style.color = "white";
                //inp1.style.backgroundColor = "red";
            }else{ 
                    if( vpAux >= -7 & vpAux < -3 || vpAux >= 3 & vpAux < 40 ){
                        document.getElementById(ajusteId).style.color = "black";
                        document.getElementById(ajusteId).style.backgroundColor = "yellow";
                        //inp1.style.color = "black";
                        //inp1.style.backgroundColor = "yellow";
                    }else{
                        document.getElementById(ajusteId).style.color = "white";
                        document.getElementById(ajusteId).style.backgroundColor = "green";
                        //inp1.style.color = "black";
                        //inp1.style.backgroundColor = "white";

                    }
            }

        }else{
                        document.getElementById(ajusteId).style.color = "black";
                        document.getElementById(ajusteId).style.backgroundColor = "white";           
        }
        actualizar();

}



//Función Listar
function listar()
{
	var GrupoPersona_idGrupoPersona = $("#GrupoPersona_idGrupoPersona").val();
	var Sucursal_idSucursal = $("#Sucursal_idSucursal").val();
    var Persona_idPersona = $("#Persona_idPersona").val();
    var GrupoArticulo_idGrupoArticulo = $("#GrupoArticulo_idGrupoArticulo").val();
	var Categoria_idCategoria = $("#Categoria_idCategoria").val();
	var Marca_idMarca = $("#Marca_idMarca").val();
	
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
                    url: '../ajax/precios.php?op=listar',
                    data:{GrupoPersona_idGrupoPersona: GrupoPersona_idGrupoPersona, Sucursal_idSucursal: Sucursal_idSucursal, Persona_idPersona: Persona_idPersona, GrupoArticulo_idGrupoArticulo:GrupoArticulo_idGrupoArticulo, Categoria_idCategoria : Categoria_idCategoria, Marca_idMarca : Marca_idMarca},
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                        console.log(e.responseText);    
                    },
                    complete: function(e){
                        cf = tabla.rows().count();
                        //actualizar();
                    },
                },
        "bDestroy": true,
        "iDisplayLength": 5000,//Paginación
        "order": [[ 0, "desc" ]],//Ordenar (columna,orden)

        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            var tabla = $('#tbllistado').DataTable();
            //actualizar();
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            }; 

        }

    }).DataTable();



}
//Función para guardar o editar

function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/precios.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    
              //bootbox.alert(datos);  

			swal({
			  position: 'top-end',
			  type: 'success',
			  title: datos,
			  showConfirmButton: false,
			  timer: 1500
			 })
			 
              //mostrarform(false);
              tabla.ajax.reload();
        },
        complete: function(datos){
        	actualizarTasa();
        }

    });
}


function mostrar()
{
    $.post("../ajax/precios.php?op=mostrarTasa", function(data, status)
    {
        data = JSON.parse(data);   
        $("#tasa1").val(data.tasa1);
    
    })
}




init();