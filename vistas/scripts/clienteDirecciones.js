(() => {
  const tblClientes = $('#tblClientes');
  const tblDirecciones = $('#tblDirecciones');
  let dtClientes, dtDirs;

  function initClientes() {
    dtClientes = tblClientes.DataTable({
      ajax: { url: '../ajax/proveedor.php?op=listarpersonadireccion', dataSrc: 'aaData' },
      columns: [
        {
          data: 0,
          render: function (d, t, r) {
            return `<button class='btn btn-sm btn-info' onclick='app.verDirecciones(${r[1].split(" - ")[0]},"${r[1].split(" - ")[1]}")'>Dir.</button>`;
          }
        },
        { data: 1 },
        { data: 2 },
        { data: 6 },
        { data: 7 },
        { data: 8 },
        { data: 10 },
        { data: 11 },
        { data: 12 },
        { data: 13 },
        { data: 14 },
        { data: 15 },
        { data: 9 },
        { data: 17 },
        { data: 18 },
        { data: 21 }
      ],
      responsive: true,
      dom: 'Bfrtip',
      buttons: ['csv', 'excel']
    });
  }

/**
 * Carga/recarga la tabla de direcciones para la persona indicada.
 * @param {number} idPersona – ID de la persona cuyas direcciones se desean mostrar
 */
function cargarDirecciones(idPersona) {
  // Si ya existía la DataTable la destruimos para evitar duplicados
  if (dtDirs) dtDirs.destroy();

  dtDirs = tblDirecciones.DataTable({
    ajax: {
      url: '../ajax/consultas.php?op=rpt_direcciones_view',
      data: { idPersona },               // ES6 shorthand
      dataSrc: 'aaData'
    },

    columns: [
      { data: 0 },                                            // Ciudad
      { data: 1 },                                            // Dirección
      { data: 2 },                                            // Latitud
      { data: 3 },                                            // Longitud

      // Vehículos por día (índices 4-10). Si está vacío, mostramos —
      { data: 4,  render: veh => veh || '—' },
      { data: 5,  render: veh => veh || '—' },
      { data: 6,  render: veh => veh || '—' },
      { data: 7,  render: veh => veh || '—' },
      { data: 8,  render: veh => veh || '—' },
      { data: 9,  render: veh => veh || '—' },
      { data: 10, render: veh => veh || '—' },

      // Miniatura de la imagen (índice 12)
      { 
        data: 12,
        orderable: false,
        render: function (img) {
          if (!img) return '—';

          const url = `https://mineraqua.com.py/mineraqua/files/direcciones/${img}`;
          return `
            <a href="${url}" target="_blank" title="Ver imagen completa">
              <img src="${url}"
                   style="width:50px;height:50px;object-fit:cover;border-radius:4px;"
                   alt="Imagen dirección">
            </a>`;
        }
      },

      // Botón “Editar Asignación” (usa idDireccion en el índice 11)
      {
        data: null,
        orderable: false,
        render: function (data, type, row) {
          const idDireccion = row[11]; // sigue siendo la posición 11
          return `
            <button class="btn btn-sm btn-primary"
                    onclick="app.editarAsignacion(${idDireccion})">
              Editar Asignación
            </button>`;
        }
      }
    ],

    dom: 'Bfrtip',
    buttons: ['excel'],
    responsive: true,
    language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' } // opcional
  });
}


  function fillVehiculos() {
    $.get('../ajax/cliente.php?op=listarVehiculos', function (html) {
      $('#cmbVehiculo').html(html);
    }).fail(function () {
      alert('Error al cargar vehículos');
    });
  }

function abrirAsignacion(idDireccion) {
  $('#txtIdDir').val(idDireccion);
  fillVehiculos();

  // Limpiar campos
  $('input[name="dias"]').prop('checked', false);
  $('#txtLatitud, #txtLongitud').val('');
  $('#imgPreview').attr('src', '').addClass('d-none');
  $('#lnkFull').attr('href', '#').addClass('d-none');
  $('#fileImg').val('');                       // limpia el input file
  $('#fileImg').data('imagen-original', '');   // guardamos la imagen actual

  // Traer datos de la dirección (lat, lng e imagen)
  $.getJSON('../ajax/persona.php?op=getDatosDireccion', { idDireccion }, function (data) {
    $('#txtLatitud').val(data.latitud);
    $('#txtLongitud').val(data.longitud);

    if (data.imagen) {
      const url = `https://mineraqua.com.py/mineraqua/files/direcciones/${data.imagen}`;
      $('#imgPreview').attr('src', url).removeClass('d-none');
      $('#lnkFull').attr('href', url).removeClass('d-none');
      $('#fileImg').data('imagen-original', data.imagen);
    }

  });

  // Cambiar vehículo ⇒ pintar días asignados
  $('#cmbVehiculo').off('change').on('change', function () {
    const vehiculo = $(this).val();
    $('input[name="dias"]').prop('checked', false);

    if (vehiculo) {
      $.getJSON('../ajax/persona.php?op=getAsignacion',
        { idDireccion, vehiculo },
        data => data.dias.forEach(dia => $(`#chk_${dia}`).prop('checked', true))
      );
    }
  });

  new bootstrap.Modal('#mdlAsignar').show();

// Vista preliminar al elegir un archivo nuevo
$('#fileImg').off('change').on('change', function () {
  const file = this.files[0];

  if (file) {
    // Leer el archivo local y mostrarlo
    const reader = new FileReader();
    reader.onload = e => {
      $('#imgPreview')
        .attr('src', e.target.result)   // DataURL
        .removeClass('d-none');

      // En un archivo local aún no hay URL pública, ocultamos el link
      $('#lnkFull').addClass('d-none');
    };
    reader.readAsDataURL(file);
  } else {
    // Si el usuario canceló la selección, restablecemos la imagen original
    const original = $(this).data('imagen-original');
    if (original) {
      const url = `https://mineraqua.com.py/mineraqua/files/direcciones/${original}`;
      $('#imgPreview').attr('src', url).removeClass('d-none');
      $('#lnkFull').attr('href', url).removeClass('d-none');
    } else {
      $('#imgPreview, #lnkFull').addClass('d-none');
    }
  }
});


}



function guardarAsignacionRuta () {
  /* ------------------------------------------------------------------
   * 1. Recolectar datos del formulario
   * ------------------------------------------------------------------ */
  const idDireccion = $('#txtIdDir').val();
  const vehiculo    = $('#cmbVehiculo').val();
  const dias        = $('input[name="dias"]:checked')
                        .map((_, el) => el.value)
                        .get();            // devuelve array

  const latitud  = $('#txtLatitud').val();
  const longitud = $('#txtLongitud').val();

  const file = $('#fileImg')[0].files[0] || null;  // imagen nueva (o null)

  /* ------------------------------------------------------------------
   * 2. Validaciones mínimas
   * ------------------------------------------------------------------ */
  if (!vehiculo) {
    return Swal.fire('Atención', 'Seleccione un vehículo', 'warning');
  }
  if (dias.length === 0) {
    return Swal.fire('Atención', 'Seleccione al menos un día', 'warning');
  }

  /* ------------------------------------------------------------------
   * 3. Construir FormData (permite enviar texto + archivos)
   * ------------------------------------------------------------------ */
  const formData = new FormData();
  formData.append('idDireccion', idDireccion);
  formData.append('vehiculo', vehiculo);
  formData.append('dias', JSON.stringify(dias));
  formData.append('latitud', latitud);
  formData.append('longitud', longitud);
  if (file) formData.append('imagen', file); // solo si se seleccionó

  /* ------------------------------------------------------------------
   * 4. Enviar petición AJAX
   * ------------------------------------------------------------------ */
  $.ajax({
    url         : '../ajax/persona.php?op=guardarAsignacionRuta',
    type        : 'POST',
    data        : formData,
    processData : false,   // ⚠️ obligatorio con FormData
    contentType : false,   // ⚠️ obligatorio con FormData
    dataType    : 'json',  // esperamos JSON
    beforeSend  : () => Swal.showLoading(),           // loader SweetAlert
    success     : (resp) => {
      Swal.close();        // cierra el loading

      if (resp.success) {
        Swal.fire('Correcto', resp.msg, 'success').then(() => {
          // Cerrar modal
          bootstrap.Modal
            .getInstance(document.getElementById('mdlAsignar'))
            .hide();

          // Refrescar tablas sin perder página
          dtDirs.ajax.reload(null, false);
          dtClientes.ajax.reload(null, false);
        });
      } else {
        Swal.fire('Error', resp.msg || 'Ocurrió un error al guardar.', 'error');
      }
    },
    error: (xhr, status, err) => {
      Swal.close();
      console.error(err);
      Swal.fire('Error', 'No se pudo conectar con el servidor', 'error');
    }
  });
}




window.app = {
  verDirecciones(id, nombre) {
    $('#lblCliente').text(nombre);
    cargarDirecciones(id);
    new bootstrap.Modal('#mdlDirecciones').show();
  },
  editarAsignacion(idDir) {
    abrirAsignacion(idDir);
  },
  guardarAsignacionRuta: guardarAsignacionRuta
};

  initClientes();
})();
