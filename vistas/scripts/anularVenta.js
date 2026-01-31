//Función para anular registros
function anular()
{
	var idVenta = $("#idVenta").val();
swal({
	  title: 'Esta seguro de anular la venta?',
	  text: "",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si, anular!'
	}).then((result) => {
	  if (result.value) {
        	$.post("../ajax/venta.php?op=anular", {idVenta : idVenta}, function(e){
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

function arqueoDetalle2()
{
	window.open("../reportes/rptNewArqueo.php?habilitacion="+ $("#idHabilitacion").val());
}