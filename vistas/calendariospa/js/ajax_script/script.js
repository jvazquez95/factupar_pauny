

function cargarPS(idcalendar){
	idcalendar = idcalendar;
	console.log("PRUEBA LA FUNCION " + idcalendar);
	var lcliente = $("#cliente_s"+idcalendar).val();
	//Cargamos los items al select cliente
	console.log("PROBAR ESTA RECOLECTANDO cliente_s"+idcalendar+ " | " +lcliente);
	$.post("../../ajax/ordenConsumision.php?op=selectPaqueteCliente",{lcliente:lcliente}, function(r){
	            $(".cliente_paquete_"+idcalendar).html(r);
	            // $('#cliente_paquete').selectpicker('refresh');
	});	

	//Cargamos los items al select cliente
	$.post("../../ajax/ordenConsumision.php?op=selectServicioCliente",{lcliente:lcliente}, function(r){
	            $(".cliente_servicio_"+idcalendar).html(r);
	            // $('#cliente_servicio').selectpicker('refresh');
	});	
}
function cargarS(idcalendar){
	idcalendar = idcalendar;
	var lcliente = $('#cliente_s'+idcalendar).val();
	var lpaquete = $('.cliente_paquete_'+idcalendar).val();

	console.log(lcliente+lpaquete);

if(lpaquete == '000'){
	//Cargamos los items al select cliente
	$.post("../../ajax/ordenConsumision.php?op=selectServicioCliente",{lcliente:lcliente}, function(r){
	            $(".cliente_servicio_"+idcalendar).html(r);
	            // $('#cliente_servicio').selectpicker('refresh');
	});	
}else{
	//Cargamos los items al select cliente
	$.post("../../ajax/ordenConsumision.php?op=selectServicioClientePaquete",{lcliente:lcliente,lpaquete:lpaquete}, function(r){
	            $(".cliente_servicio_"+idcalendar).html(r);
	            // $('#cliente_servicio').selectpicker('refresh');
	});	
}
}