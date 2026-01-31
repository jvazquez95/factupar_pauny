var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	$("#imagenmuestra").hide();
	// Cargar permisos (agrupados por categoría si existe migración)
	$.post("../ajax/usuario.php?op=permisos&id=", function(r){
		$("#permisos").html(r || "<p class='text-muted'>Sin permisos.</p>");
	});
	// Cargar roles para "Aplicar rol"
	$.getJSON("../ajax/usuario.php?op=roles", function(roles){
		var $sel = $("#selRol");
		$sel.find("option:not(:first)").remove();
		if (roles && roles.length) {
			roles.forEach(function(r){
				$sel.append($("<option></option>").attr("value", r.id).text(r.nombre + (r.descripcion ? " - " + r.descripcion : "")));
			});
		}
	}).fail(function(){ $("#selRol option:first").text("-- Sin roles (ejecutar migración) --"); });
	$("#selRol").on("change", function(){
		var idRol = $(this).val();
		var $checks = $("input[name='permiso[]']");
		if (!idRol) {
			$checks.prop("checked", false);
			return;
		}
		$.getJSON("../ajax/usuario.php?op=permisosPorRol&id_rol=" + idRol, function(ids){
			ids = ids || [];
			$checks.each(function(){
				var val = parseInt($(this).val(), 10);
				$(this).prop("checked", ids.indexOf(val) !== -1);
			});
		});
	});

	// Marcar/desmarcar por categoría (delegado: el HTML se inyecta después)
	$(document).on("click", ".permiso-marcar-todos", function(e){
		e.preventDefault();
		var $ul = $($(this).data("target"));
		$ul.find("input.permiso-check").prop("checked", true);
	});
	$(document).on("click", ".permiso-desmarcar-todos", function(e){
		e.preventDefault();
		var $ul = $($(this).data("target"));
		$ul.find("input.permiso-check").prop("checked", false);
	});
	$("#permisosMarcarTodos").on("click", function(e){ e.preventDefault(); $("#permisos").find("input.permiso-check").prop("checked", true); });
	$("#permisosDesmarcarTodos").on("click", function(e){ e.preventDefault(); $("#permisos").find("input.permiso-check").prop("checked", false); });

	//Cargamos los items al select empleado (para comisiones)
	$.post("../ajax/usuario.php?op=selectEmpleado", function(r){
	            $("#Empleado_idEmpleado").html(r);
	            $('#Empleado_idEmpleado').selectpicker('refresh');
	});	


}

//Función limpiar
function limpiar()
{
	$("#nombre").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#cargo").val("");
	$("#login").val("");
	$("#clave").val("").attr("placeholder", "Obligatoria al crear; en edición dejar en blanco para no cambiar");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
	$("#idusuario").val("");
	$("#selRol").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,
	    "aServerSide": false,
	    dom: 'Bfrtip',
	    buttons: [ 'copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf' ],
		"ajax": {
			url: '../ajax/usuario.php?op=listar',
			type: "get",
			dataType: "json",
			error: function(e){ console.log(e.responseText); }
		},
		"bDestroy": true,
		"iDisplayLength": 10,
	    "order": [[ 1, "asc" ]]
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault();
	if (!$("#idusuario").val() && !$("#clave").val()) {
		Swal.fire({
			icon: 'warning',
			title: 'Clave obligatoria',
			text: 'Debe ingresar la clave para crear un nuevo usuario.'
		});
		return;
	}
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/usuario.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos) {
			var esExito = datos.indexOf('registrado') !== -1 || datos.indexOf('actualizado') !== -1;
			Swal.fire({
				icon: esExito ? 'success' : 'error',
				title: esExito ? 'Guardado' : 'Error',
				text: datos
			}).then(function() {
				mostrarform(false);
				tabla.ajax.reload();
			});
		},
		error: function(xhr) {
			Swal.fire({
				icon: 'error',
				title: 'Error de conexión',
				text: 'No se pudo completar la operación. Verifique su conexión e intente de nuevo.'
			});
		},
		complete: function() {
			$("#btnGuardar").prop("disabled", false);
		}
	});
}

function mostrar(idusuario)
{
	$.post("../ajax/usuario.php?op=mostrar",{idusuario : idusuario}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombre").val(data.nombre);
		$("#tipo_documento").val(data.tipo_documento);
		$("#tipo_documento").selectpicker('refresh');
		$("#num_documento").val(data.num_documento);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);
		$("#cargo").val(data.cargo);
		$("#login").val(data.login);
		$("#clave").val("").attr("placeholder", "Dejar en blanco para no cambiar");
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/usuarios/"+data.imagen);
		$("#imagenactual").val(data.imagen);
		$("#Empleado_idEmpleado").val(data.Empleado_idEmpleado || '');
		$("#Empleado_idEmpleado").selectpicker('refresh');
		$("#idusuario").val(data.idusuario);

 	});
 	$("#selRol").val("");
 	$.post("../ajax/usuario.php?op=permisos&id="+idusuario,function(r){
	        $("#permisos").html(r || "<p class='text-muted'>Sin permisos.</p>");
	});
}

//Función para desactivar registros
function desactivar(idusuario)
{
	Swal.fire({
		title: '¿Desactivar usuario?',
		text: 'El usuario no podrá iniciar sesión hasta que sea activado nuevamente.',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		confirmButtonText: 'Sí, desactivar',
		cancelButtonText: 'Cancelar'
	}).then(function(result) {
		if (result.isConfirmed) {
			$.post("../ajax/usuario.php?op=desactivar", {idusuario: idusuario}, function(e) {
				var ok = e.indexOf('Desactivado') !== -1;
				Swal.fire({
					icon: ok ? 'success' : 'error',
					title: ok ? 'Usuario desactivado' : 'Error',
					text: e
				}).then(function() { tabla.ajax.reload(); });
			}).fail(function() {
				Swal.fire('Error', 'No se pudo conectar con el servidor.', 'error');
			});
		}
	});
}

//Función para activar registros
function activar(idusuario)
{
	$.post("../ajax/usuario.php?op=activar", {idusuario: idusuario}, function(e) {
		var ok = e.indexOf('activado') !== -1;
		Swal.fire({
			icon: ok ? 'success' : 'error',
			title: ok ? 'Usuario activado' : 'Error',
			text: e
		}).then(function() { tabla.ajax.reload(); });
	}).fail(function() {
		Swal.fire('Error', 'No se pudo conectar con el servidor.', 'error');
	});
}

init();