function init() {
	if (typeof CONFIG_EMPRESA_INICIAL !== 'undefined' && CONFIG_EMPRESA_INICIAL) {
		var d = CONFIG_EMPRESA_INICIAL;
		$("#nombre_empresa").val(d.nombre_empresa || "");
		$("#ruc").val(d.ruc || "");
		var color = d.color_primario || "#007bff";
		$("#color_primario").val(color);
		$("#color_primario_hex").val(color);
		$("#logo_actual").val(d.logo_ruta || "");
	}
	cargarConfig();
	$("#formulario").on("submit", function(e) {
		e.preventDefault();
		guardaryeditar();
	});
	$("#color_primario").on("input", function() {
		$("#color_primario_hex").val(this.value);
	});
	$("#color_primario_hex").on("input", function() {
		var v = $(this).val();
		if (/^#[0-9A-Fa-f]{6}$/.test(v)) {
			$("#color_primario").val(v);
		}
	});
	$("#logo").on("change", function(e) {
		var f = e.target.files[0];
		if (f && f.type.match(/^image\//)) {
			var r = new FileReader();
			r.onload = function() {
				$("#preview_logo").html('<img src="' + r.result + '" style="max-width: 200px; max-height: 80px;">');
			};
			r.readAsDataURL(f);
		} else {
			$("#preview_logo").html("");
		}
	});
}

function cargarConfig() {
	$.get("../ajax/configuracionEmpresa.php?op=obtener", function(data) {
		try {
			var d = typeof data === 'string' ? JSON.parse(data) : data;
			if (d && d.error) return;
			if (d && typeof d === 'object' && !Array.isArray(d)) {
				$("#nombre_empresa").val(d.nombre_empresa || "");
				$("#ruc").val(d.ruc || "");
				var color = d.color_primario || "#007bff";
				$("#color_primario").val(color);
				$("#color_primario_hex").val(color);
				$("#logo_actual").val(d.logo_ruta || "");
				if (d.logo_ruta) {
					$("#preview_logo").html('<img src="../' + d.logo_ruta + '?t=' + Date.now() + '" style="max-width: 200px; max-height: 80px;" alt="Logo">');
				}
			}
		} catch (e) {
			console.log("Sin config previa o error:", e);
		}
	}).fail(function() {
		console.log("No se pudo cargar configuracion");
	});
}

function guardaryeditar() {
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);
	formData.set("color_primario", $("#color_primario").val() || $("#color_primario_hex").val() || "#007bff");

	$.ajax({
		url: "../ajax/configuracionEmpresa.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos) {
			var msg = (typeof datos === 'string') ? datos : '';
			var esError = msg.indexOf('Error') === 0 || msg.indexOf('No se pudo') === 0;
			Swal.fire(esError ? "Error" : "Listo", msg || (esError ? "Error al guardar." : "Configuracion actualizada."), esError ? "error" : "success").then(function() {
				if (!esError) cargarConfig();
			});
		},
		error: function(xhr, status, err) {
			var msg = (xhr && xhr.responseText) ? xhr.responseText : "Error al guardar la configuracion.";
			Swal.fire("Error", msg.substring(0, 200), "error");
		},
		complete: function() {
			$("#btnGuardar").prop("disabled", false);
		}
	});
}

init();
