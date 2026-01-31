//Función para anular registros
function anular()
{
	var idPago = $("#idPago").val();
swal({
	  title: 'Esta seguro de anular el Pago?',
	  text: "",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si, anular!'
	}).then((result) => {
	  if (result.value) {
        	$.post("../ajax/pago.php?op=anular", {idPago : idPago}, function(e){
			swal({
			  position: 'top-end',
			  type: 'success',
			  title: e,
			  showConfirmButton: false,
			  timer: 1500
			 })	
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