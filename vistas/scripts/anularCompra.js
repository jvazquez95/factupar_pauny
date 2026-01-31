//Función para anular registros
function anular()
{
	var idcompra = $("#idcompra").val();
swal({
	  title: 'Esta seguro de anular la compra?',
	  text: "",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si, anular!'
	}).then((result) => {
	  if (result.value) {
        	$.post("../ajax/compra.php?op=anular", {idcompra : idcompra}, function(e){
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