var tabla;

function init() {
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function(e) {
		guardaryeditar(e);
	});
}

function limpiar() {
	$("#idMoneda").val("");
	$("#descripcion").val("");
}

function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();
	} else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

function cancelarform() {
	limpiar();
	mostrarform(false);
}

function listar() {
	tabla = $('#tbllistado').DataTable({
		"aProcessing": true,
		"aServerSide": true,
		dom: 'Bfrtip',
		buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf'],
		"ajax": {
			url: '../ajax/moneda.php?op=listar',
			type: "get",
			dataType: "json",
			error: function(e) {
				console.log(e.responseText);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 5,
		"order": [[0, "desc"]]
	});
}

function guardaryeditar(e) {
	e.preventDefault();
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/moneda.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos) {
			Swal.fire('Listo', datos, 'success').then(function() {
				limpiar();
				mostrarform(false);
				tabla.ajax.reload();
			});
		},
		error: function() {
			Swal.fire('Error', 'Error al procesar la solicitud.', 'error');
		},
		complete: function() {
			$("#btnGuardar").prop("disabled", false);
		}
	});
}

function mostrar(idMoneda) {
	$.post("../ajax/moneda.php?op=mostrar", { idMoneda: idMoneda }, function(data) {
		try {
			data = typeof data === 'string' ? JSON.parse(data) : data;
			if (data.error) {
				Swal.fire('Aviso', data.mensaje || 'Registro no encontrado', 'warning');
				return;
			}
			mostrarform(true);
			$("#descripcion").val(data.descripcion);
			$("#idMoneda").val(data.idMoneda);
		} catch (e) {
			Swal.fire('Error', 'Error al cargar los datos.', 'error');
		}
	}).fail(function() {
		Swal.fire('Error', 'Error de conexión.', 'error');
	});
}

function desactivar(idMoneda) {
	Swal.fire({
		title: '¿Desactivar moneda?',
		text: 'El registro quedará desactivado.',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Sí, desactivar',
		cancelButtonText: 'Cancelar'
	}).then(function(result) {
		if (result.isConfirmed) {
			$.post("../ajax/moneda.php?op=desactivar", { idMoneda: idMoneda }, function(e) {
				Swal.fire('Listo', e, 'success').then(function() {
					tabla.ajax.reload();
				});
			}).fail(function() {
				Swal.fire('Error', 'No se pudo desactivar.', 'error');
			});
		}
	});
}

function activar(idMoneda) {
	Swal.fire({
		title: '¿Activar moneda?',
		text: 'El registro quedará activo.',
		icon: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Sí, activar',
		cancelButtonText: 'Cancelar'
	}).then(function(result) {
		if (result.isConfirmed) {
			$.post("../ajax/moneda.php?op=activar", { idMoneda: idMoneda }, function(e) {
				Swal.fire('Listo', e, 'success').then(function() {
					tabla.ajax.reload();
				});
			}).fail(function() {
				Swal.fire('Error', 'No se pudo activar.', 'error');
			});
		}
	});
}

init();
