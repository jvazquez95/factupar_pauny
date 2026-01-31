//Función para anular registros

function ini(){

	//Cargamos los items al select categoria
	$.post("../ajax/cliente.php?op=selectCliente", function(r){
	            $("#clienteGiftCard").html(r);
	            $('#clienteGiftCard').selectpicker('refresh');

	});

}


function cambiarPersonaGiftCard()
{
	var idVenta = $("#idVenta").val();
	var clienteGiftCard = $("#clienteGiftCard").val();
	bootbox.confirm("¿Está Seguro de cambiar a la persona?", function(result){
		if(result)
        {
        	$.post("../ajax/venta.php?op=cambiarPersonaGiftCard", {idVenta : idVenta, clienteGiftCard:clienteGiftCard}, function(e){
        		bootbox.alert(e);
        	});	
        }
	})
}

function cambiarNroGiftCard()
{
	var idVenta = $("#idVenta2").val();
	var nroGiftCard = $("#gift").val();
	bootbox.confirm("¿Está Seguro de cambiar el numero de giftcard?", function(result){
		if(result)
        {
        	$.post("../ajax/venta.php?op=cambiarNroGiftCard", {idVenta : idVenta, nroGiftCard:nroGiftCard}, function(e){
        		bootbox.alert(e);
        	});	
        }
	})
}


function arqueo()
{
	window.open("../reportes/exArqueo.php?id="+ $("#idHabilitacion").val());
}

function arqueoDetalle()
{
	window.open("../reportes/rptArqueo.php?habilitacion="+ $("#idHabilitacion").val());
}

ini();