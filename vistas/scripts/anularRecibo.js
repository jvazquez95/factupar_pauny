//Función para anular registros
function anular()
{
	var idRecibo = $("#idRecibo").val();
swal({
	  title: 'Esta seguro de anular el recibo?',
	  text: "",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si, anular!'
	}).then((result) => {
	  if (result.value) {
        	$.post("../ajax/recibo.php?op=anular", {idRecibo : idRecibo}, function(e){
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