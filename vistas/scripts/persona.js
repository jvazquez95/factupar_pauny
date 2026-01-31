var tabla;
var contDireccion = 0;
var contTelefono = 0;
var contVisita = 0;
var contContacto = 0;
var contTP = 0;
var detallesContacto = 0;
var detallesT = 0;
var detallesV = 0;
var detallesD = 0;
var detallesTP = 0;
var documentoDuplicado = false;
var personaAjaxCount = 0;

function showLoadingPersona() {
	personaAjaxCount++;
	$("#loadingPersonaOverlay").addClass("loading-active").css("display", "flex");
}
function hideLoadingPersona() {
	personaAjaxCount--;
	if (personaAjaxCount <= 0) {
		personaAjaxCount = 0;
		$("#loadingPersonaOverlay").removeClass("loading-active").hide();
	}
}

var formatNumber = {
 separador: ".", // separador para los miles
 sepDecimal: ',', // separador para los decimales
 formatear:function (num){
 num +='';
 var splitStr = num.split('.');
 var splitLeft = splitStr[0];
 var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
 var regx = /(\d+)(\d{3})/;
 while (regx.test(splitLeft)) {
 splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
 }
 return this.simbol + splitLeft +splitRight;
 },
 new:function(num, simbol){
 this.simbol = simbol ||'';
 return this.formatear(num);
 }
}
//Función que se ejecuta al inicio
function init(){
	$("#contactos").hide();
	mostrarform(false);
	cargarKpisPersonas();
	listar();
	$("#filtroTipoPersona").on("change", function(){
		var id = $(this).val();
		$("#btnReportePersonasPdf").attr("href", "../reportes/rptInventarioPersonas.php" + (id ? "?idTipoPersona=" + id : ""));
	});
	$("#modal_detalle_completo").on("show.bs.modal", function(e){
		var id = $(e.relatedTarget).data("id-persona");
		if (id) window._detallePersonaId = id;
	});
	$("#btnEditarDesdeDetalle").on("click", function(){
		if (window._detallePersonaId) {
			$("#modal_detalle_completo").modal("hide");
			mostrar(window._detallePersonaId);
		}
	});


	// window.addEventListener("keypress", function(event){
 //    if (event.keyCode == 13){
 //        event.preventDefault();
 //    }
	// }, false);


 // function enter2tab(e) {
 //       if (e.keyCode == 13) {
 //           cb = parseInt($(this).attr('tabindex'));
    
 //           if ($(':input[tabindex=\'' + (cb + 1) + '\']') != null) {
 //               $(':input[tabindex=\'' + (cb + 1) + '\']').focus();
 //               $(':input[tabindex=\'' + (cb + 1) + '\']').select();
 //               e.preventDefault();
    
 //               return false;
 //           }
 //       }
 //   }


	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	//Cargamos los items al select grupo

	//Cargamos los items al select categoria
	$.post("../ajax/cargo.php?op=selectCargo", function(r){
	            $("#Cargo_idCargo_l").html(r);
	            $('#Cargo_idCargo_l').selectpicker('refresh');

	});

	$.post("../ajax/barrio.php?op=selectBarrio", function(r){
	            $("#Barrio_idBarrio_l").html(r);
	            $('#Barrio_idBarrio_l').selectpicker('refresh');

	});
  

	//Cargamos los items al select categoria
	$.post("../ajax/ciudad.php?op=selectCiudad", function(r){
	            $("#Ciudad_idCiudad_l").html(r);
	            $('#Ciudad_idCiudad_l').selectpicker('refresh');

	});


	//Cargamos los items al select categoria
	$.post("../ajax/grupoPersona.php?op=selectGrupoPersona", function(r){
	            $("#GrupoPersona_idGrupoPersona_l").html(r);
	            $('#GrupoPersona_idGrupoPersona_l').selectpicker('refresh');

	});

	//Cargamos los items al select categoria
	$.post("../ajax/terminoPago.php?op=selectTerminoPago", function(r){
	            $("#terminoPago_l").html(r);
	            $('#terminoPago_l').selectpicker('refresh');

	});


	$.post("../ajax/banco.php?op=selectCuentaContable", function(r){
	            $("#cuentaAPagar_l").html(r);
	            $('#cuentaAPagar_l').selectpicker('refresh');
            

	            $("#cuentaAnticipo_l").html(r);
	            $('#cuentaAnticipo_l').selectpicker('refresh');

	});


		//Cargamos los items al select categoria
	$.post("../ajax/tipoDireccionTelefono.php?op=selectTipoDireccionTelefono", function(r){
	            $("#TipoDireccion_Telefono_idTipoDireccion_Telefono_l").html(r);
	            $('#TipoDireccion_Telefono_idTipoDireccion_Telefono_l').selectpicker('refresh');

	            $("#TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_l").html(r);
	            $('#TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_l').selectpicker('refresh');


	});


	//Cargamos los items al select categoria
	$.post("../ajax/tipoPersona.php?op=select", function(r){
	            $("#TipoPersona_idTipoPersona_l").html(r);
	            $('#TipoPersona_idTipoPersona_l').selectpicker('refresh');

	});


	$("#imagenmuestra").hide();
	$("#divtwo").hide();
}


function mostrarDetalleComodato(idPersona){ 
	$('#modal_detalle').modal('show');
	$("#detalle4").val(idPersona);  
$(document).ready(function() {
    $('#tbllistado4').DataTable( {
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
					url: '../ajax/consultas.php?op=rpt_comodato',
					data:{idPersona:idPersona}, 
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
  			"columnDefs": [
            {
                "targets": [ 2],
                "visible": true,
                "searchable": false
            }],

                    "language": {
            "decimal": ".",
            "thousands": ","
        },
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación
	    "order": [[ 2, "desc" ],[ 2, "desc" ]],//Ordenar (columna,orden)

        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$.]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over this page
            pageTotal = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return parseFloat(intVal(a)) + parseFloat(intVal(b));
                }, 0 );
 
            // Update footer
            $( api.column( 2 ).footer() ).html(
               formatNumber.new(pageTotal) 
            );
        }
    } );
} );
}

//Función limpiar
function limpiar()
{
	$("#idPersona").val("");
	$("#razonSocial").val("");
	$("#nombreComercial").val("");
	$("#apellidos").val("");
	$("#nombres").val("");
	$("#nombreFantasia").val("");
	$("#tipoDocumento").val("");
	$("#nroDocumento").val("");
	$("#mail").val("");
	$("#fechaNacimiento").val("");
	$("#regimenTurismo").val("2");
	$("#tipoEmpresa").val("1");
	$("#longitud_l").val("");
	$("#latitud_l").val("");
	$("#callePrincipal_l").val("");
	$("#calleTransversal_l").val("");
	$("#nroCasa_l").val("");
	$("#telefono_l").val("");
	$("#telefono_l2").val("");
	$("#nya_l").val("");
	$("#Cargo_idCargo_l").val("");
	$("#email_l").val("");

	$(".filasTP").remove();
	$(".filasD").remove();
	$(".filasT").remove();
	$(".filasV").remove();
	$(".filasContacto").remove();

	detallesT=0;
	detallesTP=0;
	detallesD=0;
	contTelefono=0;
	contDireccion=0;
	contTP=0;
	documentoDuplicado = false;
}

function personalizar(x){

	if (x.value == 1 || x.value == 2) {
		$("#divtwo").hide();
		$("#divone").show();
	}else if(x.value == 3){
		$("#divtwo").show();
		$("#divone").hide();
	}

	if (x.value == 2) {
		$("#contactos").show();
	}else{
		$("#contactos").hide();		
	}


}


function normalizarDocumento(numero) {
	if (!numero || typeof numero !== 'string') return '';
	var t = numero.trim();
	if (t === '') return '';
	var parte = t.split('-')[0];
	return parte ? parte.trim() : '';
}

/** Consulta la API de RUC y rellena apellidos/nombres/nombreFantasia. razonSocial: "APELLIDOS, NOMBRES" o empresa sin coma. */
function consultarRucApi(rucNormalizado, callback) {
	if (!rucNormalizado || !rucNormalizado.match(/^\d+$/)) {
		if (callback) callback(false);
		return;
	}
	$.get("../ajax/persona.php?op=consultarRucApi&ruc=" + encodeURIComponent(rucNormalizado))
		.done(function(data) {
			try {
				var json = typeof data === 'string' ? JSON.parse(data) : (data || {});
			} catch (e) {
				if (callback) callback(false);
				return;
			}
			if (!json.success || !json.search || !json.search.found || !json.search.razonSocial) {
				if (callback) callback(false);
				return;
			}
			var rs = (json.search.razonSocial || '').trim();
			var apellidos = '';
			var nombres = '';
			var nombreFantasia = '';
			if (rs) {
				var idx = rs.indexOf(',');
				if (idx >= 0) {
					apellidos = rs.substring(0, idx).trim();
					nombres = rs.substring(idx + 1).trim();
				} else {
					apellidos = ',';
					nombres = rs;
					nombreFantasia = rs;
				}
			}
			$("#apellidos").val(apellidos);
			$("#nombres").val(nombres);
			$("#nombreFantasia").val(nombreFantasia);
			if (callback) callback(true);
		})
		.fail(function() {
			if (callback) callback(false);
		});
}

/** Al salir del campo RUC: actualizar tipo (RUC/Cédula), consultar API y verificar duplicado. */
function onBlurNroDocumento(el) {
	actualizarTipoDocumentoPorNumero();
	var codigo = (el.value || '').trim();
	var rucNorm = normalizarDocumento(codigo);
	if (rucNorm === '') {
		documentoDuplicado = false;
		return;
	}
	consultarRucApi(rucNorm);
	verificarRuc(el);
}

function verificarRuc(x){
	var codigo = (x.value || '').trim();
	if (normalizarDocumento(codigo) === '') {
		documentoDuplicado = false;
		return;
	}
	var idPersonaActual = ($('#idPersona').val() || '').trim();
	$.post("../ajax/persona.php?op=verificarRuc", { codigo: codigo, idPersona: idPersonaActual }, function(data, status) {
		try {
			data = typeof data === 'string' ? JSON.parse(data) : (data || {});
		} catch (e) {
			data = { cantidad: 0, idPersona: null };
		}
		var cantidad = parseInt(data.cantidad, 10) || 0;
		var idPersonaExistente = data.idPersona ? String(data.idPersona).trim() : '';
		if (cantidad > 0 && idPersonaExistente) {
			documentoDuplicado = false;
			swal({
				position: 'top-end',
				type: 'info',
				title: 'Cliente ya registrado. Se cargaron sus datos para editar.',
				showConfirmButton: false,
				timer: 2000
			});
			mostrar(idPersonaExistente);
		} else if (cantidad > 0) {
			documentoDuplicado = true;
			$('#' + x.id).focus();
			swal({
				position: 'top-end',
				type: 'error',
				title: 'Este documento (RUC/Cédula) ya está registrado. No se puede guardar.',
				showConfirmButton: false,
				timer: 2500
			});
		} else {
			documentoDuplicado = false;
		}
	});
}

/** Según el número: con guion = RUC (1), sin guion = Cédula (2). */
function actualizarTipoDocumentoPorNumero() {
	var val = ($("#nroDocumento").val() || '').trim();
	if (val.indexOf('-') >= 0) {
		$("#tipoDocumento").val("1");
	} else if (val !== '') {
		$("#tipoDocumento").val("2");
	}
	$("#tipoDocumento").selectpicker("refresh");
}

$(document).ready(function() {
	$(document).on('input', '#nroDocumento', function() {
		documentoDuplicado = false;
		actualizarTipoDocumentoPorNumero();
	});
	// Spinner/loading solo para peticiones a persona.php
	$(document).ajaxSend(function(e, xhr, opts) {
		if (opts.url && opts.url.indexOf("persona.php") !== -1) {
			showLoadingPersona();
		}
	});
	$(document).ajaxComplete(function(e, xhr, opts) {
		if (opts.url && opts.url.indexOf("persona.php") !== -1) {
			hideLoadingPersona();
		}
	});
});




function cambiarTerminoPago(x){

	alert(x.value);
	alert(x.id);


}



function crud(ventana){
	window.open("../vistas/"+ ventana +".php", "Diseño Web", "width=600, height=600");
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
		"aProcessing": true,//Activamos el procesamiento del datatables
	    //"aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/persona.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
	    "responsive": true,
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación
	    "order": [[ 2, "asc" ]],//Ordenar por Razón social
		"columnDefs": [
			{ "targets": 1, "createdCell": function(td, cellData) { $(td).html(cellData || ''); } },
			{ "targets": 10, "orderable": false, "createdCell": function(td, cellData, rowData) {
				var id = rowData[0] || cellData;
				$(td).html('<button type="button" class="btn btn-default btn-xs btn-ver-detalle-completo" data-id-persona="' + id + '" title="Ver ficha del cliente"><i class="fa fa-eye"></i> Ficha del cliente</button>');
			}},
			{ "targets": 11, "createdCell": function(td, cellData) { $(td).html(cellData || ''); } }
		]
	}).DataTable();
}
$(document).off("click", ".btn-ver-detalle-completo").on("click", ".btn-ver-detalle-completo", function(e){
	e.preventDefault();
	e.stopPropagation();
	var id = $(this).attr("data-id-persona") || $(this).data("id-persona");
	if (id) verDetalleCompleto(parseInt(id, 10));
});

function cargarKpisPersonas(){
	$.get("../ajax/persona.php?op=kpis", function(data){
		if (typeof data === "string") data = JSON.parse(data);
		$("#kpiTotal").text(data.total || 0);
		$("#kpiActivos").text(data.activos || 0);
		$("#kpiInactivos").text(data.inactivos || 0);
		var porTipo = data.porTipo || [];
		var txt = porTipo.length ? porTipo.map(function(t){ return t.descripcion + ": " + t.cantidad; }).join(" | ") : "-";
		$("#kpiPorTipo").text(txt);
		var $sel = $("#filtroTipoPersona");
		$sel.find("option:not(:first)").remove();
		porTipo.forEach(function(t){
			$sel.append($("<option></option>").attr("value", t.idTipoPersona).text(t.descripcion + " (" + t.cantidad + ")"));
		});
	}).fail(function(){ $("#kpiTotal").text("-"); });
}

function verDetalleCompleto(idPersona){
	window._detallePersonaId = idPersona;
	$("#modal_detalle_completo_body").html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>');
	$("#modal_detalle_completo").modal("show");
	$.get("../ajax/persona.php?op=detalleCompleto&idPersona=" + idPersona, function(res){
		if (typeof res === "string") res = JSON.parse(res);
		if (!res.ok) {
			$("#modal_detalle_completo_body").html('<p class="text-danger">' + (res.mensaje || 'Error al cargar.') + '</p>');
			return;
		}
		var p = res.persona || {};
		var get = function(a, b){ var v = p[a] || p[b]; return v !== undefined && v !== null ? v : ''; };
		var nombre = get('nombreFantasia','NombreFantasia') || (get('apellidos','Apellidos') + ', ' + get('nombres','Nombres')).replace(/^,\s*|,\s*$/g,'') || get('razonSocial','razonSocial');
		var esc = function(s){ return (s === undefined || s === null) ? '' : String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); };
		var html = '<div class="panel panel-default"><div class="panel-heading"><strong>Datos generales</strong></div><div class="panel-body">';
		html += '<div class="row"><div class="col-md-6"><p><strong>Nombre / Razón:</strong> ' + esc(nombre || '-') + '</p>';
		html += '<p><strong>Documento:</strong> ' + (p.tipoDocumento == 1 ? 'RUC' : p.tipoDocumento == 2 ? 'Cédula' : 'Ext.') + ' ' + esc(get('nroDocumento','nroDocumento') || '-') + '</p>';
		html += '<p><strong>Email:</strong> ' + esc(get('mail','mail') || '-') + '</p></div>';
		html += '<div class="col-md-6"><p><strong>Fecha nacimiento:</strong> ' + esc(get('fechaNacimiento','fechaNacimiento') || '-') + '</p>';
		html += '<p><strong>Tipo empresa:</strong> ' + (p.tipoEmpresa == 1 ? 'Privada' : p.tipoEmpresa == 2 ? 'Pública' : '-') + '</p>';
		html += '<p><strong>Registro:</strong> ' + esc(get('usuarioInsercion','usuarioInsercion') || '-') + '</p></div></div></div></div>';
		// Tipos de persona (puede haber varios)
		html += '<div class="panel panel-default"><div class="panel-heading"><strong>Tipos de persona</strong> <span class="badge">' + (res.tipos ? res.tipos.length : 0) + '</span></div><div class="panel-body">';
		if (res.tipos && res.tipos.length) {
			html += '<table class="table table-condensed table-striped"><thead><tr><th>#</th><th>Tipo</th><th>Término pago</th><th>Grupo</th></tr></thead><tbody>';
			res.tipos.forEach(function(t, i){ html += '<tr><td>' + (i+1) + '</td><td>' + esc(t.tipo || '-') + '</td><td>' + esc(t.terminoPago || '-') + '</td><td>' + esc(t.grupo || '-') + '</td></tr>'; });
			html += '</tbody></table>';
		} else { html += '<p class="text-muted">Ninguno registrado.</p>'; }
		html += '</div></div>';
		// Direcciones (puede haber varias)
		html += '<div class="panel panel-default"><div class="panel-heading"><strong>Direcciones</strong> <span class="badge">' + (res.direcciones ? res.direcciones.length : 0) + '</span></div><div class="panel-body">';
		if (res.direcciones && res.direcciones.length) {
			html += '<table class="table table-condensed table-striped"><thead><tr><th>#</th><th>Tipo</th><th>Ciudad</th><th>Barrio</th><th>Dirección</th></tr></thead><tbody>';
			res.direcciones.forEach(function(d, i){ html += '<tr><td>' + (i+1) + '</td><td>' + esc(d.tipo || '-') + '</td><td>' + esc(d.ciudad || '-') + '</td><td>' + esc(d.barrio || '-') + '</td><td>' + esc(d.direccion || '-') + '</td></tr>'; });
			html += '</tbody></table>';
		} else { html += '<p class="text-muted">Ninguna registrada.</p>'; }
		html += '</div></div>';
		// Teléfonos (puede haber varios)
		html += '<div class="panel panel-default"><div class="panel-heading"><strong>Teléfonos</strong> <span class="badge">' + (res.telefonos ? res.telefonos.length : 0) + '</span></div><div class="panel-body">';
		if (res.telefonos && res.telefonos.length) {
			html += '<table class="table table-condensed table-striped"><thead><tr><th>#</th><th>Tipo</th><th>Número</th></tr></thead><tbody>';
			res.telefonos.forEach(function(t, i){ html += '<tr><td>' + (i+1) + '</td><td>' + esc(t.tipo || '-') + '</td><td>' + esc(t.numero || '-') + '</td></tr>'; });
			html += '</tbody></table>';
		} else { html += '<p class="text-muted">Ninguno registrado.</p>'; }
		html += '</div></div>';
		// Contactos (puede haber varios)
		html += '<div class="panel panel-default"><div class="panel-heading"><strong>Contactos</strong> <span class="badge">' + (res.contactos ? res.contactos.length : 0) + '</span></div><div class="panel-body">';
		if (res.contactos && res.contactos.length) {
			html += '<table class="table table-condensed table-striped"><thead><tr><th>#</th><th>Nombre</th><th>Email</th><th>Teléfono</th></tr></thead><tbody>';
			res.contactos.forEach(function(c, i){ html += '<tr><td>' + (i+1) + '</td><td>' + esc(c.nya || '-') + '</td><td>' + esc(c.email || '-') + '</td><td>' + esc(c.telefono || '-') + '</td></tr>'; });
			html += '</tbody></table>';
		} else { html += '<p class="text-muted">Ninguno registrado.</p>'; }
		html += '</div></div>';
		$("#modal_detalle_completo_body").html(html);
	}).fail(function(){
		$("#modal_detalle_completo_body").html('<p class="text-danger">Error al cargar el detalle.</p>');
	});
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault();
	if (documentoDuplicado) {
		swal({
			position: 'top-end',
			type: 'error',
			title: 'No se puede guardar: el documento ya está registrado. Corrija el RUC/Cédula.',
			showConfirmButton: true
		});
		return;
	}
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/persona.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
						swal({
						  position: 'top-end',
						  type: 'success',
						  title: datos,
						  showConfirmButton: false,
						  timer: 3000
						 })	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(idPersona)
{
	$.post("../ajax/persona.php?op=mostrar",{idPersona : idPersona}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

	$("#razonSocial").val("");
	$("#nombreComercial").val("");
	$("#apellidos").val(data.apellidos || data.Apellidos || "");
	$("#nombres").val(data.nombres || data.Nombres || "");
	$("#nombreFantasia").val(data.nombreFantasia || data.NombreFantasia || "");
	$("#tipoDocumento").val(data.tipoDocumento);
	$("#tipoDocumento").selectpicker("refresh");
	$("#tercerizado").val(data.tercerizado);
	$("#tercerizado").selectpicker("refresh");
	$("#regimenTurismo").val(data.regimenTurismo);
	$("#regimenTurismo").selectpicker("refresh");
	$("#nroDocumento").val(data.nroDocumento);
	$("#mail").val(data.mail);
	$("#fechaNacimiento").val(data.fechaNacimiento);
	$("#tipoEmpresa").val(data.tipoEmpresa);
	$("#tipoEmpresa").selectpicker("refresh");
	$("#idPersona").val(data.idPersona);

 	})

 	$.post("../ajax/persona.php?op=listarDetalleTipoPersona&idPersona="+idPersona,function(r){
	        if (r && typeof r === 'string') {
	        	$("#detalleTipoPersona tbody").html(r);
	        	$("#detalleTipoPersona tbody select").each(function(){
	        		var $s = $(this);
	        		var v = $s.find("option:selected").val();
	        		if (v !== undefined && v !== '') $s.val(v);
	        		if ($.fn.selectpicker && $s.data("selectpicker")) $s.selectpicker("refresh");
	        	});
	        }
	});
 	$.post("../ajax/persona.php?op=listarDetalleTelefono&idPersona="+idPersona,function(r){
	        if (r && typeof r === 'string') {
	        	$("#detalleTelefono tbody").html(r);
	        	$("#detalleTelefono tbody select").each(function(){
	        		var $s = $(this);
	        		var v = $s.find("option:selected").val();
	        		if (v !== undefined && v !== '') $s.val(v);
	        		if ($.fn.selectpicker && $s.data("selectpicker")) $s.selectpicker("refresh");
	        	});
	        }
	});
 	$.post("../ajax/persona.php?op=listarDetalleDireccion&idPersona="+idPersona,function(r){
	        if (r && typeof r === 'string') {
	        	$("#detalleDireccion tbody").html(r);
	        	$("#detalleDireccion tbody select").each(function(){
	        		var $s = $(this);
	        		var v = $s.find("option:selected").val();
	        		if (v !== undefined && v !== '') $s.val(v);
	        		if ($.fn.selectpicker && $s.data("selectpicker")) $s.selectpicker("refresh");
	        	});
	        }
	});
 	$.post("../ajax/persona.php?op=listarDetallePersonaContacto&idPersona="+idPersona,function(r){
	        if (r && typeof r === 'string') {
	        	$("#detalleContacto tbody").html(r);
	        	$("#detalleContacto tbody select").each(function(){
	        		var $s = $(this);
	        		var v = $s.find("option:selected").val();
	        		if (v !== undefined && v !== '') $s.val(v);
	        		if ($.fn.selectpicker && $s.data("selectpicker")) $s.selectpicker("refresh");
	        	});
	        }
	});	


		$("#btnGuardar").prop("disabled",false);


}


function addDetalleTipoPersona()
  {
   	
	var TipoPersona_idTipoPersona = $("#TipoPersona_idTipoPersona_l option:selected").val();
  var TipoPersona_idTipoPersona_text = $("#TipoPersona_idTipoPersona_l option:selected").text();

//	var terminosHabilitado = $("#terminosHabilitado_l option:selected").val();
// 	var terminosHabilitado_text = $("#terminosHabilitado option:selected").text();


	var terminoPago = $("#terminoPago_l option:selected").val();
  	var terminoPago_text = $("#terminoPago_l option:selected").text();

	var GrupoPersona_idGrupoPersona = $("#GrupoPersona_idGrupoPersona_l option:selected").val();
  	var GrupoPersona_idGrupoPersona_text = $("#GrupoPersona_idGrupoPersona_l option:selected").text();

  	//var lservicio_nombre = $("#Articulo_idArticulo_Servicio option:selected").text();
	var cuentaAPagar = $("#cuentaAPagar_l option:selected").val();
  var cuentaAPagar_text = $("#cuentaAPagar_l option:selected").text();


	var cuentaAnticipo = $("#cuentaAnticipo_l option:selected").val();
  var cuentaAnticipo_text = $("#cuentaAnticipo_l option:selected").text();


	var comision = $("#comision_l").val();
	var salario = $("#salario_l").val();


		if (terminoPago=='') {
			alert('Complete Termino de pago');
			$("#terminoPago_l").focus();
			return;			
		}


	if (TipoPersona_idTipoPersona == 1 || TipoPersona_idTipoPersona == 2) {
		if (cuentaAPagar=='') {
			alert('Complete la cuenta a pagar');
			$("#cuentaAPagar_l").focus();
			return;			
		}

		if (cuentaAnticipo == '') {
			alert('Complete la cuenta anticipo');
			$("#cuentaAnticipo_l").focus();
			return;			

		}


	}

	if (TipoPersona_idTipoPersona == 3) {

		if (comision == '') {
			alert('Complete la comision');
			$("#comision_l").focus();
			return;			


		}

		if (salario == '') {
			alert('Complete el salario');
			$("#salario_l").focus();
			return;			

		}

	}


	var $fila = $('<tr class="filasTP" id="filaTP'+contTP+'"></tr>');
	$fila.append('<td><button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalleTipoPersona(\''+contTP+'\',0)">X</button></td>');
	var $selTipo = $('<select name="TipoPersona_idTipoPersona[]" class="form-control input-sm"></select>').append($("#TipoPersona_idTipoPersona_l option").clone());
	$selTipo.val(TipoPersona_idTipoPersona);
	$fila.append($('<td></td>').append($selTipo));
	var $selTP = $('<select name="terminoPago[]" class="form-control input-sm"></select>').append($("#terminoPago_l option").clone());
	$selTP.val(terminoPago);
	$fila.append($('<td></td>').append($selTP));
	var $selGP = $('<select name="GrupoPersona_idGrupoPersona[]" class="form-control input-sm"></select>').append($("#GrupoPersona_idGrupoPersona_l option").clone());
	$selGP.val(GrupoPersona_idGrupoPersona);
	$fila.append($('<td></td>').append($selGP));
	var $selCAP = $('<select name="cuentaAPagar[]" class="form-control input-sm"></select>').append($("#cuentaAPagar_l option").clone());
	$selCAP.val(cuentaAPagar);
	$fila.append($('<td></td>').append($selCAP));
	var $selCA = $('<select name="cuentaAnticipo[]" class="form-control input-sm"></select>').append($("#cuentaAnticipo_l option").clone());
	$selCA.val(cuentaAnticipo);
	$fila.append($('<td></td>').append($selCA));
	$fila.append('<td><input type="text" name="comision[]" class="form-control input-sm" value="'+ (comision || '') +'" placeholder="Comisión"></td>');
	$fila.append('<td><input type="text" name="salario[]" class="form-control input-sm" value="'+ (salario || '') +'" placeholder="Salario"></td>');
	$fila.append('<td><input type="hidden" name="idPersonaTipoPersona[]" value="0"></td>');
	contTP++;
	detallesTP = detallesTP + 1;
	$("#btnGuardar").prop("disabled", false);
	$('#detalleTipoPersona tbody').append($fila);
    	if (detallesTP > 0) {
			$("#btnGuardar").prop("disabled",false);
    	}
    	//modificarSubototales();
  }
  function eliminarDetalleTipoPersona(indice,valor){
		Swal.fire({
			title: '¿Eliminar registro?',
			html: 'El tipo de persona seleccionado se eliminará por completo. <strong>Esta acción no se puede deshacer.</strong>',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Sí, eliminar',
			cancelButtonText: 'Cancelar'
		}).then(function(result) {
			if (result.isConfirmed) {
				if (valor > 0) {
					$.post("../ajax/persona.php?op=desactivarTP", {idTP : valor}, function(e){});
				}
				$("#filaTP" + indice).remove();
				detallesTP = detallesTP - 1;
				if (document.getElementsByName("TipoPersona_idTipoPersona[]").length <= 0) {
					$("#btnGuardar").prop("disabled", true);
				}
			}
		});
  }



function addDetalleDireccion()
  {
	var TipoDireccion_Telefono_idTipoDireccion_Telefono = $("#TipoDireccion_Telefono_idTipoDireccion_Telefono_l option:selected").val();
	var TipoDireccion_Telefono_idTipoDireccion_Telefono_text = $("#TipoDireccion_Telefono_idTipoDireccion_Telefono_l option:selected").text();
	var Barrio_idBarrio = $("#Barrio_idBarrio_l option:selected").val();
	var Barrio_idBarrio_text = $("#Barrio_idBarrio_l option:selected").text();
	var Ciudad_idCiudad = $("#Ciudad_idCiudad_l option:selected").val();
	var Ciudad_idCiudad_text = $("#Ciudad_idCiudad_l option:selected").text();
	var callePrincipal = $("#callePrincipal_l").val();
	var calleTransversal = $("#calleTransversal_l").val();
	var nroCasa = $("#nroCasa_l").val();
	var latitud = $("#latitud_l").val();
	var longitud = $("#longitud_l").val();

	if (!Ciudad_idCiudad || Ciudad_idCiudad=='') {
		alert('Seleccione la ciudad');
		$("#Ciudad_idCiudad_l").focus();
		return;
	}
	if (callePrincipal=='') {
		alert('Complete la calle principal');
		$("#callePrincipal_l").focus();
		return;
	}

	var $filaD = $('<tr class="filasD" id="filaD'+contDireccion+'"></tr>');
	$filaD.append('<td><button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalleDireccion(\''+contDireccion+'\',0)">X</button><input type="hidden" name="idDireccion[]" value="0"></td>');
	var $selTipoDir = $('<select name="TipoDireccion_Telefono_idTipoDireccion_Telefono[]" class="form-control input-sm"></select>').append($("#TipoDireccion_Telefono_idTipoDireccion_Telefono_l option").clone());
	$selTipoDir.val(TipoDireccion_Telefono_idTipoDireccion_Telefono);
	$filaD.append($('<td></td>').append($selTipoDir));
	var $selCiudad = $('<select name="Ciudad_idCiudad[]" class="form-control input-sm"></select>').append($("#Ciudad_idCiudad_l option").clone());
	$selCiudad.val(Ciudad_idCiudad);
	$filaD.append($('<td></td>').append($selCiudad));
	var $selBarrio = $('<select name="Barrio_idBarrio[]" class="form-control input-sm"></select>').append($("#Barrio_idBarrio_l option").clone());
	$selBarrio.val(Barrio_idBarrio);
	$filaD.append($('<td></td>').append($selBarrio));
	$filaD.append('<td><input type="text" name="callePrincipal[]" class="form-control input-sm" value="'+ (callePrincipal||'') +'" placeholder="Calle principal"></td>');
	$filaD.append('<td><input type="text" name="calleTransversal[]" class="form-control input-sm" value="'+ (calleTransversal||'') +'" placeholder="Transversal"></td>');
	$filaD.append('<td><input type="text" name="nroCasa[]" class="form-control input-sm" value="'+ (nroCasa||'') +'" placeholder="Nro"></td>');
	$filaD.append('<td><input type="text" name="latitud[]" class="form-control input-sm" value="'+ (latitud||'') +'" placeholder="Lat"></td>');
	$filaD.append('<td><input type="text" name="longitud[]" class="form-control input-sm" value="'+ (longitud||'') +'" placeholder="Lng"></td>');
	contDireccion++;
	detallesD = detallesD + 1;
	$('#detalleDireccion tbody').append($filaD);
    	//modificarSubototales();
  }

  function eliminarDetalleDireccion(indice,valor){
		Swal.fire({
			title: '¿Eliminar dirección?',
			html: 'La dirección se eliminará por completo. <strong>Esta acción no se puede deshacer.</strong>',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Sí, eliminar',
			cancelButtonText: 'Cancelar'
		}).then(function(result) {
			if (result.isConfirmed) {
				if (valor > 0) {
					$.post("../ajax/persona.php?op=desactivarDireccion", {idDireccion : valor}, function(e){});
				}
				$("#filaD" + indice).remove();
				detallesD = detallesD - 1;
			}
		});
  }

function addDetalleTelefono()
  {
   	
	var TipoDireccion_Telefono_idTipoDireccion_Telefono_tel = $("#TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_l option:selected").val();
  	var TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_text = $("#TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_l option:selected").text();

	var telefono = $("#telefono_l").val();

		if (telefono=='') {
			alert('Complete el nro de telefono');
			$("#telefono_l").focus();
			return;			
		}
	var $filaT = $('<tr class="filasT" id="filaT'+contTelefono+'"></tr>');
	$filaT.append('<td><button type="button" class="btn btn-danger btn-xs" onclick="eliminarDetalleTelefono(\''+contTelefono+'\',0)">X</button></td>');
	var $selTipoTel = $('<select name="TipoDireccion_Telefono_idTipoDireccion_Telefono_tel[]" class="form-control input-sm"></select>').append($("#TipoDireccion_Telefono_idTipoDireccion_Telefono_tel_l option").clone());
	$selTipoTel.val(TipoDireccion_Telefono_idTipoDireccion_Telefono_tel);
	$filaT.append($('<td></td>').append($selTipoTel));
	$filaT.append('<td><input type="text" name="telefono[]" class="form-control input-sm" value="'+ (telefono||'') +'" placeholder="Teléfono"></td>');
	$filaT.append('<td><input type="hidden" name="idTelefono[]" value="0"></td>');
	contTelefono++;
	detallesT = detallesT + 1;
	$('#detalleTelefono tbody').append($filaT);
		
  }

  function eliminarDetalleTelefono(indice,valor){
		Swal.fire({
			title: '¿Eliminar teléfono?',
			html: 'El teléfono se eliminará por completo. <strong>Esta acción no se puede deshacer.</strong>',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Sí, eliminar',
			cancelButtonText: 'Cancelar'
		}).then(function(result) {
			if (result.isConfirmed) {
				if (valor > 0) {
					$.post("../ajax/persona.php?op=desactivarTelefono", {idTelefono : valor}, function(e){});
				}
				$("#filaT" + indice).remove();
				detallesT = detallesT - 1;
			}
		});
  }






function addDetalleContacto()
  {
	var nya = $("#nya_l").val();
	
	var Cargo_idCargo = $("#Cargo_idCargo_l option:selected").val();
  	var Cargo_idCargo_text = $("#Cargo_idCargo_l option:selected").text();

	var telefono = $("#telefono_l2").val();

		if (telefono=='') {
			alert('Complete el nro de telefono');
			$("#telefono_l2").focus();
			return;			
		}

	var email = $("#email_l").val();


    	var fila=
    	'<tr class="filasContacto" id="filaContacto'+contContacto+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleContacto('+contContacto+',0)">X</button></td>'+
    	'<td><input type="hidden" name="nya[]" value="'+nya+'">'+nya+'</td>'+
    	'<td><input type="hidden" name="Cargo_idCargo[]"  value="'+Cargo_idCargo+'">'+Cargo_idCargo_text+'</td>'+
    	'<td><input type="hidden" name="telefono_2[]"  value="'+telefono+'">'+telefono+'</td>'+
    	'<td><input type="hidden" name="email_2[]"  value="'+email+'">'+email+'</td>'+
    	'<td><input type="hidden" name="idPersonaContacto[]" data-idPersonaContacto="0"  value="0"></td>'+

    	'</tr>';
    	contContacto++;
    	detallesContacto=detallesContacto+1;
    	$('#detalleContacto tbody').append(fila);
		
  }

  function eliminarDetalleContacto(indice,valor){
		Swal.fire({
			title: '¿Eliminar contacto?',
			html: 'El contacto se eliminará por completo. <strong>Esta acción no se puede deshacer.</strong>',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Sí, eliminar',
			cancelButtonText: 'Cancelar'
		}).then(function(result) {
			if (result.isConfirmed) {
				if (valor > 0) {
					$.post("../ajax/persona.php?op=desactivarPersonaContacto", {idPersonaContacto : valor}, function(e){});
				}
				$("#filaContacto" + indice).remove();
				detallesContacto = detallesContacto - 1;
			}
		});
  }






function addDetalleDias()
  {
   	
	var Dia_idDia = $("#Dia_idDia option:selected").val();
  var Dia_idDia_text = $("#Dia_idDia option:selected").text();

	var cantidad = $("#cantidad").val();

		if (cantidad=='') {
			alert('Complete la cantidad');
			$("#cantidad").focus();
			return;			
		}
    	var fila=
    	'<tr class="filasV" id="filaV'+contVisita+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleVisita('+contVisita+',0)">X</button></td>'+
    	'<td><input type="hidden" name="Dia_idDia_persona[]" value="'+Dia_idDia+'">'+Dia_idDia_text+'</td>'+
    	'<td><input type="hidden" name="cantidad_persona[]"  value="'+cantidad+'">'+cantidad+'</td>'+
    	'<td><input type="hidden" name="idPersonaDia[]" data-idPersonaDia="0"  value="0"></td>'+

    	'</tr>';
    	contVisita++;
    	detallesV=detallesV+1;
    	$('#detalleVisita').append(fila);
		
  }

  function eliminarDetalleVisita(indice,valor){

	if (valor > 0) {
        	$.post("../ajax/persona.php?op=desactivarVisita", {idPersonaDia : valor}, function(e){
				//tabla.ajax.reload();
        	});		
    }

  	$("#filaV" + indice).remove();
	detallesV=detallesV-1;
	


  }






// Función para desactivar registros con gif de carga
function desactivar(idPersona) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción desactivará el cliente!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, desactivar!'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Procesando...',
                html: '<img src="loading.gif" width="50" height="50">',
                allowOutsideClick: false,
                showConfirmButton: false
            });
            
            $.post("../ajax/persona.php?op=desactivar", { idPersona: idPersona }, function(e) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Cliente desactivado correctamente',
                    text: e,
                    showConfirmButton: false,
                    timer: 1500
                });
                
                tabla.ajax.reload(null, false); // Recargar tabla sin reiniciar paginación
            });
        }
    });
}

// Función para activar registros con gif de carga
function activar(idPersona) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción activará el cliente!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, activar!'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Procesando...',
                html: '<img src="loading.gif" width="50" height="50">',
                allowOutsideClick: false,
                showConfirmButton: false
            });
            
            $.post("../ajax/persona.php?op=activar", { idPersona: idPersona }, function(e) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Cliente activado correctamente',
                    text: e,
                    showConfirmButton: false,
                    timer: 1500
                });
                
                tabla.ajax.reload(null, false); // Recargar tabla sin reiniciar paginación
            });
        }
    });
}




init();


function initialize() {
    var initialLat = $('.search_latitude').val();
    var initialLong = $('.search_longitude').val();
    initialLat = initialLat?initialLat:36.169648;
    initialLong = initialLong?initialLong:-115.141000;

    var latlng = new google.maps.LatLng(initialLat, initialLong);
    var options = {
        zoom: 16,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("geomap"), options);

    geocoder = new google.maps.Geocoder();

    marker = new google.maps.Marker({
        map: map,
        draggable: true,
        position: latlng
    });

    google.maps.event.addListener(marker, "dragend", function () {
        var point = marker.getPosition();
        map.panTo(point);
        geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                $('.search_addr').val(results[0].formatted_address);
                $('.search_latitude').val(marker.getPosition().lat());
                $('.search_longitude').val(marker.getPosition().lng());
            }
        });
    });

}

navigator.geolocation.getCurrentPosition(function(position){ 
var geocoder;
var map;
var marker;
//load google map
geocoder = new google.maps.Geocoder();   
var PostCodeid = '#search_location';
$( "#Ciudad_idCiudad_l" ).on('keyup',function() {
  // alert( "Handler for .change() called." + $("#Ciudad_idCiudad_l").val() );
	if ($("#Ciudad_idCiudad_l").val() == "1") {
		$("#search_location").val("Asuncion, Paraguay");
	}
	else if($("#Ciudad_idCiudad_l").val() == "2"){
	$("#search_location").val("San Lorenzo, Paraguay");
	}
});
$("#callePrincipal_l").on('keyup',function(){
	if ($("#Ciudad_idCiudad_l").val() == "1") {
		$("#search_location").val($("#callePrincipal_l").val()+", Asuncion, Paraguay");
	}
	else if($("#Ciudad_idCiudad_l").val() == "2"){
	$("#search_location").val($("#callePrincipal_l").val()+", San Lorenzo, Paraguay");
	}
});
$("#nroCasa_l").on('keyup',function(){
	if ($("#Ciudad_idCiudad_l").val() == "1") {
		$("#search_location").val($("#callePrincipal_l").val() + "  " +$("#nroCasa_l").val()+", Asuncion, Paraguay");
	}
	else if($("#Ciudad_idCiudad_l").val() == "2"){
	$("#search_location").val($("#callePrincipal_l").val() + "  " +$("#nroCasa_l").val()+", San Lorenzo, Paraguay");
	}
});
 $('#search_location').on('keyup',function() {
   Obtener_ubicacion();
 });

	Obtener_ubicacion();
	var map;
	var marker = false;

	function Obtener_ubicacion(){
		var address = $(PostCodeid).val();
	        geocoder.geocode({'address': address}, function (results, status) {
	            if (status == google.maps.GeocoderStatus.OK) {
	                $('.search_addr').val(results[0].formatted_address);
	                $('.search_latitude').val(results[0].geometry.location.lat());
	                $('.search_longitude').val(results[0].geometry.location.lng());
	                initMap();
	            }
	            else {
	                console.log("ERROR : " + status);
	            }
	                $(function () {
	                    $("#search_location").autocomplete({
	                        source: function (request, response) {
	                            geocoder.geocode({
	                                'address': request.term
	                            }, function (results, status) {
	                                response($.map(results, function (item) {
	                                    return {
	                                        label: item.formatted_address,
	                                        value: item.formatted_address,
	                                        lat: item.geometry.location.lat(),
	                                        lon: item.geometry.location.lng()
	                                    };
	                                }));
	                            });
	                        },
	                        select: function (event, ui) {
	                            $('.search_addr').val(ui.item.value);
	                            $('.search_latitude').val(ui.item.lat);
	                            $('.search_longitude').val(ui.item.lon);
	                            var latlng = new google.maps.LatLng(ui.item.lat, ui.item.lon);
	                            //marker.setPosition(latlng);
	                        }
	                    });
	                });
	        });
	}


	function initMap() {


	    var centerOfMap = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
	 
	    //Map options.
	    var options = {
	      center: centerOfMap, //Set center.
	      zoom: 14 //The zoom value.
	    };
	 
	    map = new google.maps.Map(document.getElementById('map'), options);
	 

		var marker = new google.maps.Marker({
		position: centerOfMap,
		map: map,
		});



	    google.maps.event.addListener(map, 'click', function(event) {                
	        var clickedLocation = event.latLng;
	        if(marker === false){
	            marker = new google.maps.Marker({
	                position: clickedLocation,
	                map: map,
	                draggable: true //make it draggable
	            });
	            google.maps.event.addListener(marker, 'dragend', function(event){
	            	    var currentLocation = marker.getPosition();

	    $("#longitud_l").val(currentLocation.lat());

	    $("#latitud_l").val(currentLocation.lng());
	            });
	        } else{

	            marker.setPosition(clickedLocation);
	        }

	         	    var currentLocation = marker.getPosition();

	    $("#longitud_l").val(currentLocation.lat());

	    $("#latitud_l").val(currentLocation.lng());


	    });
	}




});





