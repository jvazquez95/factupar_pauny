<?php
ob_start();
session_start();
if(!isset($_SESSION["almacen"])) { header("Location: login.html"); exit(); }
require 'header.php';
requierePermisoVista(basename(__FILE__, '.php'));
if($_SESSION['almacen']!=1){ require 'noacceso.php'; exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Clientes · Direcciones</title>

  <!-- Bootstrap 5 & DataTables -->  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css"/>
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css"/>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

  <style> body{padding:15px;} th,td{vertical-align:middle;} </style>
</head>
<body>
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="m-0">Clientes &nbsp;×&nbsp; Direcciones</h3>
      <button id="btnNuevo" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo Cliente</button>
    </div>

    <!-- Tabla principal -->
    <table id="tblClientes" class="table table-sm table-striped table-bordered w-100">
      <thead class="table-dark">
        <tr>
          <th>Opc.</th><th>Razón social</th><th>Nombre comercial</th>
          <th>Ciudad</th><th>Dirección</th><th>Lat/Lng</th>
          <th>Lun</th><th>Mar</th><th>Mié</th><th>Jue</th><th>Vie</th><th>Sáb</th><th>Dom</th>
          <th>Usuario&nbsp;Ins.</th><th>Fecha&nbsp;Ins.</th><th>Estado</th> 
        </tr>
      </thead>
    </table>
  </div>

  <!-- Modal direcciones del cliente -->
  <div class="modal " id="mdlDirecciones" tabindex="-1"><div class="modal-dialog modal-xl"><div class="modal-content">
    <div class="modal-header bg-primary text-white"><h5 class="modal-title">Direcciones <span id="lblCliente"></span></h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body p-2">
      <table id="tblDirecciones" class="table table-bordered table-hover w-100">
        <thead class="table-light">
          <tr>
            <th>Ciudad</th><th>Dirección</th><th>Lat</th><th>Lng</th>
            <th>Lun</th><th>Mar</th><th>Mié</th><th>Jue</th><th>Vie</th><th>Sáb</th><th>Dom</th>
            <th>Acción</th><th>Imagen</th>

          </tr>
        </thead>
      </table>
    </div>
  </div></div></div>


<!-- Modal asignar vehículo / editar imagen -->
<div class="modal " id="mdlAsignar" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Asignar vehículo y días</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <!-- ID oculto -->
        <input type="number" id="txtIdDir" class="form-control mb-3" readonly>

        <!-- Vehículo -->
        <div class="mb-3">
          <label class="form-label">Vehículo</label>
          <select id="cmbVehiculo" class="form-select"></select>
        </div>

        <!-- Días -->
        <div class="mb-3">
          <label class="form-label d-block">Días de visita</label>
          <div class="d-flex flex-wrap gap-2">
            <div class="form-check"><input class="form-check-input" type="checkbox" id="chk_lunes" value="lunes"   name="dias"><label class="form-check-label" for="chk_lunes">Lunes</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" id="chk_martes" value="martes" name="dias"><label class="form-check-label" for="chk_martes">Martes</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" id="chk_miercoles" value="miercoles" name="dias"><label class="form-check-label" for="chk_miercoles">Miércoles</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" id="chk_jueves" value="jueves" name="dias"><label class="form-check-label" for="chk_jueves">Jueves</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" id="chk_viernes" value="viernes" name="dias"><label class="form-check-label" for="chk_viernes">Viernes</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" id="chk_sabado" value="sabado" name="dias"><label class="form-check-label" for="chk_sabado">Sábado</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" id="chk_domingo" value="domingo" name="dias"><label class="form-check-label" for="chk_domingo">Domingo</label></div>
          </div>
        </div>

        <!-- Lat/Lng -->
        <div class="row g-3 mb-3">
          <div class="col">
            <label class="form-label">Latitud</label>
            <input type="text" id="txtLatitud" class="form-control">
          </div>
          <div class="col">
            <label class="form-label">Longitud</label>
            <input type="text" id="txtLongitud" class="form-control">
          </div>
        </div>

        <!-- Imagen -->
        <div class="mb-3">
          <label class="form-label">Imagen de la dirección</label>
          <div class="border rounded p-2">
            <img id="imgPreview" class="img-thumbnail mb-2 d-none" style="max-width:100%; height:auto;" alt="Imagen dirección">
            <a id="lnkFull" class="d-none mb-2" target="_blank">Ver tamaño completo</a>
            <input type="file" id="fileImg" accept="image/*" class="form-control">
            <small class="text-muted">Seleccione una nueva imagen para reemplazar la existente (opcional).</small>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" onclick="app.guardarAsignacionRuta()">Guardar</button>
      </div>
    </div>
  </div>
</div>




  <script src="scripts/clienteDirecciones.js"></script>
</body>
</html>
<?php require 'footer.php'; ?>
